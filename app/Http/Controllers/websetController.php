<?php

namespace App\Http\Controllers;

use App\Models\bank;
use App\Models\licenses;
use App\Models\set_bpjs;
use App\Models\set_satusehat;
use App\Models\setsatusehat;
use App\Models\setweb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class websetController extends Controller
{
    public function index()
    {
        $title = 'Rs Apps';
        $webset = setweb::all();
        $setbpjs = set_bpjs::all();
        $setsatusehat = set_satusehat::all();
        $license = licenses::find(1); // Mencari record dengan id = 1
        $licensewa = licenses::find(2); // Mencari record dengan id = 1
        $licenseKey = $license->key ?? '';
        $bank = bank::all();
        return view('superadmin.webset', compact('title', 'webset','setbpjs','setsatusehat','licenseKey','licensewa','bank'));
    }

    public function updates(Request $request)
    {
        // Validate the request
        $request->validate([
            'name_app' => 'required|string|max:255',
            'logo_app' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the SetWeb record you want to update by id
        $setWeb = SetWeb::findOrFail($request->id);

        // Update name_app
        $setWeb->name_app = $request->name_app;


        // Handle the file upload
        if ($request->hasFile('logo_app')) {
            // Remove the old file if it exists
            $oldFileName = $setWeb->logo_app;
            if ($oldFileName) {
                $oldFilePath = public_path('webset/' . $oldFileName);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            $file = $request->file('logo_app');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // Store the file directly in the 'public/webset' directory
            $file->move(public_path('webset'), $fileName);

            // Update logo_app with the relative path from 'public/webset'
            $setWeb->logo_app = $fileName;  // Store the relative path
        }

        // Save the changes
        $setWeb->save();

        return redirect()->back()->with('success', 'Record updated successfully.');
    }

    public function set_satusehat(Request $request)
    {
        $id = 1 ;
        $validated = $request->validate([
            'org_id' => 'string',
            'client_id' => 'string',
            'client_secret' => 'string',
            'SCREET_KEY' => 'string',
            'SATUSEHAT_BASE_URL' => 'string',
        ]);

        $record = set_satusehat::findOrFail($id);
        $record->update($validated);
        return redirect()->route('setweb')->with('success', 'Record updated successfully.');
    }
    public function set_bpjs(Request $request)
    {
        $id = 1 ;
        $validated = $request->validate([
            'CONSID' => 'string',
            'USERNAME' => 'string',
            'PASSWORD' => 'string',
            'SCREET_KEY' => 'string',
            'USER_KEY' => 'string',
            'APP_CODE' => 'string',
            'BASE_URL' => 'string',
            'SERVICE' => 'string',
            'SERVICE_ANTREAN' => 'string',
            'KPFK' => 'string',
        ]);

        $record = set_bpjs::findOrFail($id);
        $record->update($validated);
        return redirect()->route('setweb')->with('success', 'Record updated successfully.');
    }

    public function saveLicenseKey(Request $request,$id)
    {
        // ✅ Pastikan hanya ID 1 (app) atau ID 2 (wa_token) yang bisa diupdate
        if (!in_array($id, [1, 2])) {
            return response()->json(['message' => 'Invalid license ID'], 400);
        }

        // ✅ Validasi input
        $validatedData = $request->validate([
            'key' => 'required|string|max:255',
        ]);

        // ✅ Cari lisensi berdasarkan ID
        $license = licenses::find($id);
        if (!$license) {
            return response()->json(['message' => "License with ID $id not found"], 404);
        }

        // ✅ Update lisensi yang ditemukan
        $license->key = $validatedData['key'];
        $license->save();

        // ✅ Hapus sesi error lisensi jika pembaruan berhasil
        Session::forget('license_error');

        return response()->json([
            'message' => "License ID $id updated successfully",
            'license' => $license
        ], 200);
    }
}
