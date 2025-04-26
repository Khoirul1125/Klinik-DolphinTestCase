<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class odontogram extends Model
{
    protected $fillable = [
        'patient_id',
        'rawatt_id',
        'tooth_number',
        'condition',
        'note',
    ];

}
