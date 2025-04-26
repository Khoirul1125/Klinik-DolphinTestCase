<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class poli extends Model
{
    use HasFactory;
    protected $table = 'polis';
    protected $fillable = [
        'nama_poli',
        'kode_poli',
        'jenis_poli',
        'id_satusehat',
        'deskripsi',
        'status',
    ];

    public function doctor()
    {
        return $this->hasOne(doctor::class);
    }

    public function perjal()
    {
        return $this->hasOne(perjal::class);
    }

    public function rajal()
    {
        return $this->hasMany(rajal::class);
    }

    public function antrian()
    {
        return $this->hasMany(antrian::class, 'poli_id');
    }

    public function antrianPasiens()
    {
        return $this->hasMany(antiran_get::class, 'kodepoli','kode_poli');
    }

}
