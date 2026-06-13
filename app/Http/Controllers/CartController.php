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
        $total = 0;

        if (count($cart) > 0) {
            $products = Product::whereIn('Id', array_keys($cart))
                ->where('IsActive', 1)
                ->get();

            foreach ($products as $product) {
                $quantity = $cart[$product->Id] ?? 0;
                $total += $product->Price * $quantity;
            }
        }

        return view('cart.index', [
            'cart' => $cart,
            'products' => $products,
            'total' => $total
        ]);
    }

    public function add(int $id)
    {
        // dodaje produkt do koszyka w sesji
        $product = Product::where('IsActive', 1)->findOrFail($id);

        $cart = session('cart', []);
        $cart[$product->Id] = ($cart[$product->Id] ?? 0) + 1;

        session(['cart' => $cart]);

        return redirect()->route('cart.index')
            ->with('success', 'Produkt został dodany do koszyka.');
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

        return redirect()->route('orders.index')
            ->with('success', 'Zamówienie zostało złożone.');
    }
}