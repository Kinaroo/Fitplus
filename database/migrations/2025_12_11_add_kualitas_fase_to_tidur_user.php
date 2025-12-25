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
        Schema::table('tidur_user', function (Blueprint $table) {
            if (!Schema::hasColumn('tidur_user', 'kualitas_tidur')) {
                $table->integer('kualitas_tidur')->nullable()->after('durasi_jam');
            }
            if (!Schema::hasColumn('tidur_user', 'fase_tidur')) {
                $table->string('fase_tidur')->nullable()->after('kualitas_tidur');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tidur_user', function (Blueprint $table) {
            if (Schema::hasColumn('tidur_user', 'kualitas_tidur')) {
                $table->dropColumn('kualitas_tidur');
            }
            if (Schema::hasColumn('tidur_user', 'fase_tidur')) {
                $table->dropColumn('fase_tidur');
            }
        });
    }
};
