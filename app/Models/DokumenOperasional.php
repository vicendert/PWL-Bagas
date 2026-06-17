<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_dokumen', 'tahun', 'kategori', 'unit_pengunggah', 'jabatan_pengunggah', 'file_path'])]
class DokumenOperasional extends Model
{
    protected $table = 'dokumen_operasional';
}
