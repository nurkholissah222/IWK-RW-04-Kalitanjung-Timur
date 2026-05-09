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
        Schema::table('users', function (Blueprint $table) {
            // Check if column doesn't exist before adding
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('RT')->after('email');
            }
            
            if (!Schema::hasColumn('users', 'unit_rt')) {
                $table->string('unit_rt')->nullable()->after('role');
            }
        });

        // Update existing data: Users with null rt_id are likely RW
        \Illuminate\Support\Facades\DB::table('users')
            ->whereNull('rt_id')
            ->update(['role' => 'RW']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'unit_rt']);
        });
    }
};
