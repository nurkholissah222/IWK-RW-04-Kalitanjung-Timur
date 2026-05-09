<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\KategoriTransaksi;

class KategoriTransaksiSeeder extends Seeder
{
    public function run(): void
    {
        KategoriTransaksi::create([
            'nama_kategori' => 'IWK (Pribumi)',
            'tipe' => 'Masuk',
            'nominal_default' => 3000,
            'uraian_default' => 'Iuran Wajib Keluarga (IWK) - Pribumi'
        ]);

        KategoriTransaksi::create([
            'nama_kategori' => 'Andon (Pendatang)',
            'tipe' => 'Masuk',
            'nominal_default' => 5000,
            'uraian_default' => 'Iuran Pendatang (Andon)'
        ]);

        KategoriTransaksi::create([
            'nama_kategori' => 'Konsumsi',
            'tipe' => 'Keluar',
            'nominal_default' => 0,
            'uraian_default' => 'Biaya Konsumsi Kegiatan'
        ]);
        
        KategoriTransaksi::create([
            'nama_kategori' => 'Operasional',
            'tipe' => 'Keluar',
            'nominal_default' => 0,
            'uraian_default' => 'Biaya Operasional RT'
        ]);
    }
}
