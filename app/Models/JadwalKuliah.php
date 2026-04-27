<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalKuliah extends Model
{
    protected $guarded = [];

    public function mata_kuliah(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    public function jenis_kelas(): BelongsTo
    {
        return $this->belongsTo(JenisKelas::class, 'jenis_kelas_id');
    }

    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }

    public function waktu_kuliah(): BelongsTo
    {
        return $this->belongsTo(WaktuKuliah::class, 'waktu_kuliah_id');
    }
}
