<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Warga;
use App\Models\TransaksiKas;
use App\Models\KartuKeluarga;
class EnsureAccessRT
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (!$user || $user->isAdmin()) {
            return $next($request);
        }

        if (!$user->rt_id) {
            return $next($request);
        }
        // Cek Parameter Rute (Contoh: /warga/{warga})
        $warga = $request->route('warga');
        if ($warga) {
            $wargaModel = ($warga instanceof Warga) ? $warga : Warga::find($warga);
            if ($wargaModel && $wargaModel->kartuKeluarga->rt_id !== $user->rt_id) {
                abort(403, 'Akses Ditolak: Data Warga ini bukan milik RT Anda.');
            }
        }
        $transaksi = $request->route('transaksi');
        if ($transaksi) {
            $transaksiModel = ($transaksi instanceof TransaksiKas) ? $transaksi : TransaksiKas::find($transaksi);
            if ($transaksiModel && $transaksiModel->rt_id !== $user->rt_id) {
                abort(403, 'Akses Ditolak: Data Transaksi ini bukan milik RT Anda.');
            }
        }
        return $next($request);
    }
}
