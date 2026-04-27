<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JalurPendaftaran extends Model
{
    // Mengizinkan mass assignment
    protected $guarded = [];

    /**
     * Relasi ke Periode Pendaftaran.
     * Nama fungsi 'periode_pendaftaran' harus sama dengan yang dipanggil 
     * di JalurPendaftaranResource ->relationship('periode_pendaftaran', ...)
     */
    public function periode_pendaftaran(): BelongsTo
    {
        return $this->belongsTo(PeriodePendaftaran::class, 'periode_pendaftaran_id');
    }

    /**
     * Relasi ke Gelombang.
     * Biasanya satu jalur pendaftaran memiliki banyak gelombang.
     */
    public function gelombangs(): HasMany
    {
        return $this->hasMany(Gelombang::class, 'jalur_pendaftaran_id');
    }
}
