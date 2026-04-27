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
        Schema::create('mata_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurikulum_id')->constrained('kurikulums')->cascadeOnDelete(); // 
            $table->foreignId('program_studi_id')->constrained('program_studis')->cascadeOnDelete(); // 
            
            // Self-referencing untuk matkul prasyarat (opsional)
            $table->foreignId('prasyarat_id')->nullable()->constrained('mata_kuliahs')->nullOnDelete(); // 
            
            // Dosen Pengampu
            $table->foreignId('dosen_1_id')->nullable()->constrained('dosens')->nullOnDelete(); // 
            $table->foreignId('dosen_2_id')->nullable()->constrained('dosens')->nullOnDelete(); // 
            $table->foreignId('dosen_3_id')->nullable()->constrained('dosens')->nullOnDelete(); // 
            
            $table->string('nama_mata_kuliah'); // [cite: 21, 22]
            $table->string('kode_mata_kuliah')->unique(); // [cite: 21]
            $table->integer('semester'); // [cite: 21, 22]
            $table->integer('sks'); // [cite: 21]
            $table->string('dokumen_rps')->nullable(); // 
            $table->string('dokumen_kontrak_kuliah')->nullable(); // 
            $table->text('deskripsi_mata_kuliah')->nullable(); // 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_kuliahs');
    }
};
