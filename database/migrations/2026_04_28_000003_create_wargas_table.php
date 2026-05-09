<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('wargas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kk_id')->constrained('kartu_keluargas')->onDelete('cascade');
            $table->string('nik', 16)->unique();
            $table->string('nama_warga');
            $table->enum('status_warga', ['Pribumi', 'Pendatang']);
            $table->date('tgl_masuk_warga')->nullable();
            $table->string('no_wa')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wargas');
    }
};
