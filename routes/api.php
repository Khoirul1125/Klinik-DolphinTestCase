<?php

use App\Http\Controllers\BpjsController;
use App\Http\Controllers\DolphiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\data_request_obat;
use App\Http\Controllers\Modules\GudangUtamaController;
use App\Http\Controllers\Modules\PatientController;
use App\Http\Controllers\Modules\BarangController;
use App\Http\Controllers\Modules\DatamasterController;
use App\Http\Controllers\Modules\RegisController;
use App\Http\Controllers\Modules\SumberdayamController;
use App\Http\Controllers\Modules\LayananController;
use App\Http\Controllers\Modules\WagatweyController;
use App\Http\Controllers\SatusehatController;
use App\Http\Controllers\websetController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/get-last-batch-code', function () {
    $lastRecord = data_request_obat::orderBy('id', 'desc')->first();
    if ($lastRecord) {
        return response()->json(['success' => true, 'last_code' => $lastRecord->kode]);
    }
    return response()->json(['success' => true, 'last_code' => null]); // Jika belum ada data
});

// Punya Gudang Utama (Center)
Route::get('/data-request-detail/{kode}', [GudangUtamaController::class, 'getDetailRequest'])->name('getDetailRequest');
Route::get('/cek-stok-obat-manual', [GudangUtamaController::class, 'CekStokMan'])->name('CekStokMan');
Route::get('/check-stock/{kode_obat}', [GudangUtamaController::class, 'checkStock'])->name('checkStock');
Route::get('/get-price/{kode_obat}', [GudangUtamaController::class, 'getPrice'])->name('getPrice');


// filter data regis
Route::get('/doctor/filter', [RegisController::class, 'filterDokter'])->name('doctor.filter');

// search pasien pada regis rajal
Route::get('/search-pasien-rajal', [RegisController::class, 'searchPasienRajal'])->name('searchPasienRajal');
Route::get('/pasien/cari-data/{id}', [PatientController::class, 'caripasien']);
Route::get('/pasien/cari-data-new/{id}', [PatientController::class, 'caripasiennew']);

Route::get('/doctor/cari-data/{id}', [SumberdayamController::class, 'doctorcari']);

//soap diet

Route::get('/diets', [RegisController::class, 'indexdiet']);
Route::post('/diets', [RegisController::class, 'storediet']);
Route::delete('/diets/{id}', [RegisController::class, 'destroydiet']);
Route::post('/diets/{id}/remove-item', [RegisController::class, 'removeItemdiet']);


// get no-reg regis rajal
Route::get('/generate-no-reg-rajal', [RegisController::class, 'generateNoRegRajal'])->name('generateNoRegRajal');

// get no-rawat regis rajal
Route::get('/generate-no-rawat-rajal', [RegisController::class, 'generateNoRawatRajal'])->name('generateNoRawatRajal');

// filter odontogram
Route::get('/regis/gigi/load/{patient_id}/{treatment_id}', [RegisController::class, 'loadGigiData'])->where('treatment_id', '.*'); // Accept any characters in the treatment_id

// get data soap
Route::get('/load-data/soap', [RegisController::class, 'getDataByNoRawat'])->name('soap.load');
Route::post('/rujuk_lanjut', [LayananController::class, 'rujuk_lanjut']);
Route::get('/cetak-rujukan/{nomor_rawat}', [LayananController::class, 'cetakRujukan']);


//pasien baru
Route::post('/check-noka', [PatientController::class, 'checknoka']);
Route::post('/check-nik', [PatientController::class, 'checkNIK']);
Route::get('/patient/generate-nomor-rm', [PatientController::class, 'generate'])->name('patient.generate');

// api dolphi satusehat
Route::get('/get-token-satusehat', [SatusehatController::class, 'get_token']);
Route::get('/get-nik-satusehat/{nik}', [SatusehatController::class, 'get_nik_satusehat']);
Route::get('/get-kfa-satusehat/{nama}', [SatusehatController::class, 'get_kfa_satusehat']);

// api dolphi bpjs
Route::get('/get-token-bpjs', [BpjsController::class, 'get_token'])->name('get_token_bpjs');
Route::get('/get-noka-bpjs/{noka}', [BpjsController::class, 'get_noka_bpjs']);
Route::get('/get-nik-bpjs/{noka}', [BpjsController::class, 'get_nik_bpjs']);
Route::get('/get-statpul-bpjs/{codisi}', [BpjsController::class, 'get_statpul_bpjs']);
Route::get('/get-bkesadaran-bpjs', [BpjsController::class, 'get_kesadaran_bpjs']);
Route::get('/get-provider-bpjs', [BpjsController::class, 'get_provider_bpjs']);
Route::get('/get-spesialis-bpjs', [BpjsController::class, 'get_spesialis_bpjs']);
Route::get('/get-subspesialis-bpjs/{nama}', [BpjsController::class, 'get_sub_spesialis_bpjs']);
Route::get('/get-sarana-bpjs', [BpjsController::class, 'get_sarana_bpjs']);
Route::get('/get-khusus-bpjs', [BpjsController::class, 'get_khusus_bpjs']);
Route::get('/get-reujukan-bpjs/{koderujukan}', [BpjsController::class, 'get_rujukan_bpjs']);
Route::get('/put-reujukan-bpjs/{koderujukan}', [BpjsController::class, 'edit_rujukan_bpjs']);
Route::get('/get-dpho-obat-bpjs/{nama}', [BpjsController::class, 'get_dphoobat_bpjs']);
Route::get('/get-tindakan-bpjs/{row}/{data}', [BpjsController::class, 'get_tindakan_bpjs']);
Route::get('/get-rujukan-spesialis-bpjs/{data1}/{data2}/{data3}', [BpjsController::class, 'get_rujukan_spesialis_bpjs']);
Route::get('/get-rujukan-husus-bpjs/{data1}/{data2}/{data3}', [BpjsController::class, 'get_rujukan_husus_bpjs']);
Route::get('/get-rujukan-husus-spesialis-bpjs/{data1}/{data2}/{data3}/{data4}', [BpjsController::class, 'get_rujukan_spesialis_husus_bpjs']);

Route::get('/get-dekrip-bpjs', [BpjsController::class, 'dekrip']);


// api dolphi wilayah
Route::get('/get-kabupaten', [PatientController::class, 'getKabupaten'])->name('wilayah.getKabupaten');
Route::get('/get-kecamatan', [PatientController::class, 'getKecamatan'])->name('wilayah.getKecamatan');
Route::get('/get-desa', [PatientController::class, 'getDesa'])->name('wilayah.getDesa');

//api dolphi barang
Route::get('/get-dpho-obat', [DatamasterController::class, 'searchObat']);

// Punya transaksi barang
    Route::get('/transaksi/obat', [BarangController::class, 'getObatPasien'])->name('transaksi.obat');
    Route::get('/transaksi/harga', [BarangController::class, 'getHargaObat'])->name('transaksi.harga');
    Route::post('/transaksi/get-harga-bebas', [BarangController::class, 'getHargaBebas'])->name('getHargaBebas');
    Route::get('/generate-no-rm', [BarangController::class, 'generateNoRM'])->name('barang.transaksi.generateNoRM');
    Route::get('/generate-invoice-code', [BarangController::class, 'generateInvoiceCode'])->name('barang.transaksi.generateInvoiceCode');

// api untuk data barang pada gudang (datmas)
Route::get('/generate-kode-barang', [DatamasterController::class, 'generateKodeBarang'])->name('generate.kode.barang');

// stok obat realtime
Route::get('/gudang/getgudangobat', [BarangController::class, 'getgudangobat'])->name('gudang.getgudangobat');

// Modul Pcare
    Route::get('/pcare/polifktp/get', [SatusehatController::class, 'polifktp'])->name('pcare.polifktp.get');
    Route::get('/pcare/polifktl/get', [SatusehatController::class, 'polifktl'])->name('pcare.polifktl.get');
    Route::get('/pcare/icd10/get/{nama}', [BpjsController::class, 'icd10'])->name('pcare.icd10.get');
    Route::get('/pcare/icd9/get/{nama}', [SatusehatController::class, 'icd9'])->name('pcare.icd9.get');
    Route::get('/pcare/Kesadaran/get', [SatusehatController::class, 'Kesadaran'])->name('pcare.Kesadaran.get');
    Route::get('/pcare/obats/get/{nama}', [SatusehatController::class, 'obats'])->name('pcare.obats.get');




    Route::get('/pcare/khusus/get', [SatusehatController::class, 'khusus'])->name('pcare.khusus.get');

// DataMaster
    // perawatan rawat jalan
    Route::get('/generate-kode-perjal', [DatamasterController::class, 'generateKodePerjal'])->name('generate.kode.perjal');
    Route::get('/get-next-kode-penjab', [DatamasterController::class, 'getNextKodepenjab']);
    Route::get('/get-next-kode-industri', [DatamasterController::class, 'getNextKodeindustri']);
    Route::get('/get-next-kode-katper', [DatamasterController::class, 'getNextKodekatper']);
    Route::get('/get-next-kode-satuan', [DatamasterController::class, 'getNextKodesatuan']);

    // Head to toe sub
    Route::get('/get-next-kode-subpemeriksaan', [DatamasterController::class, 'getNextKodeSubPemeriksaan'])->name('getNextKodeSubPemeriksaan');
    Route::get('/get-next-kode-pemeriksaan', [DatamasterController::class, 'getNextKodePemeriksaan']);

    // Data Lama Pemeriksaan
    Route::get('/data-lama-pemeriksaan', [DatamasterController::class, 'filterData'])->name('filterData');


// Data Kasir
    // get data lunas kasir
    Route::get('/kasir/transaksifilter', [LayananController::class, 'filterLunasTransaksi'])->name('keuangan.datakasir.filterLunasTransaksi');

    Route::get('/kasir/filter', [LayananController::class, 'filterLunasKasir'])->name('keuangan.datakasir.filterLunasKasir');

    Route::get('/kasir/obatfilter', [LayananController::class, 'filterLunasObat'])->name('keuangan.datakasir.filterLunasObat');

    Route::patch('setweb/save-license-key/{id}', [websetController::class, 'saveLicenseKey'])->name('setweb.lisensi');

    Route::prefix('whatsapp')->group(function () {
        Route::get('/get-qr', [WagatweyController::class, 'getQrCode']); // ✅ Ambil QR Code untuk login
        Route::post('/save-login', [WagatweyController::class, 'saveWhatsAppLogin']); // ✅ Simpan status login
        Route::get('/check-status', [WagatweyController::class, 'checkStatus']); // ✅ Cek status login WhatsApp
        Route::post('/send-message', [WagatweyController::class, 'sendMessage']); // ✅ Kirim pesan WhatsApp
        Route::get('/key', [WagatweyController::class, 'getLicenseKey']); // ✅ Kirim pesan WhatsApp
    });

