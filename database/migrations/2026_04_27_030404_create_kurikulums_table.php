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
        Schema::create('kurikulums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_studi_id')->constrained('program_studis')->cascadeOnDelete(); // 
            $table->string('nama_kurikulum'); // 
            $table->string('kode_kurikulum')->unique(); // [cite: 18]
            $table->year('tahun_mulai'); // 
            $table->year('tahun_berakhir')->nullable(); // 
            $table->text('deskripsi')->nullable(); // [cite: 19]
            $table->enum('status', ['Masih Berlaku', 'Tidak Berlaku'])->default('Masih Berlaku'); // [cite: 19]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurikulums');
    }
};
