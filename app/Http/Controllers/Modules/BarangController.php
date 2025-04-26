<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\setweb;
use App\Models\dabar;
use App\Models\bank;
use App\Models\industri;
use App\Models\User;
use App\Models\barang_faktur_detail;
use App\Models\barang_faktur;
use App\Models\faktur_apotek;
use App\Models\faktur_apotek_prebayar;
use App\Models\rajal;
use App\Models\obat_pasien;
use App\Models\poli;
use App\Models\doctor;
use App\Models\penjab;
use App\Models\barang_setting;
use App\Models\barang_harga;
use App\Models\barang_stok;
use App\Models\gudang_obat_utama;
use App\Models\gudang_obat_sementara;
use App\Models\data_request_obat;
use App\Models\data_request_obat_detail;
use App\Models\gudang_obat_utama_harga;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;


class BarangController extends Controller
{
    public function index()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "barang";
        return view('barang.index', compact('title'));
    }

    public function gudangobat()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "gudang";
        return view('gudang.gudangobat', compact('title'));
    }

    public function getgudangobat()
    {
        $results = barang_stok::select('kode_barang',
                                       DB::raw('MAX(nama_barang) AS nama_barang'),  // Ambil nama_barang pertama untuk setiap kode_barang
                                       DB::raw('SUM(qty) AS total_qty'))
        ->where('tgl_terima', '<=', now()->toDateString())
        ->groupBy('kode_barang')  // Kelompokkan berdasarkan kode_barang
        ->havingRaw('SUM(qty) > 0')  // Hanya tampilkan jika qty lebih dari 0
        ->get();

        return response()->json($results);
    }

    public function pembelian()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "pembelian";
        $dabar = dabar::with(['satuan','satuan_sedangs','satuan_besars','jenbar'])->get();
        $industri = industri::all();
        $user = user::all();

        // Cek apakah ada data di tabel barang_setting
        $barangSettingExists = barang_setting::exists() ? 1 : 0;

        return view('barang.pembelian', compact('title','dabar','industri','user','barangSettingExists'));
    }

    public function pembelianadd(Request $request)
    {
        $data_header = $request->validate([
            "no_faktur" => 'required',
            "supplierSelect" => 'nullable',
            "supplierInput" => 'nullable',
            "no_po_sp" => 'required|max:255',
            "no_faktur_suplier" => 'required|max:255',
            "tgl_terima" => 'required|max:255',
            "tgl_faktur" => 'required|max:255',
            "date-range-view" => 'required|max:255',
            "ppnpajak" => 'required|max:255',
        ]);

        $data_total = $request->validate([
            "sub_total" => 'required',
            "ppn_total" => 'required',
            "materai" => 'required|max:255',
            "koreksi" => 'required|max:255',
            "harga_total" => 'required|max:255',
            "penerima_barang" => 'required|max:255',
        ]);

        // Validasi untuk tableData
        $validatedData = $request->validate([
            'tableData' => 'required|string', // tableData dalam bentuk JSON string
        ]);

        // Decode JSON tableData menjadi array PHP
        $tableDataArray = json_decode($validatedData['tableData'], true);

        $barangSetting = barang_setting::first();

        // Pastikan decoding berhasil dan tableDataArray berupa array
        if (is_array($tableDataArray)) {
            foreach ($tableDataArray as $item) {
                // Tambahkan `no_faktur` dari $data_header ke setiap item
                $item['no_faktur'] = $data_header['no_faktur'];
                $item['tgl_terima'] = $data_header['tgl_terima'];

                // Simpan setiap item ke database, sesuaikan dengan tabel dan kolom
                barang_faktur_detail::create([
                    'no_faktur' => $item['no_faktur'],          // Menyimpan no_faktur ke database
                    'tgl_terima' => $item['tgl_terima'],          // Menyimpan no_faktur ke database
                    'nama_barang' => $item['namaBarang'],        // kolom di database
                    'kode_barang' => $item['kodeBarang'],               // kolom di database
                    'qty' => $item['qty'],                       // kolom di database
                    'harga' => $item['harga'],                   // kolom di database
                    'exp' => $item['exp'],                       // kolom di database
                    'diskon' => $item['diskon'],                 // kolom di database
                    'ppn' => $item['ppnAwal'],                 // kolom di database
                    'kode_batch' => $item['kodeBatch'],          // kolom di database
                    'total' => $item['total'],     // kolom di database
                ]);

                // barang_harga::updateOrCreate(
                //     ['kode_barang' => $item['kodeBarang']], // Kondisi `kode_barang`
                //     [
                //         'nama_barang' => $item['namaBarang'],
                //         'harga_dasar' => $item['hargaSatuan'],
                //         'disc' => $item['diskonBarang'] ?? 0, // Default 0 jika null
                //         'ppn' => $item['ppn'] ?? 0, // Default 0 jika null
                //         'user' => auth()->user()->id, // User ID yang sedang login
                //     ]
                // );

                    // Apabila omega klinik matikan fitur dibawah (untuk menentukan harga jual obat)
                    // KALAU SELAIN OMEGA INI DINYALAIN
                barang_stok::create([
                    'kode_barang' => $item['kodeBarang'],
                    'nama_barang' => $item['namaBarang'],
                    'qty' => $item['qty'],
                    'tgl_terima' => $item['tgl_terima'],
                    'exp' => $item['exp'],
                ]);

                $barangHarga = barang_harga::where('kode_barang',$item['kodeBarang'])->first();

                if ($barangHarga) {
                    // Jika data ada, cek apakah harga_dasar yang baru lebih besar
                    if ($item['hargaSatuan'] > $barangHarga->harga_dasar) {
                        // Jika lebih besar, update data dengan harga_dasar baru
                        $barangHarga->update([
                            'nama_barang' => $item['namaBarang'],
                            'harga_dasar' => $item['hargaSatuan'],
                            'disc' => $item['diskonBarang'] ?? 0, // Default 0 jika null
                            'ppn' => $item['ppn'] ?? 0, // Default 0 jika null
                            'user' => auth()->user()->id,
                        ]);
                    }
                } else {
                    // Jika data belum ada, buat data baru
                    barang_harga::create([
                        'kode_barang' => $item['kodeBarang'],
                        'nama_barang' => $item['namaBarang'],
                        'harga_dasar' => $item['hargaSatuan'],
                        'disc' => $item['diskonBarang'] ?? 0, // Default 0 jika null
                        'ppn' => $item['ppn'] ?? 0, // Default 0 jika null
                        'user' => auth()->user()->id,
                    ]);
                };

                    // OMEGA GUDANG UTAMA NYALAIN INI DAN BARANG_STOK MATIIN, Selain klinik omega matiin
                // gudang_obat_utama::create([
                //     'kode_barang' => $item['kodeBarang'],
                //     'nama_barang' => $item['namaBarang'],
                //     'qty' => $item['qty'],
                //     'tgl_terima' => $item['tgl_terima'],
                //     'exp' => $item['exp'],
                // ]);

                // // Cek apakah data barang dengan kode_barang sudah ada
                // $barangHarga = gudang_obat_utama_harga::where('kode_barang',$item['kodeBarang'])->first();

                // if ($barangHarga) {
                //     // Jika data ada, cek apakah harga_dasar yang baru lebih besar
                //     if ($item['hargaSatuan'] > $barangHarga->harga_dasar) {
                //         // Jika lebih besar, update data dengan harga_dasar baru
                //         $barangHarga->update([
                //             'nama_barang' => $item['namaBarang'],
                //             'harga_dasar' => $item['hargaSatuan'],
                //             'disc' => $item['diskonBarang'] ?? 0, // Default 0 jika null
                //             'ppn' => $item['ppn'] ?? 0, // Default 0 jika null
                //             'user' => auth()->user()->id,
                //         ]);
                //     }
                // } else {
                //     // Jika data belum ada, buat data baru
                //     gudang_obat_utama_harga::create([
                //         'kode_barang' => $item['kodeBarang'],
                //         'nama_barang' => $item['namaBarang'],
                //         'harga_dasar' => $item['hargaSatuan'],
                //         'disc' => $item['diskonBarang'] ?? 0, // Default 0 jika null
                //         'ppn' => $item['ppn'] ?? 0, // Default 0 jika null
                //         'user' => auth()->user()->id,
                //     ]);
                // };
            }
        }

        $barang = new barang_faktur();
        $barang->no_faktur = $data_header['no_faktur'];
        $barang->supplier = !empty($data_header['supplierSelect']) ? $data_header['supplierSelect'] : $data_header['supplierInput'];
        $barang->po_sp = $data_header['no_po_sp'];
        $barang->faktur_supplier = $data_header['no_faktur_suplier'];
        $barang->tgl_faktur_supplier = $data_header['tgl_faktur'];
        $barang->tgl_terima_barang = $data_header['tgl_terima'];
        $barang->tgl_jatuh_tempo = $data_header['date-range-view'];
        $barang->ppn = $data_header['ppnpajak'];
        $barang->sub_total_barang = $data_total['sub_total'];
        $barang->total_ppn = $data_total['ppn_total'];
        $barang->total_materai = $data_total['materai'];
        $barang->total_koreksi = $data_total['koreksi'];
        $barang->total_harga = $data_total['harga_total'];
        $barang->penerima_barang = $data_total['penerima_barang'];
        $barang->save();

        // Pisahkan data berdasarkan tanda strip "-"
        $dateRange = explode(' - ', $data_header['date-range-view']);

        // Ambil tanggal akhir (array indeks ke-1)
        $jatuhTempo = trim($dateRange[1]);

        $formatted_sub_total = number_format($data_total['sub_total'], 0, ',', '.');
        $formatted_ppn_total = number_format($data_total['ppn_total'], 0, ',', '.');
        $formatted_materai = number_format($data_total['materai'], 0, ',', '.');
        $formatted_total = number_format($data_total['harga_total'], 0, ',', '.');

        // Data untuk PDF
        $dataPembelian = [
            'no_faktur' => $data_header['no_faktur'],
            'supplier' => !empty($data_header['supplierSelect']) ? $data_header['supplierSelect'] : $data_header['supplierInput'],
            'tgl_terima' => $data_header['tgl_terima'],
            'tgl_faktur' => $data_header['tgl_faktur'],
            'faktur_sup' => $data_header['no_faktur_suplier'],
            'po_sp' => $data_header['no_po_sp'],
            'jatuh_tempo' => $jatuhTempo,
            'ppn' => $data_header['ppnpajak'],
            'sub_total' => $formatted_sub_total,
            'ppn_total' => $formatted_ppn_total,
            'materai' => $formatted_materai,
            'koreksi' => $data_total['koreksi'],
            'harga_total' => $formatted_total,
            'items' => $tableDataArray,
        ];

        $pdf = PDF::loadView('pdf.pembelian', ['data' => $dataPembelian]);


        $filename = 'data_pembelian_' . $data_header['no_faktur'] . '.pdf';

        $path = 'temp/' . $filename;
        Storage::put($path, $pdf->output());

        return redirect()->route('barang.pembelian')->with([
            'success' => 'Data Pembelian Barang berhasil ditambahkan.',
            'pdf_url' => route('download.pdf', ['filename' => $filename])
        ]);

        // return redirect()->route('barang.pembelian')->with([
        //     'Success' => 'Data Pembelian Barang berhasil ditambahkan.',
        //     'pdf_url' => route('download.pdf', ['filename' => $filename])
        // ]);
        // $pdf->download('data_pembelian_' . $data_header['no_faktur'] . '.pdf');

        // return redirect()->route('barang.pembelian')->with('Success', 'Data Pembelian Barang berhasi di tambahkan');
        // try {
        //     // Download PDF
        //     $pdf->download('data_pembelian_' . $data_header['no_faktur'] . '.pdf');
        // } catch (\Exception $e) {
        //     // Jika terjadi error pada proses download, kembalikan dengan pesan error
        //     return redirect()->route('barang.pembelian')->with('error', 'Terjadi kesalahan saat mengunduh PDF.');
        // }

        // // Jika berhasil sampai di sini, lakukan redirect
        // return redirect()->route('barang.pembelian')->with('success', 'Data Pembelian Barang berhasil ditambahkan.');

    }

    public function hargaobat()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Harga Obat";
        $harga = barang_harga::all();
        return view('barang.hargaobat', compact('title','harga'));
    }

    public function setting()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "Setting Item";
        $setting = barang_setting::first();
        return view('barang.setting', compact('title','setting'));
    }

    public function settingadd(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            "hj_1" => 'nullable',
            "hj_2" => 'nullable',
            "hj_3" => 'nullable',
            "hj_4" => 'nullable',
            "hj_5" => 'nullable',
            "embalase" => 'nullable',
        ]);

        // Cek apakah data setting sudah ada
        $setting = barang_setting::first(); // Ambil data pertama yang ada (jika sudah ada)

        if (!$setting) {
            // Jika setting belum ada, buat data baru dengan ID pertama kali
            $setting = new barang_setting();
            $setting->hj_1 = $data['hj_1'];
            $setting->hj_2 = $data['hj_2'];
            $setting->hj_3 = $data['hj_3'];
            $setting->hj_4 = $data['hj_4'];
            $setting->hj_5 = $data['hj_5'];
            $setting->embalase = $data['embalase'];
            $setting->save();

            return redirect()->route('gudang.setting')->with('Success','Data berhasil ditambahkan.');
        } else {
            // Jika setting sudah ada, update bagian yang diubah saja
            $setting->updateSetting($data); // Gunakan method updateSetting dari model

            return redirect()->route('gudang.setting')->with('Success','Data berhasil diperbarui.');
        }
    }


    public function transaksi()
    {
        $setweb = setweb::first();
        $title = $setweb->name_app ." - ". "transaksi";
        $today = Carbon::now()->format('Y-m-d');
        $rawatjalan = rajal::with(['poli','pasien','doctor','penjab'])
                            ->where('status', 'Sudah Periksa')
                            ->get();
        // $obat_pasien = obat_pasien::with('obats')->whereDate('tgl', $today)->get();
        // $obat_pasien = obat_pasien::with('obats')->where('no_rawat', $noRawat)->where('tgl', $today)->get();
        $poli = poli::all();
        $doctor = doctor::all();
        $penjab = penjab::all();
        $stok = barang_stok::with(['harga','dabar'])->get()->unique('nama_barang');
        return view('barang.transaksi', compact('title','rawatjalan','poli','doctor','penjab','stok'));
    }

    public function transaksiadd(Request $request)
    {
        // Validation rules
        $rules = [
            'noReg' => 'nullable', // Validation for no_reg
            'noRm' => 'required', // Validation for no_rm
            'nama' => 'required', // Validation for nama
            'alamat' => 'nullable', // Validation for alamat
            'resep' => 'required', // Validation for resep
            'resepKode' => 'required', // Validation for resep_kode
            'rawat' => 'required', // Validation for rawat
            'poli' => 'required', // Validation for poli
            'dokter' => 'nullable', // Validation for dokter
            'jenisPx' => 'required', // Validation for jenis_px
            'penjamin' => 'nullable', // Validation for penjamin
            'tableData' => 'required|array', // Ensure tableData is an array with at least one row
            'embis' => 'nullable', // Embis should be a number
            'sub_total' => 'required', // Sub total should be a number
            'total' => 'required', // Total should be a number
        ];

        // Custom validation for table data rows
        $tableDataRules = [
            'tableData.*.namaObat' => 'required',
            'tableData.*.kode' => 'required',
            'tableData.*.harga' => 'required',
            'tableData.*.kuantitas' => 'required',
            'tableData.*.total_harga' => 'required',
            'tableData.*.diskon' => 'nullable',
        ];

        // Validate incoming request data
        $validatedData = $request->validate(array_merge($rules, $tableDataRules));

        // Process the data (after validation passes)
        $data = $validatedData;

        // Example: Create the transaction
        $transaction = faktur_apotek::create([
            'no_reg' => $data['noReg'] ?? null,
            'no_rm' => $data['noRm'],
            'nama' => $data['nama'],
            'alamat' => $data['alamat'],
            'jenis_resep' => $data['resep'], //resep atau beli bebas
            'kode_faktur' => $data['resepKode'],
            'rawat' => $data['rawat'],
            'nama_poli' => $data['poli'],
            'dokter' => $data['dokter'] ?? null,
            'jenis_px' => $data['jenisPx'],
            'penjamin' => $data['penjamin'] ?? null,
            'total_embis' => $data['embis'] ?? null,
            'sub_total' => $data['sub_total'],
            'total' => $data['total'],
            'stts_bayar' => "0",
        ]);

        // Now handle the table data (items)
        foreach ($data['tableData'] as $row) {
            $row['no_rm'] = $data['noRm'];
            $row['nama'] = $data['nama'];
            $row['rawat'] = $data['rawat'];
            $row['resep'] = $data['resep'];
            $row['resepKode'] = $data['resepKode'];
            $row['jenisPx'] = $data['jenisPx'];
            $row['tanggal'] = now()->toDateString(); // Format: YYYY-MM-DD
            $row['jam'] = now()->toTimeString(); // Format: HH:mm:ss

            faktur_apotek_prebayar::create([
                'no_rm' => $row['no_rm'],
                'kode_faktur' => $row['resepKode'],
                'nama' => $row['nama'],
                'rawat' => $row['rawat'],
                'jenis_resep' => $row['resep'],
                'jenis_px' => $row['jenisPx'],
                'tanggal' => $row['tanggal'],
                'jam' => $row['jam'],
                'nama_obat' => $row['namaObat'],
                'kode' => $row['kode'],
                'harga' => $row['harga'],
                'kuantitas' => $row['kuantitas'],
                'total_harga' => $row['total_harga'],
                'diskon' => $row['diskon'] ?? null,
            ]);
        }

        // Kembalikan respons JSON
        return response()->json(['success' => true]);
    }

public function downloadResepPDF(Request $request)
{
    $data = $request->input('data');
    $noReg = $request->input('no_reg');
    $username = auth()->user()->name;
    $notes = $request->input('notes');

    if (empty($data)) {
        return response()->json(['error' => 'Tidak ada data untuk dicetak'], 400);
    }

    $groupedData = [
        'R/' => null,    // Simpan resep asli
        'R: /' => null,  // Simpan revisi resep
    ];

    $currentGroup = null;
    $nama_pasien = '';
    $tgl_resep = '';

    foreach ($data as $item) {
        if (!empty($item['header'])) {
            if ($item['header'] === "R/") {
                $groupedData['R/'] = [
                    'header' => $item['header'],
                    'id' => $item['id'],
                    'dokter' => $item['penjab'] ?? '-',
                    'items' => []
                ];
                $currentGroup = 'R/';
            } elseif (str_starts_with($item['header'], "R: /")) {
                $groupedData['R: /'] = [
                    'header' => $item['header'],
                    'id' => $item['id'],
                    'dokter' => $item['penjab'] ?? '-',
                    'items' => []
                ];
                $currentGroup = 'R: /';
            }
        }

        if ($currentGroup && !empty($item['nama_obat'])) {
            $groupedData[$currentGroup]['items'][] = [
                'nama_obat' => $item['nama_obat'],
                'jumlah' => ($item['dosis'] ?? '-') . ' ' . ($item['dosis_satuan'] ?? ''),
                'aturan_pakai' => ($item['signa_s'] ?? '-') . ' x ' . ($item['signa_x'] ?? '-') . ' ' . ($item['signa_besaran'] ?? ''),
                'keterangan' => $item['signa_keterangan'] ?? '-'
            ];
        }

        $nama_pasien = $item['nama_pasien'] ?? 'Pasien';
        $tgl_resep = $item['tgl'] ?? date('Y-m-d');
        $namaDokter = $item['rajal']['doctor']['nama_dokter'] ?? 'Tidak ada dokter';
    }

    // Jika hanya ada "R: /" tanpa "R/", hapus "R: /" karena tidak valid tanpa resep asli
    if ($groupedData['R: /'] && !$groupedData['R/']) {
        unset($groupedData['R: /']);
    }

    // Buat array final untuk Blade
    $kelompokData = array_filter($groupedData);

    $pdf = Pdf::loadView('pdf.apotek_resep', compact('kelompokData', 'noReg', 'username', 'nama_pasien', 'notes', 'namaDokter'))
        ->setPaper([0, 0, 420, 595], 'portrait'); // A5 ukuran dalam points

    $filename = 'resep_' . $nama_pasien . '_' . $tgl_resep . '.pdf';
    $path = 'temp/' . $filename;
    Storage::put($path, $pdf->output());

    return response()->json([
        'pdf_url' => route('download.pdf', ['filename' => $filename])
    ]);
}

    public function getObatPasien(Request $request)
    {
        $noReg = $request->query('no_reg'); // Ambil nilai dari query string
        $today = now()->format('Y-m-d');

        $obat_pasien = obat_pasien::with(['harga','obats','rajal.doctor'])
            ->where('no_rawat', $noReg)
            ->where('tgl', $today)
            ->get();

        return response()->json($obat_pasien);
    }

    public function getHargaObat(Request $request)
    {
        $barangSetting = barang_setting::first();  // Ambil data pertama atau sesuai kriteria

        return response()->json([
            'embalase' => $barangSetting ? $barangSetting->embalase : 0
        ]);
    }

    public function generateNoRM()
    {
        // Ambil nomor RM terakhir dari database atau buat nomor default jika belum ada
        $lastNoRM = DB::table('faktur_apoteks')->latest('no_rm')->first(); // Asumsi tabel pasien memiliki kolom no_rm

        // Jika belum ada data, set nomor RM mulai dari 001
        $counter = $lastNoRM ? (intval(substr($lastNoRM->no_rm, -3)) + 1) : 1;

        // Format nomor RM (HV + 3 digit angka)
        $formattedNoRM = 'HV-' . str_pad($counter, 3, '0', STR_PAD_LEFT);

        return response()->json([
            'no_rm' => $formattedNoRM,
            'nama' => 'Beli Bebas / APS' // Nama yang akan ditampilkan
        ]);
    }

    public function generateInvoiceCode(Request $request)
    {
        // Validasi prefix (RSP atau BBS)
        $request->validate([
            'prefix' => 'required|string|in:RSP,BBS',
        ]);

        // Ambil prefix dan tanggal sekarang
        $prefix = $request->input('prefix');
        $dateString = date('Ymd');  // Ambil tanggal dalam format YYYYMMDD

        // Tentukan table yang akan digunakan untuk menyimpan nomor faktur
        // Misalnya kita menggunakan tabel "transaksi"
        $table = 'faktur_apoteks';

        // Cari nomor terakhir yang digunakan untuk prefix tertentu (RSP atau BBS)
        $lastInvoice = DB::table($table)
                         ->where('kode_faktur', 'like', "{$prefix}-{$dateString}-%")
                         ->orderBy('kode_faktur', 'desc')
                         ->first();

        // Tentukan nomor urut baru
        $newInvoiceNumber = '00001';  // Default mulai dari 00001

        if ($lastInvoice) {
            // Ambil nomor terakhir dan tambahkan 1
            $lastNumber = substr($lastInvoice->kode_faktur, -5);  // Ambil 5 digit terakhir
            $newInvoiceNumber = str_pad((int)$lastNumber + 1, 5, '0', STR_PAD_LEFT);  // Tambah 1 dan pad dengan 0
        }

        // Kembalikan nomor faktur yang baru dalam format
        return response()->json([
            'success' => true,
            'invoiceNumber' => $newInvoiceNumber,  // Nomor faktur baru
        ]);
    }

    public function getHargaBebas(Request $request)
    {
        $kodeBarang = $request->kode_barang;
        $pilHarga = $request->pil_harga;

        // Cari barang berdasarkan kode_barang
        $barang = barang_harga::where('kode_barang', $kodeBarang)->first();

        if ($barang) {
            // Pilih harga sesuai dengan pilihan user
            $harga = $barang->{$pilHarga}; // Menggunakan dynamic property
            return response()->json(['harga' => $harga]);
        }

        return response()->json(['message' => 'Barang tidak ditemukan'], 404);
    }

// Request Obat khusus Omega Klinik
    public function requestObat()
    {
        $setweb = Setweb::first();
        $title = $setweb->name_app . " - Approve Obat";
        //jangan lupa ubah sesuai kode klinik
        $dataObatSementara = gudang_obat_sementara::where('kode_klinik', 'BLRJ')->get();
        $dataRequestObat = data_request_obat::where('status', '0')->with('details')->get();
        $dabar = dabar::all();
        // $stok = barang_stok::all();

        $stok = barang_stok::select('kode_barang',
                                       DB::raw('MAX(nama_barang) AS nama_barang'),  // Ambil nama_barang pertama untuk setiap kode_barang
                                       DB::raw('SUM(qty) AS total_qty'))
        ->groupBy('kode_barang')  // Kelompokkan berdasarkan kode_barang
        ->havingRaw('SUM(qty) > 0')  // Hanya tampilkan jika qty lebih dari 0
        ->get();
        return view('barang.request_obat', compact('title', 'dataObatSementara','dataRequestObat','dabar','stok'));
    }

    public function requestObatAdd(Request $request)
    {
        // Validasi data yang dikirim dari form
        $request->validate([
            'kode' => 'required',
            'tableData' => 'required|json', // Pastikan data berbentuk JSON
        ]);

        // Decode data JSON dari input hidden tableData
        $tableData = json_decode($request->input('tableData'), true);

        if (empty($tableData)) {
            return redirect()->back()->with('error', 'Tidak ada data obat yang dikirim.');
        }

        // Simpan setiap item ke dalam database
        foreach ($tableData as $item) {
            data_request_obat_detail::create([
                'kode' => $item['kode'],
                'kode_obat' => $item['kode_obat'],
                'nama_obat' => $item['nama_obat'],
                'qty' => $item['qty'],
            ]);
        }
        // Tambahkan ke tabel data_obat_sementara
        data_request_obat::create([
            'kode_klinik' => 'BLRJ',
            'nama_klinik' => 'Klinik Balaraja',
            'kode' => $request->kode,
            'status' => '0',
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('gudang.request')->with('Success', 'Data obat berhasil disimpan.');
    }

    public function approveObat($id)
    {
        $obatSementara = gudang_obat_sementara::with('harga')->find($id);

        if (!$obatSementara) {
            return redirect()->route('gudang.request')->with('error', 'Data obat tidak ditemukan');
        }

        // Tambahkan ke Gudang Obat Balaraja
        // $obatClient = gudang_obat_balaraja::firstOrCreate(
        barang_stok::create([
            'kode_barang' => $obatSementara->kode_barang,
            'nama_barang' => $obatSementara->nama_obat,
            'qty' => $obatSementara->qty,
            'tgl_terima' => now(),
            'harga_dasar' => $obatSementara->harga_dasar,
            'exp' => $obatSementara->exp,
        ]);

        // Hapus dari tabel data_obat_sementara
        $obatSementara->delete();

        // Cek apakah data barang dengan kode_barang sudah ada
        $barangHarga = barang_harga::where('kode_barang', $obatSementara->kode_barang)->first();

        if ($barangHarga) {
            // Jika data ada, cek apakah harga_dasar yang baru lebih besar
            if ($obatSementara->harga_dasar > $barangHarga->harga_dasar) {
                // Jika lebih besar, update data dengan harga_dasar baru
                $barangHarga->update([
                    'nama_barang' => $obatSementara->nama_obat,
                    'harga_dasar' => $obatSementara->harga_dasar,
                    'disc' => $obatSementara->harga->disc ?? 0,
                    'ppn' => $obatSementara->harga->ppn ?? 0,
                    'user' => auth()->user()->id,
                ]);
            }
        } else {
            // Jika data belum ada, buat data baru
            barang_harga::create([
                'kode_barang' => $obatSementara->kode_barang,
                'nama_barang' => $obatSementara->nama_obat,
                'harga_dasar' => $obatSementara->harga_dasar,
                'disc' => $obatSementara->harga->disc ?? 0,
                'ppn' => $obatSementara->harga->ppn ?? 0,
                'user' => auth()->user()->id,
            ]);
        };

        return redirect()->route('gudang.request')->with('success', 'Data obat berhasil diapprove');
    }

    public function rejectObat($id)
    {
        // Cari data obat sementara berdasarkan ID
        $obatSementara = gudang_obat_sementara::find($id);

        // Jika obat tidak ditemukan, tampilkan pesan error
        if (!$obatSementara) {
            return redirect()->route('gudang.request')->with('error', 'Data obat tidak ditemukan');
        }

        // Kembalikan qty yang ada di Gudang Sementara ke Gudang Utama
        $obatUtama = gudang_obat_utama::firstOrCreate(
            ['kode_barang' => $obatSementara->kode_barang], // Pastikan ada barang yang sama
            ['nama_obat' => $obatSementara->nama_obat, 'qty' => 0] // Jika belum ada, buat dengan jumlah 0
        );

        // Tambahkan qty dari Gudang Sementara ke Gudang Utama
        $obatUtama->qty += $obatSementara->qty;
        $obatUtama->save();

        // Hapus data dari Gudang Sementara setelah dikembalikan
        $obatSementara->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('gudang.request')->with('success', 'Barang berhasil ditolak dan dikembalikan ke Gudang Utama');
    }
}
