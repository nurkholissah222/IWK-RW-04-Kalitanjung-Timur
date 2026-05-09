<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

$users = \App\Models\User::all();
echo "--- USERS ---\n";
foreach ($users as $u) {
    echo "ID: {$u->id}, NAME: {$u->name}, ROLE: {$u->role}, RT_ID: {$u->rt_id}, UNIT: {$u->unit_rt}\n";
}
