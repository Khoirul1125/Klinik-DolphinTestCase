<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class data_lama_pemeriksaan extends Model
{
    use HasFactory;
    protected $table = 'data_lama_pemeriksaans';
    protected $fillable = [
        'tanggal_pelayanan',
        'no_rm',
        'nama_pasien',
        'tanggal_lahir',
        'jenis_kelamin',
        'nama_dokter',
        'keadaan_umum',
        'kesadaran_pasien',
        'tekanan_darah',
        'nadi',
        'suhu',
        'pernafasan',
        'tinggi_badan',
        'berat_badan',
        'nasabah',
        'resep',
        'diagnosa',
        'tindakan',
        'laboratorium',
        'radiologi',
        'status_pcare',
        'no_surat',
        'keterangan',
        'yth',
        'rujuk_bagian',
        'jam_masuk',
        'jam_keluar',
        'no_kunjungan',
    ];
}
