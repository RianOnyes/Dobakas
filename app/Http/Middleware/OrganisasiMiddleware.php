<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OrganisasiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !Auth::user()->isOrganisasi()) {
            abort(403, 'Access denied. Organisasi only.');
        }

        return $next($request);
    }
} 