<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_setting extends Model
{
    use HasFactory;
    protected $table = 'barang_settings';
    protected $fillable = [
        'hj_1',
        'hj_2',
        'hj_3',
        'hj_4',
        'hj_5',
        'embalase',
    ];

    // Menambahkan method untuk mengubah data yang sudah ada
    public function updateSetting($data)
    {
        if (isset($data['hj_1'])) {
            $this->hj_1 = $data['hj_1'];
        }
        if (isset($data['hj_2'])) {
            $this->hj_2 = $data['hj_2'];
        }
        if (isset($data['hj_3'])) {
            $this->hj_3 = $data['hj_3'];
        }
        if (isset($data['hj_4'])) {
            $this->hj_4 = $data['hj_4'];
        }
        if (isset($data['hj_5'])) {
            $this->hj_5 = $data['hj_5'];
        }
        if (isset($data['embalase'])) {
            $this->embalase = $data['embalase'];
        }
        $this->save();
    }

    protected static function booted()
    {
        static::saved(function ($barangSetting) {
            // Ambil semua data dari barang_harga
            $barangHargas = barang_harga::all();

            foreach ($barangHargas as $barangHarga) {
                // Perbarui nilai harga_1 hingga harga_5
                $hargaDasar = $barangHarga->harga_dasar;

                $barangHarga->update([
                    'harga_1' => $hargaDasar + ($hargaDasar * ($barangSetting->hj_1 / 100)),
                    'harga_2' => $hargaDasar + ($hargaDasar * ($barangSetting->hj_2 / 100)),
                    'harga_3' => $hargaDasar + ($hargaDasar * ($barangSetting->hj_3 / 100)),
                    'harga_4' => $hargaDasar + ($hargaDasar * ($barangSetting->hj_4 / 100)),
                    'harga_5' => $hargaDasar + ($hargaDasar * ($barangSetting->hj_5 / 100)),
                ]);
            }
        });
    }
}
