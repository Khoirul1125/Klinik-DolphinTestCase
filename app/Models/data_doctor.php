<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class data_doctor extends Model
{
    // Tentukan tabel yang digunakan oleh model ini
    protected $table = 'data_doctors';
    protected $fillable = [
        'doctor_id',
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

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
