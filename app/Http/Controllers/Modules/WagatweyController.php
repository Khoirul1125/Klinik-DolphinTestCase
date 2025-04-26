<?php

namespace App\Http\Controllers\Modules;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\licenses;
use App\Models\setweb;
use App\Models\whatsapp_sessions;
use Illuminate\Support\Facades\Http;

class WagatweyController extends Controller
{
    public function index()
    {
        $title = 'Rs Apps';
        $webset = setweb::all();
        $licenseKey = licenses::first()->key ?? ''; // Adjust the query as needed
        return view('wageteway.index', compact('title', 'webset','licenseKey'));
    }
    public function saveLicenseKey(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'license_key' => 'required|string|max:255',
        ]);

        // Save the license key to the database
        $license = licenses::find(1); // Assuming the ID is 1

    // Check if the license exists
    if ($license) {
        // Update the license key
        $license->key = $request->license_key;
        $license->save();

        return response()->json(['message' => 'License key updated successfully!'], 200);
    } else {
        return response()->json(['message' => 'License not found.'], 404);
    }

        return response()->json(['message' => 'License key saved successfully!']);
    }

    //
    private $whatsappApiUrl = 'http://100.94.229.86:3002/api';

    // ✅ Ambil `licenseKey` dari database (ID = 2)
    public function getLicenseKey()
    {
        $license = licenses::find(2);
        return $license ? $license->key : null;
    }

    // ✅ Ambil QR Code & Refresh Jika Belum Login
    public function getQrCode()
    {
        $licenseKey = $this->getLicenseKey();
        if (!$licenseKey) {
            return response()->json(['message' => 'License not found'], 403);
        }

        // Cek apakah WhatsApp sudah login
        $session = whatsapp_sessions::first();
        if ($session && $session->is_authenticated) {
            return response()->json(['message' => 'Already logged in', 'status' => 'ready']);
        }

        // Looping untuk menunggu koneksi WhatsApp hingga 1 menit (12 x 5 detik)
        $attempts = 0;
        while ($attempts < 12) {
            // Minta QR Code ke Next.js
            $response = Http::get("$this->whatsappApiUrl/get-qr", ['licenseKey' => $licenseKey]);
            if ($response->successful()) {
                $data = $response->json();

                // Jika WhatsApp sudah login, hentikan loop dan update status
                if ($data['status'] === 'ready') {
                    return response()->json(['message' => 'WhatsApp connected', 'status' => 'ready']);
                }

                // Jika masih menunggu scan QR Code, teruskan loop
                if ($data['status'] === 'pending' && isset($data['qrCode'])) {
                    return response()->json(['status' => 'pending', 'qrCode' => $data['qrCode']]);
                }
            }

            // Delay sebelum mencoba lagi
            sleep(30);
            $attempts++;
        }

        return response()->json(['message' => 'WhatsApp is not connected after multiple attempts'], 408);
    }

    // ✅ Simpan Status Login WhatsApp
    public function saveWhatsAppLogin(Request $request)
    {
        $session = whatsapp_sessions::updateOrCreate(
            [],
            ['whatsapp_number' => $request->whatsapp_number, 'is_authenticated' => true]
        );

        return response()->json(['message' => 'WhatsApp login saved', 'session' => $session]);
    }

    // ✅ Cek Status WhatsApp
    public function checkStatus()
    {
        $license = licenses::find(2); // Ambil lisensi dari database
        if (!$license) {
            return response()->json(['message' => 'License not found'], 403);
        }

        // Kirim request ke Next.js untuk cek status WhatsApp
        $response = Http::get("$this->whatsappApiUrl/check-status", [
            'licenseKey' => $license->key
        ]);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['status' => 'disconnected', 'message' => 'Failed to check WhatsApp status'], 500);
    }

    // ✅ Kirim Pesan WhatsApp (Gunakan Lisensi dari Database)
    public function sendMessage(Request $request)
    {
        $licenseKey = $this->getLicenseKey();
        if (!$licenseKey) {
            return response()->json(['message' => 'License not found'], 403);
        }


        // Kirim pesan menggunakan Next.js API
        $response = Http::post("$this->whatsappApiUrl/send-message", [
            'licenseKey' => $licenseKey,
            'phoneNumber' => $request->phoneNumber,
            'message' => $request->message
        ]);

        return response()->json($response->json());
    }
}
