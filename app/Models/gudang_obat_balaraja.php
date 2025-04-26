<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gudang_obat_balaraja extends Model
{
    use HasFactory;

    protected $table = 'gudang_obat_balarajas';
    protected $fillable = [
        'kode_klinik',
        'nama_klinik',
        'kode_obat',
        'nama_obat',
        'harga_dasar',
        'harga_jual',
        'jumlah',
    ];
}
