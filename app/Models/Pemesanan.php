<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['user_id', 'lapangan_id', 'slot_waktu_id', 'tanggal', 'jam_mulai', 'jam_selesai', 'total_biaya', 'status'])]
class Pemesanan extends Model
{
    protected $table = 'pemesanan';

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'total_biaya' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }

    public function slotWaktu(): BelongsTo
    {
        return $this->belongsTo(SlotWaktu::class);
    }
}
