<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$profiles = \App\Models\ProfilRt::all();
foreach ($profiles as $p) {
    echo "ID: {$p->id}, RT_ID: {$p->rt_id}, FOTO: {$p->foto}\n";
}
