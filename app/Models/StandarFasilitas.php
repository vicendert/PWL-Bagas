<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['parent_id', 'nama_fasilitas', 'deskripsi', 'jenis_indikator', 'bobot_kelayakan', 'urutan'])]
class StandarFasilitas extends Model
{
    protected $table = 'standar_fasilitas';

    protected function casts(): array
    {
        return [
            'bobot_kelayakan' => 'decimal:2',
            'urutan' => 'integer',
        ];
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(StandarFasilitas::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(StandarFasilitas::class, 'parent_id')->orderBy('urutan');
    }
}
