<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class obat_pasien extends Model
{
    use HasFactory;
    protected $table = 'obat_pasiens';
    protected $fillable = [
        'no_rm',
        'no_rawat',
        'nama_pasien',
        'tgl',
        'jam',
        'penjab',
        'header',
        'kode_obat',
        'nama_obat',
        'dosis',
        'dosis_satuan',
        'instruksi',
        'signa_s',
        'signa_x',
        'signa_besaran',
        'signa_keterangan',
    ];


    public function obats()
    {
        return $this->belongsTo(dabar::class, 'kode_obat', 'kode');
    }

    public function harga()
    {
        return $this->belongsTo(barang_harga::class, 'kode_obat', 'kode_barang');
    }

    public function rajal()
    {
        return $this->belongsTo(rajal::class, 'no_rawat', 'no_rawat');
    }
}
