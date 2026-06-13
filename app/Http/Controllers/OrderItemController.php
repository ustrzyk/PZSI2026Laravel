<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\OrderItemService;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    private OrderItemService $orderItemService;

    public function __construct(OrderItemService $orderItemService)
    {
        $this->orderItemService = $orderItemService;
    }

    public function index(Request $request)
    {
        $items = $this->orderItemService->getAll($request);

        return view('orderItems.index', [
            'items' => $items,
            'search' => $request->query('search')
        ]);
    }

    public function create()
    {
        $orders = Order::where('IsActive', 1)->get();
        $products = Product::where('IsActive', 1)->get();

        return view('orderItems.create', [
            'orders' => $orders,
            'products' => $products
        ]);
    }

    public function store(Request $request)
    {
        $this->orderItemService->addToDb($request);

        return redirect()->route('order-items.index')
            ->with('success', 'Pozycja zamówienia została dodana.');
    }

    public function edit(int $id)
    {
        $item = $this->orderItemService->getById($id);
        $orders = Order::where('IsActive', 1)->get();
        $products = Product::where('IsActive', 1)->get();

        return view('orderItems.edit', [
            'item' => $item,
            'orders' => $orders,
            'products' => $products
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->orderItemService->update($request, $id);

        return redirect()->route('order-items.index')
            ->with('success', 'Pozycja zamówienia została zaktualizowana.');
    }

    public function delete(int $id)
    {
        $this->orderItemService->delete($id);

        return redirect()->route('order-items.index')
            ->with('success', 'Pozycja zamówienia została dezaktywowana.');
    }
}