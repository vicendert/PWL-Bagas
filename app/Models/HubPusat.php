<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['nama_hub', 'deskripsi'])]
class HubPusat extends Model
{
    protected $table = 'hub_pusat';

    public function lapangans(): HasMany
    {
        return $this->hasMany(Lapangan::class);
    }
}
