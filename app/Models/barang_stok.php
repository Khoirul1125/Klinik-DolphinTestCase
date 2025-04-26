<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_stok extends Model
{
    use HasFactory;
    protected $table = 'barang_stoks';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'qty',
        'tgl_terima',
        'harga_dasar',
        'exp',
    ];

    public function dabar()
    {
        return $this->belongsTo(dabar::class, 'kode_barang', 'kode');
    }

    public function harga()
    {
        return $this->belongsTo(barang_harga::class, 'kode_barang', 'kode_barang');
    }
}
