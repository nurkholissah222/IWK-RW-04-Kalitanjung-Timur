<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransaksiKas;
use App\Models\Warga;
use App\Models\Category;

class TransaksiKasSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil Data Warga
        $laelati = Warga::where('nama_warga', 'Ibu Laelati')->first();
        $budi = Warga::where('nama_warga', 'Budi Santoso')->first();
        $sahidin = Warga::where('nama_warga', 'Bapak Sahidin')->first();
        $tari = Warga::where('nama_warga', 'Mang Tari')->first();

        // Ambil Data Kategori
        $catIwk = Category::where('name', 'IWK (Pribumi)')->first();
        $catAndon = Category::where('name', 'Andon (Pendatang)')->first();
        $catSosial = Category::where('name', 'Sosial')->first();
        $catInfra = Category::where('name', 'Infrastruktur')->first();

        // Pemasukan
        if ($laelati && $catIwk) {
            TransaksiKas::create([
                'rt_id' => 3,
                'kategori_id' => $catIwk->id,
                'warga_id' => $laelati->id,
                'jenis_transaksi' => 'Masuk',
                'tanggal' => now(),
                'jumlah' => 36000,
                'uraian' => 'Iuran IWK Ibu Laelati (1 tahun)',
                'last_edited_by' => 'System'
            ]);
        }

        if ($budi && $catAndon) {
            TransaksiKas::create([
                'rt_id' => 3,
                'kategori_id' => $catAndon->id,
                'warga_id' => $budi->id,
                'jenis_transaksi' => 'Masuk',
                'tanggal' => now(),
                'jumlah' => 5000,
                'uraian' => 'Iuran Andon Budi Santoso',
                'last_edited_by' => 'System'
            ]);
        }

        // Pengeluaran
        if ($catSosial) {
            TransaksiKas::create([
                'rt_id' => 3,
                'kategori_id' => $catSosial->id,
                'warga_id' => $sahidin ? $sahidin->id : null,
                'jenis_transaksi' => 'Keluar',
                'tanggal' => now(),
                'jumlah' => 40000,
                'uraian' => 'Takjiah Alm. Bapak Sahidin',
                'last_edited_by' => 'System'
            ]);
        }

        if ($catInfra) {
            TransaksiKas::create([
                'rt_id' => 3,
                'kategori_id' => $catInfra->id,
                'warga_id' => $tari ? $tari->id : null,
                'jenis_transaksi' => 'Keluar',
                'tanggal' => now(),
                'jumlah' => 1100000,
                'uraian' => 'Perbaikan selokan Mang Tari',
                'last_edited_by' => 'System'
            ]);
        }
    }
}
