<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kurikulum extends Model
{
    // Mengizinkan semua field diisi (sesuai kebutuhan Filament)
    protected $guarded = [];

    /**
     * Relasi ke Program Studi.
     * Nama fungsi 'program_studi' harus sama dengan yang dipanggil 
     * di KurikulumResource ->relationship('program_studi', ...)
     */
    public function program_studi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    /**
     * Relasi ke Mata Kuliah (Opsional, jika nanti dibutuhkan)
     * Biasanya satu kurikulum memiliki banyak mata kuliah
     */
    public function mata_kuliah(): HasMany
    {
        return $this->hasMany(MataKuliah::class, 'kurikulum_id');
    }
}
