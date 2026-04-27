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
        Schema::create('mutasi_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete(); // [cite: 86]
            $table->foreignId('lokasi_awal_id')->constrained('ruangs')->cascadeOnDelete(); // [cite: 86]
            $table->foreignId('lokasi_akhir_id')->constrained('ruangs')->cascadeOnDelete(); // [cite: 86]
            $table->integer('jumlah'); // [cite: 86]
            $table->enum('kondisi', ['Baik', 'Rusak Ringan', 'Rusak Berat']); // [cite: 86]
            $table->string('foto')->nullable(); // [cite: 86]
            $table->text('deskripsi')->nullable(); // [cite: 86]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mutasi_barangs');
    }
};
