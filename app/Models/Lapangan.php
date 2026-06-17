<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'hub_pusat_id',
    'kategori_lapangan_id',
    'cabang_id',
    'kode',
    'nama_lapangan',
    'akreditasi',
    'nomor_sk',
    'tanggal_sertifikasi',
    'alamat',
    'dokumen_legalitas',
    'foto',
    'is_active'
])]
class Lapangan extends Model
{
    protected $table = 'lapangan';

    protected function casts(): array
    {
        return [
            'tanggal_sertifikasi' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function hubPusat(): BelongsTo
    {
        return $this->belongsTo(HubPusat::class);
    }

    public function kategoriLapangan(): BelongsTo
    {
        return $this->belongsTo(KategoriLapangan::class);
    }

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }

    public function saranaFasilitas(): HasMany
    {
        return $this->hasMany(SaranaFasilitas::class);
    }

    public function slotWaktus(): HasMany
    {
        return $this->hasMany(SlotWaktu::class);
    }

    public function targetKeterisians(): HasMany
    {
        return $this->hasMany(TargetKeterisian::class);
    }

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class);
    }

    public function staffQc(): HasMany
    {
        return $this->hasMany(StafQC::class);
    }

    public function rekapKelayakans(): HasMany
    {
        return $this->hasMany(RekapKelayakan::class);
    }
}
