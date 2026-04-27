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
        Schema::table('mahasiswas', function (Blueprint $table) {
     
            $table->string('asal_sekolah')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswas', function (Blueprint $table) {
            $table->dropColumn(['nik', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'alamat_lengkap', 'asal_sekolah']);
        });
    }
};
