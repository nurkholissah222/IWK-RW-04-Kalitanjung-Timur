<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\RtUnit;
use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\Category;
use App\Models\TransaksiKas;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Inisialisasi Unit RT (01, 02, 03)
        $rt01 = RtUnit::updateOrCreate(['nomor_rt' => '01'], ['nama_bendahara' => 'BAMBANG']);
        $rt02 = RtUnit::updateOrCreate(['nomor_rt' => '02'], ['nama_bendahara' => 'NOKMALA']);
        $rt03 = RtUnit::updateOrCreate(['nomor_rt' => '03'], ['nama_bendahara' => 'SRI MUFARIDA']);

        // 2. Buat Akun Pengurus
        User::updateOrCreate(
            ['email' => 'adminrw@mail.com'],
            [
                'name' => 'ASRIMAWATI',
                'password' => Hash::make('password123'),
                'role' => 'RW',
                'unit_rt' => 'RW',
                'rt_id' => null
            ]
        );

        User::updateOrCreate(
            ['email' => 'rt01@mail.com'],
            [
                'name' => 'BAMBANG',
                'password' => Hash::make('password123'),
                'role' => 'RT',
                'unit_rt' => '01',
                'rt_id' => $rt01->id
            ]
        );

        User::updateOrCreate(
            ['email' => 'rt02@mail.com'],
            [
                'name' => 'NOKMALA',
                'password' => Hash::make('password123'),
                'role' => 'RT',
                'unit_rt' => '02',
                'rt_id' => $rt02->id
            ]
        );

        User::updateOrCreate(
            ['email' => 'rt03@mail.com'],
            [
                'name' => 'SRI MUFARIDA',
                'password' => Hash::make('password123'),
                'role' => 'RT',
                'unit_rt' => '03',
                'rt_id' => $rt03->id
            ]
        );

        // 3. Inisialisasi Kategori (Jika belum ada)
        $catIwk = Category::updateOrCreate(['name' => 'IWK (Pribumi)', 'type' => 'pemasukan']);
        $catAndon = Category::updateOrCreate(['name' => 'Andon (Pendatang)', 'type' => 'pemasukan']);

        // 4. Buat 15 Data Warga (5 per RT)
        $wargaNames = [
            '01' => ['Agus Setiawan', 'Siti Rahayu', 'Budi Cahyono', 'Ani Wijaya', 'Dedi Kurniawan'],
            '02' => ['Eko Prasetyo', 'Lusi Indah', 'Fajar Sidik', 'Gita Permata', 'Hadi Sucipto'],
            '03' => ['Iwan Fals', 'Joko Widodo', 'Kartini', 'Lilik Sumardi', 'Maman Suherman'],
        ];

        foreach ($wargaNames as $rtNo => $names) {
            $rt = RtUnit::where('nomor_rt', $rtNo)->first();
            foreach ($names as $index => $name) {
                $kk = KartuKeluarga::updateOrCreate(
                    ['no_kk' => '3201' . $rtNo . '0000' . ($index + 1)],
                    ['nama_kepala_keluarga' => $name, 'rt_id' => $rt->id]
                );

                $warga = Warga::updateOrCreate(
                    ['nik' => '3201' . $rtNo . '1111' . ($index + 1)],
                    [
                        'kk_id' => $kk->id,
                        'rt_id' => $rt->id,
                        'no_kk' => $kk->no_kk,
                        'nama_warga' => $name,
                        'status' => ($index < 3) ? 'Pribumi' : 'Pendatang',
                        'no_telp' => '08' . rand(111111, 999999),
                        'is_active' => true,
                        'unit_rt' => $rtNo
                    ]
                );

                // 5. Buat Riwayat Transaksi (Iuran April & Mei 2026)
                // Anggap 2 warga pertama tiap RT sudah LUNAS April-Mei, sisanya belum.
                if ($index < 2) {
                    // April 2026
                    TransaksiKas::updateOrCreate(
                        ['warga_id' => $warga->id, 'tanggal' => '2026-04-05'],
                        [
                            'rt_id' => $rt->id,
                            'kategori_id' => $warga->status == 'Pribumi' ? $catIwk->id : $catAndon->id,
                            'jenis_transaksi' => 'Masuk',
                            'jumlah' => $warga->status == 'Pribumi' ? 3000 : 5000,
                            'uraian' => 'Iuran IWK April 2026 - ' . $warga->nama_warga,
                            'last_edited_by' => 'System'
                        ]
                    );
                    // Mei 2026
                    TransaksiKas::updateOrCreate(
                        ['warga_id' => $warga->id, 'tanggal' => '2026-05-05'],
                        [
                            'rt_id' => $rt->id,
                            'kategori_id' => $warga->status == 'Pribumi' ? $catIwk->id : $catAndon->id,
                            'jenis_transaksi' => 'Masuk',
                            'jumlah' => $warga->status == 'Pribumi' ? 3000 : 5000,
                            'uraian' => 'Iuran IWK Mei 2026 - ' . $warga->nama_warga,
                            'last_edited_by' => 'System'
                        ]
                    );
                }
            }
        }
    }
}
