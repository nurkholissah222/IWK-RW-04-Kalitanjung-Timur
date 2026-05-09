# SI-IWK (Sistem Informasi Iuran Warga & Kas)
### RW 04 Kalitanjung Timur

SI-IWK adalah platform manajemen keuangan digital yang dirancang khusus untuk mempermudah pengelolaan Iuran Warga (IWK) dan dana kas di lingkungan RW 04 Kalitanjung Timur. Aplikasi ini mengintegrasikan pencatatan transaksi, manajemen data warga, hingga laporan keuangan otomatis yang dapat diunduh dalam format PDF (A3/A4).

---

## 🚀 Fitur Utama
- **Dashboard Interaktif**: Visualisasi saldo kas, total pemasukan, dan pengeluaran secara real-time.
- **Manajemen User (Multi-Role)**: Sistem login untuk Bendahara RW dan Bendahara RT dengan hak akses yang terisolasi.
- **Pencatatan Iuran Cerdas**: Form iuran dengan deteksi otomatis status pembayaran (Lunas/Tunggakan) dan perhitungan nominal otomatis.
- **Notifikasi WhatsApp**: Kirim pengingat tunggakan iuran langsung ke nomor WhatsApp warga dengan pesan yang terpersonalisasi.
- **Laporan Otomatis**: Generate laporan keuangan bulanan atau kuartal dalam format PDF siap cetak dengan tanda tangan pengurus otomatis.
- **Manajemen Warga**: Pendataan warga per RT yang rapi dan mudah dicari.

---

## 🛠️ Teknologi yang Digunakan
- **Framework**: [Laravel 10+](https://laravel.com)
- **Styling**: [Tailwind CSS](https://tailwindcss.com) (Full Navy Theme)
- **Database**: MySQL / MariaDB
- **Icons**: [FontAwesome](https://fontawesome.com)
- **PDF Engine**: DomPDF / Browsershot

---

## 📦 Instalasi (Lokal)
Jika Anda ingin menjalankan proyek ini di komputer lokal:

1. **Clone Repository**
   ```bash
   git clone https://github.com/nurkholissah222/IWK-RW-04-Kalitanjung-Timur.git
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install && npm run dev
   ```

3. **Konfigurasi Environment**
   - Copy `.env.example` menjadi `.env`
   - Atur koneksi database di file `.env`
   - Jalankan `php artisan key:generate`

4. **Migrasi & Seed Database**
   ```bash
   php artisan migrate --seed
   ```

5. **Link Storage**
   ```bash
   php artisan storage:link
   ```

6. **Jalankan Server**
   ```bash
   php artisan serve
   ```

---

## 👤 Pengembang
- **Nama**: Nurkholissah
- **Instansi**: [Nama Universitas/Sekolah jika perlu]
- **Tujuan**: Pengembangan Sistem Digitalisasi Keuangan Desa.

---

## 📄 Lisensi
Proyek ini bersifat open-source di bawah lisensi [MIT](LICENSE).
