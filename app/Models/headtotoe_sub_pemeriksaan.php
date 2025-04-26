<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class headtotoe_sub_pemeriksaan extends Model
{
    use HasFactory;
    protected $table = 'headtotoe_sub_pemeriksaans';
    protected $fillable = [
        'kode_pemeriksaan',
        'nama_pemeriksaan',
        'kode_subpemeriksaan',
        'nama_subpemeriksaan',
        'user_name',
        'user_id',
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(headtotoe_pemeriksaan::class, 'kode_pemeriksaan', 'kode_pemeriksaan');
    }

    public function detailPemeriksaan()
    {
        return $this->hasMany(headtotoe_detail_pemeriksaan::class, 'kode_subpemeriksaan', 'kode_subpemeriksaan');
    }
}
