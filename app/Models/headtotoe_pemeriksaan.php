<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class headtotoe_pemeriksaan extends Model
{
    use HasFactory;
    protected $table = 'headtotoe_pemeriksaans';
    protected $fillable = [
        'kode_pemeriksaan',
        'nama_pemeriksaan',
        'user_name',
        'user_id',
    ];

    public function subPemeriksaan()
    {
        return $this->hasMany(headtotoe_sub_pemeriksaan::class, 'kode_pemeriksaan', 'kode_pemeriksaan');
    }

}
