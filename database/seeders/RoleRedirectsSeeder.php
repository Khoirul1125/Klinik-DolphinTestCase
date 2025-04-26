<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleRedirectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleRedirects = [
            ['role_id' => 'Super-Admin', 'redirect_route' => 'superadmin'],
            ['role_id' => 'Dokter', 'redirect_route' => 'Dokter'],
            ['role_id' => 'Pendaftaran', 'redirect_route' => 'Pendaftaran'],
            ['role_id' => 'Apotik', 'redirect_route' => 'Apotik'],
            ['role_id' => 'Perawat', 'redirect_route' => 'Perawat'],
            ['role_id' => 'Kasir', 'redirect_route' => 'Kasir'],
            ['role_id' => 'SDM', 'redirect_route' => 'SDM'],
            ['role_id' => 'Rekam Medis', 'redirect_route' => 'Rekam Medis'],
        ];

        // Insert the data into the role_redirects table
        DB::table('role_redirects')->insert($roleRedirects);
    }
}
