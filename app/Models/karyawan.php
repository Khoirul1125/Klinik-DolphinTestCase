<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class karyawan extends Model
{
    use HasFactory;
    protected $table = 'karyawans';
    protected $fillable = [
        'nama_karyawan',
        'kode_karyawan',
        'nik',
        'jabatan',
        'aktivasi',
        'poli',
        'tglawal',
        'sip',
        'expspri',
        'str',
        'pk',
        'exppk',
        'expstr',
        'npwp',
        'status_kerja',
        'kode',
        'Alamat',
        'rt',
        'rw',
        'kode_pos',
        'kewarganegaraan',
        'provinsi',
        'kota_kabupaten',
        'kecamatan',
        'desa',
        'seks',
        'tempat_lahir',
        'tgllahir',
        'agama',
        'goldar',
        'pernikahan',
        'telepon',
        'suku',
        'bangsa',
        'bahasa',
        'pendidikan',
        'userinput',
        'userinputid',
        'posker',
        'user_id',
    ];



    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function pasien()
    {
        return $this->hasOne(pasien::class);
    }
    public function jabatans()
    {
        return $this->belongsTo(jabatan::class,'jabatan','id');
    }

    public function polis()
    {
        return $this->belongsTo(poli::class,'poli','id');
    }

    public function statdok()
    {
        return $this->belongsTo(statdok::class,'status_kerja','id');
    }
    public function rajal()
    {
        return $this->hasOne(rajal::class);
    }
    public function layanan()
    {
        return $this->hasOne(rajal_layanan::class,'id','id_dokter');
    }
    public function details()
    {
        return $this->hasOne(data_doctor::class);
    }

}
