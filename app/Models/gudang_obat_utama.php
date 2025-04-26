<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gudang_obat_utama extends Model
{
    use HasFactory;

    protected $table = 'gudang_obat_utamas';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'qty',
        'tgl_terima',
        'exp',
    ];

    public function kode_obat()
    {
        return $this->hasMany(data_request_obat_detail::class, 'kode', 'kode');
    }
}
