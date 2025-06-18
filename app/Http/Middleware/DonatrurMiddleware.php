<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DonatrurMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isDonatur()) {
            abort(403, 'Access denied. Donatur only.');
        }

        return $next($request);
    }
} 