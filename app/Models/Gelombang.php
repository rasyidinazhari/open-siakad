<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gelombang extends Model
{
    protected $guarded = [];

    /**
     * Relasi ke Periode Pendaftaran
     * Nama fungsi ini HARUS 'periode_pendaftaran' agar sinkron dengan Resource
     */
    public function periode_pendaftaran(): BelongsTo
    {
        return $this->belongsTo(PeriodePendaftaran::class, 'periode_pendaftaran_id');
    }

    /**
     * Relasi ke Jalur Pendaftaran (Pastikan ini juga ada)
     */
    public function jalur_pendaftaran(): BelongsTo
    {
        return $this->belongsTo(JalurPendaftaran::class, 'jalur_pendaftaran_id');
    }
}
