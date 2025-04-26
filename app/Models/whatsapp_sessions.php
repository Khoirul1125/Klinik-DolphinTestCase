<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class whatsapp_sessions extends Model
{
    protected $fillable =
    [
        'whatsapp_number',
        'is_authenticated'
    ];

}
