<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    public function getAll(Request $request): Collection
    {
        $query = User::query();

        $this->applyVisibilityFilter($query, $request);

        if ($request->query('search')) {
            $query->where('Name', 'like', '%' . $request->query('search') . '%');
        }

        return $query->orderBy('Name')->get();
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
            'Role' => ['required', 'string', 'in:admin,client'],
        ]);

        $model = new User();
        $model->Name = $request->input('Name');
        $model->Email = $request->input('Email');
        $model->Password = Hash::make($request->input('Password'));
        $model->Role = $request->input('Role');
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
            'Role' => ['required', 'string', 'in:admin,client'],
        ]);

        $model = User::findOrFail($id);
        $model->Name = $request->input('Name');
        $model->Email = $request->input('Email');
        $model->Role = $request->input('Role');

        if ($request->input('Password')) {
            $model->Password = Hash::make($request->input('Password'));
        }

        $model->EditDateTime = now();
        $model->save();

        if (session('user_id') == $model->Id) {
            session(['user_name' => $model->Name]);
            session(['user_role' => $model->Role]);
        }
    }

    public function delete(int $id): void
    {
        if (session('user_id') == $id) {
            throw ValidationException::withMessages([
                'user' => 'Nie możesz zablokować własnego konta.'
            ]);
        }

        $model = User::findOrFail($id);
        $model->IsActive = 0;
        $model->EditDateTime = now();
        $model->save();
    }

    public function restore(int $id): void
    {
        $model = User::findOrFail($id);
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