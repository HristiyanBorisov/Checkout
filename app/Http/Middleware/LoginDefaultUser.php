<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginDefaultUser
{
    /**
     * Handle an incoming request.
     *
     */
    public function handle(
        Request $request,
        Closure $next
    ): Response
    {
        if (!Auth::check()) {
            $credentials = [
                'email' => 'default@example.com',
                'password' => 'password123',
            ];

            Auth::attempt($credentials);
        }
        return $next($request);
    }
}
