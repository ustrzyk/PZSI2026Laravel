<?php

namespace App\Services;

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
        $model->OrderId = $request->input('OrderId');
        $model->ProductId = $request->input('ProductId');
        $model->Quantity = $request->input('Quantity');
        $model->Price = $product->Price;
        $model->EditDateTime = now();
        $model->save();
    }

    public function delete(int $id): void
    {
        $model = OrderItem::findOrFail($id);
        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();
    }
}