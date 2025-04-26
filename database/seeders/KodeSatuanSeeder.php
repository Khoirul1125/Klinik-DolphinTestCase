<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KodeSatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $satuan = [
            ['kode_satuan' => 'ST001', 'nama_satuan' => 'Kilogram'],
            ['kode_satuan' => 'ST002', 'nama_satuan' => 'Gram'],
            ['kode_satuan' => 'ST003', 'nama_satuan' => 'Liter'],
            ['kode_satuan' => 'ST004', 'nama_satuan' => 'Mililiter'],
            ['kode_satuan' => 'ST005', 'nama_satuan' => 'Unit'],
            ['kode_satuan' => 'ST006', 'nama_satuan' => 'Pcs'],
            ['kode_satuan' => 'ST007', 'nama_satuan' => 'Dus'],
            ['kode_satuan' => 'ST008', 'nama_satuan' => 'Botol'],
            ['kode_satuan' => 'ST009', 'nama_satuan' => 'Tablet'],
            ['kode_satuan' => 'ST010', 'nama_satuan' => 'Ampul'],
        ];

        DB::table('satuans')->insert($satuan);
    }
}
