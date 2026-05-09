<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warga;
use App\Models\KartuKeluarga;
use App\Models\RtUnit;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $rtUnits = RtUnit::all();
        if ($rtUnits->isEmpty()) {
            $rtUnits = collect([
                RtUnit::firstOrCreate(['nomor_rt' => '01']),
                RtUnit::firstOrCreate(['nomor_rt' => '02']),
                RtUnit::firstOrCreate(['nomor_rt' => '03']),
            ]);
        }

        foreach ($rtUnits as $rt) {
            // Data Pribumi
            if ($rt->nomor_rt == '03') {
                $pribumis = ['Cici Surahman', 'Sri Mufarida', 'Bapak Sahidin', 'Ibu Laelati', 'Ibu Maryati', 'Mang Tari'];
            } else {
                $pribumis = ['Warga Pribumi 1 RT' . $rt->nomor_rt, 'Warga Pribumi 2 RT' . $rt->nomor_rt];
            }

            foreach ($pribumis as $index => $name) {
                $kk = KartuKeluarga::firstOrCreate(
                    ['no_kk' => '3201' . $rt->nomor_rt . str_pad($index + 1, 8, '0', STR_PAD_LEFT)],
                    ['nama_kepala_keluarga' => $name, 'rt_id' => $rt->id]
                );

                Warga::create([
                    'kk_id' => $kk->id,
                    'rt_id' => $rt->id,
                    'nik' => '3201' . $rt->nomor_rt . str_pad($index + 1, 8, '1', STR_PAD_LEFT),
                    'no_kk' => $kk->no_kk,
                    'nama_warga' => $name,
                    'status' => 'Pribumi',
                    'no_telp' => '08' . rand(11111111, 99999999),
                    'is_active' => true
                ]);
            }

            // Data Pendatang
            if ($rt->nomor_rt == '03') {
                $pendatangs = ['Budi Santoso', 'Siti Aminah'];
            } else {
                $pendatangs = ['Warga Pendatang 1 RT' . $rt->nomor_rt];
            }

            foreach ($pendatangs as $index => $name) {
                $kk = KartuKeluarga::firstOrCreate(
                    ['no_kk' => '3202' . $rt->nomor_rt . str_pad($index + 1, 8, '0', STR_PAD_LEFT)],
                    ['nama_kepala_keluarga' => $name, 'rt_id' => $rt->id]
                );

                Warga::create([
                    'kk_id' => $kk->id,
                    'rt_id' => $rt->id,
                    'nik' => '3202' . $rt->nomor_rt . str_pad($index + 1, 8, '1', STR_PAD_LEFT),
                    'no_kk' => $kk->no_kk,
                    'nama_warga' => $name,
                    'status' => 'Pendatang',
                    'no_telp' => '08' . rand(11111111, 99999999),
                    'is_active' => true
                ]);
            }
        }
    }
}
