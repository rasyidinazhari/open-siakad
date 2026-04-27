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
        Schema::create('jadwal_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mata_kuliah_id')->constrained('mata_kuliahs')->cascadeOnDelete(); // 
            $table->foreignId('dosen_id')->constrained('dosens')->cascadeOnDelete(); // 
            $table->foreignId('ruang_id')->constrained('ruangs')->cascadeOnDelete(); // 
            $table->foreignId('jenis_kelas_id')->constrained('jenis_kelas')->cascadeOnDelete(); // 
            $table->foreignId('waktu_kuliah_id')->constrained('waktu_kuliahs')->cascadeOnDelete(); // 
            
            $table->string('kelas'); // Contoh: A, B, C 
            $table->integer('beban_sks'); // 
            $table->integer('pertemuan'); // Contoh: 1, 2, 3 
            $table->string('hari'); // 
            $table->enum('metode', ['Tatap Muka', 'Online']); // 
            $table->date('tanggal')->nullable(); // 
            $table->string('link')->nullable(); // Opsional untuk metode Online 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_kuliahs');
    }
};
