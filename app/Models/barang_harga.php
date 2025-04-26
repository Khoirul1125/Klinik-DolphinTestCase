<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class barang_harga extends Model
{
    use HasFactory;
    protected $table = 'barang_hargas';
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'harga_dasar',
        'harga_1',
        'harga_2',
        'harga_3',
        'harga_4',
        'harga_5',
        'disc',
        'ppn',
        'user',
    ];

    protected static function booted()
    {
        static::creating(function ($barangHarga) {
            // Ambil data dari tabel barang_settings
            $barangSetting = barang_setting::first(); // Ambil data pertama, sesuaikan logika jika ada banyak

            if ($barangSetting) {
                $hargaDasar = $barangHarga->harga_dasar;

                // Hitung harga 1 - 5 berdasarkan persentase di barang_settings
                $barangHarga->harga_1 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_1 / 100));
                $barangHarga->harga_2 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_2 / 100));
                $barangHarga->harga_3 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_3 / 100));
                $barangHarga->harga_4 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_4 / 100));
                $barangHarga->harga_5 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_5 / 100));
            }
        });

        // Logika saat memperbarui data
        static::updating(function ($barangHarga) {
            // Cek apakah harga_dasar berubah
            if ($barangHarga->isDirty('harga_dasar')) {
                $barangSetting = barang_setting::first();

                if ($barangSetting) {
                    $hargaDasar = $barangHarga->harga_dasar;

                    $barangHarga->harga_1 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_1 / 100));
                    $barangHarga->harga_2 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_2 / 100));
                    $barangHarga->harga_3 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_3 / 100));
                    $barangHarga->harga_4 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_4 / 100));
                    $barangHarga->harga_5 = $hargaDasar + ($hargaDasar * ($barangSetting->hj_5 / 100));
                }
            }
        });
    }

    public function obat()
    {
        return $this->hasOne(obat_pasien::class, 'kode_barang', 'kode_obat');
    }

    public function stok()
    {
        return $this->hasOne(barang_stok::class, 'kode_barang', 'kode_barang');
    }
}
