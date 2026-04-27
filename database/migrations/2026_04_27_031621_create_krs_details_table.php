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
        Schema::create('krs_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('krs_id')->constrained('krs')->cascadeOnDelete();
            $table->foreignId('jadwal_kuliah_id')->constrained('jadwal_kuliahs')->cascadeOnDelete();
            
            // Bagian ini akan diisi oleh Dosen di akhir semester [cite: 36, 111]
            $table->decimal('nilai_angka', 5, 2)->nullable(); 
            $table->string('nilai_huruf', 2)->nullable(); // A, B, C, D, E
            $table->boolean('is_lulus')->nullable(); // Menentukan lulus/tidak lulus [cite: 37]
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('krs_details');
    }
};
