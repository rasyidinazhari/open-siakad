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
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nim')->unique()->nullable(); // [cite: 114]
            $table->string('no_registrasi')->unique()->nullable(); // [cite: 63]
            $table->foreignId('program_studi_id')->nullable()->constrained('program_studis')->nullOnDelete(); // [cite: 114]
            $table->integer('semester')->default(1); // [cite: 114]
            
            $table->enum('status', [
                'Calon Mahasiswa Baru',
                'Mahasiswa Aktif',
                'Mahasiswa Non Aktif',
                'Mahasiswa Alumni'
            ])->default('Calon Mahasiswa Baru'); // [cite: 115, 116, 117, 118]

            // Biodata Lengkap PMB
            $table->string('nik')->nullable(); // [cite: 64]
            $table->string('nomor_telepon')->nullable(); // [cite: 64]
            $table->enum('jenis_kelamin', ['Laki laki', 'Perempuan'])->nullable(); // [cite: 64]
            $table->enum('agama', ['Islam', 'Katholik', 'Kristen', 'Hindu', 'Budha', 'Konghucu'])->nullable(); // [cite: 64]
            $table->string('tempat_lahir')->nullable(); // [cite: 64]
            $table->date('tanggal_lahir')->nullable(); // [cite: 64]
            $table->text('alamat_lengkap')->nullable(); // [cite: 64]
            $table->string('rt')->nullable(); // [cite: 64]
            $table->string('rw')->nullable(); // [cite: 64]
            $table->string('desa_kelurahan')->nullable(); // [cite: 64]
            $table->string('kecamatan')->nullable(); // [cite: 64]
            $table->string('kota_kabupaten')->nullable(); // [cite: 64]
            $table->string('provinsi')->nullable(); // [cite: 64]
            $table->string('kode_pos')->nullable(); // [cite: 64]

            // Kolom Relasi untuk PMB (Jalur, Gelombang, Jenis Kelas). 
            // Menggunakan foreignIdFor / unsignedBigInteger karena tabel referensinya akan dibuat di kloter berikutnya.
            $table->unsignedBigInteger('jalur_pendaftaran_id')->nullable(); // [cite: 64]
            $table->unsignedBigInteger('gelombang_id')->nullable(); // [cite: 64]
            $table->unsignedBigInteger('jenis_kelas_id')->nullable(); // [cite: 64]
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
