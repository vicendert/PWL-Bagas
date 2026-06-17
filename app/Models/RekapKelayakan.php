<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['lapangan_id', 'target_keterisian_jam', 'nilai_kondisi_mandiri', 'nilai_tim_qc', 'grade', 'bintang'])]
class RekapKelayakan extends Model
{
    protected $table = 'rekap_kelayakan';

    protected function casts(): array
    {
        return [
            'nilai_kondisi_mandiri' => 'decimal:2',
            'nilai_tim_qc' => 'decimal:2',
            'bintang' => 'integer',
        ];
    }

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }
}
