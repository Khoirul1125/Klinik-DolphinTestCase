<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gudang_obat_sementara extends Model
{
    use HasFactory;

    protected $table = 'gudang_obat_sementaras';
    protected $fillable = [
        'kode_klinik',
        'nama_klinik',
        'kode_req',
        'kode_barang',
        'nama_obat',
        'harga_dasar',
        'exp',
        'qty',
    ];

    public function harga()
    {
        return $this->belongsTo(gudang_obat_utama_harga::class, 'kode_barang', 'kode_barang');
    }
}
