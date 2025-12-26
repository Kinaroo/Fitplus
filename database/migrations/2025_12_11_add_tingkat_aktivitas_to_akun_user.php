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
        // Use 'users' table instead of non-existent 'akun_user'
        if (!Schema::hasTable('users')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tingkat_aktivitas')) {
                $table->decimal('tingkat_aktivitas', 3, 2)->default(1.55)->after('berat');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tingkat_aktivitas')) {
                $table->dropColumn('tingkat_aktivitas');
            }
        });
    }
};
