<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['nik', 'nama_staf', 'gelar', 'jenis_kelamin', 'jabatan', 'cabang_id', 'lapangan_id'])]
class StafQC extends Model
{
    protected $table = 'staf_qc';

    public function cabang(): BelongsTo
    {
        return $this->belongsTo(Cabang::class);
    }

    public function lapangan(): BelongsTo
    {
        return $this->belongsTo(Lapangan::class);
    }
}
