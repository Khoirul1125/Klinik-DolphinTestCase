<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Models\setweb;
use App\Http\Controllers\Controller;
use App\Models\poli;
use App\Models\jabatan;
use App\Models\statdok;
use App\Models\seks;
use App\Models\goldar;
use App\Models\Provinsi;
use App\Models\suku;
use App\Models\bangsa;
use App\Models\bahasa;
use App\Models\akuntan;
use App\Models\suberdaya;
use App\Models\User;
use App\Models\apotek;
use App\Models\data_doctor;
use App\Models\laboratorium;
use App\Models\karyawan;
use App\Models\data_karyawan;
use App\Models\doctor;
use App\Models\history_quota;
use App\Models\schedule_karyawan;
use App\Models\posker;
use App\Models\schedule_dokter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SumberdayamController extends Controller
{
    public function karyawan()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Karyawan";
        $poli = poli::all();
        $jabatan = jabatan::all();
        $status = statdok::all();
        $sex = seks::all();
        $goldar = goldar::all();
        $provinsi = Provinsi::all();
        $suku = suku::all();
        $bangsa = bangsa::all();
        $bahasa = bahasa::all();
        $posker = posker::all();
        $karyawan = karyawan::with('user','polis','jabatans','statdok')->where('aktivasi', 'aktif')->get();

        return view('sumdm.karyawan', compact('title','karyawan','poli','jabatan','status','sex','provinsi','goldar','suku','bangsa','bahasa','posker'));
    }

    public function karyawanadd(Request $request)
    {
        $data = $request->validate([
            "nama_karyawan" => 'required|string|max:255',
            "kode_karyawan" => 'nullable|string|max:255',
            "nik" => 'required|digits:16|unique:karyawans,nik',
            "jabatan" => 'required',
            "aktivasi" => 'required|in:aktif,tidak aktif',
            "poli" => 'required',
            "tglawal" => 'nullable|date',
            "sip" => 'nullable|string|max:255',
            "expspri" => 'nullable|date',
            "str" => 'nullable|string|max:255',
            "expstr" => 'nullable|date',
            "pk" => 'nullable|string|max:255',
            "exppk" => 'nullable|date',
            "npwp" => 'nullable',
            "status_kerja" => 'required',
            "kode" => 'nullable|string|max:255',
            "Alamat" => 'nullable|string|max:255',
            "rt" => 'nullable|digits_between:1,3',
            "rw" => 'nullable|digits_between:1,3',
            "kode_pos" => 'nullable|digits:5',
            "kewarganegaraan" => 'nullable|in:wni,wna',
            "provinsi" => 'required',
            "kota_kabupaten" => 'required',
            "kecamatan" => 'required',
            "desa" => 'required',
            "seks" => 'required',
            "tempat_lahir" => 'nullable|string|max:255',
            "tgllahir" => 'nullable|date',
            "agama" => 'nullable|in:islam,katolik,protestan,hindu,buddha,khonghucu',
            "goldar" => 'required',
            "pernikahan" => 'nullable|in:menikah,belum_nikah,cerai_hidup,cerai_mati',
            "suku" => 'required',
            "bangsa" => 'required',
            "bahasa" => 'required',
            "pendidikan" => 'required',
            "telepon" => 'required|string',
            "posker" => 'required',
        ]);

        $datauser = $request->validate([
            "nama_karyawan" => 'required|string|max:255',
            "username" => 'required|string|max:255',
            "email" => 'required|string|max:255',
            "password" => 'required|min:8',
            "telepon" => 'required',
            "foto" => 'nullable|image'
        ]);

        $fotoName = null;

        if ($request->hasFile('foto')) {
            // Get the original file name
            $fotoName = $request->file('foto')->getClientOriginalName();

            // Define the directory path to save in the public folder
            $destinationPath = public_path('uploads/doctor_photos');

            // Move the uploaded file to the public directory
            $request->file('foto')->move($destinationPath, $fotoName);
        }

        // Handle null profile photo if needed
        if (is_null($fotoName)) {
            // Set a default photo name or handle as required
            $fotoName = 'default.jpg';  // Example default image
        }

        try {
            $user = new User();
            $user->name = $datauser['nama_karyawan'];
            $user->username = $datauser['username'];
            $user->email = $datauser['email'];
            $user->password = Hash::make($datauser['password']); // Hash the password
            $user->profile = $fotoName;
            $user->phone = $datauser['telepon'];
            $user->save();
            $user->assignRole('SDM');

            $karyawan = new karyawan();
            $karyawan->nama_karyawan = $data['nama_karyawan'];
            $karyawan->kode_karyawan = $data['kode_karyawan'];
            $karyawan->nik = $data['nik'];
            $karyawan->jabatan = $data['jabatan'];
            $karyawan->aktivasi = $data['aktivasi'];
            $karyawan->poli = $data['poli'];
            $karyawan->tglawal = $data['tglawal'];
            $karyawan->expspri = $data['expspri'];
            $karyawan->sip = $data['sip'];
            $karyawan->expstr = $data['expstr'];
            $karyawan->str = $data['str'];
            $karyawan->pk = $data['pk'];
            $karyawan->exppk = $data['exppk'];
            $karyawan->npwp = $data['npwp'];
            $karyawan->status_kerja = $data['status_kerja'];
            $karyawan->kode = $data['kode'];
            $karyawan->Alamat = $data['Alamat'];
            $karyawan->rt = $data['rt'];
            $karyawan->rw = $data['rw'];
            $karyawan->kode_pos = $data['kode_pos'];
            $karyawan->kewarganegaraan = $data['kewarganegaraan'];
            $karyawan->provinsi = $data['provinsi'];
            $karyawan->kota_kabupaten = $data['kota_kabupaten'];
            $karyawan->kecamatan = $data['kecamatan'];
            $karyawan->desa = $data['desa'];
            $karyawan->seks = $data['seks'];
            $karyawan->tempat_lahir = $data['tempat_lahir'];
            $karyawan->tgllahir = $data['tgllahir'];
            $karyawan->agama = $data['agama'];
            $karyawan->goldar = $data['goldar'];
            $karyawan->pernikahan = $data['pernikahan'];
            $karyawan->suku = $data['suku'];
            $karyawan->bangsa = $data['bangsa'];
            $karyawan->bahasa = $data['bahasa'];
            $karyawan->pendidikan = $data['pendidikan'];
            $karyawan->telepon = $data['telepon'];
            $karyawan->userinput = $request->userinput;
            $karyawan->userinputid = $request->userinputid;
            $karyawan->posker = $data['posker'];
            $karyawan->user_id = $user->id;
            $karyawan->save();

            return redirect()->route('staff.index')->with('Success', 'karyawan berhasi di tambahkan');
        } catch (\Exception $e) {
            // Menampilkan pesan error secara lebih rinci
            return redirect()->back()->withErrors(['message' => 'Terjadi kesalahan, coba lagi. Error: ' . $e->getMessage()])->withInput();
        };
    }

    public function karyawandetail($id)
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "karyawan";
        $karyawan = karyawan::with('user', 'polis', 'jabatans', 'statdok')->findOrFail($id);

        $tingkatan = [];
        if ($karyawan->pendidikan == 'S1') {
            $tingkatan = ['SD', 'SMP', 'SMA', 'S1'];
        } elseif ($karyawan->pendidikan == 'S2') {
            $tingkatan = ['SD', 'SMP', 'SMA','S1', 'S2'];
        } elseif ($karyawan->pendidikan == 'S3') {
            $tingkatan = ['SD', 'SMP', 'SMA','S1', 'S2','S3'];
        } elseif ($karyawan->pendidikan == 'SMA') {
            $tingkatan = ['SD', 'SMP', 'SMA'];
        } elseif ($karyawan->pendidikan == 'SMP') {
            $tingkatan = ['SD', 'SMP'];
        }

        return view('sumdm.data_karyawan', compact('title','karyawan','tingkatan'));

    }

    public function karyawandetailadd(Request $request, $id)
    {
        $request->validate([
            'education.*.nama_sekolah' => 'required|string|max:255',
            'education.*.bulan_lulus' => 'required|date_format:Y-m',
            // 'education.*.ijasah' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'education.*.ijasah' => 'nullable|string|max:255',
            'sertifikasi.*.nama' => 'required|string|max:255',
            'sertifikasi.*.tanggal_pelaksanaan' => 'nullable|date',
            'sertifikat_digital.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'nama_bank' => 'nullable|string|max:255',
            'nomor_bank' => 'nullable|string|max:255',
            'cabang_bank' => 'nullable|string|max:255',
        ]);

        $education = [];
        if ($request->has('education')) {
            foreach ($request->education as $tingkat => $edu) {
                $education[] = [
                    'tingkat' => ucfirst($tingkat),
                    'nama_sekolah' => $edu['nama_sekolah'],
                    'bulan_lulus' => $edu['bulan_lulus'],
                    // 'ijasah' => $edu['ijasah'] ? $this->uploadFile($edu['ijasah']) : null,
                    'ijasah' => $edu['ijasah'] ?? null, // langsung ambil teksnya
                ];
            }
        }

        $certifications = [];
        if ($request->has('sertifikasi')) {
            foreach ($request->sertifikasi as $cert) {
                $certifications[] = [
                    'nama' => $cert['nama'],
                    'tanggal_pelaksanaan' => $cert['tanggal_pelaksanaan'],
                    'sertifikat_digital' => $cert['sertifikat_digital'] ? $this->uploadFile($cert['sertifikat_digital']) : null,
                ];
            }
        }
        data_karyawan::updateOrCreate(
            ['karyawan_id' => $id],
            [
                'education' => $education,
                'certifications' => $certifications,
                'bank_name' => $request->nama_bank,
                'bank_number' => $request->nomor_bank,
                'bank_branch' => $request->cabang_bank,
            ]
        );
        return redirect()->route('staff.index')->with('success', 'Data berhasil disimpan');
    }



    public function karyawandelete(Request $request ,$id)
    {
        // Cari karyawan berdasarkan ID
        $karyawan = karyawan::find($id);

        if ($karyawan) {
            // Ubah status aktivasi menjadi tidak aktif
            $karyawan->aktivasi = 'tidak aktif';
            $karyawan->save();

            return redirect()->route('staff.index')->with('success', 'staff berhasil di Hapus');
        }
    }





    // Fungsi untuk upload file
    private function uploadFile($file)
    {
        if ($file) {
            $path = $file->store('uploads', 'public');
            return $path;
        }
        return null;
    }





    public function dokter()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Doctor";
        $poli = poli::all();
        $jabatan = jabatan::all();
        $status = statdok::all();
        $doctors = doctor::with('user','polis','jabatans','statdok')->where('aktivasi', 'aktif')->get();
        $sex = seks::all();
        $goldar = goldar::all();
        $provinsi = Provinsi::all();
        $suku = suku::all();
        $bangsa = bangsa::all();
        $bahasa = bahasa::all();



        return view('doctor.index', compact('title','poli','jabatan','status','doctors','sex','provinsi','goldar','suku','bangsa','bahasa'));
    }

    public function doctoradd(Request $request)
    {
        $data = $request->validate([
            "nama_dokter" => 'required|string|max:255',
            "kode_dokter" => 'nullable|string|max:255',
            "nik" => 'required|digits:16|unique:doctors,nik',
            "jabatan" => 'required',
            "aktivasi" => 'required|in:aktif,tidak aktif',
            "poli" => 'required',
            "tglawal" => 'nullable|date',
            "sip" => 'nullable|string|max:255',
            "expspri" => 'nullable|date',
            "str" => 'nullable|string|max:255',
            "expstr" => 'nullable|date',
            "pk" => 'nullable|string|max:255',
            "exppk" => 'nullable|date',
            "npwp" => 'nullable',
            "status_kerja" => 'required',
            "kode" => 'nullable|string|max:255',
            "Alamat" => 'nullable|string|max:255',
            "rt" => 'nullable|digits_between:1,3',
            "rw" => 'nullable|digits_between:1,3',
            "kode_pos" => 'nullable|digits:5',
            "kewarganegaraan" => 'nullable|in:wni,wna',
            "provinsi" => 'required',
            "kota_kabupaten" => 'required',
            "kecamatan" => 'required',
            "desa" => 'required',
            "seks" => 'required',
            "tempat_lahir" => 'nullable|string|max:255',
            "tgllahir" => 'nullable|date',
            "agama" => 'nullable|in:islam,katolik,protestan,hindu,buddha,khonghucu',
            "goldar" => 'required',
            "pernikahan" => 'nullable|in:menikah,belum_nikah,cerai_hidup,cerai_mati',
            "suku" => 'required',
            "bangsa" => 'required',
            "bahasa" => 'required',
            "pendidikan" => 'required',
            "telepon" => 'required|string',
        ]);

        $datauser = $request->validate([
            "nama_dokter" => 'required|string|max:255',
            "username" => 'required|string|max:255',
            "email" => 'required|string|max:255',
            "password" => 'required|min:8',
            "telepon" => 'required',
            "foto" => 'nullable|image'
        ]);

        $fotoName = null;

        if ($request->hasFile('foto')) {
            // Get the original file name
            $fotoName = $request->file('foto')->getClientOriginalName();

            // Define the directory path to save in the public folder
            $destinationPath = public_path('uploads/doctor_photos');

            // Move the uploaded file to the public directory
            $request->file('foto')->move($destinationPath, $fotoName);
        }

        // Handle null profile photo if needed
        if (is_null($fotoName)) {
            // Set a default photo name or handle as required
            $fotoName = 'default.jpg';  // Example default image
        }


        try {
            $user = new User();
            $user->name = $datauser['nama_dokter'];
            $user->username = $datauser['username'];
            $user->email = $datauser['email'];
            $user->password = Hash::make($datauser['password']); // Hash the password
            $user->profile = $fotoName;
            $user->phone = $datauser['telepon'];
            $user->save();
            $user->assignRole('Dokter');

            $doctor = new doctor();
            $doctor->nama_dokter = $data['nama_dokter'];
            $doctor->kode_dokter = $data['kode_dokter'];
            $doctor->nik = $data['nik'];
            $doctor->jabatan = $data['jabatan'];
            $doctor->aktivasi = $data['aktivasi'];
            $doctor->poli = $data['poli'];
            $doctor->tglawal = $data['tglawal'];
            $doctor->expspri = $data['expspri'];
            $doctor->sip = $data['sip'];
            $doctor->expstr = $data['expstr'];
            $doctor->str = $data['str'];
            $doctor->pk = $data['pk'];
            $doctor->exppk = $data['exppk'];
            $doctor->npwp = $data['npwp'];
            $doctor->status_kerja = $data['status_kerja'];
            $doctor->kode = $data['kode'];
            $doctor->Alamat = $data['Alamat'];
            $doctor->rt = $data['rt'];
            $doctor->rw = $data['rw'];
            $doctor->kode_pos = $data['kode_pos'];
            $doctor->kewarganegaraan = $data['kewarganegaraan'];
            $doctor->provinsi = $data['provinsi'];
            $doctor->kota_kabupaten = $data['kota_kabupaten'];
            $doctor->kecamatan = $data['kecamatan'];
            $doctor->desa = $data['desa'];
            $doctor->seks = $data['seks'];
            $doctor->tempat_lahir = $data['tempat_lahir'];
            $doctor->tgllahir = $data['tgllahir'];
            $doctor->agama = $data['agama'];
            $doctor->goldar = $data['goldar'];
            $doctor->pernikahan = $data['pernikahan'];
            $doctor->suku = $data['suku'];
            $doctor->bangsa = $data['bangsa'];
            $doctor->bahasa = $data['bahasa'];
            $doctor->pendidikan = $data['pendidikan'];
            $doctor->telepon = $data['telepon'];
            $doctor->userinput = $request->userinput;
            $doctor->userinputid = $request->userinputid;
            $doctor->user_id = $user->id;
            $doctor->save();

            return redirect()->route('dokter.index')->with('Success', 'dokter berhasi di tambahkan');
        } catch (\Exception $e) {
            // Menampilkan pesan error secara lebih rinci
            return redirect()->back()->withErrors(['message' => 'Terjadi kesalahan, coba lagi. Error: ' . $e->getMessage()])->withInput();
        };
    }

    public function dokterdetail($id)
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Doctor";
        $doctor = doctor::with('user', 'polis', 'jabatans', 'statdok')->findOrFail($id);

        $tingkatan = [];
        if ($doctor->pendidikan == 'S1') {
            $tingkatan = ['SD', 'SMP', 'SMA', 'S1'];
        } elseif ($doctor->pendidikan == 'S2') {
            $tingkatan = ['SD', 'SMP', 'SMA','S1', 'S2'];
        } elseif ($doctor->pendidikan == 'S3') {
            $tingkatan = ['SD', 'SMP', 'SMA','S1', 'S2','S3'];
        } elseif ($doctor->pendidikan == 'SMA') {
            $tingkatan = ['SD', 'SMP', 'SMA'];
        } elseif ($doctor->pendidikan == 'SMP') {
            $tingkatan = ['SD', 'SMP'];
        }

        return view('doctor.data_dockter', compact('title','doctor','tingkatan'));

    }

    public function dokterdetailadd(Request $request, $id)
    {
        $request->validate([
            'education.*.nama_sekolah' => 'required|string|max:255',
            'education.*.bulan_lulus' => 'required|date_format:Y-m',
            // 'education.*.ijasah' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'education.*.ijasah' => 'nullable|string|max:255',
            'sertifikasi.*.nama' => 'nullable|string|max:255',
            'sertifikasi.*.tanggal_pelaksanaan' => 'nullable|date',
            'sertifikat_digital.*' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'nama_bank' => 'nullable|string|max:255',
            'nomor_bank' => 'nullable|string|max:255',
            'cabang_bank' => 'nullable|string|max:255',
        ]);

        $education = [];
        if ($request->has('education')) {
            foreach ($request->education as $tingkat => $edu) {
                $education[] = [
                    'tingkat' => ucfirst($tingkat),
                    'nama_sekolah' => $edu['nama_sekolah'],
                    'bulan_lulus' => $edu['bulan_lulus'],
                    // 'ijasah' => $edu['ijasah'] ? $this->uploadFile($edu['ijasah']) : null,
                    'ijasah' => $edu['ijasah'] ?? null, // langsung ambil teksnya
                ];
            }
        }

        $certifications = [];
        if ($request->has('sertifikasi')) {
            foreach ($request->sertifikasi as $cert) {
                $certifications[] = [
                    'nama' => $cert['nama'],
                    'tanggal_pelaksanaan' => $cert['tanggal_pelaksanaan'],
                    'sertifikat_digital' => $cert['sertifikat_digital'] ? $this->uploadFile($cert['sertifikat_digital']) : null,
                ];
            }
        }

        // Simpan ke tabel `doctor_details`
        data_doctor::updateOrCreate(
            ['doctor_id' => $id],
            [
                'education' => $education,
                'certifications' => $certifications,
                'bank_name' => $request->nama_bank,
                'bank_number' => $request->nomor_bank,
                'bank_branch' => $request->cabang_bank,
            ]
        );
        return redirect()->route('dokter.index')->with('success', 'Data berhasil disimpan');
    }

    public function dokterjadwal($id)
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Doctor";
        $doctor = doctor::with('user', 'polis', 'jabatans', 'statdok')->findOrFail($id);
        $schedules = schedule_dokter::where('doctor_id', $id)->get();

        return view('doctor.jadwal', compact('title', 'doctor','schedules'));
    }


    public function dokterjadwaladd(Request $request, $id)
    {
        $request->validate([
            'start' => 'required|date_format:H:i',
            'end' => 'required|date_format:H:i|after:start',
            'quota' => 'required|integer|min:1',
            'total_quota' => 'required|integer|min:1',
            'hari' => 'required',
            'userinput' => 'required',
            'userinputid' => 'required',
        ]);

        // Cek apakah ada konflik jadwal
        $conflict = DB::table('schedules_dokter')
            ->where('doctor_id', $id)
            ->where('hari', $request->hari)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start', [$request->start, $request->end])
                      ->orWhereBetween('end', [$request->start, $request->end])
                      ->orWhere(function ($query) use ($request) {
                          $query->where('start', '<=', $request->start)
                                ->where('end', '>=', $request->end);
                      });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['start' => 'Jadwal bertabrakan dengan jadwal lain pada hari yang sama.']);
        }


        // Membuat jadwal baru
        schedule_dokter::create([
            'doctor_id' => $id,
            'start' => $request->start,
            'end' => $request->end,
            'quota' => $request->quota,
            'total_quota' => $request->total_quota,
            'hari' => $request->hari,
            'userinput' => $request->userinput,
            'userinputid' => $request->userinputid,
        ]);

        return redirect()->route('dokter.index.jadwal', ['id' => $id])->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function doctoradelete(Request $request ,$id)
    {
        // Cari dokter berdasarkan ID
        $dokter = doctor::find($id);

        if ($dokter) {
            // Ubah status aktivasi menjadi tidak aktif
            $dokter->aktivasi = 'tidak aktif';
            $dokter->save();

            return redirect()->route('dokter.index')->with('success', 'Dokter berhasil Dihapus');
        }

    }

    public function doctorcari($id)
    {
        // Cari pasien berdasarkan ID
        $pasien = DB::table('doctors')
        ->join('users', 'doctors.user_id', '=', 'users.id')  // Gabungkan dengan tabel users berdasarkan user_id
        ->where('doctors.id', $id)  // Cari pasien berdasarkan ID
        ->select('doctors.*', 'users.*')  // Ambil kolom dari kedua tabel
        ->first();  // Ambil hasil pertama (karena mencari berdasarkan ID)


        // Jika pasien ditemukan, kembalikan data dalam format JSON
        if ($pasien) {
            return response()->json($pasien);
        }

        // Jika pasien tidak ditemukan, kembalikan respon error
        return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
    }


    public function doctorupdate(Request $request)
    {
        $data = $request->validate([
            "nama_dokter_edit" => 'nullable|string|max:255',
            "kode_dokter_edit" => 'nullable|string|max:255',
            "nik_edit" => 'nullable|digits:16',
            "jabatan_edit" => 'nullable',
            "aktivasi_edit" => 'nullable|in:aktif,tidak aktif',
            "poli_edit" => 'nullable',
            "tglawal_edit" => 'nullable|date',
            "sip_edit" => 'nullable|string|max:255',
            "expspri_edit" => 'nullable|date',
            "str_edit" => 'nullable|string|max:255',
            "expstr_edit" => 'nullable|date',
            "pk_edit" => 'nullable|string|max:255',
            "exppk_edit" => 'nullable|date',
            "npwp_edit" => 'nullable',
            "status_kerja_edit" => 'nullable',
            "kode_edit" => 'nullable|string|max:255',
            "Alamat_edit" => 'nullable|string|max:255',
            "rt_edit" => 'nullable|digits_between:1,3',
            "rw_edit" => 'nullable|digits_between:1,3',
            "kode_pos_edit" => 'nullable|digits:5',
            "kewarganegaraan_edit" => 'nullable|in:wni,wna',
            "provinsi_edit" => 'nullable',
            "kota_kabupaten_edit" => 'nullable',
            "kecamatan_edit" => 'nullable',
            "desa_edit" => 'nullable',
            "seks_edit" => 'nullable',
            "tempat_lahir_edit" => 'nullable|string|max:255',
            "tanggal_lahir_edit" => 'nullable|date',
            "agama_edit" => 'nullable|in:islam,katolik,protestan,hindu,buddha,khonghucu',
            "goldar_edit" => 'nullable',
            "pernikahan_edit" => 'nullable|in:menikah,belum_nikah,cerai_hidup,cerai_mati',
            "suku_edit" => 'nullable',
            "bangsa_edit" => 'nullable',
            "bahasa_edit" => 'nullable',
            "pendidikan_edit" => 'nullable',
            "telepon_edit" => 'nullable|string',
        ]);

        $datauser = $request->validate([
            "nama_dokter_edit" => 'nullable|string|max:255',
            "username_edit" => 'nullable|string|max:255',
            "email_edit" => 'nullable|string|max:255',
            "password_edit" => 'nullable|min:8',
            "telepon_edit" => 'nullable',
            "foto_edit" => 'nullable|image'
        ]);

        $fotoName = null;

        if ($request->hasFile('foto_edit')) {
            // Get the original file name
            $fotoName = $request->file('foto_edit')->getClientOriginalName();

            // Define the directory path to save in the public folder
            $destinationPath = public_path('uploads/doctor_photos');

            // Move the uploaded file to the public directory
            $request->file('foto_edit')->move($destinationPath, $fotoName);
        }

        // Handle null profile photo if needed
        if (is_null($fotoName)) {
            // Set a default photo name or handle as required
            $fotoName = 'default.jpg';  // Example default image
        }


        try {

            $doctor = doctor::where('npwp', $data['npwp_edit'])->firstOrFail();
            if($doctor){
                $doctor->nama_dokter = $data['nama_dokter_edit'];
                $doctor->kode_dokter = $data['kode_dokter_edit'];
                $doctor->nik = $data['nik_edit'];
                $doctor->jabatan = $data['jabatan_edit'];
                $doctor->aktivasi = $data['aktivasi_edit'];
                $doctor->poli = $data['poli_edit'];
                $doctor->tglawal = $data['tglawal_edit'];
                $doctor->expspri = $data['expspri_edit'];
                $doctor->sip = $data['sip_edit'];
                $doctor->expstr = $data['expstr_edit'];
                $doctor->str = $data['str_edit'];
                $doctor->pk = $data['pk_edit'];
                $doctor->exppk = $data['exppk_edit'];
                $doctor->status_kerja = $data['status_kerja_edit'];
                $doctor->kode = $data['kode_edit'];
                $doctor->Alamat = $data['Alamat_edit'];
                $doctor->rt = $data['rt_edit'];
                $doctor->rw = $data['rw_edit'];
                $doctor->kode_pos = $data['kode_pos_edit'];
                $doctor->kewarganegaraan = $data['kewarganegaraan_edit'];
                $doctor->provinsi = $data['provinsi_edit'];
                $doctor->kota_kabupaten = $data['kota_kabupaten_edit'];
                $doctor->kecamatan = $data['kecamatan_edit'];
                $doctor->desa = $data['desa_edit'];
                $doctor->seks = $data['seks_edit'];
                $doctor->tempat_lahir = $data['tempat_lahir_edit'];
                $doctor->tgllahir = $data['tanggal_lahir_edit'];
                $doctor->agama = $data['agama_edit'];
                $doctor->goldar = $data['goldar_edit'];
                $doctor->pernikahan = $data['pernikahan_edit'];
                $doctor->suku = $data['suku_edit'];
                $doctor->bangsa = $data['bangsa_edit'];
                $doctor->bahasa = $data['bahasa_edit'];
                $doctor->pendidikan = $data['pendidikan_edit'];
                $doctor->telepon = $data['telepon_edit'];
                $doctor->userinput = $request->userinput_edit;
                $doctor->userinputid = $request->userinputid_edit;
                $doctor->save();
            }

            $user = User::findOrFail($doctor->user_id);
            $user->name = $datauser['nama_dokter_edit'];
            $user->username = $datauser['username_edit'];
            $user->email = $datauser['email_edit'];
            if ($datauser['password_edit']) {
                $user->password = Hash::make($datauser['password_edit']);
            }
            $user->profile = $fotoName;
            $user->phone = $datauser['telepon_edit'];
            $user->save();



            return redirect()->route('dokter.index')->with('Success', 'dokter berhasi di Edit');
        } catch (\Exception $e) {
            // Menampilkan pesan error secara lebih rinci
            return redirect()->back()->withErrors(['message' => 'Terjadi kesalahan, coba lagi. Error: ' . $e->getMessage()])->withInput();
        };
    }
}
