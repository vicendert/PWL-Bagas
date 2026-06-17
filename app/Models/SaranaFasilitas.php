<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['lapangan_id', 'kode_fasilitas', 'nama_unit', 'alamat'])]
class SaranaFasilitas extends Model
{
    protected $table = 'sarana_fasilitas';

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }
}
