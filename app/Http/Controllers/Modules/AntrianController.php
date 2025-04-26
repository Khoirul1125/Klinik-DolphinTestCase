<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\BpjsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\antiran_get;
use App\Models\setweb;
use App\Models\antrian;
use App\Models\antrian_logs;
use App\Models\doctor;
use App\Models\history_quota;
use App\Models\licenses;
use App\Models\pasien;
use Illuminate\Support\Facades\DB;
use App\Models\poli;
use App\Models\rajal;
use App\Models\schedule_dokter;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log; // Add logging

class AntrianController extends Controller
{

    public function index()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "antrian";

        $queues = antiran_get::with(['poli', 'loket'])
        ->where('sta_antian', 3)
        ->whereIn('id', function ($query) {
            $query->selectRaw('MIN(ap2.id)')
                ->from('antiran_gets as ap2')
                ->join('antrians as l2', 'ap2.kodepoli', '=', 'l2.poli_id')
                ->where('ap2.sta_antian', 3)
                ->groupBy('l2.nama'); // Mengelompokkan berdasarkan nama loket
        })
        ->orderBy('nomorantrean', 'ASC')
        ->get();



        // di panggil
        $queues1 = antiran_get::with(['poli', 'loket'])
            ->where('sta_antian', 2)  // Antrian yang sedang dilayani
            ->orderBy('nomorantrean', 'ASC')  // Urutkan berdasarkan nomor antrian
            ->get();

            // Ambil loket yang pertama dipanggil (loket yang paling awal)
        $currentQueue = $queues1->first();  // Ambil antrian pertama

        // dd($queues);
        return view('antrian.welcome', compact('title','queues','currentQueue'));

    }


    public function createtiket()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "antrian";
        $poli = poli::where('jenis_poli', "pengobatan penyakit")->get();
        return view('antrian.tiket', compact('title','poli'));
    }

    public function antrian_bpjs_add(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'nikNokaInput' => 'required|numeric|digits_between:13,16', // Menerima NIK 16 digit atau NOKA 13 digit
            'poliSelect' => 'required|numeric',
            'dokterSelect' => 'required|numeric',
        ]);

        // Cari pasien berdasarkan NIK atau NOKA
        $pasien = null;

        if (strlen($data['nikNokaInput']) === 16) {
            // Cari berdasarkan NIK (16 digit) dan sertakan informasi seks dari tabel seks
            $pasien = Pasien::with('seks')
                ->where('nik', $data['nikNokaInput'])
                ->select('pasiens.*', 'seks.nama as nama_seks') // Ambil kolom tambahan dari tabel seks
                ->leftJoin('seks', 'pasiens.seks', '=', 'seks.id') // Gabungkan tabel seks
                ->first();
        } elseif (strlen($data['nikNokaInput']) === 13) {
            // Cari berdasarkan NOKA (13 digit) dan sertakan informasi seks dari tabel seks
            $pasien = Pasien::with('seks')
                ->where('no_bpjs', $data['nikNokaInput'])
                ->select('pasiens.*', 'seks.nama as nama_seks') // Ambil kolom tambahan dari tabel seks
                ->leftJoin('seks', 'pasiens.seks', '=', 'seks.id') // Gabungkan tabel seks
                ->first();
        }



        // Ambil data poli dan dokter berdasarkan ID
        $poli = Poli::find($data['poliSelect']);
        $dokter = Doctor::find($data['dokterSelect']);

        // Tentukan prefix dari antrean berdasarkan poli_id
        $prefix = 'U'; // Default prefix
        $antrian = Antrian::where('poli_id', $data['poliSelect'])->first();
        if ($antrian && !empty($antrian->nama)) {
            $prefix = strtoupper(substr($antrian->nama, 0, 1)); // Ambil huruf pertama dari nomor antrian
        }

        // Ambil angka antrean terakhir dari tabel antrean_get
        $lastAntrian = DB::table('antiran_gets')
            ->orderBy('angkaantrean', 'desc')
            ->first();

        // Tentukan nomor antrean berikutnya
        $nextNumber = 1; // Default jika belum ada antrean
        if ($lastAntrian) {
            $nextNumber = (int) $lastAntrian->angkaantrean + 1; // Ambil angka terakhir dari kolom angka_antrian
        }

        // Format nomor antrean (contoh: U-001)
        $formattedNumber = sprintf("%s-%03d", $prefix, $nextNumber);

        $hariAngka = now()->dayOfWeekIso ; // dayOfWeek memberikan angka 0 (Minggu) hingga 6 (Sabtu), tambahkan 1 agar Senin jadi 1

        $schedule = schedule_dokter::where('doctor_id', $data['dokterSelect'])
        ->where('hari', $hariAngka) // Cek hari sesuai dengan jam praktek
        ->first();


             // Cek apakah jadwal praktek tersedia
             $jamPraktek = '';
             if ($schedule) {
                 $start = $schedule->start; // Jam mulai
                 $end = $schedule->end; // Jam berakhir
                 $jamPraktek = "{$start}-{$end}";
             }


                         // Ambil no_reg terakhir
            $lastNoReg = Rajal::orderBy('no_reg', 'desc')->value('no_reg');

            // Jika tidak ada no_reg sebelumnya, mulai dari 001
            if ($lastNoReg) {
                // Ambil nomor urut dari no_reg terakhir
                $lastNoRegInt = (int) $lastNoReg;
                $newNoReg = str_pad($lastNoRegInt + 1, 3, '0', STR_PAD_LEFT); // Format menjadi 3 digit
            } else {
                // Jika belum ada data, mulai dengan 001
                $newNoReg = '001';
            }

            // Format no_rawat dengan tanggal dan no_reg
            $date = now()->format('Y/m/d'); // Format tanggal saat ini (misal: 2025/01/08)
            $noRawat = $date . '/' . $newNoReg; // Format no_rawat



        // Siapkan data antrean
        $dataantri = [
            'nomorkartu' => $pasien ? $pasien->no_bpjs : 'Tidak Diketahui', // Diambil dari noka
            'nik' => $pasien ? $pasien->nik : 'Tidak Diketahui',
            'nohp' => $pasien ? $pasien->telepon : 'Tidak Diketahui', // Tambahkan data nomor HP jika ada
            'kodepoli' => $poli ? $poli->kode_poli : null,
            'namapoli' => $poli ? $poli->nama_poli : 'Tidak Diketahui',
            'norm' =>  $pasien ? $pasien->no_rm : 'Tidak Diketahui', // Tambahkan data nomor rekam medis jika ada
            'tanggalperiksa' => now()->format('Y-m-d'),
            'keluhan' => null, // Ganti dengan data aktual jika ada
            'kodedokter' => $dokter ? $dokter->kode_dokter : null,
            'namadokter' => $dokter ? $dokter->nama_dokter : 'Tidak Diketahui',
            'jampraktek' => $jamPraktek, // Tambahkan data jam praktek jika ada
            'nomorantrean' => $formattedNumber,
            'angkaantrean' => sprintf("%03d", $nextNumber),
            'keterangan' => null,
            'infoantrean' => 'offline-bpjs',
            'sta_antian' => 1,
            'no_reg' => $newNoReg,
        ];


        antiran_get::create($dataantri);

        $rad = new rajal();
        $rad->tgl_kunjungan = $dataantri['tanggalperiksa'];
        $rad->time = date('h:i A');
        $rad->doctor_id =  $dokter->id;
        $rad->poli_id =  $poli->id;
        $rad->penjab_id = 1 ;
        $rad->no_reg = $newNoReg;
        $rad->no_rawat = $noRawat;
        $rad->no_rm = $dataantri['norm'];
        $rad->nama_pasien = $pasien->nama;
        $rad->tgl_lahir = $pasien->tanggal_lahir;
        $rad->seks =  $pasien->nama_seks;
        $rad->telepon = $pasien->telepon;
        $rad->status = 'Belum Periksa';
        $rad->status_lanjut = 'Rawat Jalan';
        $rad->stts_soap = 0;
        $rad->save();

        if ($schedule) {
            // Cek apakah sudah ada riwayat kuota sebelumnya
            $lastHistory = history_quota::where('schedule_id', $schedule->id)
                                        ->orderBy('created_at', 'desc')
                                        ->first();

            // Tentukan remaining_quota berdasarkan riwayat terakhir
            $remainingQuota = $lastHistory ? $lastHistory->remaining_quota : $schedule->total_quota;

            // Mencatat riwayat kuota dengan nilai remaining_quota yang sudah berkurang
            history_quota::create([
                'schedule_id' => $schedule->id,
                'action' => 'decrease',
                'amount' => 1,
                'remaining_quota' => $remainingQuota - 1, // Mengurangi kuota dari riwayat sebelumnya
            ]);
        }

        $wsbpjsdata = [
            'nomorkartu' => $pasien->no_bpjs,
            'nik' => $pasien->nik,
            'nohp' => $pasien->telepon,
            'kodepoli' => $poli->kode_poli,
            'namapoli' => $poli->nama_poli,
            'norm' =>  $pasien->no_rm,
            'tanggalperiksa' => now()->format('Y-m-d'),
            'kodedokter' => $dokter->kode_dokter,
            'namadokter' => $dokter->nama_dokter,
            'jampraktek' => $jamPraktek,
            'nomorantrean' => $formattedNumber,
            'angkaantrean' => sprintf("%03d", $nextNumber),
            'keterangan' => "",
        ];
        // Menggunakan app() untuk mendapatkan instance dari BpjsServiceController
        $bpjsService = app(BpjsController::class);

        // Kirim data antrean ke API BPJS
        $bpjsService->get_ws_add_bpjs($wsbpjsdata);

        $wsbpjsdatapedaf = [
            'kdProviderPeserta' => $pasien->kodeprovide,
            'tglDaftar' => now()->format('d-m-Y'),
            'noKartu' => $pasien->no_bpjs,
            'kdPoli' => $poli->kode_poli,
            "keluhan"=> null,
            "kunjSakit"=> true,
            "sistole"=> 0,
            "diastole"=> 0,
            "beratBadan"=> 0,
            "tinggiBadan"=> 0,
            "respRate"=> 0,
            "lingkarPerut"=> 0,
            "heartRate"=> 0,
            "rujukBalik"=> 0,
            "kdTkp"=> "10"
        ];

        $bpjsService->post_pendaftaran_bpjs($wsbpjsdatapedaf);

        $this->sendWhatsAppNotification($formattedNumber, $poli->nama_poli, $dokter->nama_dokter, $pasien ? $pasien->telepon : 'Tidak Diketahui');

        return redirect()->route('antrian.createtiket')->with('success', 'Submenu berhasil ditambahkan');

    }

    private function sendWhatsAppNotification($nomorAntrean, $poli, $dokter, $noHp)
    {
        $license = licenses::latest()->first();
        if (!$license) {
            Log::error('No license key found in the database');
            return;
        }
        $licenseKey = $license->key;
        // Format nomor HP ke format internasional (62 untuk Indonesia)
        $noHpFormatted = '62' . preg_replace('/[^0-9]/', '', substr($noHp, 1));

        // Pesan yang akan dikirim
        $message = "Nomor Antrian: $nomorAntrean\nPoli: $poli\nDokter: $dokter";

        $apiUrl = url('/api/whatsapp/send-message');
        // Kirim permintaan HTTP ke API WhatsApp
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($apiUrl, [
            'licenseKey' => $licenseKey,
            'phoneNumber' => $noHpFormatted,
            'message' => $message
        ]);

        // Tangani respon API
        if ($response->successful()) {
            return response()->json([
                'message' => 'WhatsApp notification sent successfully',
                'response' => $response->json()
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to send WhatsApp notification',
                'error' => $response->json()
            ], $response->status());
        }

    }


    public function antrian_no_bpjs_add(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'nikInputno' => 'required|numeric|digits:16', // Hanya menerima NIK (16 digit)
            'poliSelectNonBpjs' => 'required|numeric',
            'dokterSelectNonBpjs' => 'required|numeric',
        ]);

        // Cari pasien berdasarkan NIK
        // Ambil data pasien berdasarkan NIK dan ID seks terkait
        $pasien = DB::table('pasiens')
        ->leftJoin('seks', 'pasiens.seks', '=', 'seks.id') // Gabungkan tabel pasien dan seks
        ->where('pasiens.nik', $data['nikInputno'])         // Sesuaikan dengan NIK pasien
        ->select('pasiens.*', 'seks.nama as nama_seks')     // Pilih kolom dari tabel pasien dan nama dari tabel seks
        ->first(); // Ambil data pertama



        // Ambil data poli dan dokter berdasarkan ID
        $poli = Poli::find($data['poliSelectNonBpjs']);
        $dokter = Doctor::find($data['dokterSelectNonBpjs']);

        // Tentukan prefix dari antrean berdasarkan poli_id
        $prefix = 'U'; // Default prefix
        $antrian = Antrian::where('poli_id', $data['poliSelectNonBpjs'])->first();
        if ($antrian && !empty($antrian->nama)) {
            $prefix = strtoupper(substr($antrian->nama, 0, 1)); // Ambil huruf pertama dari nomor antrian
        }

        // Ambil angka antrean terakhir dari tabel antrean_get
        $lastAntrian = DB::table('antiran_gets')
        ->orderBy('angkaantrean', 'desc')
        ->first();

        // Tentukan nomor antrean berikutnya
        $nextNumber = 1; // Default jika belum ada antrean
        if ($lastAntrian) {
            $nextNumber = (int) $lastAntrian->angkaantrean + 1; // Ambil angka terakhir dari kolom angka_antrian
        }

        // Format nomor antrean (contoh: U-001)
        $formattedNumber = sprintf("%s-%03d", $prefix, $nextNumber);



        $hariAngka = now()->dayOfWeek ; // dayOfWeek memberikan angka 0 (Minggu) hingga 6 (Sabtu), tambahkan 1 agar Senin jadi 1

        // Jika hari 0 (Minggu), set menjadi 7
        if ($hariAngka == 8) {
            $hariAngka = 7;
        }
        $schedule = schedule_dokter::where('doctor_id', $data['dokterSelectNonBpjs'])
        ->where('hari', $hariAngka) // Cek hari sesuai dengan jam praktek
        ->first();


             // Cek apakah jadwal praktek tersedia
             $jamPraktek = '';
             if ($schedule) {
                 $start = $schedule->start; // Jam mulai
                 $end = $schedule->end; // Jam berakhir
                 $jamPraktek = "{$start} - {$end}";
             } else {
                 $jamPraktek = 'Tidak Diketahui'; // Jika tidak ada jadwal
             }


                // Ambil no_reg terakhir
            $lastNoReg = Rajal::orderBy('no_reg', 'desc')->value('no_reg');

            // Jika tidak ada no_reg sebelumnya, mulai dari 001
            if ($lastNoReg) {
                // Ambil nomor urut dari no_reg terakhir
                $lastNoRegInt = (int) $lastNoReg;
                $newNoReg = str_pad($lastNoRegInt + 1, 3, '0', STR_PAD_LEFT); // Format menjadi 3 digit
            } else {
                // Jika belum ada data, mulai dengan 001
                $newNoReg = '001';
            }

            // Format no_rawat dengan tanggal dan no_reg
            $date = now()->format('Y/m/d'); // Format tanggal saat ini (misal: 2025/01/08)
            $noRawat = $date . '/' . $newNoReg; // Format no_rawat


         // Siapkan data antrean
         $dataantri = [
            'nomorkartu' => $pasien ? $pasien->no_bpjs : 'Tidak Diketahui', // Diambil dari noka
            'nik' => $pasien ? $pasien->nik : 'Tidak Diketahui',
            'nohp' => $pasien ? $pasien->telepon : 'Tidak Diketahui', // Tambahkan data nomor HP jika ada
            'kodepoli' => $poli ? $poli->kode_poli : null,
            'namapoli' => $poli ? $poli->nama_poli : 'Tidak Diketahui',
            'norm' =>  $pasien ? $pasien->no_rm : 'Tidak Diketahui', // Tambahkan data nomor rekam medis jika ada
            'tanggalperiksa' => now()->format('Y-m-d'),
            'keluhan' => null, // Ganti dengan data aktual jika ada
            'kodedokter' => $dokter ? $dokter->kode_dokter : null,
            'namadokter' => $dokter ? $dokter->nama_dokter : 'Tidak Diketahui',
            'jampraktek' => $jamPraktek, // Tambahkan data jam praktek jika ada
            'nomorantrean' => $formattedNumber,
            'angkaantrean' => sprintf("%03d", $nextNumber),
            'keterangan' => null,
            'infoantrean' => 'offline-no-bpjs',
            'sta_antian' => 1,
            'no_reg' => $newNoReg,
        ];

        antiran_get::create($dataantri);

        $rad = new rajal();
        $rad->tgl_kunjungan = $dataantri['tanggalperiksa'];
        $rad->time = date('h:i A');
        $rad->doctor_id =  $dokter->id;
        $rad->poli_id =  $poli->id;
        $rad->penjab_id = 1 ;
        $rad->no_reg = $newNoReg;
        $rad->no_rawat = $noRawat;
        $rad->no_rm = $dataantri['norm'];
        $rad->nama_pasien = $pasien->nama;
        $rad->tgl_lahir = $pasien->tanggal_lahir;
        $rad->seks =  $pasien->nama_seks;
        $rad->telepon = $pasien->telepon;
        $rad->status = 'Belum Periksa';
        $rad->status_lanjut = 'Rawat Jalan';
        $rad->stts_soap = 0;
        $rad->save();


        if ($schedule) {
            // Cek apakah sudah ada riwayat kuota sebelumnya
            $lastHistory = history_quota::where('schedule_id', $schedule->id)
                                        ->orderBy('created_at', 'desc')
                                        ->first();

            // Tentukan remaining_quota berdasarkan riwayat terakhir
            $remainingQuota = $lastHistory ? $lastHistory->remaining_quota : $schedule->total_quota;

            // Mencatat riwayat kuota dengan nilai remaining_quota yang sudah berkurang
            history_quota::create([
                'schedule_id' => $schedule->id,
                'action' => 'decrease',
                'amount' => 1,
                'remaining_quota' => $remainingQuota - 1, // Mengurangi kuota dari riwayat sebelumnya
            ]);
        }

        $wsbpjsdata = [
            'nomorkartu' => null,
            'nik' => $pasien->nik,
            'nohp' => $pasien->telepon,
            'kodepoli' => $poli->kode_poli,
            'namapoli' => $poli->nama_poli,
            'norm' =>  $pasien->no_rm,
            'tanggalperiksa' => now()->format('Y-m-d'),
            'kodedokter' => $dokter->kode_dokter,
            'namadokter' => $dokter->nama_dokter,
            'jampraktek' => $jamPraktek,
            'nomorantrean' => $formattedNumber,
            'angkaantrean' => sprintf("%03d", $nextNumber),
            'keterangan' => "",
        ];
        // Menggunakan app() untuk mendapatkan instance dari BpjsServiceController
        $bpjsService = app(BpjsController::class);

        // Kirim data antrean ke API BPJS
        $bpjsService->get_ws_add_bpjs($wsbpjsdata);
        $this->sendWhatsAppNotification($formattedNumber, $poli->nama_poli, $dokter->nama_dokter, $pasien ? $pasien->telepon : 'Tidak Diketahui');

        return redirect()->route('antrian.createtiket')->with('success', 'Submenu berhasil ditambahkan');
    }

    public function getDoctorsByPoli($poliId)
    {
        $currentDay = Carbon::now()->dayOfWeekIso; // Menghasilkan angka 1-7 (Senin = 1, Minggu = 7)

        // Ambil waktu sekarang dalam format "H:i"
        $currentTime = Carbon::now()->format('H:i');

        // Query untuk mendapatkan daftar dokter berdasarkan jadwal di SchedulesDokter
        $doctors = Doctor::whereHas('schedules', function ($query) use ($currentDay, $currentTime) {
            $query->where('hari', $currentDay) // Filter hari dalam angka (1-7)
                ->whereTime('start', '<=', $currentTime) // Start <= waktu sekarang
                ->whereTime('end', '>=', $currentTime); // End >= waktu sekarang
        })->where('aktivasi', 'aktif') // Hanya dokter yang aktif
        ->where('poli', $poliId) // Filter berdasarkan poli
        ->get();
        if ($doctors->isEmpty()) {
            return response()->json(['status' => 'error', 'message' => 'Tidak ada dokter yang tersedia untuk poli ini pada jam ini'], 404);
        }

        return response()->json(['status' => 'success', 'data' => $doctors]);
    }
    public function checkNikNokaAjax(Request $request)
    {
        $input = $request->query('nik_noka');

        if (!is_numeric($input)) {
            return response()->json(['status' => 'error', 'message' => 'Input harus berupa angka.']);
        }

        if (strlen($input) == 13) {
            // Cek NoKa
            $patient = pasien::where('no_bpjs', $input)->first();
            $type = 'No. Kartu BPJS';
        } elseif (strlen($input) == 16) {
            // Cek NIK
            $patient = pasien::where('nik', $input)->first();
            $type = 'NIK';
        }

        if ($patient) {
            return response()->json(['status' => 'success', 'message' => "$type Nama : {$patient->nama}"]);
        } else {
            return response()->json(['status' => 'error', 'message' => "$type tidak Terdaftar."]);
        }
    }


    public function antrian_pasien_baru(Request $request)
    {
        // Cek apakah pasien sudah ada berdasarkan NIK
        $pasien = Pasien::where('nik', $request->nikInputDaftar)->first();

        // Jika pasien sudah ada, hapus validasi unique
        $rules = [
            'nikInputDaftar' => [
                'required',
                'digits:16',
                $pasien ? '' : 'unique:pasiens,nik', // Hanya cek unik jika pasien belum ada
            ],
            'nokaBpjsInput' => 'nullable|digits_between:13,16',
            'nomorhp' => 'required|numeric',
        ];

        $validated = $request->validate($rules);

        // Jika pasien sudah ada, gunakan nomor rekam medis lama
        $newNoRM = $pasien ? $pasien->no_rm : str_pad(Pasien::max('id') + 1, 6, '0', STR_PAD_LEFT);

        // Tentukan nomor antrean
        $prefix = 'N';
        $lastAntrian = DB::table('antiran_gets')->orderBy('angkaantrean', 'desc')->first();
        $nextNumber = $lastAntrian ? (int) $lastAntrian->angkaantrean + 1 : 1;
        $formattedNumber = sprintf("%s-%03d", $prefix, $nextNumber);

        // Simpan antrean
        antiran_get::create([
            'nomorkartu' => $validated['nokaBpjsInput'] ?? null,
            'nik' => $validated['nikInputDaftar'],
            'nohp' => $validated['nomorhp'],
            'kodepoli' => "00",
            'namapoli' => 'Tidak Diketahui',
            'norm' => $newNoRM,
            'tanggalperiksa' => now()->format('Y-m-d'),
            'keluhan' => null,
            'kodedokter' => "00",
            'namadokter' => 'Tidak Diketahui',
            'jampraktek' => null,
            'nomorantrean' => $formattedNumber,
            'angkaantrean' => sprintf("%03d", $nextNumber),
            'keterangan' => null,
            'infoantrean' => "offline-pasien-baru",
            'sta_antian' => 1,
        ]);

        // Tentukan pesan WhatsApp berdasarkan apakah pasien baru atau lama
        if ($pasien) {
            $whatsappMessage = "Data Anda sudah terdaftar di dalam sistem.\n Pasien Atas Nama : $pasien->nama \n Dengan Nomor RM : $pasien->no_rm \n Antrian: $formattedNumber.";
        } else {
            // Ambil data pasien dari API jika pasien baru
            $response = Http::get(url('/api/getsatusehat/' . $validated['nikInputDaftar']));
            $patientihs = $response->successful()
                ? $response->json()['patient_data']['entry'][0]['resource']['identifier'][0]['value']
                : 1;

            // Simpan data pasien baru
            Pasien::create([
                'no_rm' => $newNoRM,
                'nik' => $validated['nikInputDaftar'],
                'telepon' => $validated['nomorhp'],
                'no_bpjs' => $validated['nokaBpjsInput'],
                'kode_ihs' => $patientihs,
                'statusdata' => 1,
            ]);

            $whatsappMessage = "Nomor Antrian: $formattedNumber.\nSilahkan Lengkapi Data Anda Ke Loket Pendaftaran.";
        }

        // Kirim WhatsApp dengan pesan yang sesuai
        $this->sendWhatsAppNotifications($validated['nomorhp'], $whatsappMessage);

        return redirect()->route('antrian.createtiket')->with('success', 'Antrean berhasil ditambahkan');
    }

    private function sendWhatsAppNotifications($noHp, $message)
    {
        $license = licenses::latest()->first();
        if (!$license) {
            Log::error('No license key found in the database');
            return;
        }
        $licenseKey = $license->key;

        // Format nomor HP ke format internasional (62 untuk Indonesia)
        $noHpFormatted = '62' . preg_replace('/[^0-9]/', '', substr($noHp, 1));

        $apiUrl = url('/api/whatsapp/send-message');
        // Kirim permintaan HTTP ke API WhatsApp
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($apiUrl, [
            'licenseKey' => $licenseKey,
            'phoneNumber' => $noHpFormatted,
            'message' => $message
        ]);

        // Tangani respon API
        if ($response->successful()) {
            return response()->json([
                'message' => 'WhatsApp notification sent successfully',
                'response' => $response->json()
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to send WhatsApp notification',
                'error' => $response->json()
            ], $response->status());
        }
    }

    public function add()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "antrian";
        $poli = poli::all();
        $antrain = antrian::with('poli')->get();
        return view('antrian.home', compact('title','poli','antrain'));
    }

    public function adds(Request $request)
    {
        $request->validate([
            "poli" => 'required',
            "nama" => 'required|string|max:255',
        ]);

        antrian::create([
            "poli_id" => $request->poli,
            "nama" =>  $request->nama,
        ]);

        return redirect()->route('antrian.home')->with('success', 'Submenu berhasil ditambahkan');
    }

    public function loket()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "loket1";

        $lokets = antrian::all();
        return view('antrian.page', compact('title','lokets'));

    }

    public function getAntrian($loketId)
    {
        // Mengambil antrian pertama yang daftar ke loket yang dipilih

        $antrian = antiran_get::select(
            'antiran_gets.id',
            'antiran_gets.norm as no_rm',
            'antiran_gets.nomorantrean as no_antri',
            'antiran_gets.tanggalperiksa as tanggal_kunjungan',
            'antiran_gets.sta_antian',
            'polis.nama_poli',
            'antrians.nama as nama_loket'
        )
        ->join('polis', 'antiran_gets.kodepoli', '=', 'polis.id')
        ->join('antrians', 'antiran_gets.kodepoli', '=', 'antrians.poli_id')
        ->where('antiran_gets.sta_antian', 1)
        ->whereIn('antiran_gets.kodepoli', function ($query) {
            $query->select('ap2.kodepoli')
                ->from('antiran_gets as ap2')
                ->join('antrians as l2', 'ap2.kodepoli', '=', 'l2.poli_id')
                ->where('ap2.sta_antian', 1)
                ->groupBy('l2.id');
        })
        ->where('antrians.id', $loketId) // filter berdasarkan loket yang spesifik
        ->orderBy('antiran_gets.created_at', 'ASC')
        ->limit(1)
        ->first();


        if ($antrian) {
            return response()->json(['antrian' => $antrian]);
        }

        return response()->json(['antrian' => null]);
    }


    public function updateStatus(Request $request, $id)
    {
        // Assuming the 'id' is sent with the request (current antrian)
        $antrian = antiran_get::find($id);
        if ($antrian) {
            $antrian->sta_antian = $request->status;
            $antrian->save();

            return response()->json(['success' => true,'queue_number' => $antrian->nomorantrean]);

        }

        return response()->json(['success' => false, 'message' => 'Antrian tidak ditemukan.']);
    }

    public function updateAllStatus(Request $request)
    {
        // Ambil ID antrian saat ini (jika perlu untuk pengecualian)
        $currentId = $request->currentId;

        // Perbarui semua antrian dengan status 2 menjadi status 3
        $updated = antiran_get::where('sta_antian', 2)
            ->where('id', '!=', $currentId) // Opsional: Hindari memperbarui antrian yang baru dipanggil
            ->update(['sta_antian' => 3]);

        if ($updated) {
            return response()->json(['success' => true, 'updated_count' => $updated]);
        }

        return response()->json(['success' => false, 'message' => 'Tidak ada antrian dengan status 2 yang ditemukan.']);
    }

    private function sendWhatsAppNotificationpanggil($nomorAntrean, $poli, $dokter, $noHp)
    {
        $license = licenses::latest()->first();
        if (!$license) {
            Log::error('No license key found in the database');
            return;
        }
        $licenseKey = $license->key;
        // Format nomor HP ke format internasional (62 untuk Indonesia)
        $noHpFormatted = '62' . preg_replace('/[^0-9]/', '', substr($noHp, 1));

        // Pesan yang akan dikirim
        $message = "Nomor Antrian: $nomorAntrean\nPoli: $poli\nDokter: $dokter \nAntrian Memanggil Nomor Anda";

        $apiUrl = url('/api/whatsapp/send-message');
        // Kirim permintaan HTTP ke API WhatsApp
        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($apiUrl, [
            'licenseKey' => $licenseKey,
            'phoneNumber' => $noHpFormatted,
            'message' => $message
        ]);

        // Tangani respon API
        if ($response->successful()) {
            return response()->json([
                'message' => 'WhatsApp notification sent successfully',
                'response' => $response->json()
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to send WhatsApp notification',
                'error' => $response->json()
            ], $response->status());
        }

    }

    public function panggil(Request $request)
    {
        $nomor_rm = $request->input('nomor_rm');
        $nomor_regis = $request->input('nomor_regis');
        $kode_poli = $request->input('kode_poli');

        // Ambil data berdasarkan RM, Regis, dan Kode Poli


        $poli = Poli::where('kode_poli', $kode_poli)->first();

        $kunjungan = rajal::where('no_rm', $nomor_rm)
            ->where('no_reg', $nomor_regis)
            ->where('poli_id', $poli->id)
            ->first();


        $antrean = antiran_get::where('norm', $nomor_rm)
            ->where('kodepoli', $kode_poli)
            ->where('no_reg', $nomor_regis)
            ->first();

            $pasien = DB::table('pasiens')
            ->leftJoin('seks', 'pasiens.seks', '=', 'seks.id') // Gabungkan tabel pasien dan seks
            ->where('pasiens.nik', $antrean->nik)         // Sesuaikan dengan NIK pasien
            ->select('pasiens.*', 'seks.nama as nama_seks')     // Pilih kolom dari tabel pasien dan nama dari tabel seks
            ->first(); // Ambil data pertama
            if (!$antrean) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Simpan data antrian ke database
            antrian_logs::create([
                'nomor_antrean' => $antrean->nomorantrean,
                'nama_pasien' => $kunjungan->nama_pasien,
                'tgl_kunjungan' => $kunjungan->tgl_kunjungan,
                'poli' => $poli->nama_poli,
                'dipanggil' => false
            ]);

            // $this->sendWhatsAppNotificationpanggil($antrean->nomorantrean, $poli->nama_poli, $antrean->namadokter, $pasien ? $pasien->telepon : 'Tidak Diketahui');
            return response()->json(['message' => 'Panggilan berhasil']);
    }

    public function panggildokter(Request $request)
    {
        $nomor_rm = $request->input('nomor_rm');
        $nomor_regis = $request->input('nomor_regis');
        $kode_poli = $request->input('kode_poli');

        // Ambil data berdasarkan RM, Regis, dan Kode Poli


        $poli = Poli::where('kode_poli', $kode_poli)->first();

        $kunjungan = rajal::where('no_rm', $nomor_rm)
            ->where('no_reg', $nomor_regis)
            ->where('poli_id', $poli->id)
            ->first();


        $antrean = antiran_get::where('norm', $nomor_rm)
            ->where('kodepoli', $kode_poli)
            ->where('no_reg', $nomor_regis)
            ->first();

            $pasien = DB::table('pasiens')
            ->leftJoin('seks', 'pasiens.seks', '=', 'seks.id') // Gabungkan tabel pasien dan seks
            ->where('pasiens.nik', $antrean->nik)         // Sesuaikan dengan NIK pasien
            ->select('pasiens.*', 'seks.nama as nama_seks')     // Pilih kolom dari tabel pasien dan nama dari tabel seks
            ->first(); // Ambil data pertama
            if (!$antrean) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Simpan data antrian ke database
            antrian_logs::create([
                'nomor_antrean' => $antrean->nomorantrean,
                'nama_pasien' => $kunjungan->nama_pasien,
                'tgl_kunjungan' => $kunjungan->tgl_kunjungan,
                'poli' => $poli->nama_poli,
                'dipanggil' => false
            ]);


            if ($antrean && $antrean->infoantrean !== 'offline-no-bpjs') {
                $noka = pasien::where('no_rm', $nomor_rm)->first();

                $wsbpjsdata = [
                    'tanggalperiksa' => now()->format('Y-m-d'),
                    'kodepoli' => $kode_poli,
                    'nomorkartu' => $noka->no_bpjs,
                    'status' => 1,
                    'waktu' => now()->timestamp * 1000,
                ];

                $bpjsService = app(BpjsController::class);
                $bpjsService->get_ws_panggil_bpjs($wsbpjsdata);
            }




            $this->sendWhatsAppNotificationpanggil($antrean->nomorantrean, $poli->nama_poli, $antrean->namadokter, $pasien ? $pasien->telepon : 'Tidak Diketahui');
            return response()->json(['message' => 'Panggilan berhasil']);
    }

    public function getAntrianTerbaru()
    {
        // Ambil antrian yang belum dipanggil
        $antrian = antrian_logs::where('dipanggil', false)->first();

        if ($antrian) {
            return response()->json($antrian);
        }

        return response()->json(null);
    }

    public function markAntrianCalled($id)
    {
        $antrian = antrian_logs::find($id);
        if ($antrian) {
            $antrian->update(['dipanggil' => true]);
        }

        return response()->json(['message' => 'Antrian ditandai sebagai dipanggil']);
    }
}
