<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Create users table
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('email')->unique();
                $table->string('password');
                $table->integer('umur')->nullable();
                $table->decimal('tinggi', 5, 2)->nullable();
                $table->decimal('berat', 5, 2)->nullable();
                $table->date('tanggal_lahir')->nullable();
                $table->string('jenis_kelamin')->nullable();
                $table->timestamps();
            });
        }

        // Create aktivitas_user table
        if (!Schema::hasTable('aktivitas_user')) {
            Schema::create('aktivitas_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->date('tanggal');
                $table->integer('umur')->nullable();
                $table->decimal('berat_badan', 5, 2)->nullable();
                $table->decimal('tinggi_badan', 5, 2)->nullable();
                $table->decimal('jam_tidur', 4, 2)->nullable();
                $table->integer('olahraga')->nullable(); // in minutes
                $table->timestamps();
            });
        }

        // Create tidur_user table
        if (!Schema::hasTable('tidur_user')) {
            Schema::create('tidur_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->date('tanggal');
                $table->decimal('durasi_jam', 4, 2)->nullable();
                $table->integer('kualitas_tidur')->nullable(); // 1-10
                $table->string('fase_tidur')->nullable();
                $table->string('jam_tidur')->nullable();
                $table->string('jam_bangun')->nullable();
                $table->timestamps();
            });
        }

        // Create info_makanan table
        if (!Schema::hasTable('info_makanan')) {
            Schema::create('info_makanan', function (Blueprint $table) {
                $table->id();
                $table->string('nama_makanan');
                $table->decimal('kalori', 8, 2)->nullable();
                $table->decimal('protein', 8, 2)->nullable();
                $table->decimal('karbohidrat', 8, 2)->nullable();
                $table->decimal('lemak', 8, 2)->nullable();
                $table->timestamps();
            });
        }

        // Create makanan_user table
        if (!Schema::hasTable('makanan_user')) {
            Schema::create('makanan_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->foreignId('makanan_id')->constrained('info_makanan')->onDelete('cascade');
                $table->date('tanggal');
                $table->integer('porsi')->nullable();
                $table->decimal('total_kalori', 10, 2)->nullable();
                $table->timestamps();
            });
        }

        // Create tantangan_user table
        if (!Schema::hasTable('tantangan_user')) {
            Schema::create('tantangan_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('nama_tantangan');
                $table->string('status')->default('proses'); // proses, selesai, gagal
                $table->date('tanggal_mulai');
                $table->date('tanggal_selesai');
                $table->timestamps();
            });
        }

        // Create target_user table
        if (!Schema::hasTable('target_user')) {
            Schema::create('target_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('jenis_target'); // 'berat', 'olahraga', 'tidur', 'kalori'
                $table->decimal('nilai_target', 10, 2);
                $table->string('satuan');
                $table->date('tanggal_target');
                $table->string('status')->default('proses');
                $table->timestamps();
            });
        }

        // Create rekomendasi_user table
        if (!Schema::hasTable('rekomendasi_user')) {
            Schema::create('rekomendasi_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->text('rekomendasi');
                $table->string('kategori'); // 'olahraga', 'nutrisi', 'tidur', 'umum'
                $table->date('tanggal_rekomendasi');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rekomendasi_user');
        Schema::dropIfExists('target_user');
        Schema::dropIfExists('tantangan_user');
        Schema::dropIfExists('makanan_user');
        Schema::dropIfExists('info_makanan');
        Schema::dropIfExists('tidur_user');
        Schema::dropIfExists('aktivitas_user');
        Schema::dropIfExists('users');
    }
};
