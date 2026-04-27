<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MataKuliah extends Model
{
    protected $guarded = [];

    // Gunakan snake_case agar sesuai dengan ->relationship('program_studi') di Resource
    public function program_studi(): BelongsTo
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function kurikulum(): BelongsTo
    {
        return $this->belongsTo(Kurikulum::class, 'kurikulum_id');
    }

    // Tambahkan relasi Prasyarat (Self-referencing)
    public function prasyarat(): BelongsTo
    {
        return $this->belongsTo(MataKuliah::class, 'prasyarat_id');
    }

    // Tambahkan relasi Dosen (merujuk ke model Dosen)
    public function dosen_1(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_1_id');
    }

    public function dosen_2(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_2_id');
    }

    public function dosen_3(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'dosen_3_id');
    }
}
