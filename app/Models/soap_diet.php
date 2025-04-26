<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class soap_diet extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_id',
        'rawatt_id',
        'jenis_diet',
        'jenis_makanan',
        'jenis_tidak_boleh_dimakan'
    ];

    protected $casts = [
        'jenis_makanan' => 'array',
        'jenis_tidak_boleh_dimakan' => 'array',
    ];

}
