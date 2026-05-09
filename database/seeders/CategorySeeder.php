<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Pemasukan
        $categories = [
            ['name' => 'IWK (Pribumi)', 'type' => 'pemasukan', 'description' => 'Iuran Wajib Keluarga Rp 3.000/bulan'],
            ['name' => 'Andon (Pendatang)', 'type' => 'pemasukan', 'description' => 'Iuran Pendatang Rp 5.000/bulan'],
            ['name' => 'Sumbangan', 'type' => 'pemasukan', 'description' => 'Sumbangan sukarela dari warga'],
            ['name' => 'Kebersihan', 'type' => 'pemasukan', 'description' => 'Iuran kebersihan rutin warga'],
            ['name' => 'Infrastruktur', 'type' => 'pemasukan', 'description' => 'Pemasukan untuk infrastruktur'],
            ['name' => 'Sosial', 'type' => 'pemasukan', 'description' => 'Pemasukan untuk kegiatan sosial'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['name' => $cat['name'], 'type' => $cat['type']],
                ['description' => $cat['description']]
            );
        }

        // Pengeluaran
        $expenses = [
            ['name' => 'Konsumsi', 'type' => 'pengeluaran', 'description' => 'Biaya makan/minum kegiatan RT'],
            ['name' => 'Infrastruktur', 'type' => 'pengeluaran', 'description' => 'Perbaikan fasilitas umum/jalan'],
            ['name' => 'ATK', 'type' => 'pengeluaran', 'description' => 'Alat Tulis Kantor & Fotocopy'],
            ['name' => 'Sosial', 'type' => 'pengeluaran', 'description' => 'Biaya santunan, takjiah, dan bantuan warga'],
            ['name' => 'Kebersihan', 'type' => 'pengeluaran', 'description' => 'Biaya pengelolaan sampah dan kebersihan'],
        ];

        foreach ($expenses as $exp) {
            Category::updateOrCreate(
                ['name' => $exp['name'], 'type' => $exp['type']],
                ['description' => $exp['description']]
            );
        }
    }
}
