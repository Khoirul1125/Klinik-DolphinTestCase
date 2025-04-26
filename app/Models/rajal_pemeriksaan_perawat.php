<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rajal_pemeriksaan_perawat extends Model
{
    use HasFactory;
    protected $table = 'rajal_pemeriksaan_perawats';
    protected $casts = [
        'subyektif' => 'array',  // Memastikan kolom subyektif bertipe array
    ];
    protected $fillable = [
        'no_rawat',
        'tgl_kunjungan',
        'time',
        'nama_pasien',
        'tgl_lahir',
        'umur_pasien',
        'subyektif',
        'tensi',
        'suhu',
        'nadi',
        'rr',
        'tinggi_badan',
        'berat_badan',
        'spo2',
        'eye',
        'verbal',
        'motorik',
        'sadar',
        'alergi',
        'lingkar_perut',
        'nilai_bmi',
        'status_bmi',
        'headtotoe',
        'stts_soap',
        'user_name',
        'user_id',
    ];

    public function rajal()
    {
        return $this->belongsTo(rajal::class, 'no_rawat', 'no_rawat');
    }

    public function nilai_eye()
    {
        return $this->belongsTo(eye::class, 'eye', 'skor');
    }

    public function nilai_verbal()
    {
        return $this->belongsTo(verbal::class, 'verbal', 'skor');
    }

    public function nilai_motorik()
    {
        return $this->belongsTo(motorik::class, 'motorik', 'skor');
    }

    public function gcs_nilai()
    {
        return $this->belongsTo(gcs_nilai::class, 'sadar', 'skor');
    }
}
