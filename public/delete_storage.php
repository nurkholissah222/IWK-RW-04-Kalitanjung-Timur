<?php
/**
 * Script untuk menghapus folder public/storage yang salah alamat secara otomatis.
 * Jalankan script ini dengan membuka: http://localhost/iwk%20percobaan%20desain%201/public/delete_storage.php
 */

$dir = __DIR__ . '/storage';

function deleteRecursive($path) {
    if (is_link($path)) {
        return unlink($path);
    }
    if (!file_exists($path)) return true;
    if (!is_dir($path)) return unlink($path);
    
    foreach (scandir($path) as $item) {
        if ($item == '.' || $item == '..') continue;
        if (!deleteRecursive($path . DIRECTORY_SEPARATOR . $item)) return false;
    }
    return rmdir($path);
}

echo "<h2>Pembersih Symlink Otomatis</h2>";

if (file_exists($dir)) {
    echo "Menghapus folder: $dir ...<br>";
    if (deleteRecursive($dir)) {
        echo "<b style='color:green'>BERHASIL: Folder public/storage telah dihapus.</b><br>";
        echo "Sekarang silakan jalankan perintah berikut di terminal Anda:<br>";
        echo "<pre>php artisan storage:link</pre>";
    } else {
        echo "<b style='color:red'>GAGAL: Tidak bisa menghapus folder. Silakan hapus manual folder 'public/storage'.</b>";
    }
} else {
    echo "<b style='color:orange'>Folder public/storage tidak ditemukan atau sudah terhapus.</b>";
}

echo "<br><br><a href='index.php'>Kembali ke Aplikasi</a>";
?>
