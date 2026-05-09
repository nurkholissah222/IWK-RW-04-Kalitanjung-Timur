<?php
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_PATH_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}

$target = __DIR__ . '/public/storage';
if (file_exists($target)) {
    if (is_link($target)) {
        echo "Deleting link: $target\n";
        unlink($target);
    } else {
        echo "Deleting directory: $target\n";
        // On Windows, rmdir might fail if it's a junction.
        // We try shell_exec as well.
        shell_exec("rd /s /q \"$target\"");
        if (file_exists($target)) {
            echo "Failed to delete via shell, trying PHP rmdir...\n";
            // Simple recursive delete if shell fails
            $it = new RecursiveDirectoryIterator($target, RecursiveDirectoryIterator::SKIP_DOTS);
            $files = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
            foreach($files as $file) {
                if ($file->isDir()){
                    rmdir($file->getRealPath());
                } else {
                    unlink($file->getRealPath());
                }
            }
            rmdir($target);
        }
    }
} else {
    echo "Target does not exist.\n";
}

if (!file_exists($target)) {
    echo "SUCCESS: $target deleted.\n";
} else {
    echo "FAILED: $target still exists.\n";
}
