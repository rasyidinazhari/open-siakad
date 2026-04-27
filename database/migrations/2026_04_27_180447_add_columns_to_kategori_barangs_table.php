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
        Schema::table('kategori_barangs', function (Blueprint $table) {
            // Tambahkan kolom yang dibutuhkan Filament namun belum ada di DB
            $table->string('kode_kategori')->unique()->nullable()->after('nama_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kategori_barangs', function (Blueprint $table) {
            $table->dropColumn(['kode_kategori', 'slug']);
        });
    }
};
