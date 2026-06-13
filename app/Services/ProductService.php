<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getAll(Request $request): Collection
    {
        // tu pobieram produkty do panelu admina
        $query = Product::with(['category', 'accessories'])
            ->where('IsActive', 1);

        if ($request->query('search')) {
            $query->where('Name', 'like', '%' . $request->query('search') . '%');
        }

        return $query->get();
    }

    public function getForShop(Request $request): LengthAwarePaginator
    {
        // tu pobieram produkty do widoku klienta
        $query = Product::with(['category', 'accessories'])
            ->where('IsActive', 1);

        if ($request->query('search')) {
            $query->where('Name', 'like', '%' . $request->query('search') . '%');
        }

        if ($request->query('category_id')) {
            $query->where('CategoryId', $request->query('category_id'));
        }

        return $query->orderBy('Name')
            ->paginate(6)
            ->withQueryString();
    }

    public function getById(int $id): Product
    {
        return Product::with(['category', 'accessories'])->findOrFail($id);
    }

    public function addToDb(Request $request): void
    {
        // walidacja dla nowego produktu
        $request->validate([
            'Name' => ['required', 'string', 'max:150'],
            'Description' => ['required', 'string', 'min:5'],
            'Price' => ['required', 'numeric', 'min:0.01'],
            'Stock' => ['required', 'integer', 'min:0'],
            'CategoryId' => ['required', 'integer', 'exists:Categories,Id'],
            'ImageUrl' => ['nullable', 'string', 'max:255'],
            'Accessories' => ['nullable', 'array'],
        ]);

        $model = new Product();
        $model->Name = $request->input('Name');
        $model->Description = $request->input('Description');
        $model->Price = $request->input('Price');
        $model->Stock = $request->input('Stock');
        $model->CategoryId = $request->input('CategoryId');
        $model->ImageUrl = $request->input('ImageUrl');
        $model->CreationDateTime = now();
        $model->EditDateTime = now();
        $model->IsActive = 1;
        $model->save();

        $model->accessories()->sync($request->input('Accessories', []));
    }

    public function update(Request $request, int $id): void
    {
        // tutaj aktualizuje produkt
        $request->validate([
            'Name' => ['required', 'string', 'max:150'],
            'Description' => ['required', 'string', 'min:5'],
            'Price' => ['required', 'numeric', 'min:0.01'],
            'Stock' => ['required', 'integer', 'min:0'],
            'CategoryId' => ['required', 'integer', 'exists:Categories,Id'],
            'ImageUrl' => ['nullable', 'string', 'max:255'],
            'Accessories' => ['nullable', 'array'],
        ]);

        $model = Product::findOrFail($id);
        $model->Name = $request->input('Name');
        $model->Description = $request->input('Description');
        $model->Price = $request->input('Price');
        $model->Stock = $request->input('Stock');
        $model->CategoryId = $request->input('CategoryId');
        $model->ImageUrl = $request->input('ImageUrl');
        $model->EditDateTime = now();
        $model->save();

        $model->accessories()->sync($request->input('Accessories', []));
    }

    public function delete(int $id): void
    {
        // nie kasuje z bazy, tylko chowam rekord
        $model = Product::findOrFail($id);
        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();
    }
}