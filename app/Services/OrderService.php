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
            $search = $request->query('search');
            $statusFromSearch = $this->getStatusFromSearch($search);

            $query->where(function ($q) use ($search, $statusFromSearch) {
                $q->where('CustomerName', 'like', '%' . $search . '%')
                    ->orWhere('CustomerEmail', 'like', '%' . $search . '%')
                    ->orWhere('Address', 'like', '%' . $search . '%')
                    ->orWhere('Status', 'like', '%' . $search . '%');

                if ($statusFromSearch) {
                    $q->orWhere('Status', $statusFromSearch);
                }

                if (is_numeric($search)) {
                    $q->orWhere('Id', $search);
                }
            });
        }

        if ($request->query('status')) {
            $query->where('Status', $request->query('status'));
        }

        return $query->orderBy('CreationDateTime', 'desc')->get();
    }

    public function getById(int $id): Order
    {
        return Order::with(['user', 'items.product.category'])
            ->where('IsActive', 1)
            ->findOrFail($id);
    }

    public function getProductsForOrderEdit(): Collection
    {
        return Product::with('category')
            ->where('IsActive', 1)
            ->orderBy('Name')
            ->get();
    }

    public function getForCurrentUser(Request $request): LengthAwarePaginator
    {
        $query = Order::with(['items.product'])
            ->where('IsActive', 1)
            ->where('UserId', session('user_id'));

        if ($request->query('search')) {
            $search = $request->query('search');
            $statusFromSearch = $this->getStatusFromSearch($search);

            $query->where(function ($q) use ($search, $statusFromSearch) {
                $q->where('CustomerName', 'like', '%' . $search . '%')
                    ->orWhere('CustomerEmail', 'like', '%' . $search . '%')
                    ->orWhere('Address', 'like', '%' . $search . '%')
                    ->orWhere('Status', 'like', '%' . $search . '%');

                if ($statusFromSearch) {
                    $q->orWhere('Status', $statusFromSearch);
                }

                if (is_numeric($search)) {
                    $q->orWhere('Id', $search);
                }
            });
        }

        if ($request->query('status')) {
            $query->where('Status', $request->query('status'));
        }

        return $query->orderBy('CreationDateTime', 'desc')
            ->paginate(10)
            ->withQueryString();
    }

    public function getForCurrentUserById(int $id): Order
    {
        return Order::with(['items.product.category'])
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

        $model = Order::where('IsActive', 1)->findOrFail($id);

        $this->checkOrderCanBeEdited($model);

        $model->Status = $request->input('Status');
        $model->EditDateTime = now();
        $model->save();
    }

    public function cancel(int $id): void
    {
        DB::transaction(function () use ($id) {
            $order = Order::where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($id);

            if ($order->Status == 'Cancelled') {
                return;
            }

            $items = OrderItem::where('OrderId', $order->Id)
                ->where('IsActive', 1)
                ->lockForUpdate()
                ->get();

            foreach ($items as $item) {
                $product = Product::lockForUpdate()->find($item->ProductId);

                if ($product) {
                    $product->Stock = $product->Stock + $item->Quantity;
                    $product->EditDateTime = now();
                    $product->save();
                }
            }

            $order->Status = 'Cancelled';
            $order->EditDateTime = now();
            $order->save();
        });
    }

    public function restore(int $id): void
    {
        DB::transaction(function () use ($id) {
            $order = Order::where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($id);

            if ($order->Status != 'Cancelled') {
                return;
            }

            $items = OrderItem::where('OrderId', $order->Id)
                ->where('IsActive', 1)
                ->lockForUpdate()
                ->get();

            if ($items->count() == 0) {
                throw ValidationException::withMessages([
                    'order' => 'Nie można przywrócić zamówienia bez pozycji.'
                ]);
            }

            $productsToUpdate = [];

            foreach ($items as $item) {
                $product = Product::lockForUpdate()->find($item->ProductId);

                if (!$product || (int) $product->IsActive !== 1) {
                    throw ValidationException::withMessages([
                        'product' => 'Jeden z produktów w zamówieniu nie jest aktywny.'
                    ]);
                }

                if ($product->Stock < $item->Quantity) {
                    throw ValidationException::withMessages([
                        'stock' => 'Brak wystarczającej ilości produktu "' . $product->Name . '" w magazynie.'
                    ]);
                }

                $productsToUpdate[] = [
                    'product' => $product,
                    'quantity' => $item->Quantity,
                ];
            }

            foreach ($productsToUpdate as $productData) {
                $product = $productData['product'];
                $quantity = $productData['quantity'];

                $product->Stock = $product->Stock - $quantity;
                $product->EditDateTime = now();
                $product->save();
            }

            $order->Status = 'New';
            $order->EditDateTime = now();
            $order->save();
        });
    }

    public function addItem(Request $request, int $orderId): void
    {
        $request->validate([
            'ProductId' => ['required', 'integer', 'exists:Products,Id'],
            'Quantity' => ['required', 'integer', 'min:1'],
        ]);

        DB::transaction(function () use ($request, $orderId) {
            $order = Order::where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($orderId);

            $this->checkOrderCanBeEdited($order);

            $product = Product::where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($request->input('ProductId'));

            $quantity = (int) $request->input('Quantity');

            if ($product->Stock < $quantity) {
                throw ValidationException::withMessages([
                    'stock' => 'Nie można dodać produktu "' . $product->Name . '", ponieważ w magazynie jest tylko ' . $product->Stock . ' szt.'
                ]);
            }

            $existingItem = OrderItem::where('OrderId', $order->Id)
                ->where('ProductId', $product->Id)
                ->where('IsActive', 1)
                ->lockForUpdate()
                ->first();

            if ($existingItem) {
                $existingItem->Quantity = $existingItem->Quantity + $quantity;
                $existingItem->EditDateTime = now();
                $existingItem->save();
            } else {
                $item = new OrderItem();
                $item->OrderId = $order->Id;
                $item->ProductId = $product->Id;
                $item->Quantity = $quantity;
                $item->Price = $product->Price;
                $item->CreationDateTime = now();
                $item->EditDateTime = now();
                $item->IsActive = 1;
                $item->save();
            }

            $product->Stock = $product->Stock - $quantity;
            $product->EditDateTime = now();
            $product->save();

            $this->recalculateTotal($order->Id);
        });
    }

    public function increaseItem(int $orderId, int $itemId): void
    {
        DB::transaction(function () use ($orderId, $itemId) {
            $order = Order::where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($orderId);

            $this->checkOrderCanBeEdited($order);

            $item = OrderItem::where('OrderId', $order->Id)
                ->where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($itemId);

            $product = Product::where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($item->ProductId);

            if ($product->Stock <= 0) {
                throw ValidationException::withMessages([
                    'stock' => 'Nie można zwiększyć ilości produktu "' . $product->Name . '", ponieważ nie ma go w magazynie.'
                ]);
            }

            $item->Quantity = $item->Quantity + 1;
            $item->EditDateTime = now();
            $item->save();

            $product->Stock = $product->Stock - 1;
            $product->EditDateTime = now();
            $product->save();

            $this->recalculateTotal($order->Id);
        });
    }

    public function decreaseItem(int $orderId, int $itemId): void
    {
        DB::transaction(function () use ($orderId, $itemId) {
            $order = Order::where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($orderId);

            $this->checkOrderCanBeEdited($order);

            $item = OrderItem::where('OrderId', $order->Id)
                ->where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($itemId);

            $product = Product::lockForUpdate()
                ->findOrFail($item->ProductId);

            if ($item->Quantity > 1) {
                $item->Quantity = $item->Quantity - 1;
                $item->EditDateTime = now();
                $item->save();

                $product->Stock = $product->Stock + 1;
                $product->EditDateTime = now();
                $product->save();
            } else {
                $item->IsActive = 0;
                $item->EditDateTime = now();
                $item->save();

                $product->Stock = $product->Stock + 1;
                $product->EditDateTime = now();
                $product->save();
            }

            $this->recalculateTotal($order->Id);
        });
    }

    public function deleteItem(int $orderId, int $itemId): void
    {
        DB::transaction(function () use ($orderId, $itemId) {
            $order = Order::where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($orderId);

            $this->checkOrderCanBeEdited($order);

            $item = OrderItem::where('OrderId', $order->Id)
                ->where('IsActive', 1)
                ->lockForUpdate()
                ->findOrFail($itemId);

            $product = Product::lockForUpdate()
                ->findOrFail($item->ProductId);

            $product->Stock = $product->Stock + $item->Quantity;
            $product->EditDateTime = now();
            $product->save();

            $item->IsActive = 0;
            $item->EditDateTime = now();
            $item->save();

            $this->recalculateTotal($order->Id);
        });
    }

    public function delete(int $id): void
    {
        $model = Order::findOrFail($id);
        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();
    }

    private function recalculateTotal(int $orderId): void
    {
        $order = Order::findOrFail($orderId);

        $total = OrderItem::where('OrderId', $orderId)
            ->where('IsActive', 1)
            ->selectRaw('IFNULL(SUM(Price * Quantity), 0) as total')
            ->value('total');

        $order->TotalPrice = $total;
        $order->EditDateTime = now();
        $order->save();
    }

    private function checkOrderCanBeEdited(Order $order): void
    {
        if ($order->Status == 'Cancelled') {
            throw ValidationException::withMessages([
                'order' => 'Nie można edytować anulowanego zamówienia.'
            ]);
        }
    }

    private function getStatusFromSearch(string $search): ?string
    {
        $value = mb_strtolower(trim($search));

        return match ($value) {
            'nowe', 'new' => 'New',
            'opłacone', 'oplacone', 'paid' => 'Paid',
            'wysłane', 'wyslane', 'sent' => 'Sent',
            'zakończone', 'zakonczone', 'finished' => 'Finished',
            'anulowane', 'anulowany', 'cancelled', 'canceled' => 'Cancelled',
            default => null,
        };
    }
}