<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $guarded = [];

    public function dekan() { return $this->belongsTo(Dosen::class, 'dekan_id'); }
}
