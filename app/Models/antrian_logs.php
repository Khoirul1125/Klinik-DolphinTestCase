<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class antrian_logs extends Model
{
    protected $fillable = [
        'nomor_antrean',
        'nama_pasien',
        'poli',
        'dipanggil',
    ];
}
