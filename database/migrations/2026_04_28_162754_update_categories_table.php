<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'nama_kategori')) {
                $table->renameColumn('nama_kategori', 'name');
            }
            $table->enum('type', ['pemasukan', 'pengeluaran'])->after('id');
            $table->text('description')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->renameColumn('name', 'nama_kategori');
            $table->dropColumn(['type', 'description']);
        });
    }
};
