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
        // Skip if table doesn't exist (will be created by base migration)
        if (!Schema::hasTable('aktivitas_user')) {
            return;
        }

        Schema::table('aktivitas_user', function (Blueprint $table) {
            // Add new columns if they don't exist
            if (!Schema::hasColumn('aktivitas_user', 'umur')) {
                $table->integer('umur')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('aktivitas_user', 'berat_badan')) {
                $table->decimal('berat_badan', 5, 2)->nullable()->after('umur');
            }
            if (!Schema::hasColumn('aktivitas_user', 'tinggi_badan')) {
                $table->decimal('tinggi_badan', 5, 2)->nullable()->after('berat_badan');
            }
            if (!Schema::hasColumn('aktivitas_user', 'jam_tidur')) {
                $table->decimal('jam_tidur', 4, 2)->nullable()->after('tinggi_badan');
            }
            if (!Schema::hasColumn('aktivitas_user', 'olahraga')) {
                $table->integer('olahraga')->nullable()->after('jam_tidur');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aktivitas_user', function (Blueprint $table) {
            if (Schema::hasColumn('aktivitas_user', 'umur')) {
                $table->dropColumn('umur');
            }
            if (Schema::hasColumn('aktivitas_user', 'berat_badan')) {
                $table->dropColumn('berat_badan');
            }
            if (Schema::hasColumn('aktivitas_user', 'tinggi_badan')) {
                $table->dropColumn('tinggi_badan');
            }
            if (Schema::hasColumn('aktivitas_user', 'jam_tidur')) {
                $table->dropColumn('jam_tidur');
            }
            if (Schema::hasColumn('aktivitas_user', 'olahraga')) {
                $table->dropColumn('olahraga');
            }
        });
    }
};
