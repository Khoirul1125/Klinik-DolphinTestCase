<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_faktur_detail extends Model
{
    use HasFactory;
    protected $table = 'barang_faktur_details';
    protected $fillable = [
        'no_faktur',
        'tgl_terima',
        'nama_barang',
        'kode_barang',
        'qty',
        'harga',
        'exp',
        'diskon',
        'ppn',
        'kode_batch',
        'total'
    ];

    public function barang_faktur()
    {
        return $this->belongsTo(barang_faktur::class, 'no_faktur', 'no_faktur');
    }
}
