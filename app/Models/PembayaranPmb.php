<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use illuminate\Database\Eloquent\Relations\BelongsTo; 

class PembayaranPmb extends Model
{
    public function biaya_pendaftaran() { return $this->belongsTo(BiayaPendaftaran::class); }

    public function mahasiswa(): BelongsTo
    {
        // Pastikan kolom di tabel pembayaran_pmbs adalah mahasiswa_id
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }
}
