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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_barang_id')->constrained('kategori_barangs')->cascadeOnDelete(); // [cite: 83]
            $table->string('nama_barang'); // [cite: 83]
            $table->string('kode_barang')->unique(); // [cite: 83]
            $table->string('merk')->nullable(); // [cite: 83]
            $table->string('model')->nullable(); // [cite: 83]
            $table->string('satuan'); // [cite: 83]
            $table->string('foto_barang')->nullable(); // [cite: 83]
            $table->text('deskripsi')->nullable(); // [cite: 83]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
