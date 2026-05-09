<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RtUnit;

class RtUnitSeeder extends Seeder
{
    public function run(): void
    {
        RtUnit::create(['nomor_rt' => '01', 'nama_ketua' => null, 'nama_bendahara' => null]);
        RtUnit::create(['nomor_rt' => '02', 'nama_ketua' => null, 'nama_bendahara' => null]);
        RtUnit::create([
            'nomor_rt' => '03',
            'nama_ketua' => 'Cici Surahman',
            'nama_bendahara' => 'Sri Mufarida',
        ]);
    }
}
