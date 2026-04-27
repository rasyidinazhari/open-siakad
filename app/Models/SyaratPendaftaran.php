<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SyaratPendaftaran extends Model
{
    // Mengizinkan mass assignment agar Filament bisa menyimpan data
    protected $guarded = [];

    /**
     * Relasi ke Jalur Pendaftaran.
     * Nama fungsi 'jalur_pendaftaran' harus sama dengan yang dipanggil 
     * di SyaratPendaftaranResource ->relationship('jalur_pendaftaran', ...)
     */
    public function jalur_pendaftaran(): BelongsTo
    {
        return $this->belongsTo(JalurPendaftaran::class, 'jalur_pendaftaran_id');
    }
}