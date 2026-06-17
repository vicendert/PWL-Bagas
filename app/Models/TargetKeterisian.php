<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['lapangan_id', 'tahun', 'bulan', 'target_jam', 'realisasi_jam'])]
class TargetKeterisian extends Model
{
    protected $table = 'target_keterisian';

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }
}
