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
        Schema::table('krs_details', function (Blueprint $table) {
            if (!Schema::hasColumn('krs_details', 'nilai_angka')) {
                $table->decimal('nilai_angka', 5, 2)->nullable()->after('jadwal_kuliah_id');
            }
            
            if (!Schema::hasColumn('krs_details', 'nilai_huruf')) {
                $table->string('nilai_huruf', 2)->nullable()->after('nilai_angka');
            }
            
            if (!Schema::hasColumn('krs_details', 'status_kelulusan')) {
                $table->enum('status_kelulusan', ['Lulus', 'Tidak Lulus', 'Pending'])->default('Pending')->after('nilai_huruf');
            }
        });
    }


    public function down(): void
    {
        Schema::table('krs_details', function (Blueprint $table) {
            $table->dropColumn(['nilai_angka', 'nilai_huruf', 'status_kelulusan']);
        });
    }
};
