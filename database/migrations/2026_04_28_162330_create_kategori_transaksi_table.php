<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategori_transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->enum('tipe', ['Masuk', 'Keluar']);
            $table->decimal('nominal_default', 15, 2)->nullable();
            $table->string('uraian_default')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_transaksi');
    }
};
