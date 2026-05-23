<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        $allowedRoles = $roles ?: ['admin', 'manager'];

        if (!auth()->check() || !in_array(auth()->user()->role, $allowedRoles, true)) {
            return redirect('/')->with('error', 'Unauthorized access!');
        }

        return $next($request);
    }
}
