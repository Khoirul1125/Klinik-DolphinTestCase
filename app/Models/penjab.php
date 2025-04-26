<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class penjab extends Model
{
    use HasFactory;
    protected $table = 'penjabs';
    protected $fillable = [
        'kode',
        'pj',
        'nama',
        'alamat',
        'telp',
        'attn',
        'status',
    ];

    public function perjal()
    {
        return $this->hasOne(perjal::class);
    }

    public function rajal()
    {
        return $this->hasOne(rajal::class);
    }

    public function apotek()
    {
        return $this->hasOne(faktur_apotek::class, 'kode', 'penjamin');
    }
}
