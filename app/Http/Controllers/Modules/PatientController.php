<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\BpjsController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\antiran_get;
use App\Models\doctor;
use App\Models\pasien;
use App\Models\seks;
use App\Models\goldar;
use App\Models\suku;
use App\Models\bangsa;
use App\Models\bahasa;
use App\Models\penjamin;
use App\Models\setweb;
use App\Models\User;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\penjab;
use App\Models\poli;
use App\Models\rajal;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class PatientController extends Controller
{
    public function generate()
    {
        $lastNoRM = Pasien::orderBy('no_rm', 'DESC')->first();
        // dd

        if ($lastNoRM) {
            $newNoRM = str_pad($lastNoRM->id + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $newNoRM = '000001'; // First Nomor RM if no record exists
        }

        return response()->json(['nomor_rm' => $newNoRM]);
    }

    public function pasiens()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Patient";
        $goldar = goldar::all();
        $provinsi = Provinsi::all();
        // dd($pasien);
        $sex = seks::all();
        $suku = suku::all();
        $bangsa = bangsa::all();
        $bahasa = bahasa::all();
        $pasien = pasien::with(['goldar'])->get();
        return view('patient.index', compact('title','goldar','pasien','provinsi','sex','suku','bangsa','bahasa'));
    }
    public function patientadd(Request $request)
    {
        $data = $request->validate([
            "nomor_rm" => 'required',
            "nik" => 'required|unique:pasiens',
            "kode_ihs" => 'required|unique:pasiens',
            "nama" => 'required',
            "tempat_lahir" => 'required',
            "tanggal_lahir" => 'required',
            "Alamat" => 'required|string|max:255',
            "rt" => 'required',
            "rw" => 'required',
            "kode_pos" => 'required',
            "kewarganegaraan" => 'required',
            "provinsi" => 'required',
            "kota_kabupaten" => 'required',
            "kecamatan" => 'required',
            "desa" => 'required',
            "seks" => 'required',
            "agama" => 'required',
            "pendidikan" => 'required',
            "goldar" => 'required',
            "pernikahan" => 'required',
            "pekerjaan" => 'required',
            "suku" => 'required',
            "bangsa" => 'required',
            "bahasa" => 'required',
            "telepon" => 'required|string',
        ],[
            'nomor_rm.required' => 'Nomor RM harus diisi.',
            'nik.required' => 'NIK harus diisi.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'kode_ihs.required' => 'Kode IHS harus diisi.',
            'kode_ihs.unique' => 'Kode IHS sudah terdaftar.',
            'nama.required' => 'Nama harus diisi.',
            'tempat_lahir.required' => 'Tempat lahir harus diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir harus diisi.',
            'Alamat.required' => 'Alamat harus diisi.',
            'rt.required' => 'RT harus diisi.',
            'rw.required' => 'RW harus diisi.',
            'kode_pos.required' => 'Kode pos harus diisi.',
            'kewarganegaraan.required' => 'Kewarganegaraan harus diisi.',
            'provinsi.required' => 'Provinsi harus diisi.',
            'kota_kabupaten.required' => 'Kota/Kabupaten harus diisi.',
            'kecamatan.required' => 'Kecamatan harus diisi.',
            'desa.required' => 'Desa harus diisi.',
            'seks.required' => 'Seks harus diisi.',
            'agama.required' => 'Agama harus diisi.',
            'pendidikan.required' => 'Pendidikan harus diisi.',
            'goldar.required' => 'Golongan darah harus diisi.',
            'pernikahan.required' => 'Status pernikahan harus diisi.',
            'pekerjaan.required' => 'Pekerjaan harus diisi.',
            'telepon.required' => 'Telepon harus diisi.',
        ]);

        $datauser = $request->validate([
            "nama" => 'required',
            "username" => 'required|string|max:255',
            "email" => 'required|string|max:255',
            "password" => 'required|min:8',
            "telepon" => 'required',
        ],[
            'nama.required' => 'Nama harus diisi.',
            'username.required' => 'Username harus diisi.',
            'username.string' => 'Username harus berupa teks.',
            'username.max' => 'Username tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah digunakan.',
            'password.required' => 'Password harus diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'telepon.required' => 'Telepon harus diisi.',
        ]);

        $fotoName = null;

        if ($request->hasFile('foto')) {
            // Get the original file name
            $fotoName = $request->file('foto')->getClientOriginalName();

            // Define the directory path to save in the public folder
            $destinationPath = public_path('uploads/patient_photos');

            // Move the uploaded file to the public directory
            $request->file('foto')->move($destinationPath, $fotoName);
        }

        // Handle null profile photo if needed
        if (is_null($fotoName)) {
            // Set a default photo name or handle as required
            $fotoName = 'default.jpg';  // Example default image
        }

        // Save $fotoName to the database or use it as needed

        try {
            // Create a new user
            $user = new User();
            $user->name = $datauser['nama'];
            $user->username = $datauser['username'];
            $user->email = $datauser['email'];
            $user->password = Hash::make($datauser['password']);
            $user->profile = $fotoName;
            $user->phone = $datauser['telepon'];
            $user->save();
            $user->assignRole('User');

            // Create a new pasien
            $pasien = new Pasien();
            $pasien->no_rm = $data['nomor_rm'];
            $pasien->nik = $data['nik'];
            $pasien->kode_ihs = $data['kode_ihs'];
            $pasien->nama = $data['nama'];
            $pasien->tempat_lahir = $data['tempat_lahir'];
            $pasien->tanggal_lahir = $data['tanggal_lahir'];
            $pasien->no_bpjs = $request->no_bpjs;
            $pasien->tgl_akhir = $request->tgl_akhir;
            $pasien->kelas_bpjs = $request->kelbpjs;
            $pasien->jenis_bpjs = $request->jenper;
            $pasien->provide = $request->provide;
            $pasien->kodeprovide = $request->kodeprovide    ;
            $pasien->userinput = $request->userinput;
            $pasien->userinputid = $request->userinputid;
            $pasien->hubungan_keluarga = $request->hubka;
            $pasien->Alamat = $data['Alamat'];
            $pasien->rt = $data['rt'];
            $pasien->rw = $data['rw'];
            $pasien->kode_pos = $data['kode_pos'];
            $pasien->kewarganegaraan = $data['kewarganegaraan'];
            $pasien->provinsi_kode = $data['provinsi'];
            $pasien->kabupaten_kode = $data['kota_kabupaten'];
            $pasien->kecamatan_kode = $data['kecamatan'];
            $pasien->desa_kode = $data['desa'];
            $pasien->seks = $data['seks'];
            $pasien->agama = $data['agama'];
            $pasien->pendidikan = $data['pendidikan'];
            $pasien->suku = $data['suku'];
            $pasien->bangsa = $data['bangsa'];
            $pasien->bahasa = $data['bahasa'];
            $pasien->goldar_id = $data['goldar'];
            $pasien->pernikahan = $data['pernikahan'];
            $pasien->pekerjaan = $data['pekerjaan'];
            $pasien->telepon = $data['telepon'];
            $pasien->statusdata = 2;
            $pasien->userinput = $request->userinput;
            $pasien->userinputid = $request->userinputid;
            $pasien->user_id = $user->id; // Add this line to link pasien to user
            $pasien->save();

            return redirect()->route('pasien.index')->with('Success', 'Pasien berhasil ditambahkan');
        } catch (\Exception $e) {
            // Menampilkan pesan error secara lebih rinci
            return redirect()->back()->withErrors(['message' => 'Terjadi kesalahan, coba lagi. Error: ' . $e->getMessage()])->withInput();
        };

    }

    public function patientupdate(Request $request)
    {
        $request->validate([
            'nomor_rm_edit' => 'required|string',
            'nik_edit' => 'required|string|max:16',
            'kode_ihs_edit' => 'nullable|string',
            'nama_edit' => 'required|string',
            'tempat_lahir_edit' => 'nullable|string',
            'tanggal_lahir_edit' => 'nullable|date',
            'username_edit' => 'required|string',
            'password_edit' => 'nullable|string',
            'email_edit' => 'nullable|email',
            'no_bpjs_edit' => 'nullable|string',
            'kelbpjs_edit' => 'nullable|string',
            'jenper_edit' => 'nullable|string',
            'tgl_akhir_edit' => 'nullable|date',
            'provide_edit' => 'nullable|string',
            'hubka_edit' => 'nullable|string',
            'Alamat_edit' => 'nullable|string',
            'rt_edit' => 'nullable|string',
            'rw_edit' => 'nullable|string',
            'kode_pos_edit' => 'nullable|string',
            'kewarganegaraan_edit' => 'nullable|string',
            'provinsi_edit' => 'nullable|string',
            'kota_kabupaten_edit' => 'nullable|string',
            'kecamatan_edit' => 'nullable|string',
            'desa_edit' => 'nullable|string',
            'seks_edit' => 'nullable|string',
            'agama_edit' => 'nullable|string',
            'pendidikan_edit' => 'nullable|string',
            'goldar_edit' => 'nullable|string',
            'pernikahan_edit' => 'nullable|string',
            'pekerjaan_edit' => 'nullable|string',
            'telepon_edit' => 'nullable|string',
            'suku_edit' => 'nullable|string',
            'bangsa_edit' => 'nullable|string',
            'bahasa_edit' => 'nullable|string',
            'kodeprovide_edit' => 'nullable|string',
            'userinput_edit' => 'nullable|string',
            'userinputid_edit' => 'nullable|string',
        ]);


        $pasien = Pasien::where('no_rm', $request->nomor_rm_edit)->firstOrFail();
        if ($pasien) {
            $pasien->no_rm = $request->nomor_rm_edit;
            $pasien->nik = $request->nik_edit;
            $pasien->kode_ihs = $request->kode_ihs_edit;
            $pasien->nama = $request->nama_edit;
            $pasien->tempat_lahir = $request->tempat_lahir_edit;
            $pasien->tanggal_lahir = $request->tanggal_lahir_edit;
            $pasien->no_bpjs = $request->no_bpjs_edit;
            $pasien->tgl_akhir = $request->tgl_akhir_edit;
            $pasien->kelas_bpjs = $request->kelbpjs_edit;
            $pasien->jenis_bpjs = $request->jenper_edit;
            $pasien->provide = $request->provide_edit;
            $pasien->kodeprovide = "0195R001";
            $pasien->userinput = $request->userinput_edit;
            $pasien->userinputid = $request->userinputid_edit;
            $pasien->hubungan_keluarga = $request->hubka_edit;
            $pasien->Alamat = $request->Alamat_edit;
            $pasien->rt = $request->rt_edit;
            $pasien->rw = $request->rw_edit;
            $pasien->kode_pos = $request->kode_pos_edit;
            $pasien->kewarganegaraan = $request->kewarganegaraan_edit;
            $pasien->provinsi_kode = $request->provinsi_edit;
            $pasien->kabupaten_kode = $request->kota_kabupaten_edit;
            $pasien->kecamatan_kode = $request->kecamatan_edit;
            $pasien->desa_kode = $request->desa_edit;
            $pasien->seks = $request->seks_edit;
            $pasien->agama = $request->agama_edit;
            $pasien->pendidikan = $request->pendidikan_edit;
            $pasien->suku = $request->suku_edit;
            $pasien->bangsa = $request->bangsa_edit;
            $pasien->bahasa = $request->bahasa_edit;
            $pasien->goldar_id = $request->goldar_edit;
            $pasien->pernikahan = $request->pernikahan_edit;
            $pasien->pekerjaan = $request->pekerjaan_edit;
            $pasien->telepon = $request->telepon_edit;
            $pasien->statusdata = 2;
            $pasien->save();
        }


        $user = User::findOrFail($pasien->user_id);
        $user->name = $request->nama_edit;
        $user->username = $request->username_edit;
        $user->email = $request->email_edit;
        if ($request->password_edit) {
            $user->password = Hash::make($request->password_edit);
        }
        $user->phone = $request->telepon_edit;
        $user->save();

        return redirect()->route('pasien.index')->with('Success', 'Pasien berhasil diperbarui');

    }

    public function patientdelete(Request $request ,$id)
    {
        // Cari dokter berdasarkan ID
        $dokter = pasien::find($id);

        if ($dokter) {
            // Ambil user_id sebelum menghapus pasien
            $userId = $dokter->user_id;

            // Hapus pasien
            $dokter->delete();

            // Hapus user berdasarkan user_id
            User::destroy($userId);

            return redirect()->route('pasien.index')->with('success', 'Dokter berhasil Dihapus');
        }

    }

    public function patientlengkapi(Request $request)
    {
        $request->validate([
            'nomor_rm_lengkapi' => 'required|string',
            'nik_lengkapi' => 'required|string|max:16',
            'kode_ihs_lengkapi' => 'nullable|string',
            'nama_lengkapi' => 'required|string',
            'tempat_lahir_lengkapi' => 'nullable|string',
            'tanggal_lahir_lengkapi' => 'nullable|date',
            'username_lengkapi' => 'required|string',
            'password_lengkapi' => 'nullable|string',
            'email_lengkapi' => 'nullable|email',
            'no_bpjs_lengkapi' => 'nullable|string',
            'kelbpjs_lengkapi' => 'nullable|string',
            'jenper_lengkapi' => 'nullable|string',
            'tgl_akhir_lengkapi' => 'nullable|date',
            'provide_lengkapi' => 'nullable|string',
            'hubka_lengkapi' => 'nullable|string',
            'Alamat_lengkapi' => 'nullable|string',
            'rt_lengkapi' => 'nullable|string',
            'rw_lengkapi' => 'nullable|string',
            'kode_pos_lengkapi' => 'nullable|string',
            'kewarganegaraan_lengkapi' => 'nullable|string',
            'provinsi_lengkapi' => 'nullable|string',
            'kota_kabupaten_lengkapi' => 'nullable|string',
            'kecamatan_lengkapi' => 'nullable|string',
            'desa_lengkapi' => 'nullable|string',
            'seks_lengkapi' => 'nullable|string',
            'agama_lengkapi' => 'nullable|string',
            'pendidikan_lengkapi' => 'nullable|string',
            'goldar_lengkapi' => 'nullable|string',
            'pernikahan_lengkapi' => 'nullable|string',
            'pekerjaan_lengkapi' => 'nullable|string',
            'telepon_lengkapi' => 'nullable|string',
            'suku_lengkapi' => 'nullable|string',
            'bangsa_lengkapi' => 'nullable|string',
            'bahasa_lengkapi' => 'nullable|string',
            'kodeprovide_lengkapi' => 'nullable|string',
            'userinput_lengkapi' => 'nullable|string',
            'userinputid_lengkapi' => 'nullable|string',
        ]);

        $fotoName = null;

        if ($request->hasFile('foto_lengkapi')) {
            // Get the original file name
            $fotoName = $request->file('foto_lengkapi')->getClientOriginalName();

            // Define the directory path to save in the public folder
            $destinationPath = public_path('uploads/patient_photos');

            // Move the uploaded file to the public directory
            $request->file('foto_lengkapi')->move($destinationPath, $fotoName);
        }

        // Handle null profile photo if needed
        if (is_null($fotoName)) {
            // Set a default photo name or handle as required
            $fotoName = 'default.jpg';  // Example default image
        }

        $user = new User();
            $user->name = $request->nama_lengkapi;
            $user->username = $request->username_lengkapi;
            $user->email = $request->email_lengkapi;
            $user->password = Hash::make($request->password_lengkapi);
            $user->profile = $fotoName;
            $user->phone = $request->telepon_lengkapi;
            $user->save();
            $user->assignRole('User');


        $pasien = Pasien::where('no_rm', $request->nomor_rm_lengkapi)->firstOrFail();
        // dd($pasien);
        if ($pasien) {
            $pasien->no_rm = $request->nomor_rm_lengkapi;
            $pasien->nik = $request->nik_lengkapi;
            $pasien->kode_ihs = $request->kode_ihs_lengkapi;
            $pasien->nama = $request->nama_lengkapi;
            $pasien->tempat_lahir = $request->tempat_lahir_lengkapi;
            $pasien->tanggal_lahir = $request->tanggal_lahir_lengkapi;
            $pasien->no_bpjs = $request->no_bpjs_lengkapi;
            $pasien->tgl_akhir = $request->tgl_akhir_lengkapi;
            $pasien->kelas_bpjs = $request->kelbpjs_lengkapi;
            $pasien->jenis_bpjs = $request->jenper_lengkapi;
            $pasien->provide = $request->provide_lengkapi;
            $pasien->kodeprovide = "0195R001";
            $pasien->userinput = $request->userinput_lengkapi;
            $pasien->userinputid = $request->userinputid_lengkapi;
            $pasien->hubungan_keluarga = $request->hubka_lengkapi;
            $pasien->Alamat = $request->Alamat_lengkapi;
            $pasien->rt = $request->rt_lengkapi;
            $pasien->rw = $request->rw_lengkapi;
            $pasien->kode_pos = $request->kode_pos_lengkapi;
            $pasien->kewarganegaraan = $request->kewarganegaraan_lengkapi;
            $pasien->provinsi_kode = $request->provinsi_lengkapi;
            $pasien->kabupaten_kode = $request->kota_kabupaten_lengkapi;
            $pasien->kecamatan_kode = $request->kecamatan_lengkapi;
            $pasien->desa_kode = $request->desa_lengkapi;
            $pasien->seks = $request->seks_lengkapi;
            $pasien->agama = $request->agama_lengkapi;
            $pasien->pendidikan = $request->pendidikan_lengkapi;
            $pasien->suku = $request->suku_lengkapi;
            $pasien->bangsa = $request->bangsa_lengkapi;
            $pasien->bahasa = $request->bahasa_lengkapi;
            $pasien->goldar_id = $request->goldar_lengkapi;
            $pasien->pernikahan = $request->pernikahan_lengkapi;
            $pasien->pekerjaan = $request->pekerjaan_lengkapi;
            $pasien->telepon = $request->telepon_lengkapi;
            $pasien->user_id = $user->id; // Add this line to link pasien to user
            $pasien->statusdata = 2;
            $pasien->save();
        }
        
        return redirect()->route('pasien.index')->with('Success', 'Pasien berhasil dilengakpi');

    }

    public function caripasiennew($id)
    {
        // Cari pasien berdasarkan ID
        $pasien = DB::table('pasiens')
        ->where('id', $id)  // Cari pasien berdasarkan ID
        ->first();  // Ambil hasil pertama
        dd($pasien);

        // Jika pasien ditemukan, kembalikan data dalam format JSON
        if ($pasien) {
            return response()->json($pasien);
        }

        // Jika pasien tidak ditemukan, kembalikan respon error
        return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
    }

    public function caripasien($id)
    {
        // Cari pasien berdasarkan ID
        $pasien = DB::table('pasiens')
        ->join('users', 'pasiens.user_id', '=', 'users.id')  // Gabungkan dengan tabel users berdasarkan user_id
        ->where('pasiens.id', $id)  // Cari pasien berdasarkan ID
        ->select('pasiens.*', 'users.*')  // Ambil kolom dari kedua tabel
        ->first();  // Ambil hasil pertama (karena mencari berdasarkan ID)


        // Jika pasien ditemukan, kembalikan data dalam format JSON
        if ($pasien) {
            return response()->json($pasien);
        }

        // Jika pasien tidak ditemukan, kembalikan respon error
        return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
    }

    public function checkNIK(Request $request)
    {
        $nik = $request->input('nik');
        $exists = Pasien::where('nik', $nik)->exists(); // Check if NIK exists in the 'users' table

        return response()->json(['exists' => $exists]);
    }
    public function checknoka(Request $request)
    {
        $no_bpjs = $request->input('no_bpjs');
        $exists = Pasien::where('no_bpjs', $no_bpjs)->exists(); // Check if NIK exists in the 'users' table

        return response()->json(['exists' => $exists]);
    }

    public function rajal()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "rajal";
        $dokter = doctor::where('aktivasi', 'aktif') // Hanya dokter dengan aktivasi aktif
        ->whereHas('details')
        ->get();
        $penjab = penjab::all();
        $pasien = pasien::all();
        $poli = poli::all();
        $rajal = rajal::with(['poli', 'pasien', 'doctor', 'penjab'])
        ->get()
        ->map(function ($item) {
            // Menambahkan nomor antrean
            $antrean = antiran_get::where('norm', $item->no_rm)
                ->where('kodepoli', $item->poli->kode_poli ?? null)
                ->where('no_reg', $item->no_reg)
                ->first();

            // Menyimpan nomor antrean ke dalam item
            $item->nomor_antrean = $antrean ? $antrean->nomorantrean : null;

            return $item;
        });

        $goldar = goldar::all();
        $provinsi = Provinsi::all();
        $sex = seks::all();
        return view('regis.rajal', compact('title','dokter','penjab','pasien','poli','rajal','goldar','provinsi','sex'));
    }

    public function rajaladd(Request $request)
    {
        $data = $request->validate([
            "tgl_kunjungan" => 'required',
            "time" => 'required',
            "dokter" => 'required',
            "poli" => 'required',
            "penjamin" => 'required',
            "no_reg" => 'required',
            "no_rawat" => 'required',
            "no_rm" => 'required',
            "nama_pasien" => 'required',
            "tgl_lahir" => 'required',
            "seks" => 'required',
            "telepon" => 'required',
        ]);

        $rad = new rajal();
        $rad->tgl_kunjungan = $data['tgl_kunjungan'];
        $rad->time = $data['time'];
        $rad->doctor_id = $data['dokter'];
        $rad->poli_id = $data['poli'];
        $rad->penjab_id = $data['penjamin'];
        $rad->no_reg = $data['no_reg'];
        $rad->no_rawat = $data['no_rawat'];
        $rad->no_rm = $data['no_rm'];
        $rad->nama_pasien = $data['nama_pasien'];
        $rad->tgl_lahir = $data['tgl_lahir'];
        $rad->seks = $data['seks'];
        $rad->telepon = $data['telepon'];
        $rad->status = 'Belum Periksa';
        $rad->status_lanjut = 'Rawat Jalan';
        $rad->stts_soap = '0';
        $rad->save();

        return redirect()->route('regis.rajal')->with('Success', 'Data Rawat Jalan berhasi di tambahkan');
    }

    public function rajaldestroy(Request $request ,$id)
    {
        $request->validate([
            'reason' => 'required|string'
        ]);

        // Cari data Rajal berdasarkan ID
        $rajal = rajal::findOrFail($id);


        $rajal->delete(); // Hapus data

        // Cari data antrean dari antiran_get berdasarkan no_rm dan no_reg dari Rajal
        $antrean = antiran_get::where('norm', $rajal->no_rm)
            ->where('no_reg', $rajal->no_reg)
            ->first();
        if ($antrean && $antrean->infoantrean !== 'offline-no-bpjs') {
        $pasien = $rajal->pasien->no_bpjs;
        $poli = $rajal->poli->kode_poli;
        $wsbpjsdata = [
            'nomorkartu' => $pasien,
            'kodepoli' => $poli,
            'tanggalperiksa' => now()->format('Y-m-d'),
            'keterangan' => $request->reason,
        ];
        $bpjsService = app(BpjsController::class);
        $bpjsService->get_ws_batal_bpjs($wsbpjsdata);
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function getKabupaten(Request $request)
    {
        $kodeProvinsi = $request->kode_provinsi;
        $kabupaten = Kabupaten::where('kode_provinsi', $kodeProvinsi)->get();

        return response()->json($kabupaten); // Return as JSON response
    }

    public function getKecamatan(Request $request)
    {
        $kodeKabupaten = $request->kode_kabupaten;
        $kecamatan = Kecamatan::where('kode_kabupaten', $kodeKabupaten)->get();

        return response()->json($kecamatan); // Return kecamatan as JSON
    }

    public function getDesa(Request $request)
    {
        $kodeKecamatan = $request->kode_kecamatan;
        $desa = Desa::where('kode_kecamatan', $kodeKecamatan)->get();

        return response()->json($desa); // Return desa as JSON
    }
}
