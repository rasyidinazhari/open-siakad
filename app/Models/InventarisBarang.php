<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventarisBarang extends Model
{
    protected $guarded = [];

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }

    // Jika di Resource pakai ->relationship('ruang', 'nama_ruang')
    public function ruang(): BelongsTo
    {
        return $this->belongsTo(Ruang::class, 'ruang_id');
    }


}
