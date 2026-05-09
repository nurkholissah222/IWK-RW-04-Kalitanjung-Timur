<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\RtUnit;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $rt01 = RtUnit::where('nomor_rt', '01')->first();
        $rt02 = RtUnit::where('nomor_rt', '02')->first();
        $rt03 = RtUnit::where('nomor_rt', '03')->first();

        // Akun Admin RW
        User::updateOrCreate(
            ['email' => 'adminrw@mail.com'],
            [
                'name' => 'Bendahara RW 04',
                'password' => Hash::make('password123'),
                'rt_id' => null,
                'role' => 'admin',
            ]
        );

        // Keep legacy admin if needed or just update it
        User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Admin RW',
                'password' => Hash::make('password123'),
                'rt_id' => null,
                'role' => 'admin',
            ]
        );

        // Akun Petugas RT 01
        User::updateOrCreate(
            ['email' => 'rt01@mail.com'],
            [
                'name' => 'Bendahara RT 01',
                'password' => Hash::make('password123'),
                'rt_id' => $rt01 ? $rt01->id : 1,
                'role' => 'petugas',
            ]
        );

        // Akun Petugas RT 02
        User::updateOrCreate(
            ['email' => 'rt02@mail.com'],
            [
                'name' => 'Bendahara RT 02',
                'password' => Hash::make('password123'),
                'rt_id' => $rt02 ? $rt02->id : 2,
                'role' => 'petugas',
            ]
        );

        // Akun Petugas RT 03
        User::updateOrCreate(
            ['email' => 'rt03@mail.com'],
            [
                'name' => 'Bendahara RT 03',
                'password' => Hash::make('password123'),
                'rt_id' => $rt03 ? $rt03->id : 3,
                'role' => 'petugas',
            ]
        );
    }
}
