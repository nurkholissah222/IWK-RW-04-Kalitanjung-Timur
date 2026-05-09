<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Update existing data to match new enum values before changing schema (if possible)
        // Note: MySQL enum might not allow updating to values not in enum yet.
        // So we change the enum first.

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->change(); // Temporary change to string to allow any value
        });

        DB::table('users')->where('role', 'admin')->update(['role' => 'RW']);
        DB::table('users')->where('role', 'petugas')->update(['role' => 'RT']);

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['RW', 'RT'])->default('RT')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->change();
        });

        DB::table('users')->where('role', 'RW')->update(['role' => 'admin']);
        DB::table('users')->where('role', 'RT')->update(['role' => 'petugas']);

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['admin', 'petugas'])->default('petugas')->change();
        });
    }
};
