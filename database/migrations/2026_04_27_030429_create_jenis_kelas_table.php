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
        Schema::create('jenis_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jenis_kelas'); // 
            $table->string('kode_jenis_kelas')->unique(); // 
            $table->text('deskripsi')->nullable(); // 
            $table->boolean('status')->default(true); // [cite: 24]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jenis_kelas');
    }
};
