<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PeriodePendaftaran extends Model
{
    // Mengizinkan mass assignment
    protected $guarded = [];

    /**
     * Relasi ke Tahun Akademik.
     * Nama fungsi 'tahun_akademik' harus sama dengan yang dipanggil 
     * di PeriodePendaftaranResource ->relationship('tahun_akademik', ...)
     */
    public function tahun_akademik(): BelongsTo
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    /**
     * Relasi ke Jalur Pendaftaran.
     * Biasanya satu periode memiliki banyak jalur pendaftaran.
     */
    public function jalur_pendaftarans(): HasMany
    {
        return $this->hasMany(JalurPendaftaran::class, 'periode_pendaftaran_id');
    }
}
