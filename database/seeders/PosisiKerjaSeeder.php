<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosisiKerjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posisiKerja = [
            // Posisi Medis
            ['nama' => 'Dokter Umum', 'kode' => 'ST-DUM'],
            ['nama' => 'Dokter Spesialis', 'kode' => 'ST-DSP'],
            ['nama' => 'Perawat', 'kode' => 'ST-PRW'],
            ['nama' => 'Bidan', 'kode' => 'ST-BID'],
            ['nama' => 'Apoteker', 'kode' => 'ST-APT'],
            ['nama' => 'Asisten Apoteker', 'kode' => 'ST-AAPT'],
            ['nama' => 'Analis Laboratorium', 'kode' => 'ST-ALB'],
            ['nama' => 'Radiografer', 'kode' => 'ST-RAD'],
            ['nama' => 'Fisioterapis', 'kode' => 'ST-FIS'],
            ['nama' => 'Ahli Gizi', 'kode' => 'ST-GIZ'],
            ['nama' => 'Psikolog Klinis', 'kode' => 'ST-PSK'],

            // Posisi Administratif & Manajerial
            ['nama' => 'Administrasi', 'kode' => 'ST-ADM'],
            ['nama' => 'Manajer Keuangan', 'kode' => 'ST-MKU'],
            ['nama' => 'Manajer SDM', 'kode' => 'ST-MSD'],
            ['nama' => 'Kepala Instalasi Farmasi', 'kode' => 'ST-KIF'],
            ['nama' => 'Kepala Instalasi Radiologi', 'kode' => 'ST-KIR'],
            ['nama' => 'Kepala Instalasi Laboratorium', 'kode' => 'ST-KIL'],
            ['nama' => 'Supervisor Perawat', 'kode' => 'ST-SPV'],

            // Posisi Pendukung
            ['nama' => 'Pendaftaran Pasien', 'kode' => 'ST-PPN'],
            ['nama' => 'Kasir', 'kode' => 'ST-KSR'],
            ['nama' => 'Petugas Kebersihan', 'kode' => 'ST-PKB'],
            ['nama' => 'Teknisi Medis', 'kode' => 'ST-TKM'],
            ['nama' => 'Security', 'kode' => 'ST-SEC'],
            ['nama' => 'Driver Ambulans', 'kode' => 'ST-DRV'],

            // Posisi Umum
            ['nama' => 'Umum', 'kode' => 'ST-UMU'],
        ];

        DB::table('poskers')->insert($posisiKerja);
    }
}
