<?php

/**
 * Script for clearing/caching Laravel on InfinityFree.
 * Usage: Access via your-domain.com/clear-cache.php
 */

use Illuminate\Support\Facades\Artisan;

// Load the Laravel application
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Create a kernel to handle requests
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

echo "<h1>InfinityFree Laravel Maintenance</h1>";

try {
    echo "Running config:cache... ";
    $kernel->call('config:cache');
    echo "Done.<br>";

    echo "Running view:clear... ";
    $kernel->call('view:clear');
    echo "Done.<br>";

    echo "Running route:clear... ";
    $kernel->call('route:clear');
    echo "Done.<br>";

    echo "<br><b style='color: green;'>All commands executed successfully!</b>";
} catch (\Exception $e) {
    echo "<br><b style='color: red;'>Error: " . $e->getMessage() . "</b>";
}

echo "<br><br><small>Please delete this file (public/clear-cache.php) after use for security.</small>";
