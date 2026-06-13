<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryService
{
    public function getAll(Request $request): Collection
    {
        $query = Category::where('IsActive', 1);

        if ($request->query('search')) {
            $query->where('Name', 'like', '%' . $request->query('search') . '%');
        }

        return $query->get();
    }

    public function getActive(): Collection
    {
        // pobieram aktywne kategorie do wyboru na stronie sklepu
        return Category::where('IsActive', 1)
            ->orderBy('Name')
            ->get();
    }

    public function getById(int $id): Category
    {
        return Category::findOrFail($id);
    }

    public function addToDb(Request $request): void
    {
        // walidacja kategori
        $request->validate([
            'Name' => ['required', 'string', 'max:100'],
            'Description' => ['nullable', 'string'],
        ]);

        $model = new Category();
        $model->Name = $request->input('Name');
        $model->Description = $request->input('Description');
        $model->CreationDateTime = now();
        $model->EditDateTime = now();
        $model->IsActive = 1;
        $model->save();
    }

    public function update(Request $request, int $id): void
    {
        $request->validate([
            'Name' => ['required', 'string', 'max:100'],
            'Description' => ['nullable', 'string'],
        ]);

        $model = Category::findOrFail($id);
        $model->Name = $request->input('Name');
        $model->Description = $request->input('Description');
        $model->EditDateTime = now();
        $model->save();
    }

    public function delete(int $id): void
    {
        $model = Category::findOrFail($id);
        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();
    }
}