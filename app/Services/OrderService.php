<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderService
{
    public function getAll(Request $request): Collection
    {
        $query = Order::with(['user', 'items.product'])
            ->where('IsActive', 1);

        if ($request->query('search')) {
            $query->where('CustomerName', 'like', '%' . $request->query('search') . '%');
        }

        return $query->get();
    }

    public function getById(int $id): Order
    {
        return Order::with(['user', 'items.product'])->findOrFail($id);
    }

    public function getForCurrentUser(Request $request): LengthAwarePaginator
    {
        // pobieram tylko zamówienia aktualnie zalogowanego użytkownika
        $query = Order::with(['items.product'])
            ->where('IsActive', 1)
            ->where('UserId', session('user_id'));

        if ($request->query('search')) {
            $search = $request->query('search');

            $query->where(function ($q) use ($search) {
                $q->where('CustomerName', 'like', '%' . $search . '%')
                    ->orWhere('CustomerEmail', 'like', '%' . $search . '%')
                    ->orWhere('Address', 'like', '%' . $search . '%')
                    ->orWhere('Status', 'like', '%' . $search . '%')
                    ->orWhere('Id', $search);
            });
        }

        return $query->orderBy('CreationDateTime', 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    public function getForCurrentUserById(int $id): Order
    {
        // zabezpieczenie: klient nie może podejrzeć cudzego zamówienia
        return Order::with(['items.product'])
            ->where('IsActive', 1)
            ->where('UserId', session('user_id'))
            ->findOrFail($id);
    }

    public function createFromCart(Request $request): void
    {
        $request->validate([
            'CustomerName' => ['required', 'string', 'max:150'],
            'CustomerEmail' => ['required', 'string', 'max:150'],
            'Address' => ['required', 'string', 'min:5'],
        ]);

        $cart = session('cart', []);

        if (count($cart) == 0) {
            throw ValidationException::withMessages([
                'cart' => 'Koszyk jest pusty.'
            ]);
        }

        DB::transaction(function () use ($request, $cart) {
            $total = 0;
            $productsToOrder = [];

            foreach ($cart as $productId => $quantity) {
                $quantity = (int) $quantity;

                if ($quantity <= 0) {
                    throw ValidationException::withMessages([
                        'cart' => 'Nieprawidłowa ilość produktu w koszyku.'
                    ]);
                }

                // blokuję produkt na czas tworzenia zamówienia
                $product = Product::where('IsActive', 1)
                    ->lockForUpdate()
                    ->find($productId);

                if (!$product) {
                    throw ValidationException::withMessages([
                        'cart' => 'Jeden z produktów w koszyku nie jest już dostępny.'
                    ]);
                }

                if ($product->Stock <= 0) {
                    throw ValidationException::withMessages([
                        'stock' => 'Produkt "' . $product->Name . '" nie jest już dostępny w magazynie.'
                    ]);
                }

                if ($quantity > $product->Stock) {
                    throw ValidationException::withMessages([
                        'stock' => 'Nie można złożyć zamówienia. Produkt "' . $product->Name . '" ma w magazynie tylko ' . $product->Stock . ' szt.'
                    ]);
                }

                $total += $product->Price * $quantity;

                $productsToOrder[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                ];
            }

            if ($total <= 0) {
                throw ValidationException::withMessages([
                    'cart' => 'Nie można złożyć pustego zamówienia.'
                ]);
            }

            $order = new Order();
            $order->UserId = session('user_id');
            $order->CustomerName = $request->input('CustomerName');
            $order->CustomerEmail = $request->input('CustomerEmail');
            $order->Address = $request->input('Address');
            $order->Status = 'New';
            $order->TotalPrice = $total;
            $order->CreationDateTime = now();
            $order->EditDateTime = now();
            $order->IsActive = 1;
            $order->save();

            foreach ($productsToOrder as $cartItem) {
                $product = $cartItem['product'];
                $quantity = $cartItem['quantity'];

                $item = new OrderItem();
                $item->OrderId = $order->Id;
                $item->ProductId = $product->Id;
                $item->Quantity = $quantity;
                $item->Price = $product->Price;
                $item->CreationDateTime = now();
                $item->EditDateTime = now();
                $item->IsActive = 1;
                $item->save();

                // po zakupie zmniejszam stan magazynowy
                $product->Stock = $product->Stock - $quantity;
                $product->EditDateTime = now();
                $product->save();
            }
        });

        session()->forget('cart');
    }

    public function update(Request $request, int $id): void
    {
        $request->validate([
            'Status' => ['required', 'string', 'max:50', 'in:New,Paid,Sent,Finished'],
        ]);

        $model = Order::findOrFail($id);
        $model->Status = $request->input('Status');
        $model->EditDateTime = now();
        $model->save();
    }

    public function delete(int $id): void
    {
        $model = Order::findOrFail($id);
        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();
    }
}