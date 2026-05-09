<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AdminOrPetugas
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        $role = strtoupper($user->role ?? '');
        // 1. Role Protection
        if (!in_array($role, ['RW', 'RT', 'ADMIN', 'PETUGAS'])) {
            abort(403, 'Akses Ditolak: Anda bukan Bendahara RW atau RT.');
        }

        // 2. Anti ID Guessing (Contoh: Jika route memiliki parameter {warga})
        // Karena kita sudah pakai Global Scope, query model otomatis terfilter.
        // Tapi jika ada parameter mentah di URL yang ingin kita pastikan milik RT yang sama:
        if ($request->route('warga')) {
            $warga = $request->route('warga'); // Jika pakai Route Model Binding
            // Jika warga tidak ditemukan (karena Global Scope mem-filter query find), Laravel akan 404 otomatis.
        }

        return $next($request);
    }
}
