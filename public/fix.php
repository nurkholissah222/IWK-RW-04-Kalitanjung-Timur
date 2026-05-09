<?php
// Autoload Laravel
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\Artisan;

try {
    echo "<h1>🚀 Menjalankan Migration & Seeding Sesuai Instruksi...</h1>";
    
    // Jalankan migrate:fresh --seed
    Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true,
    ]);
    
    echo "<pre>" . Artisan::output() . "</pre>";
    echo "<h2>✅ Database Berhasil Dibersihkan dan Di-seed dengan User Baru!</h2>";
    echo "<p>Akun yang siap digunakan (Password: <b>password123</b>):</p>";
    echo "<ul>
            <li>rt01@mail.com (Petugas RT 01)</li>
            <li>rt02@mail.com (Petugas RT 02)</li>
            <li>rt03@mail.com (Petugas RT 03)</li>
            <li>adminrw@mail.com (Admin RW)</li>
          </ul>";
    echo "<hr><a href='/login'>Ke Halaman Login</a>";

} catch (Exception $e) {
    echo "<h1>❌ Terjadi Kesalahan!</h1>";
    echo "<pre>" . $e->getMessage() . "</pre>";
}
