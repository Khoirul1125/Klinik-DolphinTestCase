<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dphobarang extends Model
{
    use HasFactory;
    protected $table = 'dphobarangs';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
    ];
}
