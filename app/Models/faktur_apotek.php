<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class faktur_apotek extends Model
{
    use HasFactory;
    protected $table = 'faktur_apoteks';
    protected $fillable = [
        'no_reg',
        'no_rm',
        'nama',
        'alamat',
        'jenis_resep',
        'kode_faktur',
        'rawat',
        'nama_poli',
        'dokter',
        'jenis_px',
        'penjamin',
        'total_embis',
        'sub_total',
        'total',
        'stts_bayar',
    ];

    public function prebayar()
    {
        return $this->hasMany(faktur_apotek_prebayar::class, 'kode_faktur', 'kode_faktur');
    }

    public function penjab()
    {
        return $this->belongsTo(penjab::class, 'penjamin', 'kode');
    }

    public function rajal()
    {
        return $this->belongsTo(rajal::class, 'no_reg', 'no_rawat');
    }

    public function details_kasir()
    {
        return $this->hasOne(faktur_kasir::class, 'kode_faktur', 'kode_faktur');
    }
}
