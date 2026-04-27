<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skripsi extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke Mahasiswa yang memiliki skripsi ini
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    // Relasi ke Dosen sebagai Pembimbing
    public function pembimbing()
    {
        return $this->belongsTo(Dosen::class, 'dosen_pembimbing_id');
    }
}