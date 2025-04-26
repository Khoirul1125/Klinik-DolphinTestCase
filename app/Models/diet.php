<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class diet extends Model
{
    use HasFactory;
    protected $table = 'diets';
    protected $fillable = [
        'nama',
        'kode',
    ];

}
