<?php

namespace App\Http\Controllers;

use App\Models\Warga;
use App\Models\KartuKeluarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WargaController extends Controller
{
    public function index()
    {
        $wargas = Warga::with('kartuKeluarga')->latest()->get();
        return view('warga.index', compact('wargas'));
    }

    public function create()
    {
        $rt_units = \App\Models\RtUnit::all();
        return view('warga.create', compact('rt_units'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'nama_warga' => 'required|string|max:255',
            'nik' => 'required|string|unique:wargas,nik',
            'no_kk' => 'required|string',
            'no_telp' => 'nullable|string',
            'status' => 'required|in:Pribumi,Pendatang',
        ];

        // Jika user adalah admin (RW), mereka harus memilih RT
        if ($user->isAdmin() && is_null($user->rt_id)) {
            $rules['rt_id'] = 'required|exists:rt_units,id';
        }

        $request->validate($rules, [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem, silakan cek kembali.',
            'rt_id.required' => 'Silakan pilih RT terlebih dahulu.'
        ]);

        $rt_id = ($user->isAdmin() && is_null($user->rt_id)) ? $request->rt_id : $user->rt_id;

        if (is_null($rt_id)) {
            return redirect()->back()->withErrors(['rt_id' => 'Data RT tidak ditemukan. Silakan hubungi admin.'])->withInput();
        }

        // Cari atau buat KK
        $kk = KartuKeluarga::firstOrCreate(
            ['no_kk' => $request->no_kk, 'rt_id' => $rt_id],
            ['nama_kepala_keluarga' => $request->nama_warga]
        );

        // Data warga
        $data = $request->all();
        $data['kk_id'] = $kk->id;
        $data['rt_id'] = $rt_id;
        $data['is_active'] = true;

        Warga::create($data);

        return redirect()->back()->with('success', 'Data warga berhasil disimpan!');
    }

    public function edit(Warga $warga)
    {
        $rt_units = \App\Models\RtUnit::all();
        return view('warga.edit', compact('warga', 'rt_units'));
    }

    public function update(Request $request, Warga $warga)
    {
        $request->validate([
            'nama_warga' => 'required|string|max:255',
            'nik' => 'required|string|unique:wargas,nik,' . $warga->id,
            'no_kk' => 'required|string',
            'no_telp' => 'nullable|string',
            'status' => 'required|in:Pribumi,Pendatang',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar di sistem, silakan cek kembali.'
        ]);

        $warga->update($request->all());

        return redirect()->route('warga.index')->with('status', 'Data warga berhasil diperbarui!');
    }

    public function destroy(Warga $warga)
    {
        $warga->delete();
        return redirect()->route('warga.index')->with('status', 'Data warga berhasil dihapus!');
    }
}
