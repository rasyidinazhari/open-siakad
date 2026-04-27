<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Krs extends Model
{
    protected $guarded = [];

    public function jadwal_kuliahs()
    {
        return $this->belongsToMany(JadwalKuliah::class, 'krs_details', 'krs_id', 'jadwal_kuliah_id');
    }
}
