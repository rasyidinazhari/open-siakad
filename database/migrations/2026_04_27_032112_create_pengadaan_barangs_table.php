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
        Schema::create('pengadaan_barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete(); // [cite: 89]
            $table->integer('jumlah'); // [cite: 89]
            $table->decimal('harga_satuan', 15, 2); // [cite: 89]
            $table->decimal('total_harga', 15, 2)->virtualAs('jumlah * harga_satuan'); // Otomatis kalkulasi
            $table->string('sumber_dana')->nullable(); // [cite: 89]
            $table->date('tanggal_pengadaan'); // [cite: 89]
            $table->date('tanggal_pembelian')->nullable(); // [cite: 89]
            $table->enum('status', ['Pending', 'Disetujui', 'Ditolak'])->default('Pending'); // [cite: 89]
            $table->text('deskripsi')->nullable(); // [cite: 89]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengadaan_barangs');
    }
};
