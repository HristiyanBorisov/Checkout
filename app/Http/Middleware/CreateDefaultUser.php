<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Response;

class CreateDefaultUser
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
        if (!User::where('email', 'default@example.com')->exists()) {
            User::create(
                [
                    'id' => Uuid::uuid4()->toString(),
                    'name' => 'Default User',
                    'email' => 'default@example.com',
                    'password' => Hash::make('password123'),
                ]
            );
        }
        return $next($request);
    }
}
