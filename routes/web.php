<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BpjsController;
use App\Http\Controllers\DolphiController;
use App\Http\Controllers\HomepagesController;
use App\Http\Controllers\Modules\FinecController;
use App\Http\Controllers\Modules\DoctorController;
use App\Http\Controllers\Modules\FarmasiController;
use App\Http\Controllers\Modules\PatientController;
use App\Http\Controllers\Modules\ScheduleController;
use App\Http\Controllers\Modules\JanjiController;
use App\Http\Controllers\Modules\DatamasterController;
use App\Http\Controllers\Modules\BarangController;
use App\Http\Controllers\Modules\SumberdayamController;
use App\Http\Controllers\Modules\ObatController;
use App\Http\Controllers\Modules\LaporanController;
use App\Http\Controllers\Modules\KamarController;
use App\Http\Controllers\Modules\RegisController;
use App\Http\Controllers\Modules\LayananController;
use App\Http\Controllers\Modules\AntrianController;
use App\Http\Controllers\Modules\RadiologiController;
use App\Http\Controllers\Modules\LaboratoriumController;
use App\Http\Controllers\Modules\UtdController;
use App\Http\Controllers\Modules\PenjualanController;
use App\Http\Controllers\Modules\PCareController;
use App\Http\Controllers\Modules\GcsController;
use App\Http\Controllers\Modules\WagatweyController;
use App\Http\Controllers\Modules\GudangUtamaController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\websetController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SatusehatController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\WhatsAppController;
use Illuminate\Support\Facades\Route;



Route::get('/', [HomepagesController::class, 'index'])->name('default_dashboard');

Route::get('/redirect-dashboard', [HomepagesController::class, 'redirectToDashboard'])->name('redirect.dashboard');

Route::post('/update-app', [UpdateController::class, 'update'])->name('update.app');


Route::get('/check-nik-noka-antrian', [AntrianController::class, 'checkNikNokaAjax'])->name('checkNikNokaAjax');
Route::get('/doctors-by-poli/{poliId}', [AntrianController::class, 'getDoctorsByPoli'])->name('doctorsbypoli');
Route::post('/antrian/createtiket/add/bpjs', [AntrianController::class, 'antrian_bpjs_add'])->name('antrian.bpjs.add');
Route::post('/antrian/createtiket/add/nobpjs', [AntrianController::class, 'antrian_no_bpjs_add'])->name('antrian.no.bpjs.add');
Route::post('/antrian/createtiket/add/pasien', [AntrianController::class, 'antrian_pasien_baru'])->name('antrian.pasien.baru');
Route::get('/antrian/tiket', [AntrianController::class, 'createtiket'])->name('antrian.createtiket');

Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian');
Route::post('/panggil-pasien', [AntrianController::class, 'panggil']);
Route::post('/panggil-pasien-dokter', [AntrianController::class, 'panggildokter']);
Route::get('/get-antrian-terbaru', [AntrianController::class, 'getAntrianTerbaru']);
Route::post('/mark-antrian-called/{id}', [AntrianController::class, 'markAntrianCalled']);




Route::get('/antrian/loket-1', [AntrianController::class, 'loket'])->name('loket1');
Route::get('/get-antrian/{loketId}', [AntrianController::class, 'getAntrian']);
Route::post('/update-status/{id}', [AntrianController::class, 'updateStatus'])->name('updateStatus');
Route::post('/get-next-queue', [AntrianController::class, 'getNextQueue'])->name('getNextQueue');
Route::post('/update-all-status', [AntrianController::class, 'updateAllStatus']);

Route::post('/predict', [DolphiController::class, 'predict']);
Route::post('/speech-to-ai', [DolphiController::class, 'processSpeech']);




Route::get('/getAccessToken', [SatusehatController::class, 'getAccessToken'])->name('getAccessToken');
Route::get('/generateHeaders', [SatusehatController::class, 'generateHeaders'])->name('generateHeaders');

Route::get('/get-poli-fktp-bpjs', [BpjsController::class, 'get_poli_fktp_bpjs'])->name('get_poli_fktp_bpjs');
Route::get('/get-poli-anrol-bpjs', [BpjsController::class, 'get_poli_anrol_bpjs'])->name('get_poli_anrol_bpjs');
Route::get('/get-dokter-bpjs', [BpjsController::class, 'get_dokter_bpjs'])->name('get_dokter_bpjs');
Route::get('/get-spesialis-bpjs', [BpjsController::class, 'get_spesialis_bpjs'])->name('get_spesialis_bpjs');
Route::get('/get-sub-spesialis-bpjs/{nama}', [BpjsController::class, 'get_sub_spesialis_bpjs'])->name('get_sub_spesialis_bpjs');
Route::get('/get-ws-poli-bpjs', [BpjsController::class, 'get_ws_poli_bpjs'])->name('get_ws_poli_bpjs');
Route::get('/get-ws-dokter-bpjs/{nama}', [BpjsController::class, 'get_ws_dokter_bpjs'])->name('get_ws_dokter_bpjs');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/download/pdf/{filename}', function ($filename) {
        $filePath = storage_path('app/temp/' . $filename);
        return response()->download($filePath)->deleteFileAfterSend(true);
    })->name('download.pdf');


    Route::get('/decompress', [SatusehatController::class, 'decompress'])->name('decompress');

    Route::get('/practitionejenisKartu/{jenisKartu}', [SatusehatController::class, 'getPractitionerByNik'])->name('practitionejenisKartu');
    Route::get('/getPractitionerByNikall', [SatusehatController::class, 'getPractitionerByNikall'])->name('getPractitionerByNikall');
    Route::get('/search-matching-names/{Nama}', [SatusehatController::class, 'searchMatchingNames'])->name('getPractitioner');
    Route::get('/bpjs/{poli}', [SatusehatController::class, 'bpjs'])->name('bpjs');
    Route::get('/poli', [SatusehatController::class, 'poli'])->name('poli');
    Route::get('/comparePolisAndPoli', [SatusehatController::class, 'comparePolisAndPoli'])->name('comparePolisAndPoli');
    Route::get('/cekstatusconkesi', [SatusehatController::class, 'cekstatus'])->name('cekstatusconkesi');

    Route::get('/AllergyIntolerance/{code}', [SatusehatController::class, 'AllergyIntolerance'])->name('AllergyIntolerance');
});





// ,'check.menu.access'
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/antrian/home', [AntrianController::class, 'add'])->name('antrian.home');
    Route::post('/antrian/home/add', [AntrianController::class, 'adds'])->name('antrian.home.add');

    Route::get('/superadmin', [SuperAdminController::class, 'index'])->name('superadmin');


    Route::post('/check-sex-doctor', [DoctorController::class, 'checkSexdoctor'])->name('doctor.seks.cek');

    Route::get('/doctor/spesiali', [DoctorController::class, 'spesiali'])->name('doctor.spesiali');
    Route::post('/doctor/spesiali/add', [DoctorController::class, 'spesialiadd'])->name('doctor.spesiali.add');

    Route::get('/doctor/visit', [DoctorController::class, 'visitdocter'])->name('doctor.visit');
    Route::post('/doctor/visit', [DoctorController::class, 'visitdocteradd'])->name('doctor.visit.add');



    Route::get('/sdm', [SumberdayamController::class, 'index'])->name('sdm');
    Route::post('/sdm/add', [SumberdayamController::class, 'suberdayaadd'])->name('sdm.add');

    Route::get('/sdm/doktor', [SumberdayamController::class, 'doktor'])->name('sdm.doktor');

    Route::get('/sdm/apoteker', [SumberdayamController::class, 'apoteker'])->name('sdm.apoteker');
    Route::post('/sdm/apoteker/add', [SumberdayamController::class, 'apotekeradd'])->name('sdm.apoteker.add');

    Route::get('/sdm/laboratorium', [SumberdayamController::class, 'laboratorium'])->name('sdm.laboratorium');
    Route::post('/sdm/laboratorium/add', [SumberdayamController::class, 'laboratoriumadd'])->name('sdm.laboratorium.add');

    Route::get('/sdm/akuntan', [SumberdayamController::class, 'akuntan'])->name('sdm.akuntan');
    Route::post('/sdm/akuntan/add', [SumberdayamController::class, 'akuntanadd'])->name('sdm.akuntan.add');

    Route::post('/sdm/karyawan/add', [SumberdayamController::class, 'karyawanadd'])->name('sdm.karyawan.add');


    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
    Route::post('/laporan/add', [LaporanController::class, 'laporanadd'])->name('laporan.add');

    Route::get('/laporan/template', [LaporanController::class, 'laporantemplate'])->name('laporan.template');
    Route::post('/laporan/template/add', [LaporanController::class, 'laporantemplateadd'])->name('laporan.template.add');

    Route::get('/get-template-by-id/{id}', [LaporanController::class, 'getTemplateById'])->name('get.template.by.id');



// Sisa Modul Datamaster (ga tau masih dipake atau engga)
    Route::get('/datamaster', [DatamasterController::class, 'index'])->name('datmas');

    Route::get('/datamaster/bangsal', [DatamasterController::class, 'bangsal'])->name('datmas.bangsal');
    Route::post('/datamaster/bangsal/add', [DatamasterController::class, 'bangsaladd'])->name('datmas.bangsal.add');

    Route::get('/datamaster/pernap', [DatamasterController::class, 'pernap'])->name('datmas.pernap');
    Route::post('/datamaster/pernap/add', [DatamasterController::class, 'pernapadd'])->name('datmas.pernap.add');
    Route::get('/generate-kode-pernap', [DatamasterController::class, 'generateKodePernap'])->name('generate.kode.pernap');

    Route::get('/datamaster/perlogi', [DatamasterController::class, 'perlogi'])->name('datmas.perlogi');
    Route::post('/datamaster/perlogi/add', [DatamasterController::class, 'perlogiadd'])->name('datmas.perlogi.add');
    Route::get('/generate-kode-perlogi', [DatamasterController::class, 'generateKodePerlogi'])->name('generate.kode.perlogi');

    Route::get('/datamaster/perusahaan', [DatamasterController::class, 'perusahaan'])->name('datmas.perusahaan');
    Route::post('/datamaster/perusahaan/add', [DatamasterController::class, 'perusahaanadd'])->name('datmas.perusahaan.add');

    Route::get('/datamaster/katbar', [DatamasterController::class, 'katbar'])->name('datmas.katbar');
    Route::post('/datamaster/katbar/add', [DatamasterController::class, 'katbaradd'])->name('datmas.katbar.add');

    Route::get('/datamaster/katpen', [DatamasterController::class, 'katpen'])->name('datmas.katpen');
    Route::post('/datamaster/katpen/add', [DatamasterController::class, 'katpenadd'])->name('datmas.katpen.add');

    Route::get('/datamaster/golbar', [DatamasterController::class, 'golbar'])->name('datmas.golbar');
    Route::post('/datamaster/golbar/add', [DatamasterController::class, 'golbaradd'])->name('datmas.golbar.add');

    Route::get('/datamaster/cacat', [DatamasterController::class, 'cacat'])->name('datmas.cacat');
    Route::post('/datamaster/cacat/add', [DatamasterController::class, 'cacatadd'])->name('datmas.cacat.add');

    Route::get('/datamaster/aturanpake', [DatamasterController::class, 'aturanpake'])->name('datmas.aturanpake');
    Route::post('/datamaster/aturanpake/add', [DatamasterController::class, 'aturanpakeadd'])->name('datmas.aturanpake.add');

    Route::get('/datamaster/berkas', [DatamasterController::class, 'berkas'])->name('datmas.berkas');
    Route::post('/datamaster/berkas/add', [DatamasterController::class, 'berkasadd'])->name('datmas.berkas.add');
    Route::get('/generate-kode-berkas', [DatamasterController::class, 'generateKodeBerkas'])->name('generate.kode.berkas');

    Route::get('/datamaster/bidang', [DatamasterController::class, 'bidang'])->name('datmas.bidang');
    Route::post('/datamaster/bidang/add', [DatamasterController::class, 'bidangadd'])->name('datmas.bidang.add');

    Route::get('/datamaster/depart', [DatamasterController::class, 'depart'])->name('datmas.depart');
    Route::post('/datamaster/depart/add', [DatamasterController::class, 'departadd'])->name('datmas.depart.add');

    Route::get('/datamaster/emergency', [DatamasterController::class, 'emergency'])->name('datmas.emergency');
    Route::post('/datamaster/emergency/add', [DatamasterController::class, 'emergencyadd'])->name('datmas.emergency.add');

    Route::get('/datamaster/jenjab', [DatamasterController::class, 'jenjab'])->name('datmas.jenjab');
    Route::post('/datamaster/jenjab/add', [DatamasterController::class, 'jenjabadd'])->name('datmas.jenjab.add');

    Route::get('/datamaster/keljab', [DatamasterController::class, 'keljab'])->name('datmas.keljab');
    Route::post('/datamaster/keljab/add', [DatamasterController::class, 'keljabadd'])->name('datmas.keljab.add');

    Route::get('/datamaster/pendidikan', [DatamasterController::class, 'pendidikan'])->name('datmas.pendidikan');
    Route::post('/datamaster/pendidikan/add', [DatamasterController::class, 'pendidikanadd'])->name('datmas.pendidikan.add');

    Route::get('/datamaster/resiko', [DatamasterController::class, 'resiko'])->name('datmas.resiko');
    Route::post('/datamaster/resiko/add', [DatamasterController::class, 'resikoadd'])->name('datmas.resiko.add');

    Route::get('/datamaster/statker', [DatamasterController::class, 'statker'])->name('datmas.statker');
    Route::post('/datamaster/statker/add', [DatamasterController::class, 'statkeradd'])->name('datmas.statker.add');

    Route::get('/datamaster/statwp', [DatamasterController::class, 'statwp'])->name('datmas.statwp');
    Route::post('/datamaster/statwp/add', [DatamasterController::class, 'statwpadd'])->name('datmas.statwp.add');

    Route::get('/datamaster/metcik', [DatamasterController::class, 'metcik'])->name('datmas.metcik');
    Route::post('/datamaster/metcik/add', [DatamasterController::class, 'metcikadd'])->name('datmas.metcik.add');

    Route::get('/datamaster/ok', [DatamasterController::class, 'ok'])->name('datmas.ok');
    Route::post('/datamaster/ok/add', [DatamasterController::class, 'okadd'])->name('datmas.ok.add');
    Route::get('/datamaster/perawatan/{id}/manage', [DatamasterController::class, 'manage'])->name('datmas.perawatan.manage');
    Route::post('/datamaster/perawatan/{id}/add-detail', [DatamasterController::class, 'addDetail'])->name('datmas.perawatan.addDetail');
    Route::delete('/datamaster/perawatan/detail/{id}/delete', [DatamasterController::class, 'deleteDetail'])->name('datmas.perawatan.deleteDetail');

    Route::get('/datamaster/rujukan', [DatamasterController::class, 'rujukan'])->name('datmas.rujukan');
    Route::post('/datamaster/rujukan/add', [DatamasterController::class, 'rujukanadd'])->name('datmas.rujukan.add');








    Route::post('/regis/update-status', [RegisController::class, 'statusrajal'])->name('regis.update-status');
    Route::post('/regis/status-lanjut', [RegisController::class, 'statuslanjut'])->name('regis.status-lanjut');



    Route::put('/rajal/update-doctor/{id}', [RegisController::class, 'updateDoctor'])->name('rajal.updateDoctor');






    Route::post('/prosedur/store', [RegisController::class, 'storeProsedur'])->name('prosedur.store');
    Route::delete('/prosedur/destroy', [RegisController::class, 'destroyProsedur'])->name('prosedur.destroy');
    Route::post('/diagnosa/store', [RegisController::class, 'storeDiagnosa'])->name('diagnosa.store');
    Route::delete('/diagnosa/destroy', [RegisController::class, 'destroyDiagnosa'])->name('diagnosa.destroy');

    Route::get('/regis/kontrol/{norm}', [RegisController::class, 'kontrol'])->name('regis.kontrol');
    Route::post('/regis/kontrol/add', [RegisController::class, 'kontroladd'])->name('regis.kontrol.add');

    Route::get('setweb', [websetController::class, 'index'])->name('setweb');
    Route::post('setweb/update', [websetController::class, 'updates'])->name('setweb.update');
    Route::post('setweb/setsatusehat', [websetController::class, 'set_satusehat'])->name('setweb.setsatusehat');
    Route::post('setweb/setbpjs', [websetController::class, 'set_bpjs'])->name('setweb.setbpjs');



    Route::get('permissions', [PermissionController::class, 'index'])->name('permissions');
    Route::post('permissions/store', [PermissionController::class, 'store'])->name('permissions.store');
    Route::post('permissions/update', [PermissionController::class, 'update'])->name('permissions.update');
    Route::post('permissions/destroy', [PermissionController::class, 'destroy'])->name('permissions.destroy');

    Route::get('role', [RoleController::class, 'index'])->name('role');
    Route::post('role/store', [RoleController::class, 'store'])->name('role.store');
    Route::post('role/update', [RoleController::class, 'update'])->name('role.update');
    Route::post('role/destroy', [RoleController::class, 'destroy'])->name('role.destroy');
    Route::get('role/{roleId}/give', [RoleController::class, 'addPermissionToRole'])->name('role.give');
    Route::put('role/{roleId}/give', [RoleController::class, 'givePermissionToRole'])->name('role.give.put');

    Route::get('user/role-premesion', [SuperAdminController::class, 'userrolepremesion'])->name('user.role-premesion');
    Route::get('user/role-premesion/{user}/edit', [SuperAdminController::class, 'edit'])->name('user.role-premesions');
    Route::put('user/role-premesion/{user}/edit', [SuperAdminController::class, 'update'])->name('user.role-premesion.edit');
    Route::get('user/role-premesion/{user}', [SuperAdminController::class, 'destroy'])->name('user.role-premesion.del');


    Route::get('wagateway', [WagatweyController::class, 'index'])->name('wagateway');
    Route::post('/save-license-key', [WagatweyController::class, 'saveLicenseKey']);



});



Route::middleware(['auth', 'verified', 'role:Admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
});


require __DIR__ . '/auth.php';
require __DIR__ . '/modul.php';
require __DIR__ . '/admins.php';
