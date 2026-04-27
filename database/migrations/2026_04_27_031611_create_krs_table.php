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
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademiks')->cascadeOnDelete(); // [cite: 35]
            $table->integer('semester'); // [cite: 35]
            $table->foreignId('dosen_wali_id')->nullable()->constrained('dosens')->nullOnDelete(); // [cite: 35]
            $table->integer('total_sks')->default(0); // [cite: 33]
            $table->enum('status', ['Menunggu Persetujuan', 'Disetujui', 'Ditolak'])->default('Menunggu Persetujuan'); // [cite: 33, 34]
            $table->text('catatan')->nullable(); // [cite: 35]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
