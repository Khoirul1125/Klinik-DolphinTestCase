<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\BpjsController;
use App\Models\setweb;
use App\Http\Controllers\Controller;
use App\Models\bahasa;
use App\Models\bangsa;
use App\Models\data_doctor;
use App\Models\doctor;
use App\Models\doctor_visit;
use App\Models\faktur_apotek;
use App\Models\goldar;
use App\Models\history_quota;
use App\Models\spesiali;
use App\Models\poli;
use App\Models\jabatan;
use App\Models\pasien;
use App\Models\Provinsi;
use App\Models\rajal;
use App\Models\schedule_dokter;
use App\Models\statdok;
use App\Models\User;
use App\Models\seks;
use App\Models\suku;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{


    public function index()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app . " - " . Auth::user()->name;

        return view('doctor.dashboard', compact('title'));
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





    public function spesiali()
    {
        $setweb = setweb::first();
        $data = Spesiali::all();
        $title = $setweb->name_app ." - "." Spesialis "." - ". "Doctor";

        return view('doctor.spesiali', compact('title','data'));
    }

    public function spesialiadd(Request $request)
    {
        $data = $request->validate([
            "nama" => 'required|string|max:255',
            "kode" => 'required|unique:spesialis,kode',
        ]);

        spesiali::create($data);

        return redirect()->route('doctor.spesiali')->with('success', 'data spesialis berhasi di tambahkan');
    }

    public function visitdocter()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Doctor";
        $doctors = Doctor::all();
        return view('doctor.visit', compact('title','doctors'));
    }


    public function poli()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Tambah Poli";
        $data = poli::all();
        return view('doctor.poli', compact('title','data'));
    }

    public function update_poli_bpjs(Request $request)
    {
        // Call the get_poli_fktp_bpjs method
        $bpjsController = new BpjsController();
        $response = $bpjsController->get_poli_fktp_bpjs();

        // Check if the response is successful
        if ($response->getStatusCode() == 200) {
            $responseData = json_decode($response->getContent(), true);

            // Insert the data into the database
            foreach ($responseData['data'] as $practitioner) {
                // Check if the practitioner already exists
                $existingPractitioner = poli::where('nama_poli', $practitioner['nama_poli'])->first();
                if (!$existingPractitioner) {
                    // If it doesn't exist, save the new record
                    $newPractitioner = new poli();
                    $newPractitioner->kode_poli = $practitioner['kode_poli'];
                    $newPractitioner->nama_poli = $practitioner['nama_poli'];
                    $newPractitioner->jenis_poli = $practitioner['jenis_poli'];
                    $newPractitioner->status = 'aktif';
                    $newPractitioner->save();
                } else {
                    // Optionally, update the existing record
                    $existingPractitioner->kode_poli = $practitioner['kode_poli'];
                    $existingPractitioner->nama_poli = $practitioner['nama_poli'];
                    $existingPractitioner->jenis_poli = $practitioner['jenis_poli'];
                    $existingPractitioner->status = 'aktif';
                    $existingPractitioner->save();
                }
            }
        } else {
            return response()->json(['status' => 'error', 'message' => 'Failed to fetch data from BPJS'], 400);
        }

        return redirect()->route('doctor.poli')->with('success', 'Data poli berhasil diperbarui');
    }

    public function jabatan()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Tambah Poli";
        $jabatan = jabatan::all();
        return view('doctor.jabatan', compact('title','jabatan'));
    }

    public function jabatanadd(Request $request)
    {
        try {
            // Validasi input data
            $data = $request->validate([
                "nama" => 'required|unique:jabatans,nama',
            ]);

            // Jika validasi berhasil, simpan data
            jabatan::create($data);

            // Redirect dengan pesan sukses
            return redirect()->route('doctor.jabatan')->with('Success', 'Jabatan berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap pengecualian validasi dan kembali ke halaman sebelumnya dengan alert pesan gagal
            return redirect()->back()
                ->with('error', 'Gagal menambahkan, nama sudah ada!')
                ->withErrors($e->validator)
                ->withInput();
        }
    }


    public function status()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Tambah Poli";
        $status = statdok::all();
        return view('doctor.status', compact('title','status'));
    }

    public function statusadd(Request $request)
    {
        try {
            // Validasi input data
            $data = $request->validate([
                "nama" => 'required|unique:statdoks,nama',
            ]);

            // Jika validasi berhasil, simpan data
            statdok::create($data);

            // Redirect dengan pesan sukses
            return redirect()->route('doctor.status')->with('Success', 'Status Dokter berhasil ditambahkan');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Tangkap pengecualian validasi dan kembali ke halaman sebelumnya dengan alert pesan gagal
            return redirect()->back()
                ->with('error', 'Gagal menambahkan, nama sudah ada!')
                ->withErrors($e->validator)
                ->withInput();
        }
    }



    public function home()
    {
        $title = 'Rs Apps';
        return view('admin.index', compact('title'));
    }
}
