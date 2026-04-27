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
        Schema::create('program_studis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fakultas_id')->constrained('fakultas')->cascadeOnDelete(); 
            $table->string('nama_program_studi'); 
            $table->string('kode_prodi')->unique();  
            $table->enum('jenjang', ['Diploma', 'Sarjana', 'Magister', 'Doktoral']); 
            $table->enum('gelar', ['D3', 'S1', 'S2', 'S3']); 
            $table->string('gelar_akhir')->nullable();  
            $table->foreignId('kaprodi_id')->nullable()->constrained('dosens')->nullOnDelete(); 
            $table->string('akreditasi')->nullable(); 
            $table->integer('durasi')->comment('dalam tahun'); 
            $table->text('deskripsi')->nullable(); 
            $table->text('tujuan')->nullable(); 
            $table->text('prospek_karir')->nullable(); 
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studis');
    }
};
