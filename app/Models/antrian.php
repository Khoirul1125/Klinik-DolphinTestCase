<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class antrian extends Model
{
    protected $table = 'antrians';
    protected $fillable = [
        'nama',
        'poli_id',
    ];

    public function poli()
    {
        return $this->belongsTo(Poli::class, 'poli_id');
    }

    // Relasi dengan AntrianPasien (Loket)
    public function antrianPasiens()
    {
        return $this->hasMany(antiran_get::class, 'kodepoli', 'poli_id');
    }
}
