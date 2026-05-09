<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TransaksiKas;
use App\Models\Warga;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $role = strtoupper($user->role ?? '');

        if ($role === 'RW' || $role === 'ADMIN' || (empty($role) && is_null($user->rt_id))) {
            return redirect()->route('dashboard.rw');
        } elseif ($role === 'RT' || $role === 'PETUGAS' || (empty($role) && !is_null($user->rt_id))) {
            return redirect()->route('dashboard.rt');
        }

        return abort(403, 'Role tidak dikenali: ' . ($user->role ?: 'KOSONG'));
    }

    public function rwDashboard()
    {
        return $this->getDashboardData(null);
    }

    public function rtDashboard()
    {
        return $this->getDashboardData(Auth::user()->rt_id);
    }

    private function getDashboardData($rtId)
    {
        $user = Auth::user();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // 1. Perhitungan Saldo Kas (Masuk - Keluar)
        // Jika rtId null (RW), byRt(null) harusnya mengambil semua data atau data RW
        // Kita pastikan model byRt handle null dengan benar.
        $totalMasuk = TransaksiKas::byRt($rtId)->where('jenis_transaksi', 'Masuk')->sum('jumlah');
        $totalKeluar = TransaksiKas::byRt($rtId)->where('jenis_transaksi', 'Keluar')->sum('jumlah');
        $totalKas = $totalMasuk - $totalKeluar;

        // 1.1 Breakdown Pendapatan (IWK vs Lainnya)
        $incomeByIWK = TransaksiKas::byRt($rtId)
            ->where('jenis_transaksi', 'Masuk')
            ->whereHas('category', function($q) {
                $q->where('name', 'like', '%IWK%')
                  ->orWhere('name', 'like', '%Andon%');
            })->sum('jumlah');
        $incomeByOther = $totalMasuk - $incomeByIWK;

        // 2. Pengeluaran Bulan Ini
        $pengeluaranBulanIni = TransaksiKas::byRt($rtId)
            ->where('jenis_transaksi', 'Keluar')
            ->whereMonth('tanggal', $currentMonth)
            ->whereYear('tanggal', $currentYear)
            ->sum('jumlah');

        // 3. Logika Menghitung Tunggakan (Latest First)
        $wargas = Warga::with('rtUnit')->whereHas('kartuKeluarga', function($q) use ($rtId) {
            if ($rtId) {
                $q->where('rt_id', $rtId);
            }
        })->latest()->get();

        $tunggakanWarga = [];
        $allMonthsNames = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        
        foreach ($wargas as $w) {
            $jumlahBulanMenunggak = 0;
            $bulanMenunggakList = [];

            // Tentukan tarif berdasarkan jenis iuran
            $tarif = 0;
            if (stripos($w->jenis_iuran, 'IWK') !== false) {
                $tarif = 3000;
            } elseif (stripos($w->jenis_iuran, 'Andon') !== false) {
                $tarif = 5000;
            } else {
                // Default fallback jika tidak cocok
                $tarif = ($w->status_warga == 'Pribumi') ? 3000 : 5000;
            }

            // Cek setiap bulan dari Januari (1) sampai bulan sekarang
            for ($m = 1; $m <= $currentMonth; $m++) {
                $namaBulanCek = $allMonthsNames[$m - 1];
                
                // Cek apakah ada transaksi masuk untuk warga ini di bulan & tahun ini
                // Kita cek berdasarkan 'uraian' yang mengandung nama bulan, karena sistem mencatat bulan di uraian
                $sudahBayar = TransaksiKas::where('warga_id', $w->id)
                    ->where('jenis_transaksi', 'Masuk')
                    ->whereYear('tanggal', $currentYear)
                    ->where('uraian', 'LIKE', '%' . $namaBulanCek . '%')
                    ->exists();

                if (!$sudahBayar) {
                    $jumlahBulanMenunggak++;
                    $bulanMenunggakList[] = $namaBulanCek;
                }
            }

            if ($jumlahBulanMenunggak > 0) {
                $tunggakanWarga[] = (object) [
                    'nama_warga' => $w->nama_warga,
                    'jenis_iuran' => $w->jenis_iuran,
                    'no_wa' => $w->no_telp ?? '',
                    'jumlah_bulan' => $jumlahBulanMenunggak,
                    'tarif' => $tarif,
                    'nominal' => $jumlahBulanMenunggak * $tarif,
                    'bulan_list' => implode(', ', $bulanMenunggakList)
                ];
            }
        }

        $jumlahMenunggak = count($tunggakanWarga);
        $jumlahWarga = $wargas->count();
        
        Carbon::setLocale('id');
        $namaBulan = Carbon::now()->translatedFormat('F Y');

        $profil = \App\Models\ProfilRt::firstOrCreate(
            ['id' => 1],
            [
                'nama_bendahara' => 'Bendahara RW',
                'no_wa_bendahara' => '081234567890',
                'nama_rt' => 'Ketua RW',
                'no_wa_rt' => '089876543210'
            ]
        );

        // Dynamic Text
        if ($rtId === null) {
            $wilayahText = 'RW 04';
        } else {
            $wilayahText = $user->unit_rt ? 'RT ' . $user->unit_rt : 'RT ' . str_pad($user->rtUnit->nomor_rt ?? '00', 2, '0', STR_PAD_LEFT);
        }
        $jabatanText = ($rtId === null) ? 'Bendahara RW' : 'Bendahara RT';
        $saldoTitle = 'Total Saldo Kas ' . $wilayahText;
        $wargaTitle = 'Total Warga ' . $wilayahText;

        return view('dashboard', compact(
            'totalKas', 
            'incomeByIWK',
            'incomeByOther',
            'pengeluaranBulanIni', 
            'tunggakanWarga', 
            'jumlahMenunggak',
            'jumlahWarga',
            'namaBulan',
            'user',
            'profil',
            'wilayahText',
            'jabatanText',
            'saldoTitle',
            'wargaTitle'
        ));
    }
}
