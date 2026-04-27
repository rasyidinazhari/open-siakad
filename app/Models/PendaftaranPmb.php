<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendaftaranPmb extends Model
{
    use HasFactory;

    // Mengizinkan semua kolom diisi secara massal (updateOrCreate)
    protected $guarded = [];

    // Relasi balik ke tabel Users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}