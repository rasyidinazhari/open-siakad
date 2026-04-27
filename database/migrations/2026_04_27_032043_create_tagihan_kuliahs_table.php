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
        Schema::create('tagihan_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademiks')->cascadeOnDelete();
            $table->integer('semester');
            $table->string('nama_tagihan'); // Contoh: SPP Semester Ganjil 2024/2025
            $table->decimal('nominal', 15, 2);
            $table->enum('status', ['Belum Lunas', 'Lunas', 'Dibatalkan'])->default('Belum Lunas');
            $table->date('batas_waktu_pembayaran')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tagihan_kuliahs');
    }
};
