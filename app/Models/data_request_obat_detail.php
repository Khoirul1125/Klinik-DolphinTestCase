<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_request_obat_detail extends Model
{
    use HasFactory;

    protected $table = 'data_request_obat_details';
    protected $fillable = [
        'kode',
        'kode_obat',
        'nama_obat',
        'qty',
    ];

    public function request()
    {
        return $this->belongsTo(data_request_obat::class, 'kode', 'kode');
    }

    public function kode_obat()
    {
        return $this->belongsTo(gudang_obat_utama::class, 'kode_obat', 'kode_barang');
    }
}
