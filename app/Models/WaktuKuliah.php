<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WaktuKuliah extends Model
{
    protected $guarded = [];

    /**
     * Relasi ke Jenis Kelas.
     * Nama fungsi 'jenis_kelas' harus sama dengan yang dipanggil 
     * di WaktuKuliahResource ->relationship('jenis_kelas', ...)
     */
    public function jenis_kelas(): BelongsTo
    {
        return $this->belongsTo(JenisKelas::class, 'jenis_kelas_id');
    }
}
