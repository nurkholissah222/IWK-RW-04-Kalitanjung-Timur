<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rt_units', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_rt');
            $table->string('nama_ketua')->nullable();
            $table->string('nama_bendahara')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rt_units');
    }
};
