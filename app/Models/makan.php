<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class makan extends Model
{
    use HasFactory;
    protected $table = 'makans';
    protected $fillable = [
        'nama',
        'kode',
    ];
}
