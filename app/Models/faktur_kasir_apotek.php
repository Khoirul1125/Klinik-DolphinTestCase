<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faktur_kasir_apotek extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak mengikuti konvensi plural
    protected $table = 'faktur_kasir_apoteks';

    // Menentukan kolom yang dapat diisi (mass-assignable)
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
        'jam',
        'user_name',
        'user_id',
    ];

    public function details()
    {
        return $this->belongsTo(faktur_kasir::class, 'kode_faktur', 'kode_faktur');
    }
}
