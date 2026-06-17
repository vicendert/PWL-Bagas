<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['nama_temuan', 'jenis_temuan'])]
class KategoriTemuan extends Model
{
    protected $table = 'kategori_temuan';
}
