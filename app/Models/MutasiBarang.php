<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MutasiBarang extends Model
{
    protected $guarded = [];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    public function lokasi_awal(): BelongsTo
    {
        return $this->belongsTo(Ruang::class, 'ruang_awal_id');
    }

    // Relasi untuk Ruang Akhir
    public function lokasi_akhir(): BelongsTo
    {
        return $this->belongsTo(Ruang::class, 'ruang_akhir_id');
    }
}
