<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class eye extends Model
{
    use HasFactory;
    protected $table = 'eyes';
    protected $fillable = [
        'nama',
        'skor',
    ];

    public function eye()
    {
        return $this->hasOne(rajal_pemeriksaan::class, 'skor', 'eye');
    }
}
