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
        Schema::create('pembayaran_pmbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mahasiswa_id')->constrained('mahasiswas')->cascadeOnDelete();
            $table->foreignId('biaya_pendaftaran_id')->constrained('biaya_pendaftarans')->cascadeOnDelete();
            
            // --- Kolom Tambahan untuk Midtrans ---
            $table->string('order_id')->unique()->nullable(); // ID Unik untuk dikirim ke Midtrans
            $table->string('snap_token')->nullable(); // Token untuk memunculkan pop-up di Vue
            // -------------------------------------
            
            $table->string('bukti_bayar')->nullable(); // Tetap ada sebagai fallback/manual
            $table->enum('status', ['Pending', 'Lunas', 'Dibatalkan', 'Kedaluwarsa'])->default('Pending'); // Disesuaikan dengan status Midtrans
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_pmbs');
    }
};
