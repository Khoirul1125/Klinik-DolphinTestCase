<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            SetwebSeeder::class,
            Set_bpjsSeeder::class,
            Set_satusehatSeeder::class,
            RoleRedirectsSeeder::class,
            ProvinsiSeeder::class,
            kabupatenSeeder::class,
            KecamatanSeeder::class,
            DesaSeeder::class,
            MenuManajemen::class,
            GCSSeeder::class,
            kaperSeeder::class,
            BahasaSeeder::class,
            BangsaSeeder::class,
            BankSeeder::class,
            GolonganDarahSeeder::class,
            JabatanSeeder::class,
            JenisKelaminSeeder::class,
            KodeSatuanSeeder::class,
            PosisiKerjaSeeder::class,
            StatusKepegawaianSeeder::class,
            SukuSeeder::class,
            lisensiSeeder::class,
        ]);
    }
}
