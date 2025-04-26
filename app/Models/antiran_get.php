<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class antiran_get extends Model
{
    protected $table = 'antiran_gets';
    protected $fillable = [
        'nomorkartu',
        'nik',
        'nohp',
        'kodepoli',
        'namapoli',
        'norm',
        'tanggalperiksa',
        'keluhan',
        'kodedokter',
        'namadokter',
        'jampraktek',
        'nomorantrean',
        'angkaantrean',
        'keterangan',
        'infoantrean',
        'sta_antian',
        'no_reg'
    ];

    public function poli()
    {
        return $this->belongsTo(poli::class, 'kodepoli', 'kode_poli');
    }

    public function loket()
    {
        return $this->belongsTo(antrian::class, 'kodepoli', 'poli_id'); // Hubungkan dengan Loket berdasarkan poli_id
    }

    public function kunjungan()
    {
        return $this->hasOne(rajal::class, 'no_rm', 'norm'); // Sesuaikan dengan nama tabel kunjungan
    }

}
