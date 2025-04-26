<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session; // Tambahkan use Session jika belum ada


class VerifyLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     $license = DB::table('licenses')->where('id', 1)->first();

    //     $licenseKey = $license->key;
    //     $serverUrl = "http://100.94.229.86:3001"; // URL API server lisensi

    //     if (!$licenseKey) {
    //         Log::error("License key is missing.");
    //         abort(403, "License key is missing.");
    //     }

    //     Log::info("Verifying license from: $serverUrl");

    //     // Kirim request ke server lisensi menggunakan metode GET
    //     $response = Http::get("$serverUrl/api/license", [
    //         'license_key' => $licenseKey,
    //     ]);

    //     // Jika server tidak merespons atau terjadi error
    //     if ($response->failed()) {
    //         Log::error("License server is unavailable.");
    //         abort(500, "License server is unavailable. Please try again later.");
    //     }

    //     // Ambil data dari respons JSON
    //     $data = $response->json();

    //     // Periksa apakah lisensi valid
    //     if (!isset($data['license']) || !$data['license']['is_active']) {
    //         Log::error("Invalid or expired license.");
    //         abort(403, "Invalid or expired license.");
    //     }

    //     // Periksa apakah lisensi sudah kedaluwarsa
    //     $expiresAt = strtotime($data['license']['expires_at']); // Konversi ke timestamp
    //     if ($expiresAt && $expiresAt < time()) {
    //         Log::error("License has expired.");
    //         abort(403, "License has expired.");
    //     }

    //     Log::info("License is valid. Proceeding request.");

    //     return $next($request);
    // }


    public function handle(Request $request, Closure $next)
    {
        $license = DB::table('licenses')->where('id', 1)->first();

        $licenseKey = $license->key;
        $serverUrl = "http://100.94.229.86:3001"; // URL API server lisensi

        if (!$licenseKey) {
            Log::error("License key is missing.");
            Session::flash('license_error', 'License key is missing.');
            abort(403, "License key is missing.");
        }

        Log::info("Verifying license from: $serverUrl");

        // Kirim request ke server lisensi menggunakan metode GET
        $response = Http::get("$serverUrl/api/license", [
            'license_key' => $licenseKey,
        ]);

        if ($response->failed()) {
            Log::error("License server is unavailable.");
            Session::flash('license_error', 'License server is unavailable. Please try again later.');


        }

       // Ambil data dari respons JSON
        $data = $response->json();

        // Cek apakah respons JSON valid
        if (!is_array($data) || empty($data)) {
            Log::error("Invalid response format from license server.");
            Session::flash('license_error', 'Invalid response from license server.');
        } else {
            // Periksa apakah lisensi valid
            if (!isset($data['license']) || !isset($data['license']['is_active']) || !$data['license']['is_active']) {
                Log::error("Invalid or expired license.");
                Session::flash('license_error', 'Invalid or expired license.');
            }

            // Periksa apakah lisensi sudah kedaluwarsa
            if (isset($data['license']['expires_at'])) {
                $expiresAt = strtotime($data['license']['expires_at']); // Konversi ke timestamp
                if ($expiresAt && $expiresAt < time()) {
                    Log::error("License has expired.");
                    Session::flash('license_error', 'License has expired.');
                }
            } else {
                Log::error("Missing expiration date in license data.");
                Session::flash('license_error', 'License data is missing expiration information.');
            }
        }



        Log::info("License is valid. Proceeding request.");
        return $next($request);
    }

}
