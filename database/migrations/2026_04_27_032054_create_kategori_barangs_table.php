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
        Schema::create('kategori_barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori'); // [cite: 79]
            $table->string('kode')->unique(); // [cite: 79]
            $table->string('slug')->unique(); // [cite: 79]
            $table->text('deskripsi')->nullable(); // [cite: 80]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_barangs');
    }
};
