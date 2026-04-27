<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BiayaPendaftaran extends Model
{
    // Mengizinkan mass assignment untuk menyimpan data dari Filament
    protected $guarded = [];

    /**
     * Relasi ke Jalur Pendaftaran.
     * Nama fungsi 'jalur_pendaftaran' harus sama dengan yang dipanggil 
     * di BiayaPendaftaranResource ->relationship('jalur_pendaftaran', ...)
     */
    public function jalur_pendaftaran(): BelongsTo
    {
        return $this->belongsTo(JalurPendaftaran::class, 'jalur_pendaftaran_id');
    }
}