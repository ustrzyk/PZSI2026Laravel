<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(Request $request): void
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

    public function login(Request $request): bool
    {
        $request->validate([
            'Email' => ['required', 'string'],
            'Password' => ['required', 'string'],
        ]);

        $user = User::where('Email', $request->input('Email'))
            ->where('IsActive', 1)
            ->first();

        if ($user && Hash::check($request->input('Password'), $user->Password)) {
            session(['user_id' => $user->Id]);
            session(['user_name' => $user->Name]);

            return true;
        }

        return false;
    }

    public function logout(): void
    {
        session()->forget('user_id');
        session()->forget('user_name');
    }
}