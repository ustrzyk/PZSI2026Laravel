<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class OrderItemService
{
    public function getAll(Request $request): Collection
    {
        $query = OrderItem::with(['order', 'product'])
            ->where('IsActive', 1);

        if ($request->query('search')) {
            $query->whereHas('product', function ($q) use ($request) {
                $q->where('Name', 'like', '%' . $request->query('search') . '%');
            });
        }

        return $query->get();
    }

    public function getById(int $id): OrderItem
    {
        return OrderItem::with(['order', 'product'])->findOrFail($id);
    }

    public function addToDb(Request $request): void
    {
        $request->validate([
            'OrderId' => ['required', 'integer', 'exists:Orders,Id'],
            'ProductId' => ['required', 'integer', 'exists:Products,Id'],
            'Quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->input('ProductId'));

        $model = new OrderItem();
        $model->OrderId = $request->input('OrderId');
        $model->ProductId = $request->input('ProductId');
        $model->Quantity = $request->input('Quantity');
        $model->Price = $product->Price;
        $model->CreationDateTime = now();
        $model->EditDateTime = now();
        $model->IsActive = 1;
        $model->save();

        // po dodaniu pozycji przeliczam wartość całego zamówienia
        $this->recalculateOrderTotal($model->OrderId);
    }

    public function update(Request $request, int $id): void
    {
        $request->validate([
            'OrderId' => ['required', 'integer', 'exists:Orders,Id'],
            'ProductId' => ['required', 'integer', 'exists:Products,Id'],
            'Quantity' => ['required', 'integer', 'min:1'],
        ]);

        $product = Product::findOrFail($request->input('ProductId'));

        $model = OrderItem::findOrFail($id);

        // zapamiętuje stare zamówienie, bo pozycja może zostać przeniesiona do innego zamówienia
        $oldOrderId = $model->OrderId;

        $model->OrderId = $request->input('OrderId');
        $model->ProductId = $request->input('ProductId');
        $model->Quantity = $request->input('Quantity');
        $model->Price = $product->Price;
        $model->EditDateTime = now();
        $model->save();

        // przeliczam stare zamówienie
        $this->recalculateOrderTotal($oldOrderId);

        // jeśli pozycja została przeniesiona do innego zamówienia, przeliczam też nowe
        if ($oldOrderId != $model->OrderId) {
            $this->recalculateOrderTotal($model->OrderId);
        }
    }

    public function delete(int $id): void
    {
        $model = OrderItem::findOrFail($id);
        $orderId = $model->OrderId;

        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();

        // po dezaktywacji pozycji przeliczam wartość zamówienia
        $this->recalculateOrderTotal($orderId);
    }

    private function recalculateOrderTotal(int $orderId): void
    {
        $order = Order::findOrFail($orderId);

        $items = OrderItem::where('OrderId', $orderId)
            ->where('IsActive', 1)
            ->get();

        $total = 0;

        foreach ($items as $item) {
            $total += $item->Price * $item->Quantity;
        }

        $order->TotalPrice = $total;
        $order->EditDateTime = now();
        $order->save();
    }
}