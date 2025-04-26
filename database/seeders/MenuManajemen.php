<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuManajemen extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

         // Menu Utama
         $datamaster = DB::table('menu_manajemen')->insertGetId([
            'name' => 'Data Master',
            'route' => '',
            'icon' => 'fa fa-database',
            'permission' => 'datmas-all',
            'parent_id' => null,
            'is_visible' => true,
            'order' => 6
        ]);

        // Submenu untuk GCS
        $gcs = DB::table('menu_manajemen')->insertGetId([
            'name' => 'GCS',
            'route' => '',
            'icon' => 'fa fa-stethoscope',
            'permission' => 'datmas-gcs-all',
            'parent_id' => $datamaster,
            'is_visible' => true,
            'order' => 1
        ]);
        $doks = DB::table('menu_manajemen')->insertGetId([
            'name' => 'Dokter',
            'route' => '',
            'icon' => 'fa fa-stethoscope',
            'permission' => 'datmas-dokter-all',
            'parent_id' => $datamaster,
            'is_visible' => true,
            'order' => 2
        ]);
        $htt = DB::table('menu_manajemen')->insertGetId([
            'name' => 'Headtotoe',
            'route' => '',
            'icon' => 'fa fa-stethoscope',
            'permission' => 'datmas-htt-all',
            'parent_id' => $datamaster,
            'is_visible' => true,
            'order' => 3
        ]);
        $sdm = DB::table('menu_manajemen')->insertGetId([
            'name' => 'SDM',
            'route' => '',
            'icon' => 'fa fa-stethoscope',
            'permission' => 'datmas-sdm-all',
            'parent_id' => $datamaster,
            'is_visible' => true,
            'order' => 4
        ]);

        DB::table('menu_manajemen')->insert([
            [
                'name' => 'GCS Eye',
                'route' => 'datmas.eye',
                'icon' => '',
                'permission' => 'datmas-gcs-eye',
                'parent_id' => $gcs,
                'is_visible' => true,
                'order' => 1
            ],
            [
                'name' => 'GCS Eye Add',
                'route' => 'gcs.eye.add',
                'icon' => '',
                'permission' => 'datmas-gcs-eye-add',
                'parent_id' => $gcs,
                'is_visible' => false,
                'order' => 2
            ],
            [
                'name' => 'GCS Verbal',
                'route' => 'datmas.verbal',
                'icon' => '',
                'permission' => 'datmas-gcs-verbal',
                'parent_id' => $gcs,
                'is_visible' => true,
                'order' => 3
            ],
            [
                'name' => 'GCS Verbal Add',
                'route' => 'gcs.verbal.add',
                'icon' => '',
                'permission' => 'datmas-gcs-verbal-add',
                'parent_id' => $gcs,
                'is_visible' => false,
                'order' => 4
            ],
            [
                'name' => 'GCS Motorik',
                'route' => 'datmas.motorik',
                'icon' => '',
                'permission' => 'datmas-gcs-motorik',
                'parent_id' => $gcs,
                'is_visible' => true,
                'order' => 5
            ],
            [
                'name' => 'GCS Motorik Add',
                'route' => 'gcs.motorik.add',
                'icon' => '',
                'permission' => 'datmas-gcs-motorik-add',
                'parent_id' => $gcs,
                'is_visible' => false,
                'order' => 6
            ],
            [
                'name' => 'GCS Nilai',
                'route' => 'datmas.nilai',
                'icon' => '',
                'permission' => 'datmas-gcs-nilai',
                'parent_id' => $gcs,
                'is_visible' => true,
                'order' => 7
            ],
            [
                'name' => 'GCS Nilai Add',
                'route' => 'gcs.nilai.add',
                'icon' => '',
                'permission' => 'datmas-gcs-nilai-add',
                'parent_id' => $gcs,
                'is_visible' => false,
                'order' => 8
            ],
            [
                'name' => 'Poli Dokter',
                'route' => 'doctor.poli',
                'icon' => '',
                'permission' => 'datmas-dokter-poli',
                'parent_id' => $doks,
                'is_visible' => true,
                'order' => 9
            ],
            [
                'name' => 'Poli Dokter Add',
                'route' => 'doctor.poli.update',
                'icon' => '',
                'permission' => 'datmas-dokter-poli-add',
                'parent_id' => $doks,
                'is_visible' => false,
                'order' => 10
            ],
            [
                'name' => 'Spesilais Dokter',
                'route' => 'pcare.spesialis',
                'icon' => '',
                'permission' => 'datmas-dokter-spesialasi',
                'parent_id' => $doks,
                'is_visible' => true,
                'order' => 9
            ],
            [
                'name' => 'Sub Spesialais Dokter',
                'route' => 'pcare.subspesialis',
                'icon' => '',
                'permission' => 'datmas-dokter-poli-subspesialis',
                'parent_id' => $doks,
                'is_visible' => false,
                'order' => 10
            ],
            [
                'name' => 'ICD',
                'route' => 'datmas.icd',
                'icon' => '',
                'permission' => 'datmas-icd',
                'parent_id' => $doks,
                'is_visible' => true,
                'order' => 5
            ],
            [
                'name' => 'ICD Add',
                'route' => 'datmas.icd.9add',
                'icon' => '',
                'permission' => 'datmas-icd-9add',
                'parent_id' => $doks,
                'is_visible' => false,
                'order' => 5
            ],
            [
                'name' => 'Jabatan',
                'route' => 'doctor.jabatan',
                'icon' => '',
                'permission' => 'datmas-sdm-jabatan',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 11
            ],
            [
                'name' => 'Jabatan  Add',
                'route' => 'doctor.jabatans.add',
                'icon' => '',
                'permission' => 'datmas-sdm-jabatan-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                'order' => 12
            ],
            [
                'name' => 'Status Kepegawaian',
                'route' => 'doctor.status',
                'icon' => '',
                'permission' => 'datmas-sdm-status',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 13
            ],
            [
                'name' => 'Status Kepegawaian Add',
                'route' => 'doctor.status.add',
                'icon' => '',
                'permission' => 'datmas-sdm-status-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                'order' => 14
            ],
            [
                'name' => 'Posisi Kerja',
                'route' => 'datmas.posker',
                'icon' => '',
                'permission' => 'datmas-sdm-posisi',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 15
            ],
            [
                'name' => 'Posisi Kerja Add',
                'route' => 'datmas.posker.add',
                'icon' => '',
                'permission' => 'datmas-sdm-posisi-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                'order' => 16
            ],
            [
                'name' => 'Golongan Darah',
                'route' => 'patient.goldar',
                'icon' => '',
                'permission' => 'patient-goldar',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 11
            ],
            [
                'name' => 'Golongan Darah Add',
                'route' => 'patient.goldar.add',
                'icon' => '',
                'permission' => 'patient-goldar-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                 'order' => 12
                ],
            [
                'name' => 'Pemeriksaan',
                'route' => 'datmas.httpemeriksaan',
                'icon' => '',
                'permission' => 'datmas-htt-pemeriksaan',
                'parent_id' => $htt,
                'is_visible' => true,
                'order' => 15
            ],
            [
                'name' => 'Pemeriksaan add',
                'route' => 'datmas.httpemeriksaan.add',
                'icon' => '',
                'permission' => 'datmas-htt-pemeriksaan-add',
                'parent_id' => $htt,
                'is_visible' => false,
                'order' => 16
            ],
            [
                'name' => 'Sub Pemeriksaan',
                'route' => 'datmas.httsubpemeriksaan',
                'icon' => '',
                'permission' => 'datmas-htt-sub',
                'parent_id' => $htt,
                'is_visible' => true,
                'order' => 17
            ],
            [
                'name' => 'Sub Pemeriksaan',
                'route' => 'datmas.httsubpemeriksaan.add',
                'icon' => '',
                'permission' => 'datmas-htt-sub-add',
                'parent_id' => $htt,
                'is_visible' => false,
                'order' => 18
            ]
        ]);

        // Submenu lainnya
        DB::table('menu_manajemen')->insert([
            [
                'name' => 'Provider ',
                'route' => 'pcare.provider',
                'icon' => '',
                'permission' => 'datmas-dokter-poli-subspesialis',
                'parent_id' => $datamaster,
                'is_visible' => true,
                'order' => 5
            ],
            [
                'name' => 'Sarana ',
                'route' => 'pcare.sarana',
                'icon' => '',
                'permission' => 'datmas-dokter-poli-subspesialis',
                'parent_id' => $datamaster,
                'is_visible' => true,
                'order' => 5
            ],
            [
                'name' => 'Provider Dokter',
                'route' => 'pcare.khusus',
                'icon' => '',
                'permission' => 'datmas-dokter-poli-subspesialis',
                'parent_id' => $datamaster,
                'is_visible' => true,
                'order' => 5
            ],
            [
                'name' => 'Kategori Perawatan',
                'route' => 'datmas.katper',
                'icon' => '',
                'permission' => 'datmas-katper',
                'parent_id' => $datamaster,
                'is_visible' => true,
                 'order' => 6
            ],
            [
                'name' => 'Kategori Perawatan Add',
                'route' => 'datmas.katper.add',
                'icon' => '',
                'permission' => 'datmas-katper-add',
                'parent_id' => $datamaster,
                'is_visible' => false
                , 'order' => 6
            ],

            [
                'name' => 'Penanggung Jawab',
                'route' => 'datmas.penjab',
                'icon' => '',
                'permission' => 'datmas-penjab',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 13
            ],
            [
                'name' => 'Penanggung Jawab Add',
                'route' => 'datmas.penjab.add',
                'icon' => '',
                'permission' => 'datmas-penjab-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                'order' => 14
            ],
            [
                'name' => 'Bank',
                'route' => 'datmas.bank',
                'icon' => '',
                'permission' => 'datmas-bank',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 15
            ],
            [
                'name' => 'Bank Add',
                'route' => 'datmas.bank.add',
                'icon' => '',
                'permission' => 'datmas-bank-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                 'order' => 16
            ],
            [
                'name' => 'Bangsa',
                'route' => 'patient.bangsa',
                'icon' => '',
                'permission' => 'patient-bangsa',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 17
            ],
            [
                'name' => 'Bangsa Add',
                'route' => 'patient.bangsa.add',
                'icon' => '',
                'permission' => 'patient-bangsa-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                 'order' => 18
            ],
            [
                'name' => 'Bahasa',
                'route' => 'patient.bahasa',
                'icon' => '',
                'permission' => 'patient-bahasa',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 19
            ],
            [
                'name' => 'Bahasa Add',
                'route' => 'patient.bahasa.add',
                'icon' => '',
                'permission' => 'patient-bahasa-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                'order' => 20
            ],
            [
                'name' => 'Suku',
                'route' => 'patient.suku',
                'icon' => '',
                'permission' => 'patient-suku',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 21
            ],
            [
                'name' => 'Suku Add',
                'route' => 'patient.suku.add',
                'icon' => '',
                'permission' => 'patient-suku-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                'order' => 22
            ],
            [
                'name' => 'Jenis Kelamin',
                'route' => 'patient.seks',
                'icon' => '',
                'permission' => 'patient-seks',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 23
            ],
            [
                'name' => 'Jenis Kelamin Add',
                'route' => 'patient.seks.add',
                'icon' => '',
                'permission' => 'patient-seks-add',
                'parent_id' => $sdm,
                'is_visible' => false,
                'order' => 24
            ],
            [
                'name' => 'Perawatan Rawat Jalan',
                'route' => 'datmas.perjal',
                'icon' => '',
                'permission' => 'datmas-perjal',
                'parent_id' => $datamaster,
                'is_visible' => true,
                'order' => 25
            ],
            [
                'name' => 'Perawatan Rawat Jalan Add',
                'route' => 'datmas.perjal.add',
                'icon' => '',
                'permission' => 'datmas-perjal-add',
                'parent_id' => $datamaster,
                'is_visible' => false,
                'order' => 26
            ],
        ]);




        // Menu utama
        $sdm = DB::table('menu_manajemen')->insertGetId([
            'name' => 'SDM',
            'route' => '',
            'icon' => 'fa-solid fa-person-half-dress',
            'permission' => 'sdm-all',
            'parent_id' => null,
            'is_visible' => true,
            'order' => 5
        ]);
            // sub-menu dari SDM
            $dokter = DB::table('menu_manajemen')->insertGetId([
                'name' => 'Dokter',
                'route' => 'dokter.index',
                'icon' => 'fa-solid fa-user-doctor',
                'permission' => 'sdm-dokter-all',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 1
            ]);
            $staff = DB::table('menu_manajemen')->insertGetId([
                'name' => 'Staff',
                'route' => 'staff.index',
                'icon' => 'fa-solid fa-user-nurse',
                'permission' => 'sdm-perawat-all',
                'parent_id' => $sdm,
                'is_visible' => true,
                'order' => 2
            ]);
                // Sub-menu dari sub-menu SDM
                DB::table('menu_manajemen')->insert([
                    [
                        'name' => 'Dokter Add',
                        'route' => 'dokter.index.add',
                        'icon' => '',
                        'permission' => 'sdm-dokter-add',
                        'parent_id' => $dokter,
                        'is_visible' => false,
                        'order' => 1
                    ],
                    [
                        'name' => 'Dokter Update',
                        'route' => 'dokter.index.update',
                        'icon' => '',
                        'permission' => 'sdm-dokter-update',
                        'parent_id' => $dokter,
                        'is_visible' => false,
                        'order' => 2
                    ],
                    [
                        'name' => 'Dokter Delete',
                        'route' => 'dokter.index.delete',
                        'icon' => '',
                        'permission' => 'sdm-dokter-delete',
                        'parent_id' => $dokter,
                        'is_visible' => false,
                        'order' => 3
                    ],
                    [
                        'name' => 'Dokter Detail',
                        'route' => 'dokter.index.detail',
                        'icon' => '',
                        'permission' => 'sdm-dokter-detail',
                        'parent_id' => $dokter,
                        'is_visible' => false,
                        'order' => 4
                    ],
                    [
                        'name' => 'Dokter Detail add',
                        'route' => 'dokter.index.detail.add',
                        'icon' => '',
                        'permission' => 'sdm-dokter-detail-add',
                        'parent_id' => $dokter,
                        'is_visible' => false,
                        'order' => 5
                    ],
                    [
                        'name' => 'Dokter Jadwal',
                        'route' => 'dokter.index.jadwal',
                        'icon' => '',
                        'permission' => 'sdm-dokter-jadwal',
                        'parent_id' => $dokter,
                        'is_visible' => false,
                        'order' => 6
                    ],
                    [
                        'name' => 'Dokter Jadwal add',
                        'route' => 'dokter.index.jadwal.add',
                        'icon' => '',
                        'permission' => 'sdm-dokter-jadwal-add',
                        'parent_id' => $dokter,
                        'is_visible' => false,
                        'order' => 7
                    ],
                    [
                        'name' => 'Staff Add',
                        'route' => 'staff.index.add',
                        'icon' => '',
                        'permission' => 'sdm-staff-add',
                        'parent_id' => $staff,
                        'is_visible' => false,
                        'order' => 8
                    ],
                    [
                        'name' => 'Staff Delete',
                        'route' => 'staff.index.delete',
                        'icon' => '',
                        'permission' => 'sdm-staff-delete',
                        'parent_id' => $staff,
                        'is_visible' => false,
                        'order' => 9
                    ],
                    [
                        'name' => 'Staff Detail',
                        'route' => 'staff.index.detail',
                        'icon' => '',
                        'permission' => 'sdm-staff-detail',
                        'parent_id' => $staff,
                        'is_visible' => false,
                        'order' => 10
                    ],
                    [
                        'name' => 'Staff Detail add',
                        'route' => 'staff.index.detail.add',
                        'icon' => '',
                        'permission' => 'sdm-staff-detail-add',
                        'parent_id' => $staff,
                        'is_visible' => false,
                        'order' => 11
                    ],
                ]);

        // Menu utama
        $gudang = DB::table('menu_manajemen')->insertGetId([
            'name' => 'Gudang',
            'route' => '',
            'icon' => 'fa-solid fa-store',
            'permission' => 'gudang-all',
            'parent_id' => null,
            'is_visible' => true,
            'order' => 4
        ]);
            // sub-menu dari Gudang
            $barang = DB::table('menu_manajemen')->insertGetId([
                'name' => 'Barang',
                'route' => '',
                'icon' => 'fa-solid fa-bookmark',
                'permission' => 'gudang-barang-all',
                'parent_id' => $gudang,
                'is_visible' => true,
                'order' => 1
            ]);
            $dataharga = DB::table('menu_manajemen')->insertGetId([
                'name' => 'Seting Gudang',
                'route' => '',
                'icon' => 'fa-solid fa-gears',
                'permission' => 'gudang-seting-item-harga-all',
                'parent_id' => $gudang,
                'is_visible' => true,
                'order' => 2
            ]);
            $pembelian = DB::table('menu_manajemen')->insertGetId([
                'name' => 'Data Stok Barang',
                'route' => 'gudang.gudangobat',
                'icon' => 'fa-solid fa-chart-bar',
                'permission' => 'gudang-data-stok-barang',
                'parent_id' => $gudang,
                'is_visible' => true,
                'order' => 3
            ]);
                // Sub-menu dari sub-menu Gudang
                $databarang = DB::table('menu_manajemen')->insertGetId([
                    'name' => 'Data Barang',
                    'route' => 'datmas.dabar',
                    'icon' => 'fa-solid fa-square-poll-vertical',
                    'permission' => 'gudang-data-barang',
                    'parent_id' => $barang,
                    'is_visible' => true,
                    'order' => 1
                ]);
                $datapembelian = DB::table('menu_manajemen')->insertGetId([
                    'name' => 'Pembelian Barang',
                    'route' => 'barang.pembelian',
                    'icon' => 'fa-solid fa-cart-plus',
                    'permission' => 'gudang-pembelian-barang',
                    'parent_id' => $barang,
                    'is_visible' => true,
                    'order' => 2
                ]);
                $datasuplayer = DB::table('menu_manajemen')->insertGetId([
                    'name' => 'Data Supplier',
                    'route' => 'datmas.industri',
                    'icon' => 'fa-solid fa-person-chalkboard',
                    'permission' => 'gudang-data-supplier',
                    'parent_id' => $barang,
                    'is_visible' => true,
                    'order' => 3
                ]);
                $hargadobar = DB::table('menu_manajemen')->insertGetId([
                    'name' => 'Harga Barang',
                    'route' => 'gudang.hargaobat',
                    'icon' => 'fa-solid fa-money-check-dollar',
                    'permission' => 'gudang-harga-barang',
                    'parent_id' => $dataharga,
                    'is_visible' => true,
                    'order' => 1
                ]);
                $setingitem = DB::table('menu_manajemen')->insertGetId([
                    'name' => 'Seting Item',
                    'route' => 'gudang.setting',
                    'icon' => 'fa-solid fa-boxes-packing',
                    'permission' => 'gudang-seting-item',
                    'parent_id' => $dataharga,
                    'is_visible' => true,
                    'order' => 2
                ]);

                    // Sub-menu dari sub-menu dari sub-menu Gudang
                    DB::table('menu_manajemen')->insert([
                        [
                            'name' => 'Data Barang Add',
                            'route' => 'datmas.dabar.add',
                            'icon' => '',
                            'permission' => 'gudang-data-barang-add',
                            'parent_id' => $databarang,
                            'is_visible' => false,
                            'order' => 1
                        ],
                        [
                            'name' => 'Pembelian Barang Add',
                            'route' => 'barang.pembelian.add',
                            'icon' => '',
                            'permission' => 'gudang-pembelian-barang-add',
                            'parent_id' => $datapembelian,
                            'is_visible' => false,
                            'order' => 2
                        ],
                        [
                            'name' => 'Data Supplier Add',
                            'route' => 'datmas.industri.add',
                            'icon' => '',
                            'permission' => 'gudang-data-supplier-add',
                            'parent_id' => $datasuplayer,
                            'is_visible' => false,
                            'order' => 3
                        ],
                        [
                            'name' => 'Data Harga Barang Set',
                            'route' => 'gudang.setting.add',
                            'icon' => '',
                            'permission' => 'gudang-harga-barang-set',
                            'is_visible' => false,
                            'parent_id' => $dataharga,
                            'order' => 4
                        ],
                        [
                            'name' => 'Satuan Barang',
                            'route' => 'datmas.satuan',
                            'icon' => '',
                            'permission' => 'datmas-satuan',
                            'parent_id' => $dataharga,
                            'is_visible' => true,
                             'order' => 5
                        ],
                        [
                            'name' => 'Satuan Barang Add',
                            'route' => 'datmas.satuan.add',
                            'icon' => '',
                            'permission' => 'datmas-satuan-add',
                            'parent_id' => $dataharga,
                            'is_visible' => false,
                             'order' => 6
                        ],
                        [
                            'name' => 'Kategori Barang',
                            'route' => 'datmas.jenbar',
                            'icon' => '',
                            'permission' => 'datmas-jenbar',
                            'parent_id' => $dataharga,
                            'is_visible' => true,
                            'order' => 7
                        ],
                        [
                            'name' => 'Kategori Barang Add',
                            'route' => 'datmas.jenbar.add',
                            'icon' => '',
                            'permission' => 'datmas-jenbar-add',
                            'parent_id' => $dataharga,
                            'is_visible' => false,
                            'order' => 8
                        ],
                        [
                            'name' => 'DPHO Barang BPJS',
                            'route' => 'pcare.obats',
                            'icon' => '',
                            'permission' => 'datmas-jenbar-add',
                            'parent_id' => $dataharga,
                            'is_visible' => true,
                            'order' => 9
                        ],
                    ]);

        // Menu utama
        $keuangan = DB::table('menu_manajemen')->insertGetId([
            'name' => 'Keuangan',
            'route' => '',
            'icon' => 'fa-solid fa-calculator',
            'permission' => 'keuangan-all',
            'parent_id' => null,
            'is_visible' => true,
            'order' => 3
        ]);
            // sub-menu dari Keuangan
            $kasir = DB::table('menu_manajemen')->insertGetId([
                'name' => 'kasir',
                'route' => 'keuangan.kasir',
                'icon' => 'fa-solid fa-cash-register',
                'permission' => 'keuangan-kasir',
                'parent_id' => $keuangan,
                'is_visible' => true,
                'order' => 1
            ]);
            $kasirlunas = DB::table('menu_manajemen')->insertGetId([
                'name' => 'Data Lunas Kasir',
                'route' => 'keuangan.datakasir',
                'icon' => 'fa-solid fa-receipt',
                'permission' => 'keuangan-data-kasir',
                'parent_id' => $keuangan,
                'is_visible' => true,
                'order' => 2
            ]);

                // Sub-menu dari sub-menu Kasir
                DB::table('menu_manajemen')->insert([
                    [
                        'name' => 'Kasir Add',
                        'route' => 'keuangan.kasir.bayar.add',
                        'icon' => '',
                        'permission' => 'keuangan-kasir-add',
                        'parent_id' => $kasir,
                        'is_visible' => false,
                        'order' => 1
                    ],
                    [
                        'name' => 'Kasir Bayar',
                        'route' => 'keuangan.kasir.bayar',
                        'icon' => '',
                        'permission' => 'keuangan-kasir-bayar',
                        'parent_id' => $kasir,
                        'is_visible' => false,
                        'order' => 2
                    ],
                ]);

        // Menu utama
        $layan = DB::table('menu_manajemen')->insertGetId([
            'name' => 'Layanan',
            'route' => '',
            'icon' => 'fa-solid fa-house-chimney-medical',
            'permission' => 'layanan-all',
            'parent_id' => null,
            'is_visible' => true,
            'order' => 2
        ]);
            // sub-menu dari Layanan
            $layanrajald= DB::table('menu_manajemen')->insertGetId([
                'name' => 'Rawat Jalan dokter',
                'route' => 'layanan.rawat-jalan.index',
                'icon' => 'fa-solid fa-syringe',
                'permission' => 'layanan-rajal-dokter',
                'parent_id' => $layan,
                'is_visible' => true,
                'order' => 1
            ]);
            $layanrajalp = DB::table('menu_manajemen')->insertGetId([
                'name' => 'Rawat Jalan perawat',
                'route' => 'layanan.rawat-jalan.perawat.index',
                'icon' => 'fa-solid fa-hospital-user',
                'permission' => 'layanan-rajal-perawat',
                'parent_id' => $layan,
                'is_visible' => true,
                'order' => 2
            ]);
            $apotek = DB::table('menu_manajemen')->insertGetId([
                'name' => 'Apotek',
                'route' => 'barang.transaksi',
                'icon' => 'fa-solid fa-book-medical',
                'permission' => 'layanan-apotek',
                'parent_id' => $layan,
                'is_visible' => true,
                'order' => 3
            ]);

                // Sub-menu dari sub-menu Rawat Jalan
                DB::table('menu_manajemen')->insert([
                    [
                        'name' => 'Rawat Jalan dokter soap',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 1
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Add',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.add',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-add',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 2
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Delete',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.delete',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-delete',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 3
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Resep Obat',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.resep.obat',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-resep-obat',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 4
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Resep Obat Add',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.resep.obat.add',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-resep-obat-add',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 5
                    ],
                    [
                        'name' => 'Rawat Jalan perawat Delete',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.resep.obat.delete',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-resep-obat-delete',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 6
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Odontogram',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.odontogram',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-odontogram',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 7
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Odontogram Add',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.odontogram.add',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-odontogram-add',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 8
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Odontogram Add Details',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.odontogram.add.details',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-odontogram-add',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 9
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Tindakan',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.tindakan',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-tindakan',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 10
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Tindakan Add',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.tindakan.add',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-tindakan-add',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 11
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap Tindakan Delete',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.tindakan.delete',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-tindakan-delete',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 12
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap berkas digital',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.berkas.digital',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-berkas-digital',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 13
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap berkas digital Add',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.berkas.digital.add',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-berkas-digital-add',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 14
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap berkas digital Add Odontogram',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.berkas.digital.add.odontogram',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-berkas-digital-add-odontogram',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 15
                    ],
                    [
                        'name' => 'Rawat Jalan dokter soap berkas digital Delete',
                        'route' => 'layanan.rawat-jalan.soap-dokter.index.berkas.digital.delete',
                        'icon' => '',
                        'permission' => 'layanan-rajal-dokter-soap-berkas-digital-delete',
                        'parent_id' => $layanrajald,
                        'is_visible' => false,
                        'order' => 16
                    ],
                    [
                        'name' => 'Rawat Jalan perawat soap ',
                        'route' => 'layanan.rawat-jalan.soap-perawat.index',
                        'icon' => '',
                        'permission' => 'layanan-rajal-perawat-soap',
                        'parent_id' => $layanrajalp,
                        'is_visible' => false,
                        'order' => 17
                    ],
                    [
                        'name' => 'Rawat Jalan perawat soap Add',
                        'route' => 'layanan.rawat-jalan.soap-perawat.index.add',
                        'icon' => '',
                        'permission' => 'layanan-rajal-perawat-soap-add',
                        'parent_id' => $layanrajalp,
                        'is_visible' => false,
                        'order' => 18
                    ],
                    [
                        'name' => 'Rawat Jalan apotek add',
                        'route' => 'barang.transaksi.add',
                        'icon' => '',
                        'permission' => 'layanan-rajal-apotek-add',
                        'parent_id' => $apotek,
                        'is_visible' => false,
                        'order' => 19
                    ],
                ]);

        // Menu utama
        $Regi = DB::table('menu_manajemen')->insertGetId([
            'name' => 'Registrasi',
            'route' => '',
            'icon' => 'fa-solid fa-address-card',
            'permission' => 'regis-all',
            'parent_id' => null,
            'is_visible' => true,
            'order' => 1
        ]);
            // sub-menu dari Registrasi
            $pasienadd = DB::table('menu_manajemen')->insertGetId([
                'name' => 'pasien',
                'route' => 'pasien.index',
                'icon' => 'fa-solid fa-user-plus',
                'permission' => 'regis-pasien',
                'parent_id' => $Regi,
                'is_visible' => true,
                'order' => 1
            ]);
            $pasienrajal = DB::table('menu_manajemen')->insertGetId([
                'name' => 'Registrasi Rawat Jalan',
                'route' => 'regis.rajal',
                'icon' => 'fas fa-solid fa-wheelchair',
                'permission' => 'regis-rajal',
                'parent_id' => $Regi,
                'is_visible' => true,
                'order' => 2
            ]);

                // Sub-menu dari sub-menu Registrasi Rawat Jalan
                DB::table('menu_manajemen')->insert([
                    [
                        'name' => 'Registrasi Pasien Add',
                        'route' => 'pasien.index.add',
                        'icon' => '',
                        'permission' => 'regis-pasien-add',
                        'parent_id' => $pasienadd,
                        'is_visible' => false,
                        'order' => 1
                    ],
                    [
                        'name' => 'Registrasi Pasien Update',
                        'route' => 'pasien.index.update',
                        'icon' => '',
                        'permission' => 'regis-pasien-update',
                        'parent_id' => $pasienadd,
                        'is_visible' => false,
                        'order' => 2
                    ],
                    [
                        'name' => 'Registrasi Pasien Delete',
                        'route' => 'pasien.index.delete',
                        'icon' => '',
                        'permission' => 'regis-pasien-delete',
                        'parent_id' => $pasienadd,
                        'is_visible' => false,
                        'order' => 3
                    ],
                    [
                        'name' => 'Registrasi Pasien Lengkapi',
                        'route' => 'pasien.index.lengkapi',
                        'icon' => '',
                        'permission' => 'regis-pasien-lengkapi',
                        'parent_id' => $pasienadd,
                        'is_visible' => false,
                        'order' => 4
                    ],
                    [
                        'name' => 'Registrasi Rawat Jalan Add',
                        'route' => 'regis.rajal.add',
                        'icon' => '',
                        'permission' => 'regis-rajal-add',
                        'parent_id' => $pasienrajal,
                        'is_visible' => false,
                        'order' => 5
                    ],
                    [
                        'name' => 'Registrasi Rawat Jalan Delete',
                        'route' => 'rajal.delete',
                        'icon' => '',
                        'permission' => 'regis-rajal-delete',
                        'parent_id' => $pasienrajal,
                        'is_visible' => false,
                        'order' => 6
                    ],
                ]);
    }
}
