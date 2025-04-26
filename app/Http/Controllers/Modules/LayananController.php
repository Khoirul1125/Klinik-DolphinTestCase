<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\BpjsController;
use App\Http\Controllers\Controller;
use App\Models\antiran_get;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PDF;
use App\Models\bank;
use App\Models\barang_stok;
use App\Models\Berkasdigital;
use Illuminate\Http\Request;
use App\Models\setweb;
use App\Models\doctor;
use App\Models\pasien;
use App\Models\seks;
use App\Models\penjab;
use App\Models\poli;
use App\Models\rujukan;
use App\Models\rajal;
use App\Models\perjal;
use App\Models\ranap;
use App\Models\icd9;
use App\Models\icd10;
use App\Models\prosedur_pasien;
use App\Models\diagnosa_pasien;
use App\Models\rajal_pemeriksaan;
use App\Models\eye;
use App\Models\verbal;
use App\Models\motorik;
use App\Models\gcs_nilai;
use App\Models\rwy_penyakit_keluarga;
use App\Models\rajal_layanan;
use App\Models\suberdaya;
use App\Models\faktur_apotek;
use App\Models\faktur_apotek_prebayar;
use App\Models\faktur_kasir;
use App\Models\faktur_kasir_apotek;
use App\Models\faktur_kasir_lunas;
use App\Models\faktur_kasir_tindakan;
use App\Models\obat_pasien;
use App\Models\odontogram;
use App\Models\Odontogram_detail;
use App\Models\rajal_pemeriksaan_perawat;
use App\Models\satuan;
use App\Models\ugd;
use App\Models\DataTables;
use App\Models\headtotoe_pemeriksaan;
use App\Models\headtotoe_sub_pemeriksaan;
use App\Models\provider;
use App\Models\rujuka;
use App\Models\sarana;
use App\Models\set_bpjs;
use App\Models\spesiali;
use App\Models\subspesialis;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;

class LayananController extends Controller
{
    public function rajal()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "rajal";
        $rajal = Rajal::with(['poli', 'doctor', 'penjab', 'pasien'])
        ->get()
        ->map(function ($item) {
            $item->regis = Rajal::where('no_rm', $item->no_rm)
                ->where('no_rawat', $item->no_rawat)
                ->exists();

            $item->SOAP = rajal_pemeriksaan::where('no_rm', $item->no_rm)
                ->where('no_rawat', $item->no_rawat)
                ->exists();

            $item->obat = obat_pasien::where('no_rm', $item->no_rm)
                ->where('no_rawat', $item->no_rawat)
                ->exists();

                $antrean = antiran_get::where('norm', $item->no_rm)
                ->where('kodepoli', $item->poli->kode_poli ?? null)
                ->where('no_reg', $item->no_reg)
                ->first();

                $item->nomor_antrean = $antrean ? $antrean->nomorantrean : null;

            return $item;
        });

        $sarana = sarana::all();
        $subspesiali = subspesialis::all();
        $sarana = sarana::all();
        $provide = provider::all();
        $spesialis = spesiali::all();
        return view('layanan.rajal', compact('title','rajal','sarana','subspesiali','sarana','provide','spesialis'));
    }


    public function rujuk_lanjut(Request $request)
    {
        // Validasi data yang diterima dari frontend
        $request->validate([
            'nomor_rawat' => 'required|string',
            'status_ljt' => 'required|string',
            'kdTacc' => 'required|string',
            'alasanTacc' => 'nullable|string',
            'provider' => 'required|string',
            'tglRujukan' => 'required|string',

        ]);

        // Ambil data pasien
        $pasien = rajal_pemeriksaan::where('no_rawat', $request->nomor_rawat)->first();
        $noruju = rajal::where('no_rawat', $request->nomor_rawat)->first();
        $nopasien = pasien::where('no_rm', $noruju->no_rm)->first();

        if (!$pasien || !$noruju || !$nopasien) {
            return response()->json([
                'message' => 'Data pasien tidak ditemukan!',
                'error' => true
            ], 404);
        }

        // Pisahkan nilai sistole dan diastole jika tersedia
        if ($pasien->tensi) {
            list($sistole, $diastole) = explode("/", $pasien->tensi);
        } else {
            $sistole = null;
            $diastole = null;
        }

        // Mengambil anamnesa (subyektif) dengan validasi
        $subyektif = is_array($pasien->subyektif) ? implode(" ", $pasien->subyektif) : ($pasien->subyektif ?? "");

        // Ambil semua diagnosa pasien berdasarkan nomor rawat
        $diagnosas = diagnosa_pasien::where('no_rawat', $request->nomor_rawat)
            ->pluck('kode')
            ->toArray();

        // Jika tidak ada diagnosa, kembalikan error
        if (count($diagnosas) < 1) {
            return response()->json([
                'message' => 'Minimal harus ada 1 diagnosa!',
                'error' => true
            ], 400);
        }

        // Maksimal hanya 3 diagnosa yang dikirim ke BPJS
        $diagnosas = array_slice($diagnosas, 0, 3);
        $diagnosas = array_pad($diagnosas, 3, null); // Pastikan ada 3 slot (jika kurang, isi dengan null)

        // Data umum untuk BPJS
        $data = [
            "noKunjungan" => $noruju->no_rujukan,
            "noKartu" => $nopasien->no_bpjs,
            "keluhan" => "keluhan",
            "kdSadar" => $pasien->gcs_nilai->kode ?? "1",
            "sistole" => $sistole,
            "diastole" => $diastole,
            "beratBadan" => $pasien->berat_badan,
            "tinggiBadan" => $pasien->tinggi_badan,
            "respRate" => $pasien->rr,
            "heartRate" => $pasien->nadi,
            "lingkarPerut" => $pasien->lingkar_perut,
            "kdStatusPulang" => "4",
            "tglPulang" => now()->format('d-m-Y'),
            "kdDokter" => $noruju->doctor->kode_dokter ?? "0",
            "kdDiag1" => $diagnosas[0],
            "kdDiag2" => $diagnosas[1],
            "kdDiag3" => $diagnosas[2],
            "kdPoliRujukInternal" => null,
            "kdTacc" => $request->kdTacc,
            "alasanTacc" => $request->alasanTacc,
            "anamnesa" => $subyektif,
            "alergiMakan" => "00",
            "alergiUdara" => "00",
            "alergiObat" => "00",
            "kdPrognosa" => null,
            "terapiObat" => "test terapi obat",
            "terapiNonObat" => null,
            "bmhp" => null,
            "suhu" => $pasien->suhu,
        ];

        if ($request->status_ljt === "RJRS") {
            $data["rujukLanjut"] = [
                "tglEstRujuk" => $request->tglRujukan,
                "kdppk" => $request->provider,
                "subSpesialis" => [
                    "kdSubSpesialis1" => $request->subspesialis ?: null, // Bisa NULL
                    "kdSarana" => $request->sarana !== "0" ? $request->sarana : null, // Pastikan bisa NULL jika "0"
                ],
                "khusus" => null
            ];
        } elseif ($request->status_ljt === "RJRS_KUHUS") {
            $data["rujukLanjut"] = [
                "tglEstRujuk" => $request->tglRujukan,
                "kdppk" => $request->provider,
                "subSpesialis" => null, // Tetap NULL untuk RJRS_KUHUS
                "khusus" => [
                    "kdKhusus" => $request->spesialis ?: null, // Gunakan spesialis untuk kdKhusus
                    "kdSubSpesialis" => $request->subspesialis ?: null, // Bisa NULL jika tidak ada subspesialis
                    "catatan" => $request->input('catatan') ?: null // Bisa kosong/null
                ]
            ];
        } else {
            return response()->json([
                'message' => 'Jenis rujukan tidak valid!',
                'error' => true
            ], 400);
        }


        // Kirim data ke BPJS API melalui BpjsController
        $bpjsService = app(BpjsController::class);
        $response = $bpjsService->edit_rujukan_bpjs($data);

        // Cek apakah BPJS API mengembalikan respons yang valid
        if (!$response) {
            return response()->json([
                'message' => 'Gagal mengirim data ke BPJS!',
                'error' => true,
                'bpjs_response' => $response
            ], 500);
        }


        $tglRujukanFormatted = Carbon::createFromFormat('d-m-Y', $request->tglRujukan)->format('Y-m-d');

        $surat_rujuk = rujuka::create([
            'no_rawat' => $request->nomor_rawat,
            'no_rujuk' => $noruju->no_rujukan,
            'no_reg' => $noruju->no_reg,
            'kd_dokter' => $noruju->doctor->kode_dokter,
            'kd_poli' => $noruju->poli->kode_poli,
            'kd_pj' => $noruju->penjab_id,
            'kode_sub_spesialis' => $request->subspesialis ?: null, // Bisa null jika kosong
            'kode_rumahsakit' => $request->provider,
            'nama_rumahsakit' => $request->providernama,
            'alamat_rumahsakit' => $request->provideralamat,
            'no_telp_rumahsakit' => $request->provideratelepon,
            'tgl_rujuk' => $tglRujukanFormatted,
            'kd_sarana' => $request->sarana !== "0" ? $request->sarana : null, // Bisa NULL jika "0"
            'kd_khusus' => $request->status_ljt === "RJRS_KUHUS" ? $request->spesialis : null, // Hanya jika RJRS_KUHUS
            'catatan' => $request->status_ljt === "RJRS_KUHUS" ? $request->input('catatan') ?: null : null, // Bisa null jika tidak ada catatan
            'kdTacc' => $request->status_ljt === "RJRS_KUHUS" ? "0" : ($request->kdTacc ?: null), // Pastikan RJRS_KUHUS bernilai "0"
        ]);


        return response()->json([
            'message' => 'Data berhasil diproses!',
            'data' => $data,
            // 'bpjs_response' => $response
        ]);
    }

    public function cetakRujukan($encoded_nomor_rawat)
    {
        $nomor_rawat = base64_decode($encoded_nomor_rawat);

        // Query untuk mendapatkan data lengkap dengan JOIN ke tabel rajal, pasien, dan sub_spesialis
        $data = DB::table('rujukas')
    ->join('rajals', 'rajals.no_rawat', '=', 'rujukas.no_rawat')
    ->join('pasiens', 'pasiens.no_rm', '=', 'rajals.no_rm')
    ->leftJoin('subspesialis', 'subspesialis.kode', '=', 'rujukas.kode_sub_spesialis') // Left Join agar bisa NULL
    ->join('diagnosa_pasiens', 'diagnosa_pasiens.no_rawat', '=', 'rujukas.no_rawat')
    ->join('icd10s', 'icd10s.kode', '=', 'diagnosa_pasiens.kode')
    ->join('doctors', 'doctors.kode_dokter', '=', 'rujukas.kd_dokter')
    ->select(
        'rujukas.*',
        'doctors.nama_dokter as nama_dokter',
        'rajals.no_rujukan', 'rajals.no_rm',
        'pasiens.nama as nama_pasiens', 'pasiens.no_bpjs', 'pasiens.tanggal_lahir',
        DB::raw('COALESCE(subspesialis.nama, NULL) as nama_subspesialis'), // Tetap NULL jika tidak ada
        'icd10s.kode as kode_diagnosa', 'icd10s.nama as nama_diagnosa'
    )
    ->where('rujukas.no_rawat', $nomor_rawat)
    ->first();



        // Jika data tidak ditemukan, kembalikan error 404
        if (!$data) {
            return abort(404, "Data tidak ditemukan");
        }

        $setbpjs = set_bpjs::find(1);


        $pdf = FacadePdf::loadView('pdf.surat_rujukan', compact('data','setbpjs'))
        ->setPaper('A4', 'landscape');

        return $pdf->stream("surat_rujukan_$nomor_rawat.pdf");
    }

    // public function rujuk_lanjut(Request $request)
    // {

    //      // Validasi data yang diterima
    //      $request->validate([
    //         'nomor_rawat' => 'required|string',
    //         'status_ljt' => 'required|string',
    //         'kdTacc' => 'required|string',
    //         'nmTacc' => 'required|string',
    //         'alasanTacc' => 'nullable|string',
    //     ]);

    //     $pasien = rajal_pemeriksaan::where('no_rawat', $request->nomor_rawat)->first();
    //     $noruju = rajal::where('no_rawat', $request->nomor_rawat)->first();
    //     $nopasien = pasien::where('no_rm', $noruju->no_rm)->first();
    //     if ($pasien->tensi) {
    //         list($sistole, $diastole) = explode("/", $pasien->tensi);
    //     } else {
    //         $sistole = null;
    //         $diastole = null;
    //     }

    //     $subyektif = is_array($pasien->subyektif) ? implode(" ", $pasien->subyektif) : $pasien->subyektif;

    //      // Ambil semua diagnosa pasien berdasarkan nomor rawat
    //      $diagnosas = diagnosa_pasien::where('no_rawat', $request->nomor_rawat)
    //      ->pluck('kode')
    //      ->toArray();

    //     // Pastikan minimal ada 1 diagnosa, jika tidak ada, return error
    //     if (count($diagnosas) < 1) {
    //         return response()->json([
    //             'message' => 'Minimal harus ada 1 diagnosa!',
    //             'error' => true
    //         ], 400);
    //     }

    //     // Batasi maksimal hanya 3 diagnosa yang dikirim
    //     $diagnosas = array_slice($diagnosas, 0, 3);

    //     // Pastikan selalu ada 3 slot (jika kurang, isi dengan null)
    //     $diagnosas = array_pad($diagnosas, 3, null);


    //     if ($request->status_ljt === "RJRS") {
    //         $data = [
    //             "noKunjungan" => $noruju->no_rujukan,
    //             "noKartu" => $nopasien->no_bpjs,
    //             "keluhan" => "keluhan",
    //             "kdSadar" => $pasien->gcs_nilai->kode,
    //             "sistole" => $sistole,
    //             "diastole" => $diastole,
    //             "beratBadan" => $pasien->berat_badan,
    //             "tinggiBadan" => $pasien->tinggi_badan,
    //             "respRate" => $pasien->rr,
    //             "heartRate" => $pasien->nadi,
    //             "lingkarPerut" => $pasien->lingkar_perut,
    //             "kdStatusPulang" => "4",
    //             "tglPulang" => now()->format('d-m-Y'),
    //             "kdDokter" => $noruju->doctor->kode_dokter,
    //             "kdDiag1" => $diagnosas[0],
    //             "kdDiag2" => $diagnosas[1],
    //             "kdDiag3" => $diagnosas[2],
    //             "kdPoliRujukInternal" => null,
    //             "rujukLanjut" => [
    //                 "tglEstRujuk" => now()->format('d-m-Y'),
    //                 "kdppk" =>  $request->Provider,
    //                 "subSpesialis" =>  [
    //                     "kdSubSpesialis1" => $request->spesialis,
    //                     "kdSarana" => $request->sarana,
    //                 ],
    //                 "khusus" => null
    //             ],
    //             "kdTacc" => $request->kdTacc,
    //             "alasanTacc" => $request->alasanTacc,
    //             "anamnesa" => $subyektif,
    //             "alergiMakan" => "00",
    //             "alergiUdara" => "00",
    //             "alergiObat" => "00",
    //             "kdPrognosa" => null,
    //             "terapiObat" => "test terapi obat",
    //             "terapiNonObat" => null,
    //             "bmhp" => null,
    //             "suhu" => $pasien->suhu,
    //         ];
    //         $bpjsService = app(BpjsController::class);
    //         $respon = $bpjsService->edit_rujukan_bpjs($data);

    //     } elseif ($request->status_ljt === "RJRS_KUHUS") {
    //         $data = [
    //             "noKunjungan" => $noruju,
    //             "noKartu" => $nopasien,
    //             "keluhan" => "keluhan",
    //             "kdSadar" => $pasien->gcs_nilai->kode,
    //             "sistole" => $sistole,
    //             "diastole" => $diastole,
    //             "beratBadan" => $pasien->berat_badan,
    //             "tinggiBadan" => $pasien->tinggi_badan,
    //             "respRate" => $pasien->rr,
    //             "heartRate" => $pasien->nadi,
    //             "lingkarPerut" => $pasien->lingkar_perut,
    //             "kdStatusPulang" => "4",
    //             "tglPulang" => now()->format('d-m-Y'),
    //             "kdDokter" => $noruju->doctor->kode_dokter,
    //             "kdDiag1" => $diagnosas[0],
    //             "kdDiag2" => $diagnosas[1],
    //             "kdDiag3" => $diagnosas[2],
    //             "kdPoliRujukInternal" => null,
    //             "rujukLanjut" => [
    //                 "tglEstRujuk" => now()->format('d-m-Y'),
    //                 "kdppk" => $request->Provider,
    //                 "subSpesialis" => null,
    //                 "khusus" => [
    //                     "kdKhusus" => $request->kuhus_spesialis,
    //                     "kdSubSpesialis" => null,
    //                     "catatan" => $request->input('kuhus_spesialis')
    //                 ]
    //             ],
    //             "kdTacc" => $request->kdTacc,
    //             "alasanTacc" => $request->alasanTacc,
    //             "anamnesa" => $subyektif,
    //             "alergiMakan" => "00",
    //             "alergiUdara" => "00",
    //             "alergiObat" => "00",
    //             "kdPrognosa" => null,
    //             "terapiObat" => "test terapi obat",
    //             "terapiNonObat" => null,
    //             "bmhp" => null,
    //             "suhu" => $pasien->suhu,
    //         ];
    //         $bpjsService = app(BpjsController::class);
    //         $respon = $bpjsService->edit_rujukan_bpjs($data);
    //     }


    //     return response()->json([
    //         'message' => 'Data berhasil diproses!',
    //         'data' => $data,
    //         // 'respon' => $respon ?? null,
    //     ]);

    // }

    public function rajalperawat()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Pemeriksaan Perawat";
        $rajal = Rajal::with(['poli', 'doctor', 'penjab', 'pasien'])
        ->get()
        ->map(function ($item) {
            $item->regis = Rajal::where('no_rm', $item->no_rm)
                ->where('no_reg', $item->no_reg)
                ->exists();

            $item->SOAP = rajal_pemeriksaan::where('no_rm', $item->no_rm)
                ->where('no_reg', $item->no_reg)
                ->exists();


            $item->obat = obat_pasien::where('no_rm', $item->no_rm)
            ->where('no_rawat', $item->no_rawat)
            ->exists();

            $antrean = antiran_get::where('norm', $item->no_rm)
            ->where('kodepoli', $item->poli->kode_poli ?? null)
            ->where('no_reg', $item->no_reg)
            ->first();

            $item->nomor_antrean = $antrean ? $antrean->nomorantrean : null;

            return $item;
        });
        $dokter = doctor::where('aktivasi', 'aktif') // Hanya dokter dengan aktivasi aktif
        ->whereHas('details')
        ->get();

        return view('layanan.rajal_perawat', compact('title','rajal','dokter'));
    }

    public function dataall($ger)
    {
        $rajaldata = rajal::with(['penjab'])->where('no_reg', $ger)->first();

        if (!$rajaldata) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Ambil semua data terkait
        $pemeriksaans = rajal_pemeriksaan::with(['rajal','nilai_eye','nilai_verbal','nilai_motorik','gcs_nilai'])
            ->where('no_rawat', $rajaldata->no_rawat)
            ->get();

        $sementara = rajal_pemeriksaan_perawat::all();

        $obat_pasien = obat_pasien::where('no_rm', $rajaldata->no_rm)->get();

        // Ambil data faktur_kasir berdasarkan no_rm dari rajaldata
        $faktur_kasir = faktur_kasir::where('no_rm', $rajaldata->no_rm)->get();

        // Gabungkan semua data menjadi satu array
        $data = [
            'rajal' => $rajaldata,
            'pemeriksaans' => $pemeriksaans,
            'pemeriksaan_perawat' => $sementara,
            'obat_pasien' => $obat_pasien,
            'faktur_kasir' => $faktur_kasir, // Data tambahan
        ];

        // Return response JSON atau digunakan dalam tampilan Blade
        return response()->json($data);

    }
    public function rme($ger)
    {
        $no_rawat = base64_decode($ger);
        $setweb = setweb::first();
        $title = $setweb->name_app . " - " . "SOAP DOKTER";
        $icd10 = icd10::all();
        $icd9 = icd9::all();
        $rajaldata = rajal::with(['penjab'])->where('no_rawat', $no_rawat)->first();
        $prosedur = prosedur_pasien::with(['icd9'])->where('no_rawat', $rajaldata->no_rawat)->get();
        $diagnosas = diagnosa_pasien::with(['icd10'])->where('no_rawat', $rajaldata->no_rawat)->get();
        $rwy_keluarga = rwy_penyakit_keluarga::where('no_rawat', $rajaldata->no_rawat)->get();
        $pemeriksaans = rajal_pemeriksaan::with(['rajal','nilai_eye','nilai_verbal','nilai_motorik','gcs_nilai'])->where('no_rawat',$rajaldata->no_rawat)->get();
        $eye = eye::all();
        $verbal = verbal::all();
        $motorik = motorik::all();
        $profile = Pasien::with(['user'])->where('no_rm', $rajaldata->no_rm)->first();
        $nilai = gcs_nilai::select('nama', 'skor')->get();
        $sementara = rajal_pemeriksaan_perawat::with('nilai_eye','nilai_verbal','nilai_motorik','gcs_nilai')->where('no_rawat',$rajaldata->no_rawat)->get();
        $groupedNilai = $nilai->groupBy('nama');
        $tgl_lahir = Carbon::createFromFormat('Y-m-d', $rajaldata->tgl_lahir);
        $diff = $tgl_lahir->diff(Carbon::now());
        $umurTahun = $diff->y;
        $umurBulan = $diff->m;
        $umur = $umurTahun > 0 ? $umurTahun . ' Tahun ' . $umurBulan . ' Bulan' : $umurBulan . ' Bulan';
        $umurHidden = $umurTahun . ' Tahun ' . $umurBulan . ' Bulan';



        if (!$rajaldata) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        // Inisialisasi timeline dengan data registrasi pasien sebagai event pertama
        $timeline_data = collect([
            [
                'type' => 'Registrasi Pasien',
                'icon' => 'fas fa-hospital-user',
                'title' => 'Pasien Registrasi ke Rawat Jalan',
                'content' => "Pasien dengan No. Rawat: {$rajaldata->no_rawat} telah terdaftar di Rawat Jalan.",
                'created_at' => $rajaldata->created_at,
            ]
        ]);


        $obat_pasien = obat_pasien::where('no_rawat', $rajaldata->no_rawat)->get();
        $layanan = rajal_layanan::with(['rajal','doctor','perawat'])->where('no_rawat',$rajaldata->no_rawat)->get();
        $faktur_kasir = faktur_kasir::where('no_rm', $rajaldata->no_rm)->get();

        // **Tambahkan Pemeriksaan Perawat ke Timeline**
        foreach ($sementara as $item) {
            $content = "<strong>Detail Pemeriksaan Perawat:</strong><br>";
            $content .= "<ul class='pemeriksaan-list'>";
            $content .= "<li><b>Tensi:</b> {$item->tensi}</li>";
            $content .= "<li><b>Suhu:</b> {$item->suhu}°C</li>";
            $content .= "<li><b>Nadi:</b> {$item->nadi} bpm</li>";
            $content .= "<li><b>RR:</b> {$item->rr}</li>";
            $content .= "<li><b>Tinggi Badan:</b> {$item->tinggi_badan} cm</li>";
            $content .= "<li><b>Berat Badan:</b> {$item->berat_badan} kg</li>";
            $content .= "<li><b>SpO2:</b> {$item->spo2}%</li>";
            $content .= "<li><b>Lingkar Perut:</b> {$item->lingkar_perut} cm</li>";
            $content .= "<li><b>Alergi:</b> " . ($item->alergi ?: 'Tidak ada') . "</li>";
            $content .= "</ul>";
            // Tambahkan informasi tambahan
            $content .= "<strong>GCS (E, V, M):</strong> {$item->nilai_eye->nama}, {$item->nilai_verbal->nama}, {$item->nilai_motorik->nama}<br>";
            $content .= "<br>";
            $content .= "<strong>Kesadaran:</strong> {$item->gcs_nilai->nama}<br>";
            $content .= "<br>";
            $subyektif = json_decode($item->subyektif, true);
            $content .= "<strong>Subyektif:</strong> " . implode(', ', $subyektif) . "<br>";
            $content .= "<br>";
            $raw_data = $item->headtotoe;

            // Bersihkan tag h4 dan ganti dengan <br><strong>
            $cleaned_data = preg_replace('/<h4[^>]*>/', '<br><strong>', $raw_data);
            $cleaned_data = preg_replace('/<\/h4>/', '</strong>', $cleaned_data);

            // Bersihkan tag h5 dan ganti dengan <br>-
            $cleaned_data = preg_replace('/<h5[^>]*>/', '<br>- ', $cleaned_data);
            $cleaned_data = preg_replace('/<\/h5>/', '', $cleaned_data);

            // Hapus semua atribut style untuk menghindari konflik
            $cleaned_data = preg_replace('/style="[^"]*"/', '', $cleaned_data);

            // Pastikan gambar tetap ada
            $cleaned_data = preg_replace('/<img/', '<br><img', $cleaned_data);

            $content .= "<strong>Head To Toe:</strong><br>" . nl2br($cleaned_data);


            // Masukkan ke dalam timeline
            $timeline_data->push([
                'type' => 'Pemeriksaan Perawat',
                'icon' => 'fas fa-user-nurse',
                'title' => 'Pemeriksaan Perawat',
                'content' => $content,
                'created_at' => Carbon::parse($item->created_at),
            ]);
        }

        // **Tambahkan Tindakan ke Timeline**
        foreach ($layanan as $item) {
            $content = "<strong>Detail Tindakan:</strong><br>";
            $content .= "<ul class='tindakan-list'>";
            $content .= "<li><b>Nama Tindakan:</b> {$item->jenis_tindakan}</li>";
            $content .= "<li><b>Dokter:</b> " . ($item->doctor->nama_dokter ?? 'Tidak ada') . "</li>";
            $content .= "<li><b>Perawat:</b> " . ($item->perawat->nama ?? 'Tidak ada') . "</li>";
            $content .= "</ul>";

            // Tambahkan ke timeline
            $timeline_data->push([
                'type' => 'Tindakan',
                'icon' => 'fas fa-stethoscope',
                'title' => 'Tindakan Pasien',
                'content' => $content,
                'created_at' => \Carbon\Carbon::parse($item->created_at),
            ]);
        }


        // Tambahkan setiap kategori data ke dalam timeline
        foreach ($pemeriksaans as $item) {
            $content = "<strong>Detail Pemeriksaan:</strong><br>";
            $content .= "<ul class='pemeriksaan-list'>";
            $content .= "<li><b>Tensi:</b> {$item->tensi}</li>";
            $content .= "<li><b>Suhu:</b> {$item->suhu}°C</li>";
            $content .= "<li><b>Nadi:</b> {$item->nadi} bpm</li>";
            $content .= "<li><b>RR:</b> {$item->rr}</li>";
            $content .= "<li><b>Tinggi Badan:</b> {$item->tinggi_badan} cm</li>";
            $content .= "<li><b>Berat Badan:</b> {$item->berat_badan} kg</li>";
            $content .= "<li><b>SpO2:</b> {$item->spo2}%</li>";
            $content .= "<li><b>Lingkar Perut:</b> {$item->lingkar_perut} cm</li>";
            $content .= "<li><b>Alergi:</b> " . ($item->alergi ?: 'Tidak ada') . "</li>";
            $content .= "</ul>";

            $content .= "<br>";

            // Tambahkan informasi tambahan
            $content .= "<strong>GCS (E, V, M):</strong> {$item->nilai_eye->nama}, {$item->nilai_verbal->nama}, {$item->nilai_motorik->nama}<br>";
            $content .= "<br>";
            $content .= "<strong>Kesadaran:</strong> {$item->gcs_nilai->nama}<br>";

            $content .= "<br>";
            // Subyektif dan Obyektif
            $subyektif = json_decode($item->subyektif, true);
            $content .= "<strong>Subyektif:</strong> " . implode(', ', $subyektif) . "<br>";
            $content .= "<br>";

            $raw_data = $item->htt_pemeriksaan;
            // Bersihkan tag h4 dan ganti dengan <br><strong>
            $cleaned_data = preg_replace('/<h4[^>]*>/', '<br><strong>', $raw_data);
            $cleaned_data = preg_replace('/<\/h4>/', '</strong>', $cleaned_data);

            // Bersihkan tag h5 dan ganti dengan <br>-
            $cleaned_data = preg_replace('/<h5[^>]*>/', '<br>- ', $cleaned_data);
            $cleaned_data = preg_replace('/<\/h5>/', '', $cleaned_data);

            // Hapus semua atribut style untuk menghindari konflik
            $cleaned_data = preg_replace('/style="[^"]*"/', '', $cleaned_data);

            // Pastikan gambar tetap ada
            $cleaned_data = preg_replace('/<img/', '<br><img', $cleaned_data);

            $content .= "<strong>Head To Toe:</strong><br>" . nl2br($cleaned_data);
            // Cerita Dokter, Assessment, Plan, Instruksi, Evaluasi
            $content .= "<strong>Cerita Dokter:</strong> {$item->cerita_dokter}<br>";
            $content .= "<strong>Assessment:</strong> {$item->assessmen}<br>";
            $content .= "<strong>Plan:</strong> {$item->plan}<br>";
            $content .= "<strong>Instruksi:</strong> {$item->instruksi}<br>";
            $content .= "<strong>Evaluasi:</strong> {$item->evaluasi}<br>";

            // Masukkan ke dalam timeline
            $timeline_data->push([
                'type' => 'Pemeriksaan Dokter',
                'icon' => 'fas fa-user-md',
                'title' => 'Pemeriksaan Dokter',
                'content' => $content,
                'created_at' => Carbon::parse($item->created_at),
            ]);
        }


        // Mengelompokkan resep dan obat terkait dalam satu entry timeline
        $grouped_obat = [];
        foreach ($obat_pasien as $item) {
            if ($item->header) {
                // Jika ada "header", maka ini adalah awal resep baru
                $grouped_obat[$item->created_at->format('Y-m-d H:i:s')] = [
                    'type' => 'Resep Dokter',
                    'icon' => 'fas fa-prescription-bottle-alt',
                    'title' => 'Resep Obat',
                    'content' => "<strong>{$item->header}</strong><br>",
                    'created_at' => Carbon::parse($item->created_at),
                    'obat' => [],
                ];
            } elseif ($item->nama_obat) {
                // Jika ada nama obat, masukkan ke resep terakhir
                $last_key = array_key_last($grouped_obat);
                if ($last_key) {
                    $grouped_obat[$last_key]['obat'][] = "{$item->nama_obat} - {$item->dosis} {$item->dosis_satuan} ({$item->signa_s} x {$item->signa_x} {$item->signa_besaran}, {$item->signa_keterangan})";
                } else {
                    // Jika tidak ada header, buat entri sendiri
                    $grouped_obat[$item->created_at->format('Y-m-d H:i:s')] = [
                        'type' => 'Pemberian Obat',
                        'icon' => 'fas fa-pills',
                        'title' => 'Pemberian Obat',
                        'content' => "{$item->nama_obat} - {$item->dosis} {$item->dosis_satuan} ({$item->signa_s} x {$item->signa_x} {$item->signa_besaran}, {$item->signa_keterangan})",
                        'created_at' => Carbon::parse($item->created_at),
                    ];
                }
            }
        }

        // Format ulang tampilan resep dan obat
        foreach ($grouped_obat as $obat) {
            if (!empty($obat['obat'])) {
                $obat['content'] .= "<ul class='obat-list'>";
                foreach ($obat['obat'] as $detail) {
                    $obat['content'] .= "<li>{$detail}</li>";
                }
                $obat['content'] .= "</ul>";
            }
            $timeline_data->push($obat);
        }



        if ($faktur_kasir->isNotEmpty()) {
            foreach ($faktur_kasir as $item) {
                // Timeline untuk faktur dibuat
                $timeline_data->push([
                    'type' => 'Faktur Kasir',
                    'icon' => 'fas fa-receipt',
                    'title' => 'Pembayaran Pasien',
                    'content' => "No. Faktur: {$item->kode_faktur}, Total: Rp " . number_format($item->tagihan, 0, ',', '.'),
                    'created_at' => Carbon::parse($item->created_at),
                ]);

                // Timeline untuk status lunas
                $timeline_data->push([
                    'type' => 'Status Pembayaran',
                    'icon' => 'fas fa-check-circle',
                    'title' => 'Pembayaran Lunas',
                    'content' => "<strong>✅ Pembayaran Telah Lunas</strong><br>No. Faktur: {$item->kode_faktur}",
                    'created_at' => Carbon::parse($item->created_at)->addMinutes(10), // Simulasi timeline lunas setelah faktur dibuat
                ]);
            }
        } else {
            // Jika tidak ada data faktur, berarti belum membayar
            $timeline_data->push([
                'type' => 'Faktur Kasir',
                'icon' => 'fas fa-exclamation-circle',
                'title' => 'Pembayaran Pasien',
                'content' => "<strong>❌ Belum Membayar</strong><br>Silakan lakukan pembayaran.",
                'created_at' => now(), // Tampilkan waktu saat ini sebagai indikasi status
            ]);
        }

        // Urutkan berdasarkan created_at (terbaru ke terlama)
        $timeline_data = $timeline_data->sortBy('created_at')->values();


        return view('regis.rme',['timeline_data' => $timeline_data], compact('title','layanan','obat_pasien','rajaldata','umur','umurHidden','icd10','icd9','prosedur','diagnosas','pemeriksaans','rwy_keluarga','eye','verbal','motorik','nilai','profile','sementara'));
    }

    public function soap($norm)
    {
        $no_rawat = base64_decode($norm);
        $setweb = setweb::first();
        $title = $setweb->name_app . " - " . "SOAP DOKTER";
        $icd10 = icd10::all();
        $icd9 = icd9::all();
        $rajaldata = rajal::with(['penjab'])->where('no_rawat', $no_rawat)->first();
        $prosedur = prosedur_pasien::with(['icd9'])->where('no_rawat', $rajaldata->no_rawat)->get();
        $diagnosas = diagnosa_pasien::with(['icd10'])->where('no_rawat', $rajaldata->no_rawat)->get();
        $rwy_keluarga = rwy_penyakit_keluarga::where('no_rawat', $rajaldata->no_rawat)->get();
        $pemeriksaans = rajal_pemeriksaan::with(['rajal','nilai_eye','nilai_verbal','nilai_motorik','gcs_nilai'])->where('no_rawat',$rajaldata->no_rawat)->get();
        $eye = eye::all();
        $verbal = verbal::all();
        $motorik = motorik::all();
        $profile = Pasien::with(['user'])->where('no_rm', $rajaldata->no_rm)->first();
        $nilai = gcs_nilai::select('nama', 'skor')->get();
        $sementara = rajal_pemeriksaan_perawat::all();
        $groupedNilai = $nilai->groupBy('nama');
        $tgl_lahir = Carbon::createFromFormat('Y-m-d', $rajaldata->tgl_lahir);
        $diff = $tgl_lahir->diff(Carbon::now());
        $umurTahun = $diff->y;
        $umurBulan = $diff->m;
        $umur = $umurTahun > 0 ? $umurTahun . ' Tahun ' . $umurBulan . ' Bulan' : $umurBulan . ' Bulan';
        $umurHidden = $umurTahun . ' Tahun ' . $umurBulan . ' Bulan';

        return view('regis.soap', compact('title','rajaldata','umur','umurHidden','icd10','icd9','prosedur','diagnosas','pemeriksaans','rwy_keluarga','eye','verbal','motorik','nilai','profile','sementara'));
    }

    public function soapadd(Request $request)
    {
        $data_pribadi = $request->validate([
            "no_rawat" => 'required',
            "no_rm" => 'required',
            "no_reg"=> 'required',
            "tgl_kunjungan" => 'required',
            "time" => 'required',
            "nama_pasien" => 'required',
            "tgl_lahir" => 'required',
            "umur" => 'required',
        ]);

        $validatedData = $request->validate([
            'tableData' => 'required|string',
        ]);

        $data_obj = $request->validate([
            "tensi" => 'required',
            "suhu" => 'required',
            "nadi" => 'required',
            "rr" => 'required',
            "tinggi" => 'required',
            "berat" => 'required',
            "spo2" => 'required',
            "eye" => 'required',
            "verbal" => 'required',
            "motorik" => 'required',
            "sadar" => 'required',
            "alergi" => 'required',
            "lingkar_perut" => 'required',
            "nilai_bmi" => 'nullable',
            "status_bmi" => 'nullable',
            "summernote" => 'nullable',
            "cerita_dokter" => 'required',
        ]);

        $data_ass = $request->validate([
            "assessmen" => 'required',
        ]);

        $data_plan = $request->validate([
            "plan" => 'required',
            "instruksi" => 'required',
            "evaluasi" => 'required',
        ]);

        $tableDataArray = json_decode($validatedData['tableData'], true);


        if (is_array($tableDataArray)) {
            $subyektifArray = [];

            foreach ($tableDataArray as $item) {
                if (is_array($item) && isset($item['penyakit'], $item['durasi'], $item['waktu'])) {
                    $subyektifArray[] = $item['penyakit'] . " sejak " . $item['durasi'] . " " . $item['waktu'];
                }
            }

            $soapdata = rajal_pemeriksaan::create([
                'no_rawat' => $data_pribadi['no_rawat'],
                'no_rm' => $data_pribadi['no_rm'],
                'no_reg' => $data_pribadi['no_reg'],
                'subyektif' => json_encode($subyektifArray),
                'tgl_kunjungan' => $data_pribadi['tgl_kunjungan'],
                'time' => $data_pribadi['time'],
                'nama_pasien' => $data_pribadi['nama_pasien'],
                'tgl_lahir' => $data_pribadi['tgl_lahir'],
                'umur_pasien' => $data_pribadi['umur'],
                'tensi' => $data_obj['tensi'],
                'suhu' => $data_obj['suhu'],
                'nadi' => $data_obj['nadi'],
                'rr' => $data_obj['rr'],
                'tinggi_badan' => $data_obj['tinggi'],
                'berat_badan' => $data_obj['berat'],
                'spo2' => $data_obj['spo2'],
                'eye' => $data_obj['eye'],
                'verbal' => $data_obj['verbal'],
                'motorik' => $data_obj['motorik'],
                'sadar' => $data_obj['sadar'],
                'alergi' => $data_obj['alergi'],
                'lingkar_perut' => $data_obj['lingkar_perut'],
                'nilai_bmi' => $data_obj['nilai_bmi'],
                'status_bmi' => $data_obj['status_bmi'],
                'htt_pemeriksaan' => $data_obj['summernote'],
                'cerita_dokter' => $data_obj['cerita_dokter'],
                'assessmen' => $data_ass['assessmen'],
                'plan' => $data_plan['plan'],
                'instruksi' => $data_plan['instruksi'],
                'evaluasi' => $data_plan['evaluasi'],
            ]);
        }

        rajal_pemeriksaan_perawat::where('no_rawat', $data_pribadi['no_rawat'])->update(['stts_soap' => 2]);

        $patient = rajal::where('no_rm', $request->no_rm)->first();
        $patient->status = "Sudah Periksa";
        $patient->save();

        $tensi = $data_obj['tensi'];
        list($sistol, $distol) = explode("/", $tensi);

        $pasien = pasien::where('no_rm', $request->no_rm)->first();

        // Ambil semua diagnosa pasien berdasarkan nomor rawat
        $diagnosas = diagnosa_pasien::where('no_rawat', $data_pribadi['no_rawat'])
            ->pluck('kode')
            ->toArray();

        // Pastikan minimal ada 1 diagnosa, jika tidak ada, return error
        if (count($diagnosas) < 1) {
            return response()->json([
                'message' => 'Minimal harus ada 1 diagnosa!',
                'error' => true
            ], 400);
        }

        // Batasi maksimal hanya 3 diagnosa yang dikirim
        $diagnosas = array_slice($diagnosas, 0, 3);

        // Pastikan selalu ada 3 slot (jika kurang, isi dengan null)
        $diagnosas = array_pad($diagnosas, 3, null);


        $wsbpjsdata = [
            "noKunjungan" => null,
            "noKartu" => $pasien->no_bpjs,
            "tglDaftar" => now()->format('d-m-Y'),
            "kdPoli" => $patient->poli->kode_poli,
            "keluhan" => "keluhan",
            "kdSadar" => $soapdata->gcs_nilai->kode,
            "sistole" => $sistol,
            "diastole" => $distol,
            "beratBadan" => $data_obj['berat'],
            "tinggiBadan" => $data_obj['tinggi'],
            "respRate" => $data_obj['rr'],
            "heartRate" => $data_obj['spo2'],
            "lingkarPerut" => $data_obj['lingkar_perut'],
            "kdStatusPulang" => "3",
            "tglPulang" => now()->format('d-m-Y'),
            "kdDokter" => $patient->doctor->kode_dokter,
            "kdDiag1" => $diagnosas[0],
            "kdDiag2" => $diagnosas[1],
            "kdDiag3" => $diagnosas[2],
            "kdPoliRujukInternal" => null,
            "rujukLanjut"=> null,
            "kdTacc"=> -1,
            "alasanTacc"=> null,
            "anamnesa"=> $data_ass['assessmen'],
            "alergiMakan"=> "00",
            "alergiUdara"=> "00",
            "alergiObat"=> "00",
            "kdPrognosa"=> null,
            "terapiObat"=> "terapi obat",
            "terapiNonObat"=> null,
            "bmhp"=> null,
            "suhu"=> $data_obj['suhu'],
        ];
        $bpjsService = app(BpjsController::class);
        $response = $bpjsService->post_kunjungan_bpjs($wsbpjsdata);

        if ($response) {
            $no_kunjungan = $response->response->message;
            $update = Rajal::where('no_rawat', $data_pribadi['no_rawat'])->update([
                'no_rujukan' => $no_kunjungan
            ]);

            if ($update) {
                echo "Data berhasil diperbarui untuk no_rawat: " . $data_pribadi['no_rawat'];
            } else {
                echo "Gagal memperbarui data.";
            }
        } else {
            echo "Gagal mengambil nomor kunjungan BPJS.";
        }

        // if ($response) {
        //     $responseData = json_decode($response->getContent()); // Ubah isi response jadi objek
        //     $no_kunjungan = $responseData->message;

        //     $update = Rajal::where('no_rawat', $data_pribadi['no_rawat'])->update([
        //         'no_rujukan' => $no_kunjungan
        //     ]);

        //     if ($update) {
        //         echo "Data berhasil diperbarui untuk no_rawat: " . $data_pribadi['no_rawat'];
        //     } else {
        //         echo "Gagal memperbarui data.";
        //     }
        // } else {
        //     echo "Gagal mengambil nomor kunjungan BPJS.";
        // }

        return redirect()->route('layanan.rawat-jalan.soap-dokter.index',['norm' => base64_encode($request->no_rawat) ])->with('Success', 'Data Pemeriksaan berhasi di tambahkan');
    }

    public function soapadelete($id)
    {

        $no_rawat = base64_decode($id);
        $pemeriksaan = rajal_pemeriksaan::where('no_rawat', $no_rawat)->firstOrFail();
        $pemeriksaan->delete();
        rajal_pemeriksaan_perawat::where('no_rawat', $pemeriksaan->no_rawat)->update(['stts_soap' => 1]);

        $data = Rajal::where('no_rawat', $pemeriksaan->no_rawat)->first();
        $bpjsService = app(BpjsController::class);
        $norujuk=$data->no_rujukan;
        $bpjsService->delete_rujukan_bpjs($norujuk);
        Rajal::where('no_rawat', $pemeriksaan->no_rawat)->update([
            'no_rujukan' => null
        ]);

        return redirect()->route('layanan.rawat-jalan.soap-dokter.index',['norm' => base64_encode($pemeriksaan->no_rawat) ])->with('Success', 'Data berhasil dihapus.');
    }

    public function resepobat($norm)
    {
        $no_rawat = base64_decode($norm);
        $setweb = setweb::first(); // Pastikan ini sudah benar
        $title = $setweb->name_app . " - " . "obat";
        $rajaldata = rajal::with(['penjab'])->where('no_rawat', $no_rawat)->first();
        $tgl_lahir = Carbon::createFromFormat('Y-d-m', $rajaldata->tgl_lahir);
        $umur = $tgl_lahir->age;
        $today = Carbon::now()->format('Y-m-d');
        $stok = barang_stok::with(['dabar'])->get()->unique('nama_barang');
        $satuan = satuan::with(['dabars'])->get();
        $obat_pasien = obat_pasien::with('obats')->where('no_rawat', $rajaldata->no_rawat)->whereDate('tgl', $today)->get();
        $obat = obat_pasien::with(['obats'])->where('no_rawat', $rajaldata->no_rawat)->first();

        return view('regis.obat', compact('title','rajaldata','umur','tgl_lahir','stok','satuan','obat_pasien','obat'));
    }

    public function resepobatadd(Request $request)
    {
        $data_pribadi = $request->validate([
            "tgl_kunjungan" => 'required',
            "time" => 'required',
            "no_rawat" => 'required',
            "no_rm" => 'required',
            "nama_pasien" => 'required',
            "penjab" => 'required',
        ]);

        $data_sub = $request->validate([
            "header_input" => 'nullable',
            "obat" => 'nullable',
            "obat" => 'nullable',
            "namaObatFinal" => 'nullable',
            "perusahaan" => 'nullable',
            "numero" => 'nullable',
            "satuan_numero" => 'nullable',
            "intruksi" => 'nullable',
            "s" => 'nullable',
            "x" => 'nullable',
            "satuan_signa" => 'nullable',
            "signa" => 'nullable',
        ]);

        $obat = new obat_pasien();
        $obat->no_rm = $data_pribadi['no_rm'];
        $obat->no_rawat = $data_pribadi['no_rawat'];
        $obat->nama_pasien = $data_pribadi['nama_pasien'];
        $obat->tgl = $data_pribadi['tgl_kunjungan'];
        $obat->jam = $data_pribadi['time'];
        $obat->penjab = $data_pribadi['penjab'];
        $obat->header = $data_sub['header_input'] ?? null;
        $obat->kode_obat = $data_sub['obat'] ?? null;
        $obat->nama_obat = $data_sub['namaObatFinal'] ?? null;
        $obat->dosis = $data_sub['numero'] ?? null;
        $obat->dosis_satuan = $data_sub['satuan_numero'] ?? null;
        $obat->instruksi = $data_sub['intruksi'] ?? null;
        $obat->signa_s = $data_sub['s'] ?? null;
        $obat->signa_x = $data_sub['x'] ?? null;
        $obat->signa_besaran = $data_sub['satuan_signa'] ?? null;
        $obat->signa_keterangan = $data_sub['signa'] ?? null;
        $obat->save();

        return response()->json(['success' => true, 'message' => 'Data berhasil disimpan!']);
    }

    public function resepobatdelete(Request $request)
    {
        $id = $request->input('id');
        $obat = obat_pasien::find($id);
        if ($obat) {
            $obat->delete();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Data not found']);
        }
    }

    public function gigi($norm)
    {
        $no_rawat = base64_decode($norm);
        $setweb = setweb::first(); // Pastikan ini sudah benar
        $title = $setweb->name_app . " - " . "Odontogram";
        $rajaldata = rajal::with(['penjab'])->where('no_rawat', $no_rawat)->first();
        $tgl_lahir = Carbon::createFromFormat('Y-m-d', $rajaldata->tgl_lahir);
        $umur = $tgl_lahir->age;
        $today = Carbon::now()->format('Y-m-d');
        $gigiDetails = Odontogram_detail::where('patient_id', $rajaldata->no_rm)
        ->where('rawatt_id', $rajaldata->no_rawat)
        ->first();
        return view('regis.gigi', compact('title','rajaldata','umur','tgl_lahir','gigiDetails'));
    }

    public function gigiadd(Request $request)
    {
        try {
            // Validate the incoming request data
            $request->validate([
                'patient_id' => 'required',
                'treatment_id' => 'required',
                'tooth_number' => 'required|integer',
                'condition' => 'required|string',
                'note' => 'nullable|string',
            ]);

            // Insert the new data into the odontogram table
            odontogram::create([
                'patient_id' => $request->patient_id,
                'rawatt_id' => $request->treatment_id,
                'tooth_number' => $request->tooth_number,
                'condition' => $request->condition,
                'note' => $request->note,
            ]);

            // Return success response
            return response()->json(['success' => true,'message' => 'Data saved successfully.']);
        } catch (\Exception $e) {
            // Log the error message for debugging
            return response()->json(['message' => 'An error occurred while saving data.' .$e->getMessage() ]);
        }
    }

    public function gigiadddetail(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'patient_id' => 'required',
            'rawatt_id' => 'required',
            'Decayed' => 'nullable|string',
            'Missing' => 'nullable|string',
            'Filled' => 'nullable|string',
            'Foto' => 'nullable|integer',
            'Rontgen' => 'nullable|integer',
            'Oclusi' => 'nullable|string',
            'Palatinus' => 'nullable|string',
            'Mandibularis' => 'nullable|string',
            'Platum' => 'nullable|string',
            'Diastema' => 'nullable|string',
            'Anomali' => 'nullable|string',
        ]);

        // Create a new patient form entry
        Odontogram_detail::create($validatedData);

        // Redirect or return a response
        return redirect()->route('layanan.rawat-jalan.soap-dokter.index.odontogram',['norm' => base64_encode($request->rawatt_id) ])->with('success', 'Data saved successfully!');
    }

    public function tindakan($norm)
    {
        $no_rawat = base64_decode($norm);
        $setweb = setweb::first();
        $title = $setweb->name_app . " - " . "Layanan & Tindakan";
        $rajaldata = rajal::where('no_rawat', $no_rawat)->first();
        $doctor = doctor::all();
        $perawat = suberdaya::all();
        $perjal = perjal::all();
        $layanan = rajal_layanan::with(['rajal','doctor','perawat'])->where('no_rawat',$rajaldata->no_rawat)->get();

        return view('regis.layanan', compact('title','rajaldata','doctor','perawat','perjal','layanan'));
    }

    public function tindakanadd(Request $request)
    {
        $data = $request->validate([
            "tgl_kunjungan" => 'required',
            "time" => 'required',
            "no_rawat" => 'required',
            "no_rm" => 'required',
            "nama_pasien" => 'required',
            "jenis_tindakan" => 'required',
            "t_biaya" => 'required',
            "provider" => 'required',
            "dokter" => 'nullable',
            "b_dokter" => 'nullable',
            "perawat" => 'nullable',
            "b_perawat" => 'nullable',
        ]);

        $layanan = new rajal_layanan();
        $layanan->tgl_kunjungan = $data['tgl_kunjungan'];
        $layanan->time = $data['time'];
        $layanan->no_rawat = $data['no_rawat'];
        $layanan->no_rm = $data['no_rm'];
        $layanan->nama_pasien = $data['nama_pasien'];
        $layanan->jenis_tindakan = $data['jenis_tindakan'];
        $layanan->total_biaya = $data['t_biaya'];
        $layanan->provider = $data['provider'];
        $layanan->id_dokter = $data['dokter'] ?? null;
        $layanan->b_dokter = $data['b_dokter'] ?? null;
        $layanan->id_perawat = $data['perawat'] ?? null;
        $layanan->b_perawat = $data['b_perawat'] ?? null;
        $layanan->save();

        return redirect()->route('layanan.rawat-jalan.soap-dokter.index.tindakan',['norm' => base64_encode($layanan->no_rawat) ])->with('Success', 'Data Layanan berhasi di tambahkan');
    }

    public function tindakandelete($id)
    {
        $layanan = rajal_layanan::where('no_rm', $id)->firstOrFail();
        if ($layanan) {
            $layanan->delete(); // Menghapus data
            return redirect()->route('layanan.rawat-jalan.soap-dokter.index.tindakan',['norm' => base64_encode($layanan->no_rawat) ])->with('Success', 'Layanan berhasil dihapus.');
        }
    }


    public function berkasdigital($norm)
    {
        $setweb = setweb::first(); // Pastikan ini sudah benar
        $title = $setweb->name_app . " - " . "Berkas";
        $rajaldata = rajal::where('no_rm', $norm)->first();
        $berkasdigital = Berkasdigital::where('no_rm', $norm)->get();;

        $detailsodo = Odontogram_detail::where('patient_id', $rajaldata->no_rm)
        ->where('rawatt_id', $rajaldata->no_rawat)
        ->first();


        return view('regis.berkas', compact('title','rajaldata','berkasdigital','detailsodo'));
    }

    public function berkasdigitaladd(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'time' => 'required|date_format:H:i',
            'id_rawat' => 'required|string',
            'no_rm' => 'required|string',
            'berkas_kategori' => 'required|string',
            'pilih_berkas' => 'nullable|file',
        ]);

        // Handle file upload if a file was chosen
        if ($request->hasFile('pilih_berkas')) {
            // Get the uploaded file
            $file = $request->file('pilih_berkas');

            $uploadPath = public_path('uploads/berkas_digital');

            $timestamp = date('H-i-s_d-m-Y'); // Format waktu
            $extension = $file->getClientOriginalExtension(); // Mendapatkan jenis file (ekstensi)
            $fileName = $timestamp . '-berkas-digital.' . $extension; // Nama file baru dengan format yang diinginkan

            $file->move($uploadPath, $fileName);

            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $berksadigital = new Berkasdigital();
            $berksadigital->tanggal =  $request->tanggal;
            $berksadigital->jam =  $request->time;
            $berksadigital->id_rawat =  $request->id_rawat;
            $berksadigital->no_rm =  $request->no_rm;
            $berksadigital->kategori =  $request->berkas_kategori;
            $berksadigital->nama =  $fileName;
            $berksadigital->save();
        }

        return redirect()->route('layanan.rawat-jalan.soap-dokter.index.berkas.digital',['norm' => $request->no_rm])->with('success', 'Data has been uploaded successfully!'); // Change 'some.route.name' to the actual route

    }

    public function berkasdigitaladdodontogram(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'tanggals' => 'required|date',
            'times' => 'required|date_format:H:i',
            'id_rawat' => 'required|string',
            'no_rm' => 'required|string',
            'pilih_foto' => 'nullable|array',  // Array for photos
            'pilih_foto.*' => 'file|mimes:jpg,jpeg,png,pdf',  // Validate all files as photos
            'pilih_rontgen' => 'nullable|array',  // Array for rontgen
            'pilih_rontgen.*' => 'file|mimes:jpg,jpeg,png,pdf',  // Validate all files as rontgen
        ]);

        // Handle file upload for photos if files were chosen
        if ($request->hasFile('pilih_foto')) {
            foreach ($request->file('pilih_foto') as $photo) {
                $uploadPath = public_path('uploads/photosodo');
                $timestamp = date('H-i-s_d-m-Y'); // Format waktu
                $extension = $photo->getClientOriginalExtension(); // Mendapatkan jenis file (ekstensi)
                $fileName = $timestamp . '-Odontogram-Foto.' . $extension; // Nama file baru dengan format yang diinginkan
                $photo->move($uploadPath, $fileName);

                $berksadigital = new Berkasdigital();
                $berksadigital->tanggal = $request->tanggals;
                $berksadigital->jam = $request->times;
                $berksadigital->id_rawat = $request->id_rawat;
                $berksadigital->no_rm = $request->no_rm;
                $berksadigital->kategori = "Odontogram Foto";
                $berksadigital->nama = $fileName;  // Store photo file name
                $berksadigital->save();
            }
        }

        // Handle file upload for rontgens if files were chosen
        if ($request->hasFile('pilih_rontgen')) {
            foreach ($request->file('pilih_rontgen') as $rontgen) {
                $uploadPath = public_path('uploads/rontgens');
                $timestamp = date('H-i-s_d-m-Y');
                $extension = $rontgen->getClientOriginalExtension();
                $fileName = $timestamp . '-Odontogram-Ronsen.' . $extension;
                $rontgen->move($uploadPath, $fileName);

                $berksadigital = new Berkasdigital();
                $berksadigital->tanggal = $request->tanggals;
                $berksadigital->jam = $request->times;
                $berksadigital->id_rawat = $request->id_rawat;
                $berksadigital->no_rm = $request->no_rm;
                $berksadigital->kategori = "Odontogram Ronsen";
                $berksadigital->nama = $fileName;  // Simpan nama file
                $berksadigital->save();
            }
        }


        // Redirect after successful upload
        return redirect()->route('layanan.rawat-jalan.soap-dokter.index.berkas.digital', ['norm' => $request->no_rm])
            ->with('success', 'Files have been uploaded successfully!');
    }

    public function berkasdigitaldelete($id ,$no_rm)
    {
        $data = Berkasdigital::where('no_rm', $no_rm)
                     ->where('id', $id)
                     ->firstOrFail();


        // Hapus file fisik jika ada
        $filePath = '';
        if ($data->kategori == 'Odontogram Foto') {
            $filePath = public_path('uploads/photosodo/' . $data->nama);
        } elseif ($data->kategori == 'Odontogram Ronsen') {
            $filePath = public_path('uploads/rontgens/' . $data->nama);
        } else {
            $filePath = public_path('uploads/berkas_digital/' . $data->nama);
        }

        if (file_exists($filePath)) {
            unlink($filePath); // Menghapus file fisik
        }

        // Hapus data dari database
        $data->delete();

        return redirect()->route('layanan.rawat-jalan.soap-dokter.index.berkas.digital',['norm' => $no_rm])->with('success', 'Data has been uploaded successfully!'); // Change 'some.route.name' to the actual route

    }


    public function layanansoap($norm)
    {
        $no_rawat = base64_decode($norm);
        $setweb = setweb::first(); // Pastikan ini sudah benar
        $title = $setweb->name_app . " - " . "soap";
        $rajaldata = rajal::with(['penjab'])->where('no_rawat', $no_rawat)->first();
        $rwy_keluarga = rwy_penyakit_keluarga::where('no_rawat', $rajaldata->no_rawat)->get();
        $pemeriksaans = rajal_pemeriksaan_perawat::with(['rajal'])->where('no_rawat',$rajaldata->no_rawat)->get();
        $eye = eye::all();
        $verbal = verbal::all();
        $motorik = motorik::all();
        $profile = Pasien::with(['user'])->where('no_rm', $rajaldata->no_rm)->first();
        $nilai = gcs_nilai::select('nama', 'skor')->get();
        $groupedNilai = $nilai->groupBy('nama');
        $htt_pemeriksaan = headtotoe_pemeriksaan::with('subPemeriksaan')->get();
        $htt_sub_pemeriksaan = headtotoe_sub_pemeriksaan::all();
        $tgl_lahir = Carbon::createFromFormat('Y-m-d', $rajaldata->tgl_lahir);
        $diff = $tgl_lahir->diff(Carbon::now());
        $umurTahun = $diff->y;
        $umurBulan = $diff->m;
        $umur = $umurTahun > 0 ? $umurTahun . ' Tahun ' . $umurBulan . ' Bulan' : $umurBulan . ' Bulan';
        $umurHidden = $umurTahun . ' Tahun ' . $umurBulan . ' Bulan';


        return view('layanan.soap', compact('title','rajaldata','rwy_keluarga','pemeriksaans','umur','umurHidden','eye','verbal','motorik','nilai','profile','htt_pemeriksaan','htt_sub_pemeriksaan'));
    }

    public function layanansoapadd(Request $request)
    {
        $data_pribadi = $request->validate([
            "no_rawat" => 'required',
            "tgl_kunjungan" => 'required',
            "time" => 'required',
            "nama_pasien" => 'required',
            "tgl_lahir" => 'required',
            "umur" => 'required',
        ]);

        $validatedData = $request->validate([
            'tableData' => 'string',
            'summernote' => 'nullable|string',
        ]);

        $data_obj = $request->validate([
            "tensi" => 'required',
            "suhu" => 'required',
            "nadi" => 'required',
            "rr" => 'required',
            "tinggi" => 'required',
            "berat" => 'required',
            "spo2" => 'required',
            "eye" => 'required',
            "verbal" => 'required',
            "motorik" => 'required',
            "sadar" => 'required',
            "alergi" => 'required',
            "lingkar_perut" => 'required',
            "nilai_bmi" => 'required',
            "status_bmi" => 'required',
        ]);

        // Decode JSON tableData menjadi array PHP
        $tableDataArray = json_decode($validatedData['tableData'], true);

        // Pastikan decoding berhasil dan tableDataArray berupa array
        if (is_array($tableDataArray)) {
            // Menyimpan array subyektif ke dalam database
            $subyektifArray = [];

            foreach ($tableDataArray as $item) {
                // Gabungkan penyakit, durasi, dan waktu dalam satu string
                $subyektifArray[] = $item['penyakit'] . " sejak " . $item['durasi'] . " " . $item['waktu'];
            }

            // Simpan array ke dalam kolom subyektif dan pastikan nilai 'no_rawat' juga disertakan
            rajal_pemeriksaan_perawat::create([
                'no_rawat' => $data_pribadi['no_rawat'],  // Menambahkan no_rawat
                'subyektif' => json_encode($subyektifArray),  // Menyimpan array di kolom subyektif
                'tgl_kunjungan' => $data_pribadi['tgl_kunjungan'],
                'time' => $data_pribadi['time'],
                'nama_pasien' => $data_pribadi['nama_pasien'],
                'tgl_lahir' => $data_pribadi['tgl_lahir'],
                'umur_pasien' => $data_pribadi['umur'],
                'tensi' => $data_obj['tensi'],
                'suhu' => $data_obj['suhu'],
                'nadi' => $data_obj['nadi'],
                'rr' => $data_obj['rr'],
                'tinggi_badan' => $data_obj['tinggi'],
                'berat_badan' => $data_obj['berat'],
                'spo2' => $data_obj['spo2'],
                'eye' => $data_obj['eye'],
                'verbal' => $data_obj['verbal'],
                'motorik' => $data_obj['motorik'],
                'sadar' => $data_obj['sadar'],
                'alergi' => $data_obj['alergi'],
                'lingkar_perut' => $data_obj['lingkar_perut'],
                'nilai_bmi' => $data_obj['nilai_bmi'],
                'status_bmi' => $data_obj['status_bmi'],
                'headtotoe' => $validatedData['summernote'],
                'stts_soap' => '1',
                'user_name' => auth()->user()->name,  // Menggunakan user yang sedang login
                'user_id' => auth()->user()->id,  // Menggunakan user yang sedang login
            ]);
        }

        $patient = rajal::where('no_rm', $request->no_rm)->first();
        $patient->status = "Sudah Periksa Perawat";
        $patient->stts_soap = '1';
        $patient->save();

        return redirect()->route('layanan.rawat-jalan.perawat.index')->with('Success', 'Data Pemeriksaan Sementara berhasi di tambahkan');
    }

    public function kasir()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kasir";
        $today = Carbon::today();
        $today_tindakan = Carbon::today()->format('Ymd'); // Format tahunbulantgl
        $data = faktur_apotek::with('prebayar')->where('stts_bayar', 0)->get();

        // Ambil faktur yang sudah ada hari ini
        $existingFakturNumbers = DB::table('faktur_kasirs')
        ->where('kode_faktur', 'LIKE', "TND-{$today_tindakan}-%")
        ->pluck('kode_faktur');

        // Ambil nomor faktur terakhir hari ini
        if ($existingFakturNumbers->isNotEmpty()) {
            $lastNumber = (int) substr($existingFakturNumbers->last(), -4);
        } else {
            $lastNumber = 0;
        }

        $kodeFakturMapping = [];

        // Ambil tindakan yang tidak ada di faktur_apotek berdasarkan no_rawat
        $data_tindakan_filtered = rajal_layanan::with([
            'rajal', 'rajal.poli', 'rajal.pasien',
            'rajal.pasien.desa', 'rajal.pasien.kecamatan',
            'rajal.pasien.kabupaten', 'rajal.pasien.provinsi'
        ])
        ->whereNotIn('no_rawat', $data->pluck('no_reg'))
        ->select(
            'no_rawat',
            'no_rm',
            'nama_pasien',
            'tgl_kunjungan',
            DB::raw('SUM(total_biaya) as total_penjumlahan'),
            DB::raw('JSON_ARRAYAGG(JSON_OBJECT("nama_tindakan", jenis_tindakan, "harga", total_biaya)) as tindakan_array')
        )
        ->groupBy('no_rawat', 'no_rm', 'nama_pasien', 'tgl_kunjungan')
        ->get()
        ->map(function ($tindakan) use (&$lastNumber, $today_tindakan) {
            // Tambahkan nomor faktur baru untuk setiap tindakan
            $lastNumber++;
            $tindakan->kode_faktur = "TND-{$today_tindakan}-" . str_pad($lastNumber, 4, '0', STR_PAD_LEFT);

             // Simpan hubungan kode_faktur ⇄ no_rawat
            $kodeFakturMapping[$tindakan->kode_faktur] = $tindakan->no_rawat;
            return $tindakan;
        });

        // Simpan $kodeFakturMapping di session agar bisa digunakan di halaman pembayaran
        session(['kodeFakturMapping' => $kodeFakturMapping]);


        return view('layanan.kasir', compact('title','data','data_tindakan_filtered'));

    }

    public function kasirbayar(Request $request, $nofaktur)
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kasir Pembayaran";
        $noRawatURL = $request->query('no_rawat');
        $noFakturLayananMandiri = $nofaktur;

        $data_layanan_mandiri = rajal_layanan::with([
            'rajal', 'rajal.poli', 'rajal.doctor', 'rajal.pasien', 'rajal.penjab',
            'rajal.pasien.desa', 'rajal.pasien.kecamatan',
            'rajal.pasien.kabupaten', 'rajal.pasien.provinsi'])
            ->where('no_rawat', $noRawatURL)->first();

        $data = faktur_apotek::with(['prebayar','penjab','rajal'])->where('kode_faktur', $nofaktur)->first();
        // $dataLayanan = rajal_layanan::where('no_rawat', $data->no_reg)->get();
        // $dataLayanan = rajal_layanan::where('no_rawat', $data_layanan_mandiri->no_rawat ?? $data->no_reg)->get();

        if (!empty($noRawatURL)) {
            $noRawat = $noRawatURL;
        } elseif (!empty($data) && !empty($data->no_reg)) {
            $noRawat = $data->no_reg;
        } else {
            $noRawat = null;
        }

        $dataLayanan = rajal_layanan::where('no_rawat', $noRawat)->get();

        $penjab = penjab::all();
        $poli = poli::all();
        $bank = bank::all();
        $perjal = perjal::all();
        $penjab = penjab::all();
        $doctor = doctor::all();

        // Ambil data layanan berdasarkan no_rawat


        // $tgl_lahir = Carbon::createFromFormat('Y-m-d', $data->rajal->tgl_lahir);
        // $umur = $tgl_lahir->age;

        // Memastikan tgl_lahir memiliki nilai sebelum dihitung
        if (!empty($data->rajal->tgl_lahir)) {
            $tgl_lahir = Carbon::createFromFormat('Y-m-d', $data->rajal->tgl_lahir);
            $umur = $tgl_lahir->age;
        } elseif (!empty($data_layanan_mandiri->rajal->tgl_lahir)) {
            $tgl_lahir = Carbon::createFromFormat('Y-m-d', $data_layanan_mandiri->rajal->tgl_lahir);
            $umur = $tgl_lahir->age;

        } else {
            $umur = null; // Atur nilai default jika tgl_lahir tidak ada
        }


        return view('layanan.kasirbayar', compact('title','data','penjab','umur','poli','bank','perjal','penjab','dataLayanan','doctor','data_layanan_mandiri','noFakturLayananMandiri'));

    }

    public function kasirbayaradd (Request $request)
    {
        $data = $request->validate([
            'data_faktur' => 'required',
            'kode_faktur_inti' => 'required',
            'no_rm' => 'required',
            'nama' => 'required',
            'alamat' => 'nullable',
            'poli' => 'required',
            'dokter' => 'nullable',
            'sex' => 'nullable',
            'usia' => 'nullable',
            'jenis_perawatan' => 'required',
            'jenis_pasien' => 'required',
            'penjamin' => 'nullable',
        ]);

        $data_2 = $request->validate([
            'sub_total' => 'required',
            'potongan' => 'required',
            'total_sementara' => 'required',
            'administrasi' => 'nullable',
            'materai' => 'required',
            'tagihan' => 'required',
            'kurang_dibayar' => 'required',
            'bayar1' => 'required',
            'uangBayar1' => 'required',
            'bankBayar1' => 'nullable',
            'refInput1' => 'nullable',
            'bayar2' => 'nullable',
            'uangBayar2' => 'nullable',
            'bankBayar2' => 'nullable',
            'refInput2' => 'nullable',
            'bayar3' => 'nullable',
            'uangBayar3' => 'nullable',
            'bankBayar3' => 'nullable',
            'refInput3' => 'nullable',
        ]);

        $data_2['administrasi'] = $data_2['administrasi'] ?? '0';

        // Mengurai data_faktur yang berupa string JSON
        $data_faktur = json_decode($data['data_faktur'], true);  // mengubah JSON menjadi array

        faktur_kasir::create([
            'kode_faktur' => $data['kode_faktur_inti'],
            'no_rm' => $data['no_rm'],
            'nama' => $data['nama'],
            'rawat' => $data['jenis_perawatan'],
            'jenis_px' => $data['jenis_pasien'],
            'penjamin' => $data['penjamin'] ?? null,
            'sub_total' => $data_2['sub_total'],
            'potongan' => $data_2['potongan'] ,
            'total_sementara' => $data_2['total_sementara'],
            'administrasi' => $data_2['administrasi'],
            'materai' => $data_2['materai'],
            'tagihan' => $data_2['tagihan'],
            'kembalian' => $data_2['kurang_dibayar'],
            'bayar_1' => $data_2['bayar1'],
            'uang_bayar_1' => $data_2['uangBayar1'],
            'bank_bayar_1' => $data_2['bankBayar1'] ?? null,
            'ref_bayar_1' => $data_2['refInput1'] ?? null,
            'bayar_2' => $data_2['bayar2'] ?? null,
            'uang_bayar_2' => $data_2['uangBayar2'] ?? null,
            'bank_bayar_2' => $data_2['bankBayar2'] ?? null,
            'ref_bayar_2' => $data_2['refInput2'] ?? null,
            'bayar_3' => $data_2['bayar3'] ?? null,
            'uang_bayar_3' => $data_2['uangBayar3'] ?? null,
            'bank_bayar_3' => $data_2['bankBayar3'] ?? null,
            'ref_bayar_3' => $data_2['refInput3'] ?? null,
            'user_name' => auth()->user()->name,  // Menggunakan user yang sedang login
            'user_id' => auth()->user()->id,  // Menggunakan user yang sedang login
        ]);

        // Menyimpan data_faktur ke dalam database faktur_kasirs
        foreach ($data_faktur as $faktur) {
            faktur_kasir_lunas::create([
                'kode_faktur' => $data['kode_faktur_inti'],
                'no_rm' => $data['no_rm'],  // nilai dari request data
                'kode_obat' => $faktur['kode'] ?? null,
                'nama' => $faktur['nama_obat'] ?? $faktur['nama_tambahan'],  // nilai dari request data
                'harga' => $faktur['harga'],  // jika ada jenis_px dalam data_faktur, pakai itu, jika tidak pakai jenis_pasien dari request
                'kuantitas' => $faktur['kuantitas'] ?? null,  // nilai dari request data
                'total_harga' => $faktur['total_harga'],
                'diskon' => $faktur['diskon'] ?? 0,
                'tanggal' => $faktur['tanggal'],
                'user_name' => auth()->user()->name,
                'user_id' => auth()->user()->id,
            ]);
        }

        // Menyimpan data_faktur ke dalam database kasir_tindakan
        foreach ($data_faktur as $faktur_tindakan) {
            // Cek apakah data memiliki semua kunci yang diperlukan
            if (
                !isset($faktur_tindakan['diskon']) || empty($faktur_tindakan['diskon'])
            ) {
                // Periksa apakah data merupakan tindakan (memiliki `nama_tambahan`)
                if (isset($faktur_tindakan['nama_tambahan'])) {
                    faktur_kasir_tindakan::create([
                        'kode_faktur' => $data['kode_faktur_inti'],
                        'no_rm' => $data['no_rm'],
                        'nama' => $faktur_tindakan['nama_tambahan'],
                        'provide' => $faktur_tindakan['provide'],
                        'nama_dokter' => $faktur_tindakan['nama_dokter'],
                        'harga_dokter' => $faktur_tindakan['harga_dokter'],
                        'nama_perawat' => $faktur_tindakan['nama_perawat'],
                        'harga_perawat' => $faktur_tindakan['harga_perawat'],
                        'harga' => $faktur_tindakan['harga'],
                        'qty' => $faktur_tindakan['kuantitas'],
                        'total_harga' => $faktur_tindakan['total_harga'],
                        'tanggal' => $faktur_tindakan['tanggal'],
                        'user_name' => auth()->user()->name,
                        'user_id' => auth()->user()->id,
                    ]);
                }
                // Jika tidak ada `nama_tambahan`, abaikan data
            }
        }


        // Menyimpan data_faktur ke dalam database kasir_apotek
        foreach ($data_faktur as $faktur_apotek) {
            // Cek apakah kode_obat ada dan tidak kosong
            if (!empty($faktur_apotek['kode'])) {
                faktur_kasir_apotek::create([
                    'kode_faktur' => $data['kode_faktur_inti'],
                    'no_rm' => $data['no_rm'],
                    'kode_obat' => $faktur_apotek['kode'],
                    'nama' => $faktur_apotek['nama_obat'],
                    'harga' => $faktur_apotek['harga'],
                    'kuantitas' => $faktur_apotek['kuantitas'],
                    'total_harga' => $faktur_apotek['total_harga'],
                    'diskon' => $faktur_apotek['diskon'],
                    'tanggal' => $faktur_apotek['tanggal'],
                    'jam' => $faktur_apotek['jam'],
                    'user_name' => auth()->user()->name,
                    'user_id' => auth()->user()->id,
                ]);
            }
        }

        // Update menggunakan model
        faktur_apotek::where('kode_faktur', $data['kode_faktur_inti'])->update(['stts_bayar' => 1]);

        $dataBayar1 = $data_2['uangBayar1'] ?? 0;
        $dataBayar2 = $data_2['uangBayar2'] ?? 0;
        $dataBayar3 = $data_2['uangBayar3'] ?? 0;

        $tagihanPDF = $dataBayar1 + $dataBayar2 + $dataBayar3;

        $dataPDF = [
            'no_faktur' => $data['kode_faktur_inti'],
            'no_rm' => $data['no_rm'],
            'nama' => $data['nama'],
            'perawatan' => $data['jenis_perawatan'],
            'tagihan' => $data_2['tagihan'],
            'dibayar' => $tagihanPDF,
            'username' => auth()->user()->name,
            'tanggal' => now()->format('d-m-Y'),
            'data_faktur' => $data_faktur,
        ];

        $pdf = PDF::loadView('pdf.kasirbayar', ['data' => $dataPDF])->setPaper('a5', 'portrait');


        $filename = 'kasir_bayar_' . $data['kode_faktur_inti'] . '.pdf';

        $path = 'temp/' . $filename;
        Storage::put($path, $pdf->output());
        return redirect()->route('keuangan.kasir')->with([
            'Success' => 'Pembayaran Berhasil Dilakukan.',
            'pdf_url' => route('download.pdf', ['filename' => $filename])
        ]);
    }

    public function datatransaksi()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Data Tindakan";
        $today = Carbon::today();
        $data = faktur_kasir::with('details')->get();
        return view('layanan.datatransaksi', compact('title','data'));
    }

    public function filterLunasTransaksi(Request $request)
    {
        $startDate = $request->query('start');
        $endDate = $request->query('end');

        // Pastikan tanggal tidak kosong
        if (!$startDate || !$endDate) {
            return response()->json(["error" => "Tanggal awal dan akhir wajib diisi"], 400);
        }

        // Ambil data Faktur dalam rentang tanggal
        $data = faktur_kasir::whereBetween('created_at', [$startDate, $endDate])
        ->with('details', 'details_apotek') // Pastikan model Faktur memiliki relasi details()
        ->get()
        ->map(function ($item, $index) {
            return [
                "index" => $index + 1,
                "no_rm" => $item->no_rm,
                "nama" => $item->nama,
                "alamat" => optional($item->details_apotek)->alamat ?? 'Beli Bebas',
                "nama_poli" => optional($item->details_apotek)->nama_poli ?? '-',
                "total" => $item->details->sum('total_harga'),
                "created_at" => $item->created_at->format('d-m-Y'),
                "kode_faktur" => $item->kode_faktur,
                "details" => $item->details,
            ];
        });

        return response()->json(["data" => $data]);
    }

    public function datakasir()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Data Kasir";
        $today = Carbon::today();
        $data = faktur_kasir::with('details')->get();
        return view('layanan.datakasir', compact('title','data'));
    }

    public function filterLunasKasir(Request $request)
    {
        $query = faktur_kasir::query()->with('details','details_apotek');

        // Filter berdasarkan rentang tanggal
        if ($request->has(['start_date', 'end_date'])) {
            $start = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $end = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        // Filter berdasarkan jenis pasien
        if ($request->has('jenis') && !empty($request->jenis)) {
            $query->where('jenis_px', $request->jenis);
        }

        return response()->json($query->get());
    }

    public function datakasirPdf(Request $request)
    {
        $tableData = $request->input('data');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if (!is_array($tableData) || empty($tableData)) {
            return response()->json([
                'error' => 'Data tidak valid atau kosong.'
            ], 400);
        }

        $dataPDF = [];

        // Inisialisasi total untuk setiap kategori pembayaran
        $totalCash = 0;
        $totalDebit = 0;
        $totalCreditCard = 0;
        $totalCredit = 0;
        $totalTransfer = 0;
        $totalQR = 0;
        $totalIncome = 0;

        foreach ($tableData as $data) {
            $cash = $data[6] ?? 0;
            $debit = $data[7] ?? 0;
            $creditCard = $data[8] ?? 0;
            $credit = $data[9] ?? 0;
            $transfer = $data[10] ?? 0;
            $qr = $data[11] ?? 0;
            $total = $data[13] ?? 0;

            // Menambahkan ke total masing-masing metode pembayaran
            $totalCash += $cash;
            $totalDebit += $debit;
            $totalCreditCard += $creditCard;
            $totalCredit += $credit;
            $totalTransfer += $transfer;
            $totalQR += $qr;
            $totalIncome += $total;

            $dataPDF[] = [
                'no' => $data[0] ?? '-',
                'no_rm' => $data[1] ?? '-',
                'nama' => $data[2] ?? '-',
                'jenis' => $data[3] ?? '-',
                'alamat' => $data[4] ?? '-',
                'no_faktur' => $data[5] ?? '-',
                'cash' => $data[6] ?? '0',
                'debit' => $data[7] ?? '0',
                'credit_card' => $data[8] ?? '0',
                'credit' => $data[9] ?? '0',
                'transfer' => $data[10] ?? '0',
                'qr' => $data[11] ?? '0',
                'kembalian' => $data[12] ?? '0',
                'total' => $data[13] ?? '0',
                'tanggal' => $data[14] ?? now()->format('d-m-Y'),
                'username' => auth()->user()->name,
            ];
        }

        // Generate PDF dengan data yang telah dihitung
        $pdf = PDF::loadView('pdf.lunaskasir', [
            'data' => $dataPDF,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'total_cash' => $totalCash,
            'total_debit' => $totalDebit,
            'total_credit_card' => $totalCreditCard,
            'total_credit' => $totalCredit,
            'total_transfer' => $totalTransfer,
            'total_qr' => $totalQR,
            'total_income' => $totalIncome,
        ])->setPaper('a4', 'portrait');

        // Simpan sementara di storage
        $filename = 'data_lunas_kasir_' . now()->timestamp . '.pdf';
        $path = 'temp/' . $filename;
        Storage::put($path, $pdf->output());

        return response()->json([
            'pdf_url' => route('download.pdf', ['filename' => $filename])
        ]);
    }

    public function dataobat()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Data Obat";
        $today = Carbon::today();
        return view('layanan.dataobat', compact('title'));
    }

    // public function filterLunasObat(Request $request)
    // {
    //     $query = faktur_kasir::query()->with('details','details_apotek.rajal','details_obat','details_tindakan');

    //     // Filter berdasarkan rentang tanggal
    //     if ($request->has(['start_date', 'end_date'])) {
    //         $start = \Carbon\Carbon::parse($request->start_date)->startOfDay();
    //         $end = \Carbon\Carbon::parse($request->end_date)->endOfDay();
    //         $query->whereBetween('created_at', [$start, $end]);
    //     }

    //     // Filter berdasarkan jenis pasien
    //     if ($request->has('jenis') && !empty($request->jenis)) {
    //         $query->where('jenis_px', $request->jenis);
    //     }

    //     return response()->json($query->get());
    // }

    // public function filterLunasObat(Request $request)
    // {
    //     $query = faktur_kasir::query()
    //         ->with([
    //             'details',
    //             'details_apotek.rajal',
    //             'details_obat',
    //             'details_tindakan' => function ($query) {
    //                 // $query->orderBy('created_at', 'asc'); // Pastikan data urut
    //                 $query->whereColumn('kode_faktur', 'faktur_kasir.kode_faktur');
    //             }
    //         ]);

    //     // Filter berdasarkan rentang tanggal
    //     if ($request->has(['start_date', 'end_date'])) {
    //         $start = \Carbon\Carbon::parse($request->start_date)->startOfDay();
    //         $end = \Carbon\Carbon::parse($request->end_date)->endOfDay();
    //         $query->whereBetween('created_at', [$start, $end]);
    //     }

    //     // Filter berdasarkan jenis pasien
    //     if ($request->has('jenis') && !empty($request->jenis)) {
    //         $query->where('jenis_px', $request->jenis);
    //     }

    //     $data = $query->get();

    //     return response()->json($data);
    // }

    public function filterLunasObat(Request $request)
    {
        $query = faktur_kasir::query()
            ->with([
                'details',
                'details_apotek.rajal',
                'details_obat',
                'details_tindakan'
            ])
            ->distinct(); // ✅ Gunakan distinct untuk menghindari duplikasi faktur.

        // Filter berdasarkan rentang tanggal
        if ($request->has(['start_date', 'end_date'])) {
            $start = \Carbon\Carbon::parse($request->start_date)->startOfDay();
            $end = \Carbon\Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$start, $end]);
        }

        // Filter berdasarkan jenis pasien
        if ($request->has('jenis') && !empty($request->jenis)) {
            $query->where('jenis_px', $request->jenis);
        }

        $data = $query->get();

        return response()->json($data);
    }


    public function datadetailPdf(Request $request)
    {
        $data = $request->input('data');
        $dataTumbal = $request->input('data');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $username = auth()->user()->name;

        if (empty($data)) {
            return response()->json(['error' => 'Tidak ada data untuk dicetak'], 400);
        }

        $totalIncome = 0;

        foreach ($dataTumbal as $set) {
            $total = $set[12] ?? 0;
            $totalIncome += $total;
        }

        // Generate PDF
        $pdf = Pdf::loadView('pdf.lunasdetail', compact('data', 'startDate', 'endDate', 'totalIncome', 'username'))->setPaper('a4', 'landscape');

        // Simpan sementara di storage
        $filename = 'data_lunas_detail_' . now()->timestamp . '.pdf';
        $path = 'temp/' . $filename;
        Storage::put($path, $pdf->output());

        return response()->json([
            'pdf_url' => route('download.pdf', ['filename' => $filename])
        ]);
    }
}
