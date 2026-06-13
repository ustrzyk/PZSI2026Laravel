<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // najpierw sprawdzam, czy użytkownik jest zalogowany
        if (!session('user_id')) {
            return redirect()->route('auth.login')
                ->withErrors([
                    'login' => 'Najpierw musisz się zalogować.'
                ]);
        }

        // potem sprawdzam, czy ma role admin
        if (session('user_role') !== 'admin') {
            return redirect()->route('shop.index')
                ->withErrors([
                    'admin' => 'Nie masz dostępu do panelu administracyjnego.'
                ]);
        }

        return $next($request);
    }
}