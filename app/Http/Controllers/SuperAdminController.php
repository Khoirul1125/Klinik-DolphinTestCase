<?php

namespace App\Http\Controllers;

use App\Models\faktur_apotek;
use App\Models\pasien;
use App\Models\rajal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    //
    public function index()
    {
        $title = 'Rs Apps';
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        $Pasienb = pasien::whereMonth('created_at', $currentMonth)
                        ->whereYear('created_at', $currentYear)
                        ->count();

        $totalPatients = Pasien::count();

        $rajal = rajal::count();
        $apotek = faktur_apotek::count();
        $patientData = [
            ['label' => 'Rawat Jalan', 'count' => $rajal, 'color' => '#3c8dbc'],
            ['label' => 'Apotek', 'count' => $apotek, 'color' => '#f39c12']
        ];

        $timeStats = [
            ['icon' => 'fa-chair', 'title' => 'Rata Waktu Tunggu Dokter', 'time' => '153 m 32 s'],
            ['icon' => 'fa-user', 'title' => 'Pasien Baru Bulan Ini', 'count' => $Pasienb],
            ['icon' => 'fa-user', 'title' => 'Pasien Baru Bulan Ini', 'count' => 58],
            ['icon' => 'fa-phone', 'title' => 'Rata Waktu Konsultasi', 'time' => '263 m 25 s'],
            ['icon' => 'fa-phone', 'title' => 'Rata Waktu Konsultasi', 'time' => '263 m 25 s'],
            ['icon' => 'fa-clipboard', 'title' => 'Pasien Terdaftar di Klinik', 'count' => $totalPatients]
        ];

        $financialData = [
            ['label' => 'Total Pendapatan Bulan Februari', 'amount' => 'Rp. 0', 'color' => 'green'],
            ['label' => 'Total Pengeluaran Bulan Februari', 'amount' => 'Rp. 0', 'color' => 'red']
        ];
        return view('superadmin.index', compact('title','patientData', 'timeStats', 'financialData'));
    }



    public function userrolepremesion()
    {
        $users = User::get();
        return view('superadmin.users', ['users' => $users]);

    }
    public function edit(User $user)
    {
        $roles = Role::pluck('name','name')->all();
        $userRoles = $user->roles->pluck('name','name')->all();
        return view('superadmin.useredit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles
        ]);
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'required'
        ]);
        $user->syncRoles($request->roles);

        // var_dump($request);
        return redirect()->route('user.role-premesion')->with('status', 'Permissions added to role');

    }

    public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('user.role-premesion')->with('status', 'Permissions added to role');
    }
}
