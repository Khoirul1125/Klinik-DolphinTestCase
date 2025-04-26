<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class motorik extends Model
{
    use HasFactory;
    protected $table = 'motoriks';
    protected $fillable = [
        'nama',
        'skor',
    ];

    public function soap_dokter()
    {
        return $this->hasOne(rajal_pemeriksaan::class, 'skor', 'motorik');
    }
}
