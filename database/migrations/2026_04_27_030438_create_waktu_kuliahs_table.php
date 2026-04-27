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
        Schema::create('waktu_kuliahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_waktu_kuliah'); // 
            $table->foreignId('jenis_kelas_id')->constrained('jenis_kelas')->cascadeOnDelete(); // 
            $table->time('waktu_mulai'); // [cite: 28]
            $table->time('waktu_selesai'); // [cite: 28]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waktu_kuliahs');
    }
};
