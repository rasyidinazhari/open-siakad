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
        Schema::create('khs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('tahun_akademik_id')->constrained('tahun_akademiks')->cascadeOnDelete();
            $table->integer('semester');
            $table->integer('total_sks_semester');
            $table->decimal('ips', 3, 2)->default(0); // Indeks Prestasi Semester
            $table->decimal('ipk', 3, 2)->default(0); // Indeks Prestasi Kumulatif [cite: 39]
            $table->enum('status', ['Draft', 'Published'])->default('Draft'); // [cite: 39]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('khs');
    }
};
