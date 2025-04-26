<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\MenuManajemen;
use App\Models\MenuSubManajemen;
use Illuminate\Support\Facades\DB;

class DynamicMenuAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Jika user belum login, redirect ke halaman login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses halaman ini.');
        }

        $routeName = $request->route()->getName(); // Mendapatkan nama route yang diakses
        $userRoles = $user->roles->pluck('id')->toArray(); // Ambil semua role_id user


        // Cari permission berdasarkan route dari database
        $menu = MenuManajemen::where('route', $routeName)->first();

        // Jika menu ditemukan dan user memiliki "all-permission", izinkan akses tanpa batas
        if ($user->hasPermissionTo('all-permission')) {
            return $next($request);
        }

        // Jika menu ditemukan dan ada permission yang dibutuhkan
        if ($menu && $user->hasPermissionTo($menu->permission)) {
            return $next($request);
        }

        // Jika user tidak memiliki izin, redirect ke dashboard dengan pesan error
        $redirectRoute = null;
        foreach ($userRoles as $roleId) {
            $redirectRoute = DB::table('role_redirects')
                ->where('role_id', $roleId)
                ->value('redirect_route');

            if ($redirectRoute) {
                break; // Hentikan loop jika sudah menemukan rute pengalihan
            }
        }

        // Redirect berdasarkan role atau default ke dashboard
        if ($redirectRoute) {
            return redirect()->route($redirectRoute)->with('error', 'Anda tidak memiliki izin untuk mengakses halaman ini.');            ;
        }
    }
}
