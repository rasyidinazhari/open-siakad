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
        Schema::create('gelombangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_gelombang'); // Contoh: Gelombang 1
            $table->foreignId('jalur_pendaftaran_id')->constrained('jalur_pendaftarans')->cascadeOnDelete();
            $table->foreignId('periode_pendaftaran_id')->constrained('periode_pendaftarans')->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gelombangs');
    }
};
