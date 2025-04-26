<?php

use App\Http\Controllers\Modules\DoctorController;
use App\Http\Controllers\SuperAdminController;
use Illuminate\Support\Facades\Route;

// halaman Dokter
Route::middleware(['auth', 'verified'])->group(function () {
    // dashboard
    Route::get('/dokter-dash', [DoctorController::class, 'index'])->name('dokter-dash');
});
