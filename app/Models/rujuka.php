<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class rujuka extends Model
{
    protected $fillable = [
        'no_rujuk',
        'no_reg',
        'no_rawat',
        'kd_dokter',
        'kd_poli',
        'kd_pj',
        'kode_sub_spesialis',
        'kode_rumahsakit',
        'nama_rumahsakit',
        'alamat_rumahsakit',
        'no_telp_rumahsakit',
        'tgl_rujuk',
        'tanggal_berlaku',
        'kd_sarana',          // Tambahan untuk Sarana
        'kd_khusus',          // Tambahan untuk RJRS_KUHUS
        'catatan',            // Tambahan untuk RJRS_KUHUS
        'kdTacc',             // Tambahan untuk validasi RJRS
    ];

    public function rajal()
    {
        return $this->belongsTo(rajal::class, 'no_rawat', 'no_rawat');
    }

    public function pasien()
    {
        return $this->hasOneThrough(
            pasien::class,
            rajal::class,
            'no_rawat', // Foreign key di rajal
            'no_rm',    // Foreign key di pasien
            'no_rawat', // Local key di rujukas
            'no_rm'     // Local key di rajal
        );
    }

    public function subSpesialis()
    {
        return $this->belongsTo(subspesialis::class, 'kode_sub_spesialis', 'kode');
    }
}
