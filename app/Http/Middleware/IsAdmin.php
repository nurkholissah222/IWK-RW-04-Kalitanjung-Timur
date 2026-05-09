<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = strtoupper(Auth::user()->role ?? '');
        if (!Auth::check() || ($role !== 'RW' && $role !== 'ADMIN')) {
            abort(403, 'Akses Ditolak: Khusus Bendahara RW.');
        }

        return $next($request);
    }
}
