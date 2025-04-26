<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faktur_apotek_prebayar extends Model
{
    use HasFactory;
    protected $table = 'faktur_apotek_prebayars';
    protected $fillable = [
        'no_rm',
        'kode_faktur',
        'nama',
        'rawat',
        'jenis_resep',
        'jenis_px',
        'tanggal',
        'jam',
        'nama_obat',
        'kode',
        'harga',
        'kuantitas',
        'total_harga',
        'diskon',
    ];

    public function faktur()
    {
        return $this->belongsTo(faktur_apotek::class, 'kode_faktur', 'kode_faktur');
    }
}
