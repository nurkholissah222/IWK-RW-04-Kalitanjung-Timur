<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleRT
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || strtoupper(Auth::user()->role ?? '') !== 'RT') {
            return redirect()->route('dashboard.rw')->with('error', 'Akses khusus Bendahara RT.');
        }

        return $next($request);
    }
}
