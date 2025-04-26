<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class set_bpjs extends Model
{
    protected $table = 'set_bpjs';
    protected $fillable = [
        'CONSID',
        'USERNAME',
        'PASSWORD',
        'SCREET_KEY',
        'USER_KEY',
        'APP_CODE',
        'BASE_URL',
        'SERVICE',
        'SERVICE_ANTREAN',
        'KPFK',
    ];
}
