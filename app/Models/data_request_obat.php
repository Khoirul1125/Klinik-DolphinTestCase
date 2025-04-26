<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_request_obat extends Model
{
    use HasFactory;

    protected $table = 'data_request_obats';
    protected $fillable = [
        'kode_klinik',
        'nama_klinik',
        'kode',
        'status',
    ];

    public function details()
    {
        return $this->hasMany(data_request_obat_detail::class, 'kode', 'kode');
    }
}
