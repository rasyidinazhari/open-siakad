<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran_pmbs', function (Blueprint $table) {
            $table->string('order_id')->unique()->nullable()->after('biaya_pendaftaran_id');
            $table->string('snap_token')->nullable()->after('order_id');
        });

        // Gunakan Raw SQL untuk mengubah ENUM di PostgreSQL
        DB::statement("ALTER TABLE pembayaran_pmbs DROP CONSTRAINT IF EXISTS pembayaran_pmbs_status_check");
        DB::statement("ALTER TABLE pembayaran_pmbs ALTER COLUMN status TYPE VARCHAR(255)");
        DB::statement("ALTER TABLE pembayaran_pmbs ADD CONSTRAINT pembayaran_pmbs_status_check CHECK (status IN ('Pending', 'Lunas', 'Dibatalkan', 'Kedaluwarsa'))");
        DB::statement("ALTER TABLE pembayaran_pmbs ALTER COLUMN status SET DEFAULT 'Pending'");
    }

    public function down(): void
    {
        Schema::table('pembayaran_pmbs', function (Blueprint $table) {
            $table->dropColumn(['order_id', 'snap_token']);
        });

        DB::statement("ALTER TABLE pembayaran_pmbs DROP CONSTRAINT IF EXISTS pembayaran_pmbs_status_check");
        DB::statement("ALTER TABLE pembayaran_pmbs ADD CONSTRAINT pembayaran_pmbs_status_check CHECK (status IN ('Pending', 'Lunas', 'Ditolak'))");
    }
};
