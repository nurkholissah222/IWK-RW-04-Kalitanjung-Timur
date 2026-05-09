<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\Category;
use App\Models\TransaksiKas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IuranController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        
        $query = Warga::with('kartuKeluarga');
        
        if (!$user->isAdmin()) {
            $query->where('rt_id', $user->rt_id);
        }

        $wargas = $query->get();

        // Form A: Kategori Iuran Rutin (IWK, Andon, Sumbangan)
        $categoriesA = Category::where('type', 'pemasukan')
            ->whereIn('name', ['IWK (Pribumi)', 'Andon (Pendatang)', 'Sumbangan'])
            ->get();

        // Form B: Kategori Operasional
        $categoriesB = Category::whereIn('name', ['Infrastruktur', 'Kebersihan', 'Sosial', 'Konsumsi', 'ATK'])
            ->get()
            ->unique('name');

        $rt_units = \App\Models\RtUnit::all();
        return view('iuran.create', compact('wargas', 'categoriesA', 'categoriesB', 'rt_units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'warga_id' => 'required|exists:wargas,id',
            'kategori_id' => 'required|exists:categories,id',
            'jumlah' => 'required|numeric|min:0',
            'bulan' => 'required|array|min:1',
            'tanggal' => 'required|date',
            'uraian' => 'nullable|string',
        ]);

        $user = Auth::user();
        $warga = Warga::findOrFail($request->warga_id);
        
        $bulanDaftar = implode(', ', $request->bulan);
        $uraian = $request->uraian ?: "Iuran Bulan: " . $bulanDaftar;

        TransaksiKas::create([
            'rt_id' => $user->rt_id ?? $warga->rt_id,
            'kategori_id' => $request->kategori_id,
            'warga_id' => $warga->id,
            'jenis_transaksi' => 'Masuk',
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'uraian' => $uraian,
            'last_edited_by' => $user->name,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Iuran Rutin berhasil dicatat!');
    }

    public function storeOperasional(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'kategori_id' => 'required|exists:categories,id',
            'jenis_transaksi' => 'required|in:Masuk,Keluar',
        ]);

        $user = Auth::user();

        $rt_id = ($user->isAdmin() && is_null($user->rt_id)) ? $request->rt_id : $user->rt_id;

        if (is_null($rt_id)) {
            return redirect()->back()->withErrors(['rt_id' => 'Silakan pilih RT terlebih dahulu untuk transaksi operasional.'])->withInput();
        }

        TransaksiKas::create([
            'rt_id' => $rt_id,
            'kategori_id' => $request->kategori_id,
            'jenis_transaksi' => $request->jenis_transaksi,
            'jumlah' => $request->jumlah,
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'last_edited_by' => $user->name,
        ]);

        return redirect()->route('laporan.index')->with('success', 'Transaksi Operasional berhasil dicatat!');
    }
    public function checkStatus($warga_id)
    {
        $warga = Warga::findOrFail($warga_id);
        
        // Ambil bulan yang sudah dibayar tahun ini
        $tahunIni = date('Y');
        $transaksi = TransaksiKas::where('warga_id', $warga_id)
            ->whereYear('tanggal', $tahunIni)
            ->get();

        $paidMonths = [];
        foreach ($transaksi as $t) {
            // Kita asumsikan uraian berisi "Iuran Bulan: Januari, Februari"
            if (preg_match('/Iuran Bulan: (.*)/i', $t->uraian, $matches)) {
                $bulanString = $matches[1];
                $bulanArray = explode(', ', $bulanString);
                foreach ($bulanArray as $b) {
                    $paidMonths[] = trim($b);
                }
            }
        }

        return response()->json([
            'paid_months' => array_unique($paidMonths),
            'current_month_index' => (int)date('m'),
            'all_months' => ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
        ]);
    }
}
