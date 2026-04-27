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
    Schema::create('tahun_akademiks', function (Blueprint $table) {
        $table->id();
        $table->string('nama'); 
        $table->enum('semester', ['Ganjil', 'Genap']); // [cite: 10]
        $table->string('periode')->nullable(); 
        $table->date('tanggal_mulai'); 
        $table->date('tanggal_berakhir'); 
        $table->text('deskripsi')->nullable(); 
        $table->boolean('is_active')->default(false); 
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahun_akademiks');
    }
};
