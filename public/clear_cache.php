<?php

/**
 * Script for clearing Laravel cache on shared hosting (like InfinityFree)
 * where SSH access is not available.
 * 
 * Usage: Access this file via your-domain.com/clear_cache.php
 */

use Illuminate\Support\Facades\Artisan;

// Load the Laravel application
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Create a kernel to handle requests
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h1>Laravel Maintenance Script</h1>";

try {
    echo "Clearing Config Cache... ";
    $kernel->call('config:clear');
    echo "Done.<br>";

    echo "Clearing Application Cache... ";
    $kernel->call('cache:clear');
    echo "Done.<br>";

    echo "Clearing Route Cache... ";
    $kernel->call('route:clear');
    echo "Done.<br>";

    echo "Clearing View Cache... ";
    $kernel->call('view:clear');
    echo "Done.<br>";

    echo "<br><b style='color: green;'>All caches cleared successfully!</b>";
} catch (\Exception $e) {
    echo "<br><b style='color: red;'>Error: " . $e->getMessage() . "</b>";
}

echo "<br><br><small>Please delete this file (public/clear_cache.php) after use for security.</small>";
