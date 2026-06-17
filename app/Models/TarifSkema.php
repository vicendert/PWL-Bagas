<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['cabang_id', 'tahun', 'nilai_tarif', 'deskripsi_skema_jam', 'periode', 'lokasi_lapangan'])]
class TarifSkema extends Model
{
    protected $table = 'tarif_skema';

    protected function casts(): array
    {
        return [
            'nilai_tarif' => 'decimal:2',
        ];
    }

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }
}
