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
        Schema::create('inventaris_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete(); // [cite: 92]
            $table->foreignId('ruang_id')->constrained('ruangs')->cascadeOnDelete(); // Lokasi [cite: 92]
            $table->integer('jumlah'); // [cite: 92]
            $table->string('kode_inventaris')->unique(); // [cite: 92]
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat'])->default('Baik'); // [cite: 92]
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Aktif'); // [cite: 92]
            $table->string('foto')->nullable(); // [cite: 92]
            $table->text('deskripsi')->nullable(); // [cite: 92]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_barangs');
    }
};
