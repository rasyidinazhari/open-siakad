<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JadwalPmb extends Model
{
    // Mengizinkan mass assignment agar Filament bisa menyimpan data
    protected $guarded = [];

    /**
     * Relasi ke Gelombang.
     * Nama fungsi 'gelombang' harus sama dengan yang dipanggil 
     * di JadwalPmbResource ->relationship('gelombang', ...)
     */
    public function gelombang(): BelongsTo
    {
        return $this->belongsTo(Gelombang::class, 'gelombang_id');
    }
}