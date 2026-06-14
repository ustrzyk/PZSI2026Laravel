<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $cart = session('cart', []);
        $products = collect();
        $unavailableProducts = collect();
        $missingProductIds = collect();
        $total = 0;
        $hasStockError = false;

        if (count($cart) > 0) {
            $allProducts = Product::with('category')
                ->whereIn('Id', array_keys($cart))
                ->orderBy('Name')
                ->get();

            $existingProductIds = $allProducts->pluck('Id')->toArray();
            $missingProductIds = collect(array_diff(array_keys($cart), $existingProductIds));

            if ($missingProductIds->count() > 0) {
                $hasStockError = true;
            }

            foreach ($allProducts as $product) {
                $quantity = $cart[$product->Id] ?? 0;

                if (
                    (int) $product->IsActive !== 1 ||
                    !$product->category ||
                    (int) $product->category->IsActive !== 1
                ) {
                    $unavailableProducts->push($product);
                    $hasStockError = true;
                    continue;
                }

                $products->push($product);
                $total += $product->Price * $quantity;

                if ($quantity > $product->Stock) {
                    $hasStockError = true;
                }
            }
        }

        return view('cart.index', [
            'cart' => $cart,
            'products' => $products,
            'unavailableProducts' => $unavailableProducts,
            'missingProductIds' => $missingProductIds,
            'total' => $total,
            'hasStockError' => $hasStockError
        ]);
    }

    public function add(int $id)
    {
        return $this->increase($id);
    }

    public function increase(int $id)
    {
        $product = Product::with('category')
            ->where('IsActive', 1)
            ->whereHas('category', function ($q) {
                $q->where('IsActive', 1);
            })
            ->findOrFail($id);

        if ($product->Stock <= 0) {
            return redirect()->back()
                ->withErrors([
                    'stock' => 'Tego produktu nie ma już w magazynie.'
                ]);
        }

        $cart = session('cart', []);
        $currentQuantity = $cart[$product->Id] ?? 0;

        if ($currentQuantity >= $product->Stock) {
            return redirect()->back()
                ->withErrors([
                    'stock' => 'Nie możesz dodać więcej sztuk tego produktu, ponieważ w magazynie jest tylko ' . $product->Stock . ' szt.'
                ]);
        }

        $cart[$product->Id] = $currentQuantity + 1;

        session(['cart' => $cart]);

        return redirect()->route('cart.index')
            ->with('success', 'Ilość produktu w koszyku została zwiększona.');
    }

    public function decrease(int $id)
    {
        $cart = session('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->route('cart.index')
                ->withErrors([
                    'cart' => 'Tego produktu nie ma w koszyku.'
                ]);
        }

        if ($cart[$id] > 1) {
            $cart[$id] = $cart[$id] - 1;

            session(['cart' => $cart]);

            return redirect()->route('cart.index')
                ->with('success', 'Ilość produktu w koszyku została zmniejszona.');
        }

        unset($cart[$id]);

        session(['cart' => $cart]);

        return redirect()->route('cart.index')
            ->with('success', 'Produkt został usunięty z koszyka.');
    }

    public function remove(int $id)
    {
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        session(['cart' => $cart]);

        return redirect()->route('cart.index')
            ->with('success', 'Produkt został usunięty z koszyka.');
    }

    public function order(Request $request)
    {
        $this->orderService->createFromCart($request);

        return redirect()->route('my-orders.index')
            ->with('success', 'Zamówienie zostało złożone.');
    }
}