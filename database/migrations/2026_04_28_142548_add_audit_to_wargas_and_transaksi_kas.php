<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->string('last_edited_by')->nullable();
        });

        Schema::table('transaksi_kas', function (Blueprint $table) {
            $table->string('last_edited_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) { $table->dropColumn('last_edited_by'); });
        Schema::table('transaksi_kas', function (Blueprint $table) { $table->dropColumn('last_edited_by'); });
    }
};
