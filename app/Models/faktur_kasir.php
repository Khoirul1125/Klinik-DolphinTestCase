<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faktur_kasir extends Model
{
    use HasFactory;
    protected $table = 'faktur_kasirs';
    protected $fillable = [
        'kode_faktur',
        'no_rm',
        'nama',
        'rawat',
        'jenis_px',
        'penjamin',
        'sub_total',
        'potongan',
        'total_sementara',
        'administrasi',
        'materai',
        'tagihan',
        'kembalian',
        'bayar_1',
        'uang_bayar_1',
        'bank_bayar_1',
        'ref_bayar_1',
        'bayar_2',
        'uang_bayar_2',
        'bank_bayar_2',
        'ref_bayar_2',
        'bayar_3',
        'uang_bayar_3',
        'bank_bayar_3',
        'ref_bayar_3',
        'user_name',
        'user_id',
    ];

    public function details()
    {
        return $this->hasMany(faktur_kasir_lunas::class, 'kode_faktur', 'kode_faktur');
    }

    public function details_obat()
    {
        return $this->hasMany(faktur_kasir_apotek::class, 'kode_faktur', 'kode_faktur');
    }

    public function details_tindakan()
    {
        return $this->hasMany(faktur_kasir_tindakan::class, 'kode_faktur', 'kode_faktur');
    }

    public function details_apotek()
    {
        return $this->belongsTo(faktur_apotek::class, 'kode_faktur', 'kode_faktur');
    }
}
