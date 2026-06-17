<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_cabang', 'keterangan', 'alamat', 'telepon', 'is_active'])]
class Cabang extends Model
{
    protected $table = 'cabang';

    public function lapangans(): HasMany
    {
        return $this->hasMany(Lapangan::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function staffQc(): HasMany
    {
        return $this->hasMany(StafQC::class);
    }
}
