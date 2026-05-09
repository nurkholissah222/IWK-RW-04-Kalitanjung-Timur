<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            if (!Schema::hasColumn('wargas', 'no_kk')) {
                $table->string('no_kk', 16)->nullable()->after('nik');
            }
            if (Schema::hasColumn('wargas', 'status_warga')) {
                $table->renameColumn('status_warga', 'status');
            }
            if (Schema::hasColumn('wargas', 'no_wa')) {
                $table->renameColumn('no_wa', 'no_telp');
            }
        });
    }

    public function down(): void
    {
        Schema::table('wargas', function (Blueprint $table) {
            $table->dropColumn('no_kk');
            $table->renameColumn('status', 'status_warga');
            $table->renameColumn('no_telp', 'no_wa');
        });
    }
};
