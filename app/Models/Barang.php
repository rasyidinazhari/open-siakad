<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    protected $guarded = [];

    // Harus 'kategori_barang' karena di Resource panggil 'kategori_barang'
    public function kategori_barang(): BelongsTo
    {
        return $this->belongsTo(KategoriBarang::class, 'kategori_barang_id');
    }
}
