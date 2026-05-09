<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RtUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['rtUnit', 'profilRt'])->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $rts = RtUnit::all();
        return view('users.create', compact('rts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:RW,RT',
            'rt_id' => 'nullable|exists:rt_units,id',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $rt = $request->rt_id ? \App\Models\RtUnit::find($request->rt_id) : null;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'rt_id' => $request->role == 'RW' ? null : $request->rt_id,
            'unit_rt' => $request->role == 'RW' ? 'RW' : ($rt ? $rt->nomor_rt : null),
            'profile_photo_path' => $photoPath,
        ]);

        // Proteksi Akun RW (Asrimawati)
        if ($user->email == 'adminrw@mail.com') {
            $user->update(['role' => 'RW', 'unit_rt' => 'RW', 'rt_id' => null]);
        }

        return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $rts = RtUnit::all();
        return view('users.edit', compact('user', 'rts'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => 'required|string|max:20', // Melonggarkan agar muat tulisan panjang
            'rt_id' => 'nullable|exists:rt_units,id',
            'unit_rt' => 'nullable|string|max:20',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->rt_id = $request->role == 'RW' ? null : $request->rt_id;
        
        // Update unit_rt secara otomatis
        if ($user->role == 'RW') {
            $user->unit_rt = 'RW';
        } else {
            $rt = RtUnit::find($request->rt_id);
            $user->unit_rt = $rt ? $rt->nomor_rt : null;
        }

        // PAKSA PROTEKSI Akun Asrimawati
        if ($user->email == 'adminrw@mail.com') {
            $user->role = 'RW';
            $user->unit_rt = 'RW';
            $user->rt_id = null;
        }

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->profile_photo_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo_path);
            }
            $user->profile_photo_path = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
