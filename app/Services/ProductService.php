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
        $query = Product::with(['category', 'accessories']);

        $this->applyVisibilityFilter($query, $request);

        if ($request->query('search')) {
            $query->where('Name', 'like', '%' . $request->query('search') . '%');
        }

        return $query->orderBy('Name')->get();
    }

    public function getPromotedForShop(Request $request): Collection
    {
        $query = Product::with(['category', 'accessories'])
            ->where('IsActive', 1)
            ->where('IsPromoted', 1);

        if ($request->query('search')) {
            $query->where('Name', 'like', '%' . $request->query('search') . '%');
        }

        if ($request->query('category_id')) {
            $query->where('CategoryId', $request->query('category_id'));
        }

        return $query->orderBy('Name')
            ->take(12)
            ->get();
    }

    public function getForCategory(Request $request, int $categoryId): LengthAwarePaginator
    {
        $query = Product::with(['category', 'accessories'])
            ->where('IsActive', 1)
            ->where('CategoryId', $categoryId);

        if ($request->query('search')) {
            $query->where('Name', 'like', '%' . $request->query('search') . '%');
        }

        return $query->orderBy('Name')
            ->paginate(6)
            ->withQueryString();
    }

    public function getForShop(Request $request): LengthAwarePaginator
    {
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

    public function getActiveByIdForShop(int $id): Product
    {
        return Product::with(['category', 'accessories'])
            ->where('IsActive', 1)
            ->findOrFail($id);
    }

    public function addToDb(Request $request): void
    {
        $request->validate([
            'Name' => ['required', 'string', 'max:150'],
            'Description' => ['required', 'string', 'min:5'],
            'Price' => ['required', 'numeric', 'min:0.01'],
            'Stock' => ['required', 'integer', 'min:0'],
            'CategoryId' => ['required', 'integer', 'exists:Categories,Id'],
            'ImageUrl' => ['nullable', 'string', 'max:255'],
            'IsPromoted' => ['nullable'],
            'Accessories' => ['nullable', 'array'],
        ]);

        $model = new Product();
        $model->Name = $request->input('Name');
        $model->Description = $request->input('Description');
        $model->Price = $request->input('Price');
        $model->Stock = $request->input('Stock');
        $model->CategoryId = $request->input('CategoryId');
        $model->ImageUrl = $request->input('ImageUrl');
        $model->IsPromoted = $request->has('IsPromoted') ? 1 : 0;
        $model->CreationDateTime = now();
        $model->EditDateTime = now();
        $model->IsActive = 1;
        $model->save();

        $model->accessories()->sync($request->input('Accessories', []));
    }

    public function update(Request $request, int $id): void
    {
        $request->validate([
            'Name' => ['required', 'string', 'max:150'],
            'Description' => ['required', 'string', 'min:5'],
            'Price' => ['required', 'numeric', 'min:0.01'],
            'Stock' => ['required', 'integer', 'min:0'],
            'CategoryId' => ['required', 'integer', 'exists:Categories,Id'],
            'ImageUrl' => ['nullable', 'string', 'max:255'],
            'IsPromoted' => ['nullable'],
            'Accessories' => ['nullable', 'array'],
        ]);

        $model = Product::findOrFail($id);
        $model->Name = $request->input('Name');
        $model->Description = $request->input('Description');
        $model->Price = $request->input('Price');
        $model->Stock = $request->input('Stock');
        $model->CategoryId = $request->input('CategoryId');
        $model->ImageUrl = $request->input('ImageUrl');
        $model->IsPromoted = $request->has('IsPromoted') ? 1 : 0;
        $model->EditDateTime = now();
        $model->save();

        $model->accessories()->sync($request->input('Accessories', []));
    }

    public function delete(int $id): void
    {
        $model = Product::findOrFail($id);
        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();
    }

    public function restore(int $id): void
    {
        $model = Product::findOrFail($id);
        $model->IsActive = 1;
        $model->EditDateTime = now();
        $model->save();
    }

    private function applyVisibilityFilter($query, Request $request): void
    {
        $visibility = $request->query('visibility', 'active');

        if ($visibility == 'hidden') {
            $query->where('IsActive', 0);
        } elseif ($visibility == 'all') {
            return;
        } else {
            $query->where('IsActive', 1);
        }
    }
}