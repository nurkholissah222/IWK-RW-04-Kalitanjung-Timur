<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransaksiKas;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        // Sort by created_at desc to show newest inputs first
        $query = TransaksiKas::with('category', 'warga')->orderBy('created_at', 'desc');

        if ($user->isAdmin() && $request->filled('rt_id')) {
            $query->where('rt_id', $request->rt_id);
        }

        $transaksis = $query->get();

        $totalMasukQuery = TransaksiKas::where('jenis_transaksi', 'Masuk');
        $totalKeluarQuery = TransaksiKas::where('jenis_transaksi', 'Keluar');

        if ($user->isAdmin() && $request->filled('rt_id')) {
            $totalMasukQuery->where('rt_id', $request->rt_id);
            $totalKeluarQuery->where('rt_id', $request->rt_id);
        }

        $totalMasuk = $totalMasukQuery->sum('jumlah');
        $totalKeluar = $totalKeluarQuery->sum('jumlah');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        $rts = \App\Models\RtUnit::all();
        $selectedRt = $request->rt_id;

        $rtIdForProfile = ($user->isAdmin() && $request->filled('rt_id')) ? $request->rt_id : $user->rt_id;
        $profil = \App\Models\ProfilRt::where('rt_id', $rtIdForProfile)->first();
        $profilRW = \App\Models\ProfilRt::whereNull('rt_id')->first();

        return view('laporan.index', compact('transaksis', 'totalMasuk', 'totalKeluar', 'saldoAkhir', 'rts', 'selectedRt', 'user', 'profil', 'profilRW'));
    }

    public function print()
    {
        $user = Auth::user();
        // Print also newest first as requested (baru ke lama)
        $transaksis = TransaksiKas::with('category', 'warga')->orderBy('created_at', 'desc')->get();
        $totalMasuk = TransaksiKas::where('jenis_transaksi', 'Masuk')->sum('jumlah');
        $totalKeluar = TransaksiKas::where('jenis_transaksi', 'Keluar')->sum('jumlah');
        $saldoAkhir = $totalMasuk - $totalKeluar;

        return view('laporan.print', compact('transaksis', 'totalMasuk', 'totalKeluar', 'saldoAkhir'));
    }

    // Existing methods for PDF export
    private function exportKuartal($rtId)
    {
        \Carbon\Carbon::setLocale('id');
        $now = now();
        $startOfQuarter = $now->copy()->startOfQuarter();
        $endOfQuarter = $now->copy()->endOfQuarter();
        
        $startMonth = strtoupper($startOfQuarter->translatedFormat('F'));
        $endMonth = strtoupper($endOfQuarter->translatedFormat('F'));
        $year = $now->format('Y');

        // Saldo sebelum periode
        $masukSblm = TransaksiKas::when($rtId, function ($query) use ($rtId) {
                return $query->where('rt_id', $rtId);
            })
            ->where('tanggal', '<', $startOfQuarter)
            ->where('jenis_transaksi', 'Masuk')
            ->sum('jumlah');
            
        $keluarSblm = TransaksiKas::when($rtId, function ($query) use ($rtId) {
                return $query->where('rt_id', $rtId);
            })
            ->where('tanggal', '<', $startOfQuarter)
            ->where('jenis_transaksi', 'Keluar')
            ->sum('jumlah');
            
        $saldoAwal = $masukSblm - $keluarSblm;

        // Sort by created_at desc for PDF (baru ke lama)
        $transaksis = TransaksiKas::with(['category', 'warga'])
                        ->when($rtId, function ($query) use ($rtId) {
                            return $query->where('rt_id', $rtId);
                        })
                        ->whereBetween('tanggal', [$startOfQuarter->format('Y-m-d'), $endOfQuarter->format('Y-m-d')])
                        ->orderBy('created_at', 'desc')
                        ->get();

        $grouped = $transaksis->groupBy(function ($item) {
            return $item->category ? $item->category->name : 'Tanpa Kategori';
        });

        $profil = \App\Models\ProfilRt::where('rt_id', $rtId)->first();
        $profilRW = \App\Models\ProfilRt::whereNull('rt_id')->first();

        return [
            'transaksis' => $transaksis,
            'grouped' => $grouped,
            'startMonth' => $startMonth,
            'endMonth' => $endMonth,
            'year' => $year,
            'saldoAwal' => $saldoAwal,
            'profil' => $profil,
            'profilRW' => $profilRW,
        ];
    }

    public function cetakA3(Request $request)
    {
        $user = Auth::user();
        $rtId = ($user->isAdmin() && $request->filled('rt_id')) ? $request->rt_id : $user->rt_id;
        
        // If Admin selects 'All' (no rt_id), handle gracefully by modifying exportKuartal
        $data = $this->exportKuartal($rtId);
        $data['user'] = $user;
        $data['wilayahFilter'] = $rtId ? \App\Models\RtUnit::find($rtId)->nomor_rt : 'Semua RT';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.a3', $data);
        $pdf->setPaper('a3', 'landscape');
        
        $pdf->getDomPDF()->add_info('Author', 'Sekar Tanjung Maulidia');
        $pdf->getDomPDF()->add_info('Subject', 'Laporan Keuangan IWK RW 04');
        
        return $pdf->download('laporan iwk per tiga bulan.pdf');
    }

    public function cetakA4(Request $request)
    {
        $user = Auth::user();
        $rtId = ($user->isAdmin() && $request->filled('rt_id')) ? $request->rt_id : $user->rt_id;

        $data = $this->exportKuartal($rtId);
        $data['user'] = $user;
        $data['wilayahFilter'] = $rtId ? \App\Models\RtUnit::find($rtId)->nomor_rt : 'Semua RT';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.a4', $data);
        $pdf->setPaper('a4', 'portrait');
        
        $pdf->getDomPDF()->add_info('Author', 'Sekar Tanjung Maulidia');
        $pdf->getDomPDF()->add_info('Subject', 'Laporan Keuangan IWK RW 04');
        
        return $pdf->download('laporan iwk per tiga bulan.pdf');
    }

    public function edit(TransaksiKas $transaksi)
    {
        $categories = Category::all();
        $wargas = \App\Models\Warga::all();
        return view('laporan.edit', compact('transaksi', 'categories', 'wargas'));
    }

    public function update(Request $request, TransaksiKas $transaksi)
    {
        $request->validate([
            'uraian' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|in:Masuk,Keluar',
            'kategori_id' => 'nullable|exists:categories,id',
            'warga_id' => 'nullable|exists:wargas,id',
        ]);

        $transaksi->update($request->all());

        return redirect()->route('laporan.index')->with('success', 'Transaksi berhasil diperbarui!');
    }

    public function destroy(TransaksiKas $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('laporan.index')->with('success', 'Transaksi berhasil dihapus!');
    }
}
