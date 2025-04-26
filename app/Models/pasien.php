<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pasien extends Model
{
    use HasFactory;
    protected $table = 'pasiens';
    protected $fillable = [
        'no_rm',
        'nik',
        'kode_ihs',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'no_bpjs',
        'tgl_akhir',
        'kelas_bpjs',
        'jenis_bpjs',
        'provide',
        'kodeprovide',
        'hubungan_keluarga',
        'Alamat',
        'rt',
        'rw',
        'kode_pos',
        'kewarganegaraan',
        'provinsi_kode',
        'kabupaten_kode',
        'kecamatan_kode',
        'desa_kode',
        'suku',
        'bahasa',
        'bangsa',
        'seks',
        'agama',
        'pendidikan',
        'goldar_id',
        'pernikahan',
        'pekerjaan',
        'telepon',
        'userinput',
        'userinputid',
        'user_id',
        'statusdata',
    ];

    public function goldar()
    {
        return $this->belongsTo(goldar::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'provinsi_kode', 'kode');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_kode', 'kode');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_kode', 'kode');
    }

    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_kode', 'kode');
    }

    public function seks()
    {
        return $this->belongsTo(seks::class, 'seks', 'id');
    }

    public function rajal()
    {
        return $this->hasOne(rajal::class,'no_rm','no_rm');
    }
}
