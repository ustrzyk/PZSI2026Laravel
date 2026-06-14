<?php

namespace App\Services;

use App\Models\Accessory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class AccessoryService
{
    public function getAll(Request $request): Collection
    {
        $query = Accessory::query();

        $this->applyVisibilityFilter($query, $request);

        if ($request->query('search')) {
            $query->where('Name', 'like', '%' . $request->query('search') . '%');
        }

        return $query->orderBy('Name')->get();
    }

    public function getById(int $id): Accessory
    {
        return Accessory::findOrFail($id);
    }

    public function addToDb(Request $request): void
    {
        $request->validate([
            'Name' => ['required', 'string', 'max:150'],
            'Description' => ['required', 'string', 'min:5'],
            'Price' => ['required', 'numeric', 'min:0.01'],
        ]);

        $model = new Accessory();
        $model->Name = $request->input('Name');
        $model->Description = $request->input('Description');
        $model->Price = $request->input('Price');
        $model->CreationDateTime = now();
        $model->EditDateTime = now();
        $model->IsActive = 1;
        $model->save();
    }

    public function update(Request $request, int $id): void
    {
        $request->validate([
            'Name' => ['required', 'string', 'max:150'],
            'Description' => ['required', 'string', 'min:5'],
            'Price' => ['required', 'numeric', 'min:0.01'],
        ]);

        $model = Accessory::findOrFail($id);
        $model->Name = $request->input('Name');
        $model->Description = $request->input('Description');
        $model->Price = $request->input('Price');
        $model->EditDateTime = now();
        $model->save();
    }

    public function delete(int $id): void
    {
        $model = Accessory::findOrFail($id);
        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();
    }

    public function restore(int $id): void
    {
        $model = Accessory::findOrFail($id);
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