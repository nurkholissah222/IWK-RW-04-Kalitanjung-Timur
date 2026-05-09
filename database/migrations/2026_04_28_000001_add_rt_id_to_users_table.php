<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('rt_id')->nullable()->constrained('rt_units')->onDelete('set null');
            $table->enum('role', ['admin', 'petugas'])->default('petugas')->after('email');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['rt_id']);
            $table->dropColumn(['rt_id', 'role']);
        });
    }
};
