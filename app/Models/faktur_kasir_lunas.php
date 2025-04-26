<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faktur_kasir_lunas extends Model
{
    use HasFactory;
    protected $table = 'faktur_kasir_lunas';
    protected $fillable = [
        'kode_faktur',
        'no_rm',
        'kode_obat',
        'nama',
        'harga',
        'kuantitas',
        'total_harga',
        'diskon',
        'tanggal',
        'user_name',
        'user_id',
    ];

    public function details()
    {
        return $this->belongsTo(faktur_kasir::class, 'kode_faktur', 'kode_faktur');
    }
}
