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
            'search' => $request->query('search'),
            'status' => $request->query('status'),
            'visibility' => $request->query('visibility', 'active')
        ]);
    }

    public function edit(int $id)
    {
        $order = $this->orderService->getById($id);
        $products = $this->orderService->getProductsForOrderEdit();

        return view('orders.edit', [
            'order' => $order,
            'products' => $products
        ]);
    }

    public function update(Request $request, int $id)
    {
        $this->orderService->update($request, $id);

        return redirect()->route('orders.edit', $id)
            ->with('success', 'Status zamówienia został zaktualizowany.');
    }

    public function cancel(int $id)
    {
        $this->orderService->cancel($id);

        return redirect()->back()
            ->with('success', 'Zamówienie zostało anulowane.');
    }

    public function restore(int $id)
    {
        $this->orderService->restore($id);

        return redirect()->back()
            ->with('success', 'Zamówienie zostało przywrócone.');
    }

    public function restoreHidden(int $id)
    {
        $this->orderService->restoreHidden($id);

        return redirect()->route('orders.index', ['visibility' => 'hidden'])
            ->with('success', 'Zamówienie zostało przywrócone na listę.');
    }

    public function addItem(Request $request, int $orderId)
    {
        $this->orderService->addItem($request, $orderId);

        return redirect()->route('orders.edit', $orderId)
            ->with('success', 'Produkt został dodany do zamówienia.');
    }

    public function increaseItem(int $orderId, int $itemId)
    {
        $this->orderService->increaseItem($orderId, $itemId);

        return redirect()->route('orders.edit', $orderId)
            ->with('success', 'Ilość produktu w zamówieniu została zwiększona.');
    }

    public function decreaseItem(int $orderId, int $itemId)
    {
        $this->orderService->decreaseItem($orderId, $itemId);

        return redirect()->route('orders.edit', $orderId)
            ->with('success', 'Ilość produktu w zamówieniu została zmniejszona.');
    }

    public function deleteItem(int $orderId, int $itemId)
    {
        $this->orderService->deleteItem($orderId, $itemId);

        return redirect()->route('orders.edit', $orderId)
            ->with('success', 'Pozycja zamówienia została usunięta.');
    }

    public function delete(int $id)
    {
        $this->orderService->delete($id);

        return redirect()->route('orders.index')
            ->with('success', 'Zamówienie zostało ukryte.');
    }
}