<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satuan extends Model
{
    use HasFactory;
    protected $table = 'satuans';
    protected $fillable = [
        'kode_satuan',
        'nama_satuan',
    ];

    public function dabars()
    {
        return $this->hasMany(dabar::class, 'satuan_id', 'id');
    }

    public function dabars_sedang()
    {
        return $this->hasMany(dabar::class, 'kode_satuan_sedang', 'id');
    }

    public function dabars_besar()
    {
        return $this->hasMany(dabar::class, 'kode_satuan_besar', 'id');
    }
}
