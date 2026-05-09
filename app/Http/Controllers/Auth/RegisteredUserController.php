<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\RtUnit;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $rtUnits = collect();
        $dbError = null;

        try {
            $rtUnits = RtUnit::all();
            if ($rtUnits->isEmpty()) {
                $dbError = 'Data Unit RT belum tersedia di database.';
            }
        } catch (\Exception $e) {
            $dbError = 'Gagal terhubung ke database. Pastikan MySQL di XAMPP sudah aktif.';
        }

        return view('auth.register', compact('rtUnits', 'dbError'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rt_id' => ['required', 'exists:rt_units,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rt_id' => $request->rt_id,
            'role' => 'RT', // Default role untuk registrasi baru
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard.rt'));
    }
}
