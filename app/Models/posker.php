<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posker extends Model
{
    use HasFactory;
    protected $table = 'poskers';
    protected $fillable = [
        'nama',
        'kode',
    ];
}
