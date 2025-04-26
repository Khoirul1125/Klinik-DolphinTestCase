<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\barang_harga;
use App\Models\setweb;
use App\Models\data_request_obat;
use App\Models\data_request_obat_detail;
use App\Models\gudang_obat_utama;
use App\Models\gudang_obat_sementara;
use App\Models\gudang_obat_balaraja;
use App\Models\dabar;
use App\Models\gudang_obat_utama_harga;

class GudangUtamaController extends Controller
{
    // Menampilkan halaman form kirim obat
    public function index()
    {
        $setweb = Setweb::first();
        $title = $setweb->name_app . " - Kirim Obat";
        $obatUtama = gudang_obat_utama::all(); // Untuk menampilkan stok obat yang ada
        $dataRequestObat = data_request_obat::all();
        $dabar = dabar::all();
        return view('gudangutama.kirim_obat', compact('title', 'obatUtama','dataRequestObat','dabar'));
    }

    // foreach ($details as $detail) {
        //     $obatUtama = gudang_obat_utama::where('kode_barang', $detail['kode_obat'])->first();

        //     if ($obatUtama) {
        //     // Kurangi stok di gudang utama
        //     $obatUtama->qty -= $detail['qty'];
        //     $obatUtama->save();
        //     }

        //     $dataRequestObat = data_request_obat::where('kode', $detail['kode_req'])->first();

        //     if ($dataRequestObat) {
        //     $dataRequestObat->status = '1';  // Ubah status menjadi 1
        //     $dataRequestObat->save();
        //     }
        // }

    public function kirimObatadd(Request $request)
    {
        // Validasi data yang diterima
        $validatedData = $request->validate([
            'details' => 'required|array', // 'details' harus berupa array
            'details.*.kode_klinik' => 'required|string',
            'details.*.nama_klinik' => 'required|string',
            'details.*.kode_req' => 'required|string',
            'details.*.kode_obat' => 'required|string',
            'details.*.nama_obat' => 'required|string',
            'details.*.harga_dasar' => 'required|numeric',
            'details.*.qty' => 'required|integer|min:1',
        ]);

        // Ambil data 'details' dari request
        $details = $validatedData['details'];
        $expResults = []; // Untuk menyimpan data exp yang digunakan

        foreach ($details as $detail) {
            $qtyNeeded = (int) $detail['qty']; // Jumlah yang harus dipenuhi

            // Ambil stok dengan FIFO (urutkan dari yang paling lama)
            $stocks = gudang_obat_utama::where('kode_barang', $detail['kode_obat'])
                ->where('qty', '>', 0) // Ambil hanya stok yang masih ada
                ->orderBy('tgl_terima', 'asc') // FIFO: gunakan stok yang lebih lama dulu
                ->get();

            foreach ($stocks as $stock) {
                if ($qtyNeeded <= 0) break; // Jika permintaan sudah terpenuhi, keluar dari loop

                if ($stock->qty >= $qtyNeeded) {
                    // Jika stok cukup, kurangi dan selesai
                    $expDate = $stock->exp; // Simpan tanggal EXP yang digunakan
                    $stock->qty -= $qtyNeeded;
                    $stock->save();
                    $qtyNeeded = 0; // Permintaan sudah terpenuhi
                    $expResults[] = [
                        'kode_obat' => $detail['kode_obat'],
                        'nama_obat' => $detail['nama_obat'],
                        'exp_used' => $expDate // Simpan exp yang digunakan
                    ];
                    break;
                } else {
                    // Jika stok tidak cukup, habiskan batch ini dan lanjut ke batch berikutnya
                    $qtyNeeded -= $stock->qty;
                    $expDate = $stock->exp; // Simpan tanggal EXP yang digunakan
                    $stock->qty = 0;
                    $stock->save();
                    $expResults[] = [
                        'kode_obat' => $detail['kode_obat'],
                        'nama_obat' => $detail['nama_obat'],
                        'exp_used' => $expDate // Simpan exp yang digunakan
                    ];
                }
            }

            // Jika masih ada kekurangan stok, berikan error
            if ($qtyNeeded > 0) {
                return response()->json([
                    'error' => 'Stok tidak cukup untuk obat ' . $detail['nama_obat']
                ], 400);
            }
        }

        // Setelah semua permintaan sukses diproses, update status `data_request_obat`
        $requestCodes = collect($details)->pluck('kode_req')->unique();
        foreach ($requestCodes as $kodeReq) {
            $dataRequestObat = data_request_obat::where('kode', $kodeReq)->first();
            if ($dataRequestObat) {
                $dataRequestObat->status = '1'; // Tandai permintaan sebagai diproses
                $dataRequestObat->save();
            }
        }

        try {
            // Loop dan simpan data ke database
            foreach ($details as $index => $detail) {
                DB::table('gudang_obat_sementaras')->insert([
                    'kode_klinik' => $detail['kode_klinik'],
                    'nama_klinik' => $detail['nama_klinik'],
                    'kode_req' => $detail['kode_req'],
                    'kode_barang' => $detail['kode_obat'],
                    'nama_obat' => $detail['nama_obat'],
                    'harga_dasar' => $detail['harga_dasar'],
                    'qty' => $detail['qty'],
                    'exp' => $expResults[$index]['exp_used'], // Menyimpan EXP yang digunakan
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
                'redirect_url' => route('kirimObat') // Berikan URL untuk redirect
            ], 200);
        } catch (\Exception $e) {
            // Tangani error dan beri response gagal
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getDetailRequest($kode)
    {
        $details = data_request_obat_detail::where('kode', $kode)->get();

        if ($details->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Detail tidak ditemukan']);
        }

        return response()->json(['success' => true, 'details' => $details]);
    }

    public function checkStock($kode_obat)
    {
        // Cek jumlah stok yang tersedia di gudang
        $stock = gudang_obat_utama::where('kode_barang', $kode_obat)->sum('qty');

        return response()->json([
            'success' => true,
            'stock' => $stock
        ]);
    }

    public function getPrice($kode_obat)
    {
        // Ambil harga dasar dan harga jual berdasarkan kode obat
        $price = gudang_obat_utama_harga::where('kode_barang', $kode_obat)->first();

        return response()->json([
            'success' => true,
            'price' => $price
        ]);
    }

    public function CekStokMan(Request $request)
    {
        $kode = $request->get('kode');

        // Cari stok dari tabel gudang_obat_utama berdasarkan kode_barang
        $stok = DB::table('gudang_obat_utamas')
                    ->where('kode_barang', $kode)
                    ->value('qty');

        if ($stok !== null) {
            return response()->json([
                'success' => true,
                'stok' => $stok,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
            ]);
        }
    }
}
