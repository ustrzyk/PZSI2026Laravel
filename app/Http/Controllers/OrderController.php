<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $orders = $this->orderService->getAll($request);

        return view('orders.index', [
            'orders' => $orders,
            'search' => $request->query('search')
        ]);
    }

    public function edit(int $id)
    {
        $order = $this->orderService->getById($id);

        return view('orders.edit', [
            'order' => $order
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->orderService->update($request, $id);

        return redirect()->route('orders.index')
            ->with('success', 'Zamówienie zostało zaktualizowane.');
    }

    public function delete(int $id)
    {
        $this->orderService->delete($id);

        return redirect()->route('orders.index')
            ->with('success', 'Zamówienie zostało dezaktywowane.');
    }
}