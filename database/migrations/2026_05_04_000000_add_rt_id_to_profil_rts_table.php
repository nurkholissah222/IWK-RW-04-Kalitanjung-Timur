<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('profil_rts', function (Blueprint $table) {
            $table->unsignedBigInteger('rt_id')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('profil_rts', function (Blueprint $table) {
            $table->dropColumn('rt_id');
        });
    }
};
