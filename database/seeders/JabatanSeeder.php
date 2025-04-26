<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JabatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jabatan = [
            // Jabatan Medis
            ['nama' => 'Dokter Umum'],
            ['nama' => 'Dokter Spesialis'],
            ['nama' => 'Dokter Gigi'],
            ['nama' => 'Perawat'],
            ['nama' => 'Bidan'],
            ['nama' => 'Apoteker'],
            ['nama' => 'Asisten Apoteker'],
            ['nama' => 'Ahli Gizi'],
            ['nama' => 'Radiografer'],
            ['nama' => 'Fisioterapis'],
            ['nama' => 'Analis Laboratorium'],
            ['nama' => 'Sanitarian'],
            ['nama' => 'Psikolog Klinis'],
            ['nama' => 'Konselor'],

            // Jabatan Manajerial & Administrasi
            ['nama' => 'Direktur Rumah Sakit'],
            ['nama' => 'Manajer Administrasi'],
            ['nama' => 'Manajer Keuangan'],
            ['nama' => 'Manajer Sumber Daya Manusia (SDM)'],
            ['nama' => 'Kepala Instalasi Farmasi'],
            ['nama' => 'Kepala Instalasi Gizi'],
            ['nama' => 'Kepala Instalasi Radiologi'],
            ['nama' => 'Kepala Instalasi Laboratorium'],
            ['nama' => 'Kepala Instalasi Rekam Medis'],
            ['nama' => 'Kepala Instalasi Rawat Inap'],
            ['nama' => 'Supervisor Perawat'],
            ['nama' => 'Koordinator Klinik'],

            // Jabatan Pendukung
            ['nama' => 'Pendaftaran Pasien'],
            ['nama' => 'Kasir'],
            ['nama' => 'Petugas Kebersihan'],
            ['nama' => 'Teknisi Medis'],
            ['nama' => 'Security'],
            ['nama' => 'Driver Ambulans'],
        ];

        DB::table('jabatans')->insert($jabatan);
    }
}
