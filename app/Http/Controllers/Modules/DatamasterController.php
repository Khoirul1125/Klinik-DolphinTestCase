<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\setweb;
use App\Models\poli;
use App\Models\katper;
use App\Models\satuan;
use App\Models\jenbar;
use App\Models\industri;
use App\Models\dabar;
use App\Models\perjal;
use App\Models\penjab;
use App\Models\bank;
use App\Models\icd10;
use App\Models\icd9;
use App\Models\posker;
use App\Models\seks;
use App\Models\goldar;
use App\Models\suku;
use App\Models\bangsa;
use App\Models\bahasa;
use App\Models\diet;
use App\Models\dphobarang;
use App\Models\headtotoe_pemeriksaan;
use App\Models\headtotoe_sub_pemeriksaan;
use App\Models\makan;
use App\Models\data_lama_pemeriksaan;

class DatamasterController extends Controller
{
    public function index()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Data Master";
        return compact('title');
    }

    public function seks()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Patient";
        $seks = seks::all();
        return view('patient.seks', compact('title','seks'));
    }

    public function seksadd(Request $request)
    {
        $data = $request->validate([
            "nama" => 'required|string|max:255',
            "kode" => 'required|unique:seks,kode',
        ]);

        seks::create($data);

        return redirect()->route('patient.seks')->with('Success', 'Data seks berhasi di tambahkan');
    }

    public function seksUpdate(Request $request, $id)
    {
        $request->validate([
            'kode_update' => 'required',
            'nama_update' => 'required',
        ]);

        $data = seks::find($id);
        $data->kode = $request->kode_update;
        $data->nama = $request->nama_update;
        $data->save();

        return redirect()->route('patient.seks')->with('Success', 'Data berhasil diperbarui');
    }

    public function seksDestroy($id)
    {
        $data = seks::find($id);
        $data->delete();

        return redirect()->route('patient.seks')->with('Success', 'Data berhasil dihapus');
    }

    public function goldar()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Patient";
        $goldar = goldar::all();
        return view('patient.goldar', compact('title','goldar'));
    }

    public function goldaradd(Request $request)
    {
        $data = $request->validate([
            "nama" => 'required',
            "resus" => 'required',
        ]);

        goldar::create($data);

        return redirect()->route('patient.goldar')->with('Success', 'Data golongan darah berhasil di tambahkan');
    }

    public function goldarUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_update' => 'required',
            'resus_update' => 'required',
        ]);

        $data = goldar::find($id);
        $data->nama = $request->nama_update;
        $data->resus = $request->resus_update;
        $data->save();

        return redirect()->route('patient.goldar')->with('Success', 'Data berhasil diperbarui');
    }

    public function goldarDestroy($id)
    {
        $data = goldar::find($id);
        $data->delete();

        return redirect()->route('patient.goldar')->with('Success', 'Data berhasil dihapus');
    }

    public function suku()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Tambah Suku";
        $suku = suku::all();
        return view('patient.suku', compact('title','suku'));
    }

    public function sukuadd(Request $request)
    {
        $data = $request->validate([
            "nama_suku" => 'required',
        ]);

        suku::create($data);

        return redirect()->route('patient.suku')->with('Success', 'Suku berhasil di tambahkan');
    }

    public function sukuUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_update' => 'required',
        ]);

        $data = suku::find($id);
        $data->nama_suku = $request->nama_update;
        $data->save();

        return redirect()->route('patient.suku')->with('Success', 'Data berhasil diperbarui');
    }

    public function sukuDestroy($id)
    {
        $data = suku::find($id);
        $data->delete();

        return redirect()->route('patient.suku')->with('Success', 'Data berhasil dihapus');
    }

    public function bangsa()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Tambah Bangsa";
        $bangsa = bangsa::all();
        return view('patient.bangsa', compact('title','bangsa'));
    }

    public function bangsaadd(Request $request)
    {
        $data = $request->validate([
            "nama_bangsa" => 'required',
        ]);

        bangsa::create($data);

        return redirect()->route('patient.bangsa')->with('Success', 'Bangsa berhasil di tambahkan');
    }

    public function bangsaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_update' => 'required',
        ]);

        $data = bangsa::find($id);
        $data->nama_bangsa = $request->nama_update;
        $data->save();

        return redirect()->route('patient.bangsa')->with('Success', 'Data berhasil diperbarui');
    }

    public function bangsaDestroy($id)
    {
        $data = bangsa::find($id);
        $data->delete();

        return redirect()->route('patient.bangsa')->with('Success', 'Data berhasil dihapus');
    }

    public function bahasa()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Tambah Bahasa";
        $bahasa = bahasa::all();
        return view('patient.bahasa', compact('title','bahasa'));
    }

    public function bahasaadd(Request $request)
    {
        $data = $request->validate([
            "bahasa" => 'required',
        ]);

        bahasa::create($data);

        return redirect()->route('patient.bahasa')->with('Success', 'Bahasa berhasil di tambahkan');
    }

    public function bahasaUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_update' => 'required',
        ]);

        $data = bahasa::find($id);
        $data->bahasa = $request->nama_update;
        $data->save();

        return redirect()->route('patient.bahasa')->with('Success', 'Data berhasil diperbarui');
    }

    public function bahasaDestroy($id)
    {
        $data = bahasa::find($id);
        $data->delete();

        return redirect()->route('patient.bahasa')->with('Success', 'Data berhasil dihapus');
    }


    public function dabar()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kelola Data Barang";
        $satuan = satuan::all();
        $jenis = jenbar::all();
        $industri = industri::all();
        $data = dabar::with(['satuan','satuan_sedangs','satuan_besars','jenbar'])->get();
        return view('datamaster.dabar', compact('title','satuan','jenis','industri','data'));
    }

    public function searchObat(Request $request)
    {
        $query = $request->input('query'); // Dapatkan query pencarian

        if (!$query) {
            return response()->json([
                'status' => 'error',
                'message' => 'Query tidak boleh kosong'
            ], 400);
        }

        // Cari obat berdasarkan kode_barang atau nama_barang
        $obat = dphobarang::where('kode_barang', 'LIKE', "%$query%")
            ->orWhere('nama_barang', 'LIKE', "%$query%")
            ->get();

        if ($obat->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Obat tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $obat
        ]);
    }

    public function dabaradd(Request $request)
    {
        $data = $request->validate([
            "kode_barang" => 'required',
            "dpho_kode" =>  'required',
            "nama_dpho" =>  'required',
            "formularium" => 'required',
            "nama_barang" => 'required|max:255',
            "kfa_kode" => 'required|max:255',
            "h_dasar" => 'required|max:255',
            "kode_satkec" => 'required|max:255',
            "satuan_sedang" => 'required|max:255',
            "kode_satuan_sedang" => 'required|max:255',
            "satuan_besar" => 'required|max:255',
            "kode_satuan_besar" => 'required|max:255',
            "penyimpanan" => 'required|max:255',
            "barcode" => 'required|max:255',
            "kode_idn" => 'required|max:255',
            "kode_jenis" => 'required|max:255',
            "nama_generik" => 'required|max:255',
            "bentuk_kesediaan" => 'required|max:255',
            "dosis" => 'required|max:255',
            "kode_dosis" => 'required|max:255',
        ]);

        $dabar = new dabar();
        $dabar->kode = $data['kode_barang'];
        $dabar->formularium = $data['formularium'];
        $dabar->nama = $data['nama_barang'];
        $dabar->kode_dpho = $data['dpho_kode'];
        $dabar->nama_dpho = $data['nama_dpho'];
        $dabar->kode_kfa = $data['kfa_kode'];
        $dabar->harga_dasar = $data['h_dasar'];
        $dabar->satuan_id = $data['kode_satkec'];
        $dabar->satuan_sedang = $data['satuan_sedang'];
        $dabar->kode_satuan_sedang = $data['kode_satuan_sedang'];
        $dabar->satuan_besar = $data['satuan_besar'];
        $dabar->kode_satuan_besar = $data['kode_satuan_besar'];
        $dabar->penyimpanan = $data['penyimpanan'];
        $dabar->barcode = $data['barcode'];
        $dabar->industri = $data['kode_idn'];
        $dabar->jenbar_id = $data['kode_jenis'];
        $dabar->nama_generik = $data['nama_generik'];
        $dabar->bentuk_kesediaan = $data['bentuk_kesediaan'];
        $dabar->dosis = $data['dosis'];
        $dabar->kode_dosis = $data['kode_dosis'];
        $dabar->save();

        // $bhp = new bhp();
        // $bhp->kode = $data['kode_barang'];
        // $bhp->nama = $data['nama_barang'];
        // $bhp->harga_dasar = $data['harga_dasar'];
        // $bhp->harga_beli = $data['harga_beli'];
        // $bhp->expired = $data['expired'];
        // $bhp->save();

        return redirect()->route('datmas.dabar')->with('Success', 'Data Barang berhasi di tambahkan');
    }

    public function generateKodeBarang()
    {
        // Ambil kode barang terakhir dari database
        $lastDabar = Dabar::orderBy('kode', 'desc')->first();

        // Tentukan kode barang pertama jika belum ada data
        if (!$lastDabar) {
            $kodeBaru = 'B00001';
        } else {
            // Ambil angka terakhir dari kode barang (misal: B00001 -> 1)
            $lastKodeNumber = (int)substr($lastDabar->kode, 1);

            // Tambah 1 ke angka terakhir
            $newKodeNumber = $lastKodeNumber + 1;

            // Format kode baru (B diikuti oleh angka dengan padding 0 menjadi 5 digit)
            $kodeBaru = 'B' . str_pad($newKodeNumber, 5, '0', STR_PAD_LEFT);
        }

        // Kirim kode baru sebagai response JSON
        return response()->json(['kode_barang' => $kodeBaru]);
    }


    public function katper()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kelola Kategori Perawatan";
        $data = katper::all();
        return view('datamaster.katper', compact('title','data'));
    }

    public function katperadd(Request $request)
    {
        $data = $request->validate([
            "kode_rawatan" => 'required',
            "nama_rawatan" => 'required',
        ]);
        katper::create($data);
        return redirect()->route('datmas.katper')->with('Success', 'Kategori Perawatan berhasi di tambahkan');
    }

    public function getNextKodekatper(Request $request) {
        $kodePrefix = 'KP'; // Awalan kode
        $kodeAwal = '001'; // Kode awal jika belum ada data

        // Ambil kode pemeriksaan terakhir berdasarkan prefix "H"
        $lastSubPemeriksaan = katper::where('kode_rawatan', 'like', $kodePrefix . '%')
            ->orderBy('kode_rawatan', 'desc')
            ->first();

        if ($lastSubPemeriksaan) {
            // Ambil angka terakhir dari kode (contoh: "H005" -> "005")
            $lastNumber = intval(substr($lastSubPemeriksaan->kode_rawatan, strlen($kodePrefix)));

            // Tambah 1 untuk mendapatkan kode berikutnya
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Format 3 digit
        } else {
            $nextNumber = $kodeAwal; // Jika belum ada data, gunakan H001
        }

        $nextKode = $kodePrefix . $nextNumber;

        return response()->json(['next_kode' => $nextKode]);
    }

    public function katperUpdate(Request $request, $id)
    {
        $request->validate([
            'kode_rawatan' => 'required',
            'nama_rawatan' => 'required',
        ]);

        $kategori = katper::find($id);
        $kategori->kode_rawatan = $request->kode_rawatan;
        $kategori->nama_rawatan = $request->nama_rawatan;
        $kategori->save();

        return redirect()->route('datmas.katper')->with('Success', 'Data berhasil diperbarui');
    }

    public function katperDestroy($id)
    {
        $kategori = katper::find($id);
        $kategori->delete();

        return redirect()->route('datmas.katper')->with('Success', 'Data berhasil dihapus');
    }

    public function satuan()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kelola Kode Satuan";
        $data = satuan::all();
        return view('datamaster.satuan', compact('title','data'));
    }

    public function satuanadd(Request $request)
    {
        $data = $request->validate([
            "kode_satuan" => 'required',
            "nama_satuan" => 'required',
        ]);
        satuan::create($data);
        return redirect()->route('datmas.satuan')->with('Success', 'Kode Satuan berhasi di tambahkan');
    }

    public function getNextKodesatuan(Request $request) {
        $kodePrefix = 'ST'; // Awalan kode
        $kodeAwal = '001'; // Kode awal jika belum ada data

        // Ambil kode pemeriksaan terakhir berdasarkan prefix "H"
        $lastSubPemeriksaan = satuan::where('kode_satuan', 'like', $kodePrefix . '%')
            ->orderBy('kode_satuan', 'desc')
            ->first();

        if ($lastSubPemeriksaan) {
            // Ambil angka terakhir dari kode (contoh: "H005" -> "005")
            $lastNumber = intval(substr($lastSubPemeriksaan->kode_satuan, strlen($kodePrefix)));

            // Tambah 1 untuk mendapatkan kode berikutnya
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Format 3 digit
        } else {
            $nextNumber = $kodeAwal; // Jika belum ada data, gunakan H001
        }

        $nextKode = $kodePrefix . $nextNumber;

        return response()->json(['next_kode' => $nextKode]);
    }

    public function satuanUpdate(Request $request, $id)
    {
        $request->validate([
            'kode_satuan' => 'required',
            'nama_satuan' => 'required',
        ]);

        $data = satuan::find($id);
        $data->kode_satuan = $request->kode_satuan;
        $data->nama_satuan = $request->nama_satuan;
        $data->save();

        return redirect()->route('datmas.satuan')->with('Success', 'Data berhasil diperbarui');
    }

    public function satuanDestroy($id)
    {
        $data = satuan::find($id);
        $data->delete();

        return redirect()->route('datmas.satuan')->with('Success', 'Data berhasil dihapus');
    }

    public function jenbar()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kelola Jenis Barang";
        $data = jenbar::all();
        return view('datamaster.jenbar', compact('title','data'));
    }

    public function jenbaradd(Request $request)
    {
        $data = $request->validate([
            "nama_jenbar" => 'required',
        ]);
        jenbar::create($data);
        return redirect()->route('datmas.jenbar')->with('Success', 'Jenis Barang berhasi di tambahkan');
    }

    public function jenbarUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_jenbar' => 'required',
        ]);

        $data = jenbar::find($id);
        $data->nama_jenbar = $request->nama_jenbar;
        $data->save();

        return redirect()->route('datmas.jenbar')->with('Success', 'Data berhasil diperbarui');
    }

    public function jenbarDestroy($id)
    {
        $data = jenbar::find($id);
        $data->delete();

        return redirect()->route('datmas.jenbar')->with('Success', 'Data berhasil dihapus');
    }

    public function industri()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kelola Jenis Barang";
        $data = industri::all();
        return view('datamaster.industri', compact('title','data'));
    }

    public function getNextKodeindustri(Request $request) {
        $kodePrefix = 'S'; // Awalan kode
        $kodeAwal = '001'; // Kode awal jika belum ada data

        // Ambil kode pemeriksaan terakhir berdasarkan prefix "H"
        $lastSubPemeriksaan = industri::where('kode_industri', 'like', $kodePrefix . '%')
            ->orderBy('kode_industri', 'desc')
            ->first();

        if ($lastSubPemeriksaan) {
            // Ambil angka terakhir dari kode (contoh: "H005" -> "005")
            $lastNumber = intval(substr($lastSubPemeriksaan->kode_industri, strlen($kodePrefix)));

            // Tambah 1 untuk mendapatkan kode berikutnya
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Format 3 digit
        } else {
            $nextNumber = $kodeAwal; // Jika belum ada data, gunakan H001
        }

        $nextKode = $kodePrefix . $nextNumber;

        return response()->json(['next_kode' => $nextKode]);
    }


    public function industriadd(Request $request)
    {
        $data = $request->validate([
            "kode_industri" => 'required',
            "nama_industri" => 'required',
            "Alamat" => 'required',
            "PIC" => 'required',
            "telepon" => 'required',
        ]);
        industri::create($data);
        return redirect()->route('datmas.industri')->with('Success', 'Data Industri Farmasi berhasi di tambahkan');
    }


    public function penjab()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kelola Jenis Barang";
        $data = penjab::all();
        return view('datamaster.penjab', compact('title','data'));
    }

    public function getNextKodepenjab(Request $request) {
        $kodePrefix = 'P'; // Awalan kode
        $kodeAwal = '001'; // Kode awal jika belum ada data

        // Ambil kode pemeriksaan terakhir berdasarkan prefix "H"
        $lastSubPemeriksaan = penjab::where('kode', 'like', $kodePrefix . '%')
            ->orderBy('kode', 'desc')
            ->first();

        if ($lastSubPemeriksaan) {
            // Ambil angka terakhir dari kode (contoh: "H005" -> "005")
            $lastNumber = intval(substr($lastSubPemeriksaan->kode, strlen($kodePrefix)));

            // Tambah 1 untuk mendapatkan kode berikutnya
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Format 3 digit
        } else {
            $nextNumber = $kodeAwal; // Jika belum ada data, gunakan H001
        }

        $nextKode = $kodePrefix . $nextNumber;

        return response()->json(['next_kode' => $nextKode]);
    }

    public function penjabadd(Request $request)
    {
        $data = $request->validate([
            "kode_penjab" => 'required',
            "nama_penjab" => 'required',
            "nama_perusahaan" => 'required',
            "Alamat" => 'required',
            "telepon" => 'required',
            "attn" => 'required',
            "status" => 'required',
        ]);

        $penjab = new penjab();
        $penjab->kode = $data['kode_penjab'];
        $penjab->pj = $data['nama_penjab'];
        $penjab->nama = $data['nama_perusahaan'];
        $penjab->alamat = $data['Alamat'];
        $penjab->telp = $data['telepon'];
        $penjab->attn = $data['attn'];
        $penjab->status = $data['status'];
        $penjab->save();

        return redirect()->route('datmas.penjab')->with('Success', 'Data Penanggung Jawab berhasi di tambahkan');
    }

    public function penjabUpdate(Request $request, $id)
    {
        $request->validate([
            'kode_penjab_update' => 'required',
            'nama_penjab_update' => 'required',
            'nama_perusahaan_update' => 'required',
            'Alamat_update' => 'required',
            'telepon_update' => 'required',
            'attn_update' => 'required',
            'status_update' => 'required',
        ]);

        $data = penjab::find($id);
        $data->kode = $request->kode_penjab_update;
        $data->pj = $request->nama_penjab_update;
        $data->nama = $request->nama_perusahaan_update;
        $data->alamat = $request->Alamat_update;
        $data->telp = $request->telepon_update;
        $data->attn = $request->attn_update;
        $data->status = $request->status_update;
        $data->save();

        return redirect()->route('datmas.penjab')->with('Success', 'Data berhasil diperbarui');
    }

    public function penjabDestroy($id)
    {
        $data = penjab::find($id);
        $data->delete();

        return redirect()->route('datmas.penjab')->with('Success', 'Data berhasil dihapus');
    }


    public function perjal()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kelola Jenis Barang";
        $katper = katper::all();
        $poli = poli::all();
        $penjab = penjab::all();
        $data = perjal::with(['katper','poli'])->get();
        return view('datamaster.perjal', compact('title','katper','poli','penjab','data'));
    }

    public function perjaladd(Request $request)
    {
        $data = $request->validate([
            "kode_perjal" => 'required',
            "nama_perjal" => 'required',
            "kategori" => 'required',
            "tarif_dokter" => 'required',
            "tarif_perawat" => 'required',
            "total_tarif" => 'required',
            "penjab" => 'required',
            "poli" => 'required',
            "status" => 'required',
        ]);

        $perjal = new perjal();
        $perjal->kode = $data['kode_perjal'];
        $perjal->nama = $data['nama_perjal'];
        $perjal->katper_id = $data['kategori'];
        $perjal->tarifdok = $data['tarif_dokter'];
        $perjal->tarifper = $data['tarif_perawat'];
        $perjal->total = $data['total_tarif'];
        $perjal->penjab_id = $data['penjab'];
        $perjal->poli_id = $data['poli'];
        $perjal->status = $data['status'];
        $perjal->save();

        return redirect()->route('datmas.perjal')->with('Success', 'Data Perawatan Rawat Jalan berhasi di tambahkan');
    }

    public function perjalUpdate(Request $request, $id)
    {
        $request->validate([
            "kode_perjal_update" => 'required',
            "nama_perjal_update" => 'required',
            "kategori_update" => 'required',
            "tarif_dokter_update" => 'required',
            "tarif_perawat_update" => 'required',
            "total_tarif_update" => 'required',
            "penjab_update" => 'required',
            "poli_update" => 'required',
            "status_update" => 'required',
        ]);

        $data = perjal::find($id);
        $data->kode = $request->kode_perjal_update;
        $data->nama = $request->nama_perjal_update;
        $data->katper_id = $request->kategori_update;
        $data->tarifdok = $request->tarif_dokter_update;
        $data->tarifper = $request->tarif_perawat_update;
        $data->total = $request->total_tarif_update;
        $data->penjab_id = $request->penjab_update;
        $data->poli_id = $request->poli_update;
        $data->status = $request->status_update;
        $data->save();

        return redirect()->route('datmas.perjal')->with('Success', 'Data berhasil diperbarui');
    }

    public function perjalDestroy($id)
    {
        $data = perjal::find($id);
        $data->delete();

        return redirect()->route('datmas.perjal')->with('Success', 'Data berhasil dihapus');
    }

    public function generateKodePerjal()
    {
        // Mengambil item terbaru berdasarkan kode barang
        $lastBarang = perjal::orderBy('kode', 'desc')->first();

        // Jika tidak ada data, mulai dengan RJ001
        if (!$lastBarang || !preg_match('/^RJ\d{3}$/', $lastBarang->kode)) {
            $newKode = 'RJ001';
        } else {
            // Ambil angka terakhir dari kode, misalnya RJ001 -> 001
            $lastKode = intval(substr($lastBarang->kode, 2));

            // Tambahkan 1 pada angka terakhir dan format menjadi 3 digit
            $newKode = 'RJ' . str_pad($lastKode + 1, 3, '0', STR_PAD_LEFT);
        }

        // Return response JSON
        return response()->json(['kode_perjal' => $newKode]);
    }

    public function bank()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Kelola Data Bank";
        $data = bank::all();
        return view('datamaster.bank', compact('title','data'));
    }

    public function bankadd(Request $request)
    {
        $data = $request->validate([
            "nama" => 'required',
        ]);
        bank::create($data);
        return redirect()->route('datmas.bank')->with('Success', 'Data Bank berhasi di tambahkan');
    }

    public function bankUpdate(Request $request, $id)
    {
        $request->validate([
            'nama_update' => 'required',
        ]);

        $data = bank::find($id);
        $data->nama = $request->nama_update;
        $data->save();

        return redirect()->route('datmas.bank')->with('Success', 'Data berhasil diperbarui');
    }

    public function bankDestroy($id)
    {
        $data = bank::find($id);
        $data->delete();

        return redirect()->route('datmas.bank')->with('Success', 'Data berhasil dihapus');
    }

    public function icd()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "rujukan ";
        $icd9 = icd9::all();
        $icd10 = icd10::all();
        return view('datamaster.icd', compact('title','icd9','icd10'));
    }

    public function icd9add(Request $request)
    {
        $data = $request->validate([
            "kode" => 'required',
            "nama" => 'required',
        ]);
        icd9::create($data);
        return redirect()->route('datmas.icd')->with('success', 'ICD 9 berhasi di tambahkan');
    }
    public function icd10add(Request $request)
    {
        $data = $request->validate([
            "kode" => 'required',
            "nama" => 'required',
        ]);
        icd10::create($data);
        return redirect()->route('datmas.icd')->with('success', 'ICD 10 berhasi di tambahkan');
    }

    public function posker()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "posker ";
        $posker = posker::all();
        return view('datamaster.posker', compact('title','posker'));
    }

    public function poskeradd(Request $request)
    {
        $data = $request->validate([
            "nama" => 'required',
            "kode" => 'required',
        ]);
        posker::create($data);
        return redirect()->route('datmas.posker')->with('Success', 'Posisi Kerja berhasi di tambahkan');
    }

    public function httpemeriksaan()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Head To Toe Pemeriksaan";
        $data_pemeriksaan = headtotoe_pemeriksaan::all();
        return view('datamaster.htt_pemeriksaan', compact('title','data_pemeriksaan'));
    }

    public function httpemeriksaanadd(Request $request)
    {
        $data = $request->validate([
            "kode" => 'required',
            "nama" => 'required',
        ]);
        $htt = new headtotoe_pemeriksaan();
        $htt->kode_pemeriksaan = $data['kode'];
        $htt->nama_pemeriksaan = $data['nama'];
        $htt->user_id = auth()->user()->id;
        $htt->user_name = auth()->user()->name;
        $htt->save();

        return response()->json(['message' => 'Data Pemeriksaan berhasil ditambahkan!']);
    }

    public function httpemeriksaanDelete($id)
    {
        $htt = headtotoe_pemeriksaan::find($id);

        if (!$htt) {
            return redirect()->route('datmas.httpemeriksaan')->with('error', 'Data tidak ditemukan');
        }

        $htt->delete();

        return redirect()->route('datmas.httpemeriksaan')->with('success', 'Data berhasil dihapus');
    }

    public function httpemeriksaanEdit(Request $request, $id)
    {
        // Validasi input
        $data = $request->validate([
            "kode" => "required",
            "nama" => "required",
        ]);

        // Cari data berdasarkan ID
        $htt = headtotoe_pemeriksaan::find($id);

        if (!$htt) {
            return redirect()->route('datmas.httpemeriksaan')->with('error', 'Data tidak ditemukan');
        }

        // Update data
        $htt->kode_pemeriksaan = $data['kode'];
        $htt->nama_pemeriksaan = $data['nama'];
        $htt->user_id = auth()->user()->id;
        $htt->user_name = auth()->user()->name;
        $htt->save();

        return redirect()->route('datmas.httpemeriksaan')->with('success', 'Data berhasil diperbarui');
    }


    public function httsubpemeriksaan()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Head To Toe Sub Pemeriksaan";
        $htt_pemeriksaan = headtotoe_pemeriksaan::all();
        $htt_sub_pemeriksaan = headtotoe_sub_pemeriksaan::all();
        return view('datamaster.htt_subpemeriksaan', compact('title','htt_pemeriksaan','htt_sub_pemeriksaan'));
    }

    public function getNextKodeSubPemeriksaan(Request $request) {
        $kodePemeriksaan = $request->kode_pemeriksaan;
        $lastSubPemeriksaan = headtotoe_sub_pemeriksaan::where('kode_pemeriksaan', $kodePemeriksaan)
            ->orderBy('kode_subpemeriksaan', 'desc')
            ->first();

        if ($lastSubPemeriksaan) {
            $lastNumber = intval(substr($lastSubPemeriksaan->kode_subpemeriksaan, strlen($kodePemeriksaan)));
            $nextKode = $kodePemeriksaan . ($lastNumber + 1);
        } else {
            $nextKode = $kodePemeriksaan . '1';
        }

        return response()->json(['next_kode' => $nextKode]);
    }

    public function getNextKodePemeriksaan(Request $request) {
        $kodePrefix = 'H'; // Awalan kode
        $kodeAwal = '001'; // Kode awal jika belum ada data

        // Ambil kode pemeriksaan terakhir berdasarkan prefix "H"
        $lastSubPemeriksaan = headtotoe_pemeriksaan::where('kode_pemeriksaan', 'like', $kodePrefix . '%')
            ->orderBy('kode_pemeriksaan', 'desc')
            ->first();

        if ($lastSubPemeriksaan) {
            // Ambil angka terakhir dari kode (contoh: "H005" -> "005")
            $lastNumber = intval(substr($lastSubPemeriksaan->kode_pemeriksaan, strlen($kodePrefix)));

            // Tambah 1 untuk mendapatkan kode berikutnya
            $nextNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT); // Format 3 digit
        } else {
            $nextNumber = $kodeAwal; // Jika belum ada data, gunakan H001
        }

        $nextKode = $kodePrefix . $nextNumber;

        return response()->json(['next_kode' => $nextKode]);
    }



    public function httsubpemeriksaanadd(Request $request)
    {
        $data = $request->validate([
            "nama_pemeriksaan" => 'required',
            "kode_pemeriksaan" => 'required',
            "kode_subpemeriksaan" => 'required',
            "nama_subpemeriksaan" => 'required',
        ]);
        $htt = new headtotoe_sub_pemeriksaan();
        $htt->kode_pemeriksaan = $data['kode_pemeriksaan'];
        $htt->nama_pemeriksaan = $data['nama_pemeriksaan'];
        $htt->kode_subpemeriksaan = $data['kode_subpemeriksaan'];
        $htt->nama_subpemeriksaan = $data['nama_subpemeriksaan'];
        $htt->user_id = auth()->user()->id;
        $htt->user_name = auth()->user()->name;
        $htt->save();

        return redirect()->route('datmas.httsubpemeriksaan')->with('Success', 'Data Sub Pemeriksaan berhasi di tambahkan');
    }

    public function httsubpemeriksaanDelete($id)
    {
        $htt = headtotoe_sub_pemeriksaan::find($id);

        if (!$htt) {
            return redirect()->route('datmas.httsubpemeriksaan')->with('error', 'Data tidak ditemukan');
        }

        $htt->delete();

        return redirect()->route('datmas.httsubpemeriksaan')->with('success', 'Data berhasil dihapus');
    }

    public function httsubpemeriksaanEdit(Request $request, $id)
    {
        // Validasi input
        $data = $request->validate([
            "nama_pemeriksaan" => "required",
            "kode_pemeriksaan" => "required",
            "kode_subpemeriksaan" => "required",
            "nama_subpemeriksaan" => "required",
        ]);

        // Cari data berdasarkan ID
        $htt = headtotoe_sub_pemeriksaan::find($id);

        if (!$htt) {
            return redirect()->route('datmas.httsubpemeriksaan')->with('error', 'Data tidak ditemukan');
        }

        // Update data
        $htt->kode_pemeriksaan = $data['kode_pemeriksaan'];
        $htt->nama_pemeriksaan = $data['nama_pemeriksaan'];
        $htt->kode_subpemeriksaan = $data['kode_subpemeriksaan'];
        $htt->nama_subpemeriksaan = $data['nama_subpemeriksaan'];
        $htt->user_id = auth()->user()->id;
        $htt->user_name = auth()->user()->name;
        $htt->save();

        return redirect()->route('datmas.httsubpemeriksaan')->with('success', 'Data berhasil diperbarui');
    }


    public function jenisdiet()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Tambah Jenis Diet";
        $diet = diet::all();
        return view('patient.jenisdiet', compact('title','diet'));
    }

    public function jenisdietadd(Request $request)
    {
        $request->validate([
            "kode_diet" => 'required',
            "nama_diet" => 'required',
        ]);

        $data = [
            'nama' => $request->nama_diet,
            'kode' => $request->kode_diet,
        ];
        diet::create($data);

        return redirect()->route('datmas.jenisdiet')->with('Success', 'Suku berhasil di tambahkan');
    }

    public function jenismakanadiet()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Tambah Jenis Diet";
        $diet = makan::all();
        return view('patient.jenismakanandiet', compact('title','diet'));
    }

    public function jenismakanadietadd(Request $request)
    {
        $request->validate([
            "kode_diet" => 'required',
            "nama_diet" => 'required',
        ]);

        $data = [
            'nama' => $request->nama_diet,
            'kode' => $request->kode_diet,
        ];
        makan::create($data);

        return redirect()->route('datmas.jenisdiet.makana')->with('Success', 'Suku berhasil di tambahkan');
    }

    // DATA LAMA OMEGA BALARAJA
    public function datalama_pemeriksaan()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "DATA LAMA PEMERIKSAAN";
        return view('datamaster.data_lama_pemeriksaan', compact('title'));
    }

    public function filterData(Request $request): JsonResponse
    {
        $no_rm = $request->query('no_rm');

        // Jika tidak ada parameter pencarian, kembalikan data kosong
        if (!$no_rm) {
            return response()->json(['message' => 'No RM is required'], 400);
        }

        // Ambil data berdasarkan No RM
        $data = data_lama_pemeriksaan::where('no_rm', $no_rm)->get();

        return response()->json($data);
    }

}
