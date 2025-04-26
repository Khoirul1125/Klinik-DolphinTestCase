<?php
use App\Http\Controllers\Modules\DoctorController;
use App\Http\Controllers\Modules\LayananController;
use App\Http\Controllers\Modules\PatientController;
use App\Http\Controllers\Modules\SumberdayamController;
use App\Http\Controllers\Modules\PCareController;
use App\Http\Controllers\Modules\GcsController;
use App\Http\Controllers\Modules\DatamasterController;
use App\Http\Controllers\Modules\BarangController;
use App\Http\Controllers\Modules\GudangUtamaController;
use App\Http\Controllers\Modules\RegisController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'check.menu.access'])->group(function () {
// modul Sumber Daya Manusia
    //dokter
    Route::get('/dokter', [SumberdayamController::class, 'dokter'])->name('dokter.index');
    Route::post('/dokter/add', [SumberdayamController::class, 'doctoradd'])->name('dokter.index.add');
    Route::post('/dokter/update', [SumberdayamController::class, 'doctorupdate'])->name('dokter.index.update');
    Route::post('/dokter/delete/{id}', [SumberdayamController::class, 'doctoradelete'])->name('dokter.index.delete');
    // dokter detail
    Route::get('/dokter/sertifikat/{id}', [SumberdayamController::class, 'dokterdetail'])->name('dokter.index.detail');
    Route::post('/dokter/sertifikat{id}/add', [SumberdayamController::class, 'dokterdetailadd'])->name('dokter.index.detail.add');
    // jadwal
    Route::get('/dokter/jadwal', [SumberdayamController::class, 'dokterjadwal'])->name('dokter.index.jadwal');
    Route::post('/dokter/jadwal/{id}/add', [SumberdayamController::class, 'dokterjadwaladd'])->name('dokter.index.jadwal.add');
    // staff
    Route::get('/staff', [SumberdayamController::class, 'karyawan'])->name('staff.index');
    Route::post('/staff/add', [SumberdayamController::class, 'karyawanadd'])->name('staff.index.add');
    Route::post('/staff/delete/{id}', [SumberdayamController::class, 'karyawandelete'])->name('staff.index.delete');
    // staff detail
    Route::get('/staff/sertifikat/{id}', [SumberdayamController::class, 'karyawandetail'])->name('staff.index.detail');
    Route::post('/staff/sertifikat/{id}/add', [SumberdayamController::class, 'karyawandetailadd'])->name('staff.index.detail.add');

// modul Registrasi
    // Pasien Baru
    Route::get('/pasien', [PatientController::class, 'pasiens'])->name('pasien.index');
    Route::post('/pasien/add', [PatientController::class, 'patientadd'])->name('pasien.index.add');
    Route::post('/pasien/update', [PatientController::class, 'patientupdate'])->name('pasien.index.update');
    Route::post('/pasien/delete/{id}', [PatientController::class, 'patientdelete'])->name('pasien.index.delete');
    Route::post('/pasien/patientlengkapi', [PatientController::class, 'patientlengkapi'])->name('pasien.index.lengkapi');
    // rawat jalan
    Route::get('/regis/rajal', [PatientController::class, 'rajal'])->name('regis.rajal');
    Route::post('/regis/rajal/add', [PatientController::class, 'rajaladd'])->name('regis.rajal.add');
    Route::delete('/rajal/{id}', [PatientController::class, 'rajaldestroy'])->name('rajal.delete');

// modul layanan
    // rawat jalan
        // dokter
        Route::get('/layanan/rawat-jalan', [LayananController::class, 'rajal'])->name('layanan.rawat-jalan.index');
            //Rme
            Route::get('/layanan/rawat-jalan/rme/{reg}', [LayananController::class, 'rme'])->name('layanan.rawat-jalan.rme.index');
            Route::get('/layanan/rawat-jalan/alls/{reg}', [LayananController::class, 'dataall'])->name('layanan.rawat-jalan.all.index');
            //soap
            Route::get('/layanan/rawat-jalan/soap-dokter/{norm}', [LayananController::class, 'soap'])->name('layanan.rawat-jalan.soap-dokter.index');
            Route::post('/layanan/rawat-jalan/soap-dokter/add', [LayananController::class, 'soapadd'])->name('layanan.rawat-jalan.soap-dokter.index.add');
            Route::delete('layanan/rawat-jalan/soap-dokter/delete/{id}', [LayananController::class, 'soapadelete'])->name('layanan.rawat-jalan.soap-dokter.index.delete');
                // resep obat
                Route::get('/layanan/rawat-jalan/soap-dokter/resep-obat/{norm}', [LayananController::class, 'resepobat'])->name('layanan.rawat-jalan.soap-dokter.index.resep.obat');
                Route::post('/layanan/rawat-jalan/soap-dokter/resep-obat/add', [LayananController::class, 'resepobatadd'])->name('layanan.rawat-jalan.soap-dokter.index.resep.obat.add');
                Route::post('/layanan/rawat-jalan/soap-dokter/resep-obat/delete', [LayananController::class, 'resepobatdelete'])->name('layanan.rawat-jalan.soap-dokter.index.resep.obat.delete');
                // odontogram
                Route::get('/layanan/rawat-jalan/soap-dokter/odontogram/{norm}', [LayananController::class, 'gigi'])->name('layanan.rawat-jalan.soap-dokter.index.odontogram');
                Route::post('/layanan/rawat-jalan/soap-dokter/odontogram/add', [LayananController::class, 'gigiadd'])->name('layanan.rawat-jalan.soap-dokter.index.odontogram.add');
                Route::post('/layanan/rawat-jalan/soap-dokter/odontogram/add/details', [LayananController::class, 'gigiadddetail'])->name('layanan.rawat-jalan.soap-dokter.index.odontogram.add.details');
                // diet
                Route::get('/regis/diet/{norm}', [RegisController::class, 'diet'])->name('soap.diet');
            //tindakan
            Route::get('/layanan/rawat-jalan/soap-dokter/tindakan/{norm}', [LayananController::class, 'tindakan'])->name('layanan.rawat-jalan.soap-dokter.index.tindakan');
            Route::post('/layanan/rawat-jalan/soap-dokter/tindakan/add', [LayananController::class, 'tindakanadd'])->name('layanan.rawat-jalan.soap-dokter.index.tindakan.add');
            Route::delete('/layanan/rawat-jalan/soap-dokter/tindakan/delete/{id}', [LayananController::class, 'tindakandelete'])->name('layanan.rawat-jalan.soap-dokter.index.tindakan.delete');
            // berkas
            Route::get('/layanan/rawat-jalan/soap-dokter/berkas-digital/{norm}', [LayananController::class, 'berkasdigital'])->name('layanan.rawat-jalan.soap-dokter.index.berkas.digital');
            Route::post('/layanan/rawat-jalan/soap-dokter/berkas-digital/add', [LayananController::class, 'berkasdigitaladd'])->name('layanan.rawat-jalan.soap-dokter.index.berkas.digital.add');
            Route::post('/layanan/rawat-jalan/soap-dokter/berkas-digital/add/odontogram', [LayananController::class, 'berkasdigitaladdodontogram'])->name('layanan.rawat-jalan.soap-dokter.index.berkas.digital.add.odontogram');
            Route::delete('/layanan/rawat-jalan/soap-dokter/berkas-digital/delete/{id}/{no_rm}', [LayananController::class, 'berkasdigitaldelete'])->name('layanan.rawat-jalan.soap-dokter.index.berkas.digital.delete');
        // perawat
        Route::get('/layanan/rawat-jalan/perawat', [LayananController::class, 'rajalperawat'])->name('layanan.rawat-jalan.perawat.index');
            //soap
            Route::get('/layanan/rawat-jalan/soap-perawat/{norm}', [LayananController::class, 'layanansoap'])->name('layanan.rawat-jalan.soap-perawat.index');
            Route::post('/layanan/rawat-jalan/soap-perawat/add', [LayananController::class, 'layanansoapadd'])->name('layanan.rawat-jalan.soap-perawat.index.add');

        // Transaksi Apotek
            Route::get('/barang/transaksi', [BarangController::class, 'transaksi'])->name('barang.transaksi');
            Route::post('/barang/transaksi/add', [BarangController::class, 'transaksiadd'])->name('barang.transaksi.add');
            Route::post('/barang/transaksi/resep/download-pdf', [BarangController::class, 'downloadResepPDF'])->name('barang.transaksi.pdf');

// Modul Keuangan
    // Kasir
        Route::get('/layanan/kasir', [LayananController::class, 'kasir'])->name('keuangan.kasir');
        Route::get('/layanan/kasir/{nofaktur}', [LayananController::class, 'kasirbayar'])->name('keuangan.kasir.bayar');
        Route::post('/layanan/kasir/add', [LayananController::class, 'kasirbayaradd'])->name('keuangan.kasir.bayar.add');
    // arsip atau data kasir
        Route::get('/layanan/datatransaksi', [LayananController::class, 'datatransaksi'])->name('keuangan.datatransaksi');

        Route::get('/layanan/datakasir', [LayananController::class, 'datakasir'])->name('keuangan.datakasir');
        Route::post('/layanan/datakasir/pdf', [LayananController::class, 'datakasirPdf'])->name('keuangan.datakasir.Pdf');

        Route::get('/layanan/datadetail', [LayananController::class, 'dataobat'])->name('keuangan.dataobat');
        Route::post('/layanan/datadetail/pdf', [LayananController::class, 'datadetailPdf'])->name('keuangan.datadetail.Pdf');


// Modul Gudang Internal
    // Barang
        // Data Barang
            Route::get('/datamaster/dabar', [DatamasterController::class, 'dabar'])->name('datmas.dabar');
            Route::post('/datamaster/dabar/add', [DatamasterController::class, 'dabaradd'])->name('datmas.dabar.add');

        // Pembelian
            Route::get('/barang/pembelian', [BarangController::class, 'pembelian'])->name('barang.pembelian');
            Route::post('/barang/pembelian/add', [BarangController::class, 'pembelianadd'])->name('barang.pembelian.add');

        // Supplier
            Route::get('/datamaster/industri', [DatamasterController::class, 'industri'])->name('datmas.industri');
            Route::post('/datamaster/industri/add', [DatamasterController::class, 'industriadd'])->name('datmas.industri.add');

    // Setting & Harga
        // Harga Item
            Route::get('/gudang/hargaobat', [BarangController::class, 'hargaobat'])->name('gudang.hargaobat');

        // Setting Margin + embalase
            Route::get('/gudang/hargaobat/setting', [BarangController::class, 'setting'])->name('gudang.setting');
            Route::post('/gudang/hargaobat/setting/add', [BarangController::class, 'settingadd'])->name('gudang.setting.add');

        // obat bpjs
        Route::get('/pcare/obats', [PCareController::class, 'obats'])->name('pcare.obats');
    // Stok Realtime
        Route::get('/gudang/gudangobat', [BarangController::class, 'gudangobat'])->name('gudang.gudangobat');

    // Khusus omega klinik request Obat
        Route::get('/gudang/request', [BarangController::class, 'requestObat'])->name('gudang.request');
        Route::post('/gudang/request/add', [BarangController::class, 'requestObatAdd'])->name('gudang.request.add');
        Route::post('/gudang/request/approve/{id}', [BarangController::class, 'approveObat'])->name('gudang.request.approve');
        Route::delete('/gudang/request/reject/{id}', [BarangController::class, 'rejectObat'])->name('gudang.request.reject');


// Modul DataMaster
    // GCS
        Route::get('/gcs/eye', [GcsController::class, 'eye'])->name('datmas.eye');
        Route::post('/gcs/eye/add', [GcsController::class, 'eyeadd'])->name('gcs.eye.add');
        Route::delete('/gcs/eye/delete/{id}', [GcsController::class, 'eyedelet'])->name('gcs.eye.delete');
        Route::put('/gcs/eye/update/{id}' , [GcsController::class, 'eyeedit'])->name('gcs.eye.edit');


        Route::get('/gcs/verbal', [GcsController::class, 'verbal'])->name('datmas.verbal');
        Route::post('/gcs/verbal/add', [GcsController::class, 'verbaladd'])->name('gcs.verbal.add');
        Route::delete('/gcs/verbal/delete/{id}', [GcsController::class, 'verbaldelet'])->name('gcs.verbal.delete');
        Route::put('/gcs/verbaledit/update/{id}' , [GcsController::class, 'verbaledit'])->name('gcs.verbal.edit');

        Route::get('/gcs/motorik', [GcsController::class, 'motorik'])->name('datmas.motorik');
        Route::post('/gcs/motorik/add', [GcsController::class, 'motorikadd'])->name('gcs.motorik.add');
        Route::delete('/gcs/motorik/delete/{id}', [GcsController::class, 'motorikdelet'])->name('gcs.motorik.delete');
        Route::put('/gcs/motorik/update/{id}' , [GcsController::class, 'motorikedit'])->name('gcs.motorik.edit');

        Route::get('/gcs/nilai', [GcsController::class, 'nilai'])->name('datmas.nilai');
        Route::post('/gcs/nilai/add', [GcsController::class, 'nilaiadd'])->name('gcs.nilai.add');


    //dokter

        Route::get('/doctor/poli', [DoctorController::class, 'poli'])->name('doctor.poli');
        Route::post('/doctor/poli/update', [DoctorController::class, 'update_poli_bpjs'])->name('doctor.poli.update');

        Route::get('/doctor/jabatan', [DoctorController::class, 'jabatan'])->name('doctor.jabatan');
        Route::post('/doctor/jabatans/add', [DoctorController::class, 'jabatanadd'])->name('doctor.jabatans.add');

        Route::get('/doctor/status', [DoctorController::class, 'status'])->name('doctor.status');
        Route::post('/doctor/status/add', [DoctorController::class, 'statusadd'])->name('doctor.status.add');

        Route::get('/datamaster/posker', [DatamasterController::class, 'posker'])->name('datmas.posker');
        Route::post('/datamaster/posker', [DatamasterController::class, 'poskeradd'])->name('datmas.posker.add');

        Route::get('/pcare/spesialis', [PCareController::class, 'spesialis'])->name('pcare.spesialis');
        Route::get('/pcare/subspesialis/{kode}', [PCareController::class, 'subspesialis'])->name('pcare.subspesialis');

        Route::get('/pcare/icd10', [PCareController::class, 'icd10'])->name('pcare.icd10');

        Route::get('/pcare/provider', [PCareController::class, 'provider'])->name('pcare.provider');
        Route::get('/pcare/sarana', [PCareController::class, 'sarana'])->name('pcare.sarana');
        Route::get('/pcare/khusus', [PCareController::class, 'khusus'])->name('pcare.khusus');

    // datmas icd
        Route::get('/datamaster/icd', [DatamasterController::class, 'icd'])->name('datmas.icd');
        Route::post('/datamaster/icd9', [DatamasterController::class, 'icd9add'])->name('datmas.icd.9add');
        Route::post('/datamaster/icd10', [DatamasterController::class, 'icd10add'])->name('datmas.icd.10add');

    // datmas kategori perawatan
        Route::get('/datamaster/katper', [DatamasterController::class, 'katper'])->name('datmas.katper');
        Route::post('/datamaster/katper/add', [DatamasterController::class, 'katperadd'])->name('datmas.katper.add');
        Route::put('/kategori-perawatan/update/{id}', [DatamasterController::class, 'katperUpdate'])->name('datmas.katper.update');
        Route::delete('/kategori-perawatan/delete/{id}', [DatamasterController::class, 'katperDestroy'])->name('datmas.katper.delete');


    // datmas kode satuan
        Route::get('/datamaster/satuan', [DatamasterController::class, 'satuan'])->name('datmas.satuan');
        Route::post('/datamaster/satuan/add', [DatamasterController::class, 'satuanadd'])->name('datmas.satuan.add');
        Route::put('/datamaster/satuan/update/{id}', [DatamasterController::class, 'satuanUpdate'])->name('datmas.satuan.update');
        Route::delete('/datamaster/satuan/delete/{id}', [DatamasterController::class, 'satuanDestroy'])->name('datmas.satuan.delete');

    // datmas jenis barang
        Route::get('/datamaster/jenbar', [DatamasterController::class, 'jenbar'])->name('datmas.jenbar');
        Route::post('/datamaster/jenbar/add', [DatamasterController::class, 'jenbaradd'])->name('datmas.jenbar.add');
        Route::put('/datamaster/jenbar/update/{id}', [DatamasterController::class, 'jenbarUpdate'])->name('datmas.jenbar.update');
        Route::delete('/datamaster/jenbar/delete/{id}', [DatamasterController::class, 'jenbarDestroy'])->name('datmas.jenbar.delete');

    // datmas goldar
        Route::get('/patient/goldar', [DatamasterController::class, 'goldar'])->name('patient.goldar');
        Route::post('/patient/goldar/add', [DatamasterController::class, 'goldaradd'])->name('patient.goldar.add');
        Route::put('/datamaster/goldar/update/{id}', [DatamasterController::class, 'goldarUpdate'])->name('datmas.goldar.update');
        Route::delete('/datamaster/goldar/delete/{id}', [DatamasterController::class, 'goldarDestroy'])->name('datmas.goldar.delete');

    // datmas penanggung jawab
        Route::get('/datamaster/penjab', [DatamasterController::class, 'penjab'])->name('datmas.penjab');
        Route::post('/datamaster/penjab/add', [DatamasterController::class, 'penjabadd'])->name('datmas.penjab.add');
        Route::put('/datamaster/penjab/update/{id}', [DatamasterController::class, 'penjabUpdate'])->name('datmas.penjab.update');
        Route::delete('/datamaster/penjab/delete/{id}', [DatamasterController::class, 'penjabDestroy'])->name('datmas.penjab.delete');

    // datmas bank
        Route::get('/datamaster/bank', [DatamasterController::class, 'bank'])->name('datmas.bank');
        Route::post('/datamaster/bank/add', [DatamasterController::class, 'bankadd'])->name('datmas.bank.add');
        Route::put('/datamaster/bank/update/{id}', [DatamasterController::class, 'bankUpdate'])->name('datmas.bank.update');
        Route::delete('/datamaster/bank/delete/{id}', [DatamasterController::class, 'bankDestroy'])->name('datmas.bank.delete');

    // datmas bangsa
        Route::get('/patient/bangsa', [DatamasterController::class, 'bangsa'])->name('patient.bangsa');
        Route::post('/patient/bangsa/add', [DatamasterController::class, 'bangsaadd'])->name('patient.bangsa.add');
        Route::put('/datamaster/bangsa/update/{id}', [DatamasterController::class, 'bangsaUpdate'])->name('datmas.bangsa.update');
        Route::delete('/datamaster/bangsa/delete/{id}', [DatamasterController::class, 'bangsaDestroy'])->name('datmas.bangsa.delete');

    // datmas bahasa
        Route::get('/patient/bahasa', [DatamasterController::class, 'bahasa'])->name('patient.bahasa');
        Route::post('/patient/bahasa/add', [DatamasterController::class, 'bahasaadd'])->name('patient.bahasa.add');
        Route::put('/datamaster/bahasa/update/{id}', [DatamasterController::class, 'bahasaUpdate'])->name('datmas.bahasa.update');
        Route::delete('/datamaster/bahasa/delete/{id}', [DatamasterController::class, 'bahasaDestroy'])->name('datmas.bahasa.delete');

    // datmas suku
        Route::get('/patient/suku', [DatamasterController::class, 'suku'])->name('patient.suku');
        Route::post('/patient/suku/add', [DatamasterController::class, 'sukuadd'])->name('patient.suku.add');
        Route::put('/datamaster/suku/update/{id}', [DatamasterController::class, 'sukuUpdate'])->name('datmas.suku.update');
        Route::delete('/datamaster/suku/delete/{id}', [DatamasterController::class, 'sukuDestroy'])->name('datmas.suku.delete');

    // datmas seks
        Route::get('/patient/seks', [DatamasterController::class, 'seks'])->name('patient.seks');
        Route::post('/patient/seks/add', [DatamasterController::class, 'seksadd'])->name('patient.seks.add');
        Route::put('/datamaster/seks/update/{id}', [DatamasterController::class, 'seksUpdate'])->name('datmas.seks.update');
        Route::delete('/datamaster/seks/delete/{id}', [DatamasterController::class, 'seksDestroy'])->name('datmas.seks.delete');

    // datmas perawatan rawat jalanx
        Route::get('/datamaster/perjal', [DatamasterController::class, 'perjal'])->name('datmas.perjal');
        Route::post('/datamaster/perjal/add', [DatamasterController::class, 'perjaladd'])->name('datmas.perjal.add');
        Route::put('/datamaster/perjal/update/{id}', [DatamasterController::class, 'perjalUpdate'])->name('datmas.perjal.update');
        Route::delete('/datamaster/perjal/delete/{id}', [DatamasterController::class, 'perjalDestroy'])->name('datmas.perjal.delete');

    // Head To Toe
        // datmas Head To Toe pemeriksaan
            Route::get('/datamaster/headtotoe/pemeriksaan', [DatamasterController::class, 'httpemeriksaan'])->name('datmas.httpemeriksaan');
            Route::post('/datamaster/headtotoe/pemeriksaan/add', [DatamasterController::class, 'httpemeriksaanadd'])->name('datmas.httpemeriksaan.add');
            Route::delete('/datamaster/headtotoe/pemeriksaan/{id}', [DatamasterController::class, 'httpemeriksaanDelete'])->name('datmas.httpemeriksaan.delete');
            Route::put('/datamaster/headtotoe/pemeriksaan/edit/{id}', [DatamasterController::class, 'httpemeriksaanEdit'])->name('datmas.httpemeriksaan.edit');

        // datmas Head To Toe subpemeriksaan
            Route::get('/datamaster/headtotoe/subpemeriksaan', [DatamasterController::class, 'httsubpemeriksaan'])->name('datmas.httsubpemeriksaan');
            Route::post('/datamaster/headtotoe/subpemeriksaan/add', [DatamasterController::class, 'httsubpemeriksaanadd'])->name('datmas.httsubpemeriksaan.add');
            Route::delete('/datamaster/headtotoe/subpemeriksaan/delete/{id}', [DatamasterController::class, 'httsubpemeriksaanDelete'])->name('datmas.httsubpemeriksaan.delete');
            Route::put('/datamaster/headtotoe/subpemeriksaan/edit/{id}', [DatamasterController::class, 'httsubpemeriksaanEdit'])->name('datmas.httsubpemeriksaan.edit');

    // diet
        Route::get('/datamaster/jenis-diet', [DatamasterController::class, 'jenisdiet'])->name('datmas.jenisdiet');
        Route::post('/datamaster/jenis-diet/add', [DatamasterController::class, 'jenisdietadd'])->name('datmas.jenisdiet.add');

        Route::get('/datamaster/jenis-diet/makanan', [DatamasterController::class, 'jenismakanadiet'])->name('datmas.jenisdiet.makana');
        Route::post('/datamaster/jenis-diet/makanan/add', [DatamasterController::class, 'jenismakanadietadd'])->name('datmas.jenisdiet.makana.add');
    // Modul Pengiriman Obat untuk Omega
        Route::get('/gudang-utama', [GudangUtamaController::class, 'index'])->name('kirimObat');
        Route::post('/gudang-utama/add', [GudangUtamaController::class, 'kirimObatadd'])->name('kirimObatadd');

    // Modul Data Lama Omega
        Route::get('/data-lama/pemeriksaan', [DatamasterController::class, 'datalama_pemeriksaan'])->name('datalama_pemeriksaan');
});
