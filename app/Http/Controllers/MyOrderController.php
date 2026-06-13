<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;

class MyOrderController extends Controller
{
    private OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        // klient widzi tylko swoje zamówienia
        $orders = $this->orderService->getForCurrentUser($request);

        return view('myOrders.index', [
            'orders' => $orders,
            'search' => $request->query('search')
        ]);
    }

    public function show(int $id)
    {
        // klient może podejrzeć tylko swoje zamówienie
        $order = $this->orderService->getForCurrentUserById($id);

        return view('myOrders.show', [
            'order' => $order
        ]);
    }
}