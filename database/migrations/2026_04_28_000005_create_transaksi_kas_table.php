<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi_kas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rt_id')->constrained('rt_units')->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('categories')->onDelete('restrict');
            $table->foreignId('warga_id')->nullable()->constrained('wargas')->onDelete('set null');
            $table->enum('jenis_transaksi', ['Masuk', 'Keluar']);
            $table->enum('jenis_iuran', ['IWK', 'Andon', 'Sumbangan'])->nullable();
            $table->decimal('jumlah', 15, 2);
            $table->date('tanggal');
            $table->text('uraian');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_kas');
    }
};
