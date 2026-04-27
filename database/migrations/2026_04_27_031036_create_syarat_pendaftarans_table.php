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
        Schema::create('syarat_pendaftarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_syarat'); // Contoh: Fotokopi Ijazah, Pas Foto
            $table->foreignId('jalur_pendaftaran_id')->constrained('jalur_pendaftarans')->cascadeOnDelete();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_pendaftarans');
    }
};
