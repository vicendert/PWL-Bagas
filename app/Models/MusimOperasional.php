<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['tahun', 'status'])]
class MusimOperasional extends Model
{
    protected $table = 'musim_operasional';
}
