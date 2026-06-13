<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLogged
{
    public function handle(Request $request, Closure $next): Response
    {
        // sprawdzam, czy użytkownik jest zalogowany
        if (!session('user_id')) {
            return redirect()->route('auth.login')
                ->withErrors([
                    'login' => 'Najpierw musisz się zalogować.'
                ]);
        }

        return $next($request);
    }
}