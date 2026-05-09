<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use App\Models\Warga;

$nullRt = Warga::withoutGlobalScopes()->whereNull('rt_id')->get();
echo "Warga with NULL rt_id: " . $nullRt->count() . "\n";
foreach($nullRt as $w) {
    echo "- " . $w->nama_warga . " (Created at: " . $w->created_at . ")\n";
}
