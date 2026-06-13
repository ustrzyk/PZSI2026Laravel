<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll(Request $request): Collection
    {
        $query = User::where('IsActive', 1);

        if ($request->query('search')) {
            $query->where('Name', 'like', '%' . $request->query('search') . '%');
        }

        return $query->get();
    }

    public function getById(int $id): User
    {
        return User::findOrFail($id);
    }

    public function addToDb(Request $request): void
    {
        $request->validate([
            'Name' => ['required', 'string', 'max:100'],
            'Email' => ['required', 'string', 'max:150', 'unique:Users,Email'],
            'Password' => ['required', 'string', 'min:5'],
        ]);

        $model = new User();
        $model->Name = $request->input('Name');
        $model->Email = $request->input('Email');
        $model->Password = Hash::make($request->input('Password'));
        $model->CreationDateTime = now();
        $model->EditDateTime = now();
        $model->IsActive = 1;
        $model->save();
    }

    public function update(Request $request, int $id): void
    {
        $request->validate([
            'Name' => ['required', 'string', 'max:100'],
            'Email' => ['required', 'string', 'max:150', 'unique:Users,Email,' . $id . ',Id'],
            'Password' => ['nullable', 'string', 'min:5'],
        ]);

        $model = User::findOrFail($id);
        $model->Name = $request->input('Name');
        $model->Email = $request->input('Email');

        if ($request->input('Password')) {
            $model->Password = Hash::make($request->input('Password'));
        }

        $model->EditDateTime = now();
        $model->save();
    }

    public function delete(int $id): void
    {
        $model = User::findOrFail($id);
        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();
    }
}