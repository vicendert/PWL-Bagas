<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['lapangan_id', 'tanggal_mulai', 'tanggal_selesai', 'tipe_slot'])]
class SlotWaktu extends Model
{
    protected $table = 'slot_waktu';

    protected function casts(): array
    {
        return [
            'tanggal_mulai' => 'date',
            'tanggal_selesai' => 'date',
        ];
    }

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class);
    }
}
