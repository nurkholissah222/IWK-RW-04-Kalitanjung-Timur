<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ProfilRt;

$profiles = ProfilRt::all();
foreach ($profiles as $p) {
    echo "RT ID: " . ($p->rt_id ?? 'RW') . " | Bendahara: " . $p->nama_bendahara . " | Ketua: " . $p->nama_rt . "\n";
}
