<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $isLogged = $this->authService->login($request);

        if ($isLogged) {
            return $this->redirectAfterLogin()
                ->with('success', 'Zalogowano poprawnie.');
        }

        return back()->withErrors([
            'login' => 'Niepoprawny login albo hasło.'
        ])->withInput();
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $this->authService->register($request);

        return redirect()->route('auth.login')
            ->with('success', 'Konto zostało utworzone. Możesz się zalogować.');
    }

    public function logout()
    {
        $this->authService->logout();

        return redirect()->route('shop.index')
            ->with('success', 'Wylogowano poprawnie.');
    }

    private function redirectAfterLogin()
    {
        if (session('user_role') === 'admin' && Route::has('dashboard.index')) {
            return redirect()->route('dashboard.index');
        }

        return redirect()->route('shop.index');
    }
}