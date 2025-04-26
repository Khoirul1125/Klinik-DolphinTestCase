<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_faktur extends Model
{
    use HasFactory;
    protected $table = 'barang_fakturs';
    protected $fillable = [
        'no_faktur',
        'supplier',
        'po_sp',
        'faktur_supplier',
        'tgl_faktur_supplier',
        'tgl_terima_barang',
        'tgl_jatuh_tempo',
        'ppn',
        'sub_total_barang',
        'total_ppn',
        'total_materai',
        'total_koreksi',
        'total_harga',
        'penerima_barang',
    ];

    public function barang_detail()
    {
        return $this->hasMany(barang_faktur_detail::class, 'no_faktur', 'no_faktur');
    }
}
