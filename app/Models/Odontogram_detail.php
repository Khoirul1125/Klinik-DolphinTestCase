<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Odontogram_detail extends Model
{
    protected $fillable = [
        'patient_id','rawatt_id','Decayed', 'Missing', 'Filled', 'Foto', 'Rontgen',
        'Oclusi', 'Palatinus', 'Mandibularis', 'Platum',
        'Diastema', 'Anomali'
    ];

}
