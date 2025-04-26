<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gudang_obat_utama_harga extends Model
{
    use HasFactory;
    protected $table = 'gudang_obat_utama_hargas';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'harga_dasar',
        'disc',
        'ppn',
        'user',
    ];

    public function obatSementara()
    {
        return $this->hasOne(gudang_obat_sementara::class, 'kode_barang', 'kode_barang');
    }
}
