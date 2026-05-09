<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/dashboard/rw', [\App\Http\Controllers\DashboardController::class, 'rwDashboard'])
    ->middleware(['auth', 'verified', 'role_rw'])
    ->name('dashboard.rw');

Route::get('/dashboard/rt', [\App\Http\Controllers\DashboardController::class, 'rtDashboard'])
    ->middleware(['auth', 'verified', 'role_rt'])
    ->name('dashboard.rt');

Route::middleware('auth')->group(function () {
    // Custom Routes (Restricted to Admin/Petugas)
    Route::middleware(['admin_petugas', 'ensure_rt'])->group(function () {
        Route::get('/laporan', [\App\Http\Controllers\LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/print', [\App\Http\Controllers\LaporanController::class, 'print'])->name('laporan.print');
        Route::get('/laporan/cetak-a3', [\App\Http\Controllers\LaporanController::class, 'cetakA3'])->name('laporan.a3');
        Route::get('/laporan/cetak-a4', [\App\Http\Controllers\LaporanController::class, 'cetakA4'])->name('laporan.a4');
        Route::get('/laporan/{transaksi}/edit', [\App\Http\Controllers\LaporanController::class, 'edit'])->name('laporan.edit');
        Route::put('/laporan/{transaksi}', [\App\Http\Controllers\LaporanController::class, 'update'])->name('laporan.update');
        Route::delete('/laporan/{transaksi}', [\App\Http\Controllers\LaporanController::class, 'destroy'])->name('laporan.destroy');

        Route::resource('/warga', \App\Http\Controllers\WargaController::class);
        
        Route::get('/iuran/create', [\App\Http\Controllers\IuranController::class, 'create'])->name('iuran.create');
        Route::post('/iuran/store', [\App\Http\Controllers\IuranController::class, 'store'])->name('iuran.store');
        Route::post('/iuran/store-operasional', [\App\Http\Controllers\IuranController::class, 'storeOperasional'])->name('iuran.store-operasional');

        Route::get('/profil-rt', [\App\Http\Controllers\ProfilRtController::class, 'index'])->name('profil-rt.index');
        Route::post('/profil-rt', [\App\Http\Controllers\ProfilRtController::class, 'update'])->name('profil-rt.update');
        Route::post('/profil-rt/delete-photo', [\App\Http\Controllers\ProfilRtController::class, 'deletePhoto'])->name('profil-rt.delete-photo');

        // Admin Only Routes
        Route::middleware('is_admin')->group(function () {
            Route::get('/kategori', [\App\Http\Controllers\CategoryController::class, 'index'])->name('kategori.index');
            Route::post('/kategori', [\App\Http\Controllers\CategoryController::class, 'store'])->name('kategori.store');
            Route::put('/kategori/{category}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('kategori.update');
            Route::delete('/kategori/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('kategori.destroy');

            Route::resource('/users', \App\Http\Controllers\UserController::class);
        });
    });

    // Breeze Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/recover-data', function () {
    $warga = \App\Models\Warga::withoutGlobalScopes()->whereNull('rt_id')->update(['rt_id' => 1]);
    $transaksi = \App\Models\TransaksiKas::withoutGlobalScopes()->whereNull('rt_id')->update(['rt_id' => 1]);
    $kk = \App\Models\KartuKeluarga::withoutGlobalScopes()->whereNull('rt_id')->update(['rt_id' => 1]);
    return "Data recovered: $warga warga, $transaksi transaksi, $kk kartu keluarga. Silakan kembali ke dashboard.";
});

Route::get('/fix-passwords', function () {
    \App\Models\User::query()->update(['password' => \Illuminate\Support\Facades\Hash::make('password123')]);
    return 'Passwords updated to password123';
});
Route::get('/force-fix', function () {
    // 1. Identifikasi & Perbaiki Pimpinan RW (Asrimawati)
    $asrimawati = \App\Models\User::where('email', 'adminrw@mail.com')->first();
    if ($asrimawati) {
        $asrimawati->update([
            'name' => 'ASRIMAWATI',
            'role' => 'RW',
            'rt_id' => null,
            'unit_rt' => 'RW'
        ]);
    }

    // 2. Perbaiki Petugas RT lainnya
    $users = \App\Models\User::all();
    foreach ($users as $u) {
        if ($u->email == 'adminrw@mail.com') continue;

        $u->role = 'RT';
        // Tentukan nomor RT dari email (misal rt01@mail.com -> 01)
        if (preg_match('/rt(\d+)/i', $u->email, $matches)) {
            $nomor = str_pad($matches[1], 2, '0', STR_PAD_LEFT);
            $rtUnit = \App\Models\RtUnit::where('nomor_rt', $nomor)->first();
            $u->rt_id = $rtUnit ? $rtUnit->id : null;
            $u->unit_rt = $nomor;
        }
        $u->save();
    }

    return "<h2>MEGA FIX BERHASIL!</h2>
            <p>Data Wilayah RT telah disinkronkan (01, 02, 03).</p>
            <a href='".url('/users')."'>Kembali ke Manajemen User</a>";
});

Route::get('/fix-storage', function () {
    if (file_exists(public_path('storage'))) {
        app('files')->delete(public_path('storage'));
    }
    app('files')->link(storage_path('app/public'), public_path('storage'));
    return "Storage Link Fixed! Silakan cek kembali foto profil Anda.";
});

Route::get('/debug-profiles', function () {
    return \App\Models\ProfilRt::all();
});

Route::get('/debug-all-users', function () {
    return [
        'rt_units_count' => \App\Models\RtUnit::count(),
        'rt_units' => \App\Models\RtUnit::all(),
        'users' => \App\Models\User::all()
    ];
});

Route::get('/iuran/check-status/{warga_id}', [\App\Http\Controllers\IuranController::class, 'checkStatus'])->name('iuran.check-status');

Route::get('/fix-db', function () {
    try {
        // 1. Tambah kolom unit_rt jika belum ada
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'unit_rt')) {
            \Illuminate\Support\Facades\Schema::table('users', function ($table) {
                $table->string('unit_rt')->nullable()->after('role');
            });
        }
        
        // 2. Tambah kolom profile_photo_path jika belum ada
        if (!\Illuminate\Support\Facades\Schema::hasColumn('users', 'profile_photo_path')) {
            \Illuminate\Support\Facades\Schema::table('users', function ($table) {
                $table->string('profile_photo_path')->nullable()->after('email');
            });
        }
        
        // 3. Ubah tipe data role & unit_rt agar lebih panjang (Fix Data Truncated)
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY COLUMN role VARCHAR(20)");
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE users MODIFY COLUMN unit_rt VARCHAR(20) NULL");
        
        return "DATABASE FIXED: Kolom diperluas, unit_rt dan profile_photo siap! Silakan buka Dashboard.";
    } catch (\Exception $e) {
        return "Gagal fix DB: " . $e->getMessage();
    }
});

Route::get('/clear-cache', function() {
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    return "Cache berhasil dibersihkan! Silakan buka kembali Dashboard.";
});

Route::get('/storage-file/{path}', function ($path) {
    $fullPath = storage_path('app/public/' . $path);
    if (!file_exists($fullPath)) {
        return response()->json(['error' => 'File not found at ' . $fullPath], 404);
    }
    
    $file = file_get_contents($fullPath);
    $type = mime_content_type($fullPath);
    
    return response($file)->header('Content-Type', $type);
})->where('path', '.*')->name('storage.file');

require __DIR__.'/auth.php';
