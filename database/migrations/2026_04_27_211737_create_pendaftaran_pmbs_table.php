<?php 
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pendaftaran_pmbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Kolom Biodata
            $table->string('nik', 16)->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('asal_sekolah')->nullable();

            // Kolom Berkas (File path)
            $table->string('path_foto')->nullable();
            $table->string('path_ijazah')->nullable();
            $table->string('path_kk')->nullable();
            $table->string('path_ktp')->nullable();

            // Kolom Status Pendaftaran
            $table->enum('status_lulus', ['Pending', 'Lulus', 'Tidak Lulus'])->default('Pending');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_pmbs');
    }
};