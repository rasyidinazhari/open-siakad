<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramStudi extends Model
{
    protected $guarded = [];
    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function kaprodi(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'kaprodi_id');
    }
}
