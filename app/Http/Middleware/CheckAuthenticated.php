<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        // Block access if no session
        if (!session()->has('user_id')) {
            return redirect()->route('login.show')->with('error', 'Please log in first.');
        }

        // Prevent browser caching of protected pages
        $response = $next($request);
        $response->headers->set('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');
        $response->headers->set('Pragma','no-cache');
        $response->headers->set('Expires','Sat, 01 Jan 2000 00:00:00 GMT');

        return $response;
    }
}
