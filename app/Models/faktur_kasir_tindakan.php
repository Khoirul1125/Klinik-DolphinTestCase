<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faktur_kasir_tindakan extends Model
{
    use HasFactory;

    // Menentukan nama tabel jika tidak mengikuti konvensi plural
    protected $table = 'faktur_kasir_tindakans';

    // Menentukan kolom yang dapat diisi (mass-assignable)
    protected $fillable = [
        'kode_faktur',
        'no_rm',
        'nama',
        'provide',
        'nama_dokter',
        'harga_dokter',
        'nama_perawat',
        'harga_perawat',
        'qty',
        'harga',
        'total_harga',
        'tanggal',
        'user_name',
        'user_id',
    ];

    public function details()
    {
        return $this->belongsTo(faktur_kasir::class, 'kode_faktur', 'kode_faktur');
    }
}
