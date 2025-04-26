<?php

namespace App\Http\Controllers;

use App\Models\RoleRedirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomepagesController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function redirectToDashboard()
    {
        // Ambil role_id pengguna yang sedang login
        $user = Auth::user();
        $roleNames = $user->roles->pluck('name');

        $redirectRoute = null;

        foreach ($roleNames as $roleName) {
            // Ambil rute pengalihan berdasarkan nama role (bukan role_id)
            $redirectRoute = RoleRedirect::where('role_id', $roleName)->value('redirect_route');

            if ($redirectRoute) {
                break; // Hentikan loop jika sudah menemukan rute pengalihan
            }
        }

        // Cek apakah redirectRoute ditemukan
        if (!empty($redirectRoute)) { // Pastikan redirectRoute tidak kosong
            return redirect()->route($redirectRoute);
        }
        // Jika tidak ada redirectRoute, arahkan ke rute default
        return redirect()->route('default_dashboard'); // Ganti dengan rute default Anda

    }
}
