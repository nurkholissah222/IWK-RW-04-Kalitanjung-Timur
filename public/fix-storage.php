<?php

/**
 * Script to create storage symlink on InfinityFree.
 * Usage: Access via your-domain.com/fix-storage.php
 */

$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';

echo "<h1>InfinityFree Storage Link Fixer</h1>";

if (file_exists($shortcut)) {
    echo "The 'public/storage' directory already exists.<br>";
    if (is_link($shortcut)) {
        echo "It is already a symbolic link.";
    } else {
        echo "It is a physical directory. You might need to delete it first to create a symlink.";
    }
} else {
    if (symlink($target, $shortcut)) {
        echo "<b style='color: green;'>Symlink created successfully!</b><br>";
        echo "From: $target <br>To: $shortcut";
    } else {
        echo "<b style='color: red;'>Failed to create symlink.</b><br>";
        echo "This might be due to hosting restrictions or missing permissions.";
    }
}

echo "<br><br><small>Please delete this file (public/fix-storage.php) after use.</small>";
