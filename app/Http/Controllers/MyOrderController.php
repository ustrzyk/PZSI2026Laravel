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
        $orders = $this->orderService->getForCurrentUser($request);

        return view('myOrders.index', [
            'orders' => $orders,
            'search' => $request->query('search'),
            'status' => $request->query('status')
        ]);
    }

    public function show(int $id)
    {
        $order = $this->orderService->getForCurrentUserById($id);

        return view('myOrders.show', [
            'order' => $order
        ]);
    }
}