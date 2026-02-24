<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserLevel
{
    public function handle($request, Closure $next, $role)
    {
        if (session('user_level') !== $role) {
            return redirect('/login')->with('error', 'Unauthorized access.');
        }
        return $next($request);
    }
}
