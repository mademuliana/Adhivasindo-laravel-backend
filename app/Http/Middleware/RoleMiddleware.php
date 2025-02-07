<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = Auth::user();

        // Check if the user's role matches the required role
        if ($user->role !== $role) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
