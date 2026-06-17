<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_kategori', 'icon', 'deskripsi'])]
class KategoriLapangan extends Model
{
    protected $table = 'kategori_lapangan';

    public function lapangans(): HasMany
    {
        return $this->hasMany(Lapangan::class);
    }
}
