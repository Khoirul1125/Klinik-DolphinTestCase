<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rwy_penyakit_keluarga extends Model
{
    use HasFactory;
    protected $table = 'rwy_penyakit_keluargas';
    protected $fillable = [
        'no_rawat',
        'keluarga',
        'penyakit_keluarga',
    ];
}
