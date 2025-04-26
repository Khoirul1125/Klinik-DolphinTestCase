<?php

namespace App\Http\Controllers\Modules;

// use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\bangsal;
use App\Models\kontrol;
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
use App\Models\icd9;
use App\Models\icd10;
use App\Models\diet;
use App\Models\makan;
use App\Models\prosedur_pasien;
use App\Models\diagnosa_pasien;
use App\Models\rajal_pemeriksaan;
use App\Models\rajal_pemeriksaan_perawat;
use App\Models\rajal_layanan;
use App\Models\suberdaya;
use App\Models\rwy_penyakit_keluarga;
use App\Models\satuan;
use App\Models\obat_pasien;
use App\Models\barang_stok;
use App\Models\eye;
use App\Models\verbal;
use App\Models\motorik;
use App\Models\gcs_nilai;
use App\Models\goldar;
use App\Models\odontogram;
use App\Models\Odontogram_detail;
use App\Models\Provinsi;
use App\Models\soap_diet;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RegisController extends Controller
{
    public function index()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "obat";
        $penjab = penjab::all();
        $doctor = doctor::all();
        return view('regis.index', compact('title','penjab','doctor'));

    }


    public function filterDokter(Request $request)
    {
        $poli_id = $request->input('poli_id');
        $dokterQuery = doctor::where('aktivasi', 'aktif')->whereHas('details');

        if ($poli_id) {
            $dokterQuery->where('poli', $poli_id); // Filter berdasarkan poli_id
        }

        $dokter = $dokterQuery->get();

        return response()->json(['dokter' => $dokter]);
    }


    public function statusrajal(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:rajals,no_rm', // Adjust the table and column name as needed
            'status' => 'required|string'
        ]);
        $patient = rajal::where('no_rm', $request->id)->first();
        $patient->status = $request->status;
        $patient->save();

        return response()->json([
            'message' => 'Data Rawat Jalan berhasil ditambahkan'
        ]);
    }

    public function statuslanjut(Request $request)
    {
        $request->validate([
            'no_rm' => 'required|string',
            'nama' => 'required|string',
            'poliid' => 'required|string',
            'doctorid' => 'required|string',
            'penjabid' => 'required|string',
            'alamat' => 'required|string',
            'telepon' => 'required|string',
            'tanggal_rawat' => 'required|date',
            'status_ljt' => 'required|string',
        ]);



        $patient = rajal::where('no_rm', $request->no_rm)->first();
        $patient->status_lanjut = "Rawat Inap";
        $patient->save();

        return response()->json(['message' => $request->nama .' Berhasil di Pindahkan ke Rawat Inap']);

    }

    public function getDataByNoRawat(Request $request)
    {
        $no_rawat = $request->query('no_rawat'); // Ambil no_rawat dari query string

        $input_perawat = DB::table('rajal_pemeriksaan_perawats')
            ->where('no_rawat', $no_rawat)
            ->get();

        // Jika data ditemukan, kirimkan ke frontend
        if ($input_perawat->isNotEmpty()) {
            return response()->json(['input_perawat' => $input_perawat]);
        } else {
            return response()->json(['input_perawat' => []]);
        }
    }






    // Function to load data based on patient_id and treatment_id
    public function loadGigiData($patient_id, $treatment_id)
    {
        try {
            // Retrieve the data for the given patient_id and treatment_id
            $odontograms = Odontogram::where('patient_id', $patient_id)
                                     ->where('rawatt_id', urldecode($treatment_id))
                                     ->get();

            if ($odontograms->isEmpty()) {
                return response()->json(['message' => 'No data found for the specified patient and treatment.'], 404);
            }

            // Return the loaded data
            return response()->json([
                'message' => 'Data loaded successfully.',
                'toothData' => $odontograms,
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            return response()->json(['message' => 'An error occurred while loading data.'], 500);
        }
    }









    public function diet($norm)
    {
        $no_rawat = base64_decode($norm);
        $setweb = setweb::first(); // Pastikan ini sudah benar
        $title = $setweb->name_app . " - " . "diet";
        $rajaldata = rajal::with(['penjab'])->where('no_rawat', $no_rawat)->first();
        $tgl_lahir = Carbon::createFromFormat('Y-m-d', $rajaldata->tgl_lahir);
        $umur = $tgl_lahir->age;
        $jenisdiet = diet::all();
        $maknana = makan::all();
        return view('regis.diet', compact('title','rajaldata','umur','tgl_lahir','jenisdiet','maknana'));
    }

    public function indexdiet()
    {
        $diets = soap_diet::all();

        if ($diets->isEmpty()) {
            return response()->json(['message' => 'Tidak ada data diet ditemukan.'], 200);
        }

        // Pastikan semua data dalam array, bukan JSON string
        foreach ($diets as $diet) {
            $diet->jenis_makanan = json_decode($diet->jenis_makanan, true) ?? [];
            $diet->jenis_tidak_boleh_dimakan = json_decode($diet->jenis_tidak_boleh_dimakan, true) ?? [];
        }

        return response()->json($diets);
    }

    public function storediet(Request $request)
    {
        \Log::info("Data yang diterima di API:", $request->all());

        if (!$request->has('diets')) {
            return response()->json(['error' => 'Data diet tidak ditemukan.'], 400);
        }

        $savedDiets = [];

        foreach ($request->diets as $dietData) {
            \Log::info("Data diet yang diterima:", $dietData);

            if (!isset($dietData['patient_id']) || !isset($dietData['rawatt_id'])) {
                return response()->json(['error' => 'Patient ID atau Rawat ID tidak boleh kosong.'], 400);
            }

            $diet = soap_diet::updateOrCreate(
                [
                    'patient_id' => $dietData['patient_id'],
                    'rawatt_id' => $dietData['rawatt_id'],
                    'jenis_diet' => $dietData['jenis_diet']
                ],
                [
                    'jenis_makanan' => json_encode($dietData['jenis_makanan'] ?? []),
                    'jenis_tidak_boleh_dimakan' => json_encode($dietData['jenis_tidak_boleh_dimakan'] ?? []),
                ]
            );

            $savedDiets[] = $diet;
        }

        return response()->json(['message' => 'Data berhasil disimpan.', 'diets' => $savedDiets]);
    }

    public function destroydiet($id)
    {
        $diet = soap_diet::findOrFail($id);
        $diet->delete();

        return response()->json(['message' => 'Data berhasil dihapus']);
    }

    public function removeItemdiet(Request $request, $id)
    {
        // Cek apakah ID valid
        $diet = soap_diet::find($id);

        if (!$diet) {
            return response()->json(['error' => 'Data diet tidak ditemukan.'], 404);
        }

        // Pastikan input tidak null
        if (!$request->has('item') || !$request->has('type')) {
            return response()->json(['error' => 'Data tidak lengkap.'], 400);
        }

        $jenis_makanan = json_decode($diet->jenis_makanan, true) ?? [];
        $jenis_tidak_boleh_dimakan = json_decode($diet->jenis_tidak_boleh_dimakan, true) ?? [];

        if ($request->type === "makanan") {
            $jenis_makanan = array_values(array_filter($jenis_makanan, function ($item) use ($request) {
                return $item !== $request->item;
            }));
        } else if ($request->type === "tidak_boleh") {
            $jenis_tidak_boleh_dimakan = array_values(array_filter($jenis_tidak_boleh_dimakan, function ($item) use ($request) {
                return $item !== $request->item;
            }));
        } else {
            return response()->json(['error' => 'Tipe data tidak valid.'], 400);
        }

        // Update data
        $diet->update([
            'jenis_makanan' => json_encode($jenis_makanan),
            'jenis_tidak_boleh_dimakan' => json_encode($jenis_tidak_boleh_dimakan),
        ]);

        return response()->json(['message' => 'Item berhasil dihapus']);
    }







    public function updateDoctor(Request $request, $id)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
    ]);

    $data = Rajal::findOrFail($id);
    $data->doctor_id = $request->doctor_id;
    $data->save();

    return redirect()->back()->with('success', 'Dokter berhasil diperbarui!');
}


    public function storeProsedur(Request $request)
    {
        $request->validate([
            'no_rawat' => 'required',
            'kode' => 'required',
            'prioritas' => 'required',
        ]);

        try {
            // Simpan data ke model prosedur_pasien
            $prosedur = new prosedur_pasien();
            $prosedur->no_rawat = $request->no_rawat;
            $prosedur->kode = $request->kode;
            $prosedur->prioritas = $request->prioritas;
            $prosedur->status = 'Rawat Jalan'; // Add any other field you want to save
            $prosedur->save();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroyProsedur(Request $request)
    {
        try {
            // Find the record by ID and delete it
            $prosedur = prosedur_pasien::find($request->id);

            if ($prosedur) {
                $prosedur->delete();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Data not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function storeDiagnosa(Request $request)
    {
        $request->validate([
            'no_rawat' => 'required',
            'kode' => 'required',
            'prioritas' => 'required',
        ]);

        try {
            // Create a new diagnosa_pasien record
            $diagnosa = new diagnosa_pasien();
            $diagnosa->no_rawat = $request->no_rawat;
            $diagnosa->kode = $request->kode;
            $diagnosa->status = 'Rawat Jalan';
            $diagnosa->prioritas = $request->prioritas;
            $diagnosa->status_penyakit = 'Baru';
            $diagnosa->save();

            return response()->json(['success' => true, 'id' => $diagnosa->id]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function destroyDiagnosa(Request $request)
    {
        try {
            // Find the record by ID and delete it
            $diagnosa = diagnosa_pasien::find($request->id);

            if ($diagnosa) {
                $diagnosa->delete();
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false, 'message' => 'Data not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }










    public function searchPasienRajal(Request $request)
    {
        // Ambil parameter nama dari request
        $query = $request->input('nama');

        // Cari pasien berdasarkan nama (case insensitive) dan eager load relasi 'seks'
        $pasiens = Pasien::query()
        ->where(function ($q) use ($query) {
            $q->where('nama', 'LIKE', "%$query%")
              ->orWhere('no_rm', 'LIKE', "%$query%")
              ->orWhere('no_bpjs', 'LIKE', "%$query%")
              ->orWhere('nik', 'LIKE', "%$query%");
        })
        ->with('seks') // Eager loading relasi 'seks'
        ->get();

        // $pasiens = Pasien::where('nama', 'LIKE', '%' . $nama . '%')->with('seks')->get();

        // Kembalikan hasil dalam format JSON
        return response()->json($pasiens);
    }

    public function generateNoRegRajal()
    {
        // Mendapatkan tanggal hari ini
        $today = date('Y-m-d');

        // Mencari data registrasi terakhir yang dibuat hari ini
        $lastReg = rajal::whereDate('created_at', $today)->orderBy('no_reg', 'desc')->first();

        if ($lastReg) {
            // Jika ada registrasi pada hari ini, tambahkan 1
            $lastNoReg = intval($lastReg->no_reg);
            $newNoReg = str_pad($lastNoReg + 1, 3, '0', STR_PAD_LEFT);
        } else {
            // Jika tidak ada, mulai dari 001
            $newNoReg = '001';
        }

        // Mengirim nomor registrasi baru ke frontend
        return response()->json(['no_reg' => $newNoReg]);
    }

    public function generateNoRawatRajal()
    {
        // Memanggil fungsi generateNoReg() dan menangkap respons JSON
        $noRegResponse = $this->generateNoRegRajal();

        // Mengambil no_reg dari respons JSON
        $noRegArray = json_decode($noRegResponse->getContent(), true);
        $noReg = $noRegArray['no_reg'];

        // Mendapatkan tanggal hari ini dengan format yyyy/mm/dd
        $today = date('Y/m/d');

        // Buat format nomor rawat baru: yyyy/mm/dd/no_reg
        $noRawat = $today . '/' . $noReg;

        // Return response sebagai JSON
        return response()->json(['no_rawat' => $noRawat]);
    }








    public function kontrol($norm)
    {
        $setweb = setweb::first(); // Pastikan ini sudah benar
        $title = $setweb->name_app . " - " . "kontrol";
        $rajaldata = rajal::where('no_rm', $norm)->first();
        $kontrol = kontrol::all();

        if (!$rajaldata) {
            return redirect()->back()->with('error', 'Data pasien tidak ditemukan ');
        }

        return view('regis.kontrol', compact('title','rajaldata','kontrol'));
    }

    public function kontroladd(Request $request)
    {
        $data = $request->validate([
            "diagnosa" => 'required',
            "tindakan" => 'required',
            "alasan_kontrol" => 'required',
            "rencana_tindak_lanjut" => 'required',
            "tgl_datang" => 'required',
        ]);
        $kontrol = new kontrol();
        $kontrol->diagnosa =  $request->diagnosa;
        $kontrol->tindakan =  $request->tindakan;
        $kontrol->alasan_kontrol =  $request->alasan_kontrol;
        $kontrol->rencana_tindak_lanjut =  $request->rencana_tindak_lanjut;
        $kontrol->tgl_datang =  $request->tgl_datang;
        $kontrol->save();

        // Mengalihkan ke route yang benar
        return redirect()->route('regis.kontrol', ['norm' => $request->no_rm])->with('success', 'Data kontrol berhasil ditambahkan');
    }

    public function cariNoRM(Request $request)
    {
        // Validasi No. RM
        $request->validate([
            'no_rm' => 'required|string',
        ]);

        // Mencari pasien berdasarkan No. RM
        $pasien = Pasien::where('no_rm', $request->no_rm)->first();

        if ($pasien) {
            // Mengembalikan data pasien dalam format JSON
            return response()->json([
                'status' => 'success',
                'data' => [
                    'nama' => $pasien->nama,
                    'alamat' => $pasien->Alamat,
                    'telepon' => $pasien->telepon,
                ]
            ]);
        }

        // Jika pasien tidak ditemukan
        return response()->json([
            'status' => 'error',
            'message' => 'Pasien tidak ditemukan.',
        ]);
    }

}
