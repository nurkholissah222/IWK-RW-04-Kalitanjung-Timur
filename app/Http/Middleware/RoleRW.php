<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleRW
{
    public function handle(Request $request, Closure $next): Response
    {
        $role = strtoupper(Auth::user()->role ?? '');
        if (!Auth::check() || ($role !== 'RW' && $role !== 'ADMIN')) {
            return redirect()->route('dashboard.rt')->with('error', 'Akses khusus Bendahara RW.');
        }

        return $next($request);
    }
}
