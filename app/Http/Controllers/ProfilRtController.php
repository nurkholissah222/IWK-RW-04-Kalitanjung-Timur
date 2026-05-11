<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilRt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;

class ProfilRtController extends Controller
{
    public function index()
    {
        // Emergency Fix: Ensure storage link exists
        try {
            if (!file_exists(public_path('storage'))) {
                Artisan::call('storage:link');
            }
        } catch (\Exception $e) {
            // Silently fail if permissions prevent link creation
        }

        $rt_id = auth()->user()->rt_id;
        
        $profil = ProfilRt::firstOrCreate(
            ['rt_id' => $rt_id],
            [
                'nama_bendahara' => $rt_id ? 'Bendahara RT ' . auth()->user()->rtUnit->nomor_rt : 'Sri Mufarida',
                'no_wa_bendahara' => '081234567890',
                'nama_rt' => $rt_id ? 'Ketua RT ' . auth()->user()->rtUnit->nomor_rt : 'Toto S',
                'no_wa_rt' => '089876543210'
            ]
        );

        return view('profil.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_bendahara' => 'required|string|max:255',
            'no_wa_bendahara' => 'required|string|max:20',
            'nama_rt' => 'required|string|max:255',
            'no_wa_rt' => 'required|string|max:20',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $rt_id = auth()->user()->rt_id;
        
        // Use updateOrCreate for guaranteed persistence
        $profil = ProfilRt::updateOrCreate(
            ['rt_id' => $rt_id],
            [
                'nama_bendahara' => $request->nama_bendahara,
                'no_wa_bendahara' => $request->no_wa_bendahara,
                'nama_rt' => $request->nama_rt,
                'no_wa_rt' => $request->no_wa_rt,
            ]
        );

        // Sinkronisasi Nama ke Tabel Users agar Navbar ikut berubah
        $user = auth()->user();
        $user->name = $request->nama_bendahara;
        $user->save();

        if ($request->hasFile('foto')) {
            // 1. Delete old photo if exists from the correct directory
            if ($profil->foto && Storage::disk('public')->exists($profil->foto)) {
                Storage::disk('public')->delete($profil->foto);
            }
            
            // 2. Store the new file with unique name in 'profile_photos'
            $file = $request->file('foto');
            $filename = 'profil_' . ($rt_id ?? 'rw') . '_' . time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('profile_photos', $filename, 'public');
            
            // 3. Save path to database (path is already relative like 'profile_photos/filename.jpg')
            $profil->foto = $path;
            $profil->save();

            // 4. Sinkronisasi Foto ke Tabel Users agar Navbar ikut berubah
            $user->profile_photo_path = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Data Profil Pengurus berhasil diperbarui!');
    }

    public function deletePhoto()
    {
        $rt_id = auth()->user()->rt_id;
        $profil = ProfilRt::where('rt_id', $rt_id)->first();

        if ($profil && $profil->foto) {
            if (Storage::disk('public')->exists($profil->foto)) {
                Storage::disk('public')->delete($profil->foto);
            }
            $profil->foto = null;
            $profil->save();

            // Sinkronisasi ke Tabel Users
            $user = auth()->user();
            $user->profile_photo_path = null;
            $user->save();

            return redirect()->back()->with('success', 'Foto profil berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Tidak ada foto untuk dihapus.');
    }
}
