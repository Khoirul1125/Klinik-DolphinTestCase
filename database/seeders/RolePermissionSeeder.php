<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'all-permission']);
        Permission::create(['name' => 'datmas-all']);
        Permission::create(['name' => 'datmas-gcs-all']);
        Permission::create(['name' => 'datmas-gcs-eye']);
        Permission::create(['name' => 'datmas-gcs-eye-add']);
        Permission::create(['name' => 'datmas-gcs-verbal']);
        Permission::create(['name' => 'datmas-gcs-verbal-add']);
        Permission::create(['name' => 'datmas-gcs-motorik']);
        Permission::create(['name' => 'datmas-gcs-motorik-add']);
        Permission::create(['name' => 'datmas-gcs-nilai']);
        Permission::create(['name' => 'datmas-gcs-nilai-add']);
        Permission::create(['name' => 'datmas-icd']);
        Permission::create(['name' => 'datmas-icd-9add']);
        Permission::create(['name' => 'datmas-katper']);
        Permission::create(['name' => 'datmas-katper-add']);
        Permission::create(['name' => 'datmas-satuan']);
        Permission::create(['name' => 'datmas-satuan-add']);
        Permission::create(['name' => 'datmas-jenbar']);
        Permission::create(['name' => 'datmas-jenbar-add']);
        Permission::create(['name' => 'patient-goldar']);
        Permission::create(['name' => 'patient-goldar-add']);
        Permission::create(['name' => 'datmas-penjab']);
        Permission::create(['name' => 'datmas-penjab-add']);
        Permission::create(['name' => 'datmas-bank']);
        Permission::create(['name' => 'datmas-bank-add']);
        Permission::create(['name' => 'patient-bangsa']);
        Permission::create(['name' => 'patient-bangsa-add']);
        Permission::create(['name' => 'patient-bahasa']);
        Permission::create(['name' => 'patient-bahasa-add']);
        Permission::create(['name' => 'patient-suku']);
        Permission::create(['name' => 'patient-suku-add']);
        Permission::create(['name' => 'patient-seks']);
        Permission::create(['name' => 'patient-seks-add']);
        Permission::create(['name' => 'datmas-perjal']);
        Permission::create(['name' => 'datmas-perjal-add']);
        Permission::create(['name' => 'sdm-all']);
        Permission::create(['name' => 'sdm-dokter-all']);
        Permission::create(['name' => 'sdm-perawat-all']);
        Permission::create(['name' => 'sdm-dokter-add']);
        Permission::create(['name' => 'sdm-dokter-update',]);
        Permission::create(['name' => 'sdm-dokter-delete',]);
        Permission::create(['name' => 'sdm-dokter-detail']);
        Permission::create(['name' => 'sdm-dokter-detail-add']);
        Permission::create(['name' => 'sdm-dokter-jadwal']);
        Permission::create(['name' => 'sdm-dokter-jadwal-add']);
        Permission::create(['name' => 'sdm-staff-add']);
        Permission::create(['name' => 'sdm-staff-delete']);
        Permission::create(['name' => 'sdm-staff-detail']);
        Permission::create(['name' => 'sdm-staff-detail-add']);
        Permission::create(['name' => 'gudang-all']);
        Permission::create(['name' => 'gudang-barang-all']);
        Permission::create(['name' => 'gudang-seting-item-harga-all']);
        Permission::create(['name' => 'gudang-data-stok-barang']);
        Permission::create(['name' => 'gudang-data-barang']);
        Permission::create(['name' => 'gudang-pembelian-barang']);
        Permission::create(['name' => 'gudang-data-supplier']);
        Permission::create(['name' => 'gudang-harga-barang']);
        Permission::create(['name' => 'gudang-seting-item']);
        Permission::create(['name' => 'gudang-data-barang-add']);
        Permission::create(['name' => 'gudang-pembelian-barang-add']);
        Permission::create(['name' => 'gudang-data-supplier-add']);
        Permission::create(['name' => 'gudang-harga-barang-set']);
        Permission::create(['name' => 'keuangan-all']);
        Permission::create(['name' => 'keuangan-kasir']);
        Permission::create(['name' => 'keuangan-data-kasir']);
        Permission::create(['name' => 'keuangan-kasir-add']);
        Permission::create(['name' => 'keuangan-kasir-bayar']);
        Permission::create(['name' => 'regis-all']);
        Permission::create(['name' => 'layanan-all']);
        Permission::create(['name' => 'layanan-rajal-dokter']);
        Permission::create(['name' => 'layanan-rajal-perawat']);
        Permission::create(['name' => 'layanan-apotek']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-add']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-delete']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-resep-obat']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-resep-obat-add']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-resep-obat-delete']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-odontogram']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-odontogram-add']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-tindakan']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-tindakan-add']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-tindakan-delete']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-berkas-digital']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-berkas-digital-add']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-berkas-digital-add-odontogram']);
        Permission::create(['name' => 'layanan-rajal-dokter-soap-berkas-digital-delete']);
        Permission::create(['name' => 'layanan-rajal-perawat-soap']);
        Permission::create(['name' => 'layanan-rajal-perawat-soap-add']);
        Permission::create(['name' => 'layanan-rajal-apotek-add']);
        Permission::create(['name' => 'regis-pasien']);
        Permission::create(['name' => 'regis-rajal']);
        Permission::create(['name' => 'regis-pasien-add']);
        Permission::create(['name' => 'regis-pasien-update']);
        Permission::create(['name' => 'regis-pasien-lengkapi']);
        Permission::create(['name' => 'regis-rajal-add']);
        Permission::create(['name' => 'regis-rajal-delete']);
        Permission::create(['name' => 'datmas-Dokter-all']);
        Permission::create(['name' => 'datmas-dokter-poli-add']);
        Permission::create(['name' => 'datmas-dokter-jabatan']);
        Permission::create(['name' => 'datmas-dokter-jabatan-add']);
        Permission::create(['name' => 'datmas-dokter-status']);
        Permission::create(['name' => 'datmas-dokter-status-add']);




        Role::create(['name' => 'Super-Admin']);
        Role::create(['name' => 'Dokter']);
        Role::create(['name' => 'Pendaftaran']);
        Role::create(['name' => 'Apotik']);
        Role::create(['name' => 'Perawat']);
        Role::create(['name' => 'Kasir']);
        Role::create(['name' => 'SDM']);
        Role::create(['name' => 'Rekam Medis']);
        Role::create(['name' => 'User']);


        $rolesuperadmin = Role::findByName('Super-Admin');
        $rolesuperadmin->givePermissionTo('all-permission');
    }
}
