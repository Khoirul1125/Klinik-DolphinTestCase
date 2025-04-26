<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dabar extends Model
{
    use HasFactory;
    protected $table = 'dabars';
    protected $fillable = [
        'kode',
        'formularium',
        'nama',
        'kode_kfa',
        'kode_dpho',
        'nama_dpho',
        'harga_dasar',
        'satuan_id',
        'satuan_sedang',
        'kode_satuan_sedang',
        'satuan_besar',
        'kode_satuan_besar',
        'penyimpanan',
        'barcode',
        'industri',
        'jenbar_id',
        'nama_generik',
        'bentuk_kesediaan',
        'dosis',
        'kode_dosis',
    ];

    public function satuan()
    {
        return $this->belongsTo(satuan::class);
    }

    public function satuan_sedangs()
    {
        return $this->belongsTo(satuan::class,'kode_satuan_sedang','id');
    }

    public function satuan_besars()
    {
        return $this->belongsTo(satuan::class,'kode_satuan_besar','id');
    }

    public function jenbar()
    {
        return $this->belongsTo(jenbar::class);
    }

    public function obat_pasien()
    {
        return $this->hasMany(obat_pasien::class, 'kode', 'kode_obat');
    }

    public function barangStok()
    {
        return $this->hasMany(barang_stok::class, 'kode_barang', 'kode');
    }
}
