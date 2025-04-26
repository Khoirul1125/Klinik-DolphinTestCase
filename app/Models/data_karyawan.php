<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class data_karyawan extends Model
{
    // Tentukan tabel yang digunakan oleh model ini
    protected $table = 'data_karyawans';
    protected $fillable = [
        'karyawan_id',
        'education',           // Data pendidikan (JSON)
        'certifications',      // Data sertifikasi (JSON)
        'bank_name',
        'bank_number',
        'bank_branch',
    ];

    protected $casts = [
        'education' => 'array',         // JSON untuk pendidikan
        'certifications' => 'array',   // JSON untuk sertifikasi
    ];

    public function karyawan()
    {
        return $this->belongsTo(karyawan::class);
    }
}
