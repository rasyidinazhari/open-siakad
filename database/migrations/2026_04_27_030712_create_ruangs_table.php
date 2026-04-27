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
        Schema::create('ruangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gedung_id')->constrained('gedungs')->cascadeOnDelete(); // 
            $table->string('nama_ruang'); // 
            $table->string('lantai'); // 
            $table->integer('kapasitas'); // 
            $table->enum('tipe_ruang', [
                'Ruang Publik', 
                'Kelas', 
                'Pelayanan', 
                'Khusus', 
                'Gudang'
            ]); // 
            $table->string('foto_ruang')->nullable(); // 
            $table->text('deskripsi')->nullable(); // 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruangs');
    }
};
