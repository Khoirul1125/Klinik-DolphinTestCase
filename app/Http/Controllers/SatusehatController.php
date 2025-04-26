<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use LZCompressor\LZString;
use App\Models\kadok;
use App\Models\set_bpjs;
use App\Models\set_satusehat;
use GuzzleHttp\Client;
use GuzzleHttp\Promise;

use function Laravel\Prompts\error;

class SatusehatController extends Controller
{
    public function get_token()
    {
        $config = set_satusehat::find(1);

        if (!$config) {
            abort(500, 'Configuration not found.');
        }

        $response = Http::asForm()->withHeaders([
            'Content-Type' => 'application/x-www-form-urlencoded',
            'User-Agent' => 'PostmanRuntime/7.26.10',
        ])->post("{$config->SATUSEHAT_BASE_URL}/oauth2/v1/accesstoken?grant_type=client_credentials", [
            'client_id' => $config->client_id,
            'client_secret' => $config->client_secret,
        ]);

        return $response->successful() ? $response->json('access_token') : null;
    }


    public function get_nik_satusehat($jenisKartu)
    {
        $config = set_satusehat::find(1);
        $BASE_URL = $config->SATUSEHAT_BASE_URL;
        // Periksa apakah NIK diberikan
        if (empty($jenisKartu)) {
            return response()->json(['error' => 'NIK tidak boleh kosong'], 400);
        }

        // Dapatkan token akses
        $token = $this->get_token();

        if (!$token) {
            return response()->json(['error' => 'Unable to obtain access token'], 500);
        }

        // Mulai hitung waktu respons
        $startTime = microtime(true);

        // Lakukan request ke API
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get($BASE_URL.'/fhir-r4/v1/Patient?identifier=' . urlencode('https://fhir.kemkes.go.id/id/nik|' . $jenisKartu));

        // Hitung waktu respons
        $responseTime = round((microtime(true) - $startTime) * 1000, 2); // dalam milidetik

        // Cek apakah request gagal
        if ($response->failed()) {
            return response()->json([
                'error' => 'Request failed',
                'details' => $response->body(),
                'response_time_ms' => $responseTime
            ], 500);
        }

        // Kembalikan response JSON dengan response time
        return response()->json([
            'access_token' => $token,
            'patient_data' => $response->json(),
            'response_time_ms' => $responseTime
        ]);
    }




    public function generateHeaders()
    {
        $config = set_bpjs::find(1);

        $cons_id = $config->CONSID;
        $secret_key = $config->SCREET_KEY;
        $username = $config->USERNAME;
        $password = $config->PASSWORD;
        $app_code = $config->APP_CODE;
        $user_key = $config->USER_KEY;


        date_default_timezone_set('UTC');
        $timestamp = strval(time() - strtotime('1970-01-01 00:00:00'));


        $data = "{$cons_id}&{$timestamp}";
        $signature = hash_hmac('sha256', $data, $secret_key, true);
        $encodedSignature = base64_encode($signature);

        $key_decrypt = $cons_id.$secret_key.$timestamp;
        $signature = $encodedSignature;


        $data = "{$username}:{$password}:{$app_code}";
        $encodedAuth = base64_encode($data);
        $authorization = "Basic {$encodedAuth}";

        $data = [
            'X-cons-id'       => $cons_id,
            'X-Timestamp'     => $timestamp,
            'X-Signature'     => $signature,
            'X-Authorization' => $authorization,
            'user_key' => $user_key,
        ];

        return [
            'headers'    => $data,
            'key_decrypt' => $key_decrypt,
        ];

    }

    public function cekstatus()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;

        try {
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->generateHeaders()['headers']);

            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/");

            // Check the response status
            if ($response->successful()) {
                return response()->json(['status' => 'connect']);
            } else {
                return response()->json(['status' => 'disconnect']);
            }
        } catch (\Exception $e) {
            return response()->json(['status' => 'disconnect', 'error' => $e->getMessage()]);
        }
    }

    public function decompress($output)
    {
        // Decompress using LZString
        return LZString::decompressFromEncodedURIComponent($output);
    }



    public function getPractitionerByNik( $jenisKartu )
    {
        // Get NIK from request or fallback to input
        if ($jenisKartu === null) {
            $jenisKartu = $jenisKartu;
        }

        // Check if NIK is provided
        if (empty($jenisKartu)) {
            return response()->json(['error' => 'NIK tidak boleh kosong'], 400);
        }

        // Get access token
        $token = $this->get_token();

        if (!$token) {
            return response()->json(['error' => 'Unable to obtain access token'], 500);
        }

        // Make the API request to fetch patient by NIK
        $url = env('SATUSEHAT_BASE_URL').'/fhir-r4/v1/Practitioner?identifier=https%3A%2F%2Ffhir.kemkes.go.id%2Fid%2Fnik%7C' . $jenisKartu;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get($url);

        // Check for errors in the response
        if ($response->failed()) {
            return response()->json(['error' => 'Request failed', 'details' => $response->body()], 500);
        }

        // Return the API response as JSON

           // Return both the access token and the patient data
            return response()->json([
                'access_token' => $token,
                'patient_data' => $response->json()
            ]);
    }




    public function searchMatchingNames(Request $request)
    {
        // Validate the request input
        $request->validate([
            'name' => 'required|string',
        ]);

        // Get the name from the request
        $name = $request->input('name');


        // Search for matching names in the 'kadok' table
        $matchingKadoks = kadok::where('nama', 'LIKE', '%' . $name . '%')->get();

        // Combine the results
        $results = [
            'kadoks' => $matchingKadoks,
        ];

        // Return the results as JSON
        return response()->json($results);
    }



    public function AllergyIntolerance( $code )
    {
        // Get NIK from request or fallback to input
        if ($code === null) {
            $code = $code;
        }

        // Check if NIK is provided
        if (empty($code)) {
            return response()->json(['error' => 'code tidak boleh kosong'], 400);
        }

        // Get access token
        $token = $this->getAccessToken();

        if (!$token) {
            return response()->json(['error' => 'Unable to obtain access token'], 500);
        }

        // Make the API request to fetch patient by NIK
        $url = env('SATUSEHAT_BASE_URL').'/fhir-r4/v1/AllergyIntolerance/' . $code;

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ])->get($url);

        // Check for errors in the response
        if ($response->failed()) {
            return response()->json(['error' => 'Request failed', 'details' => $response->body()], 500);
        }

        // Return the API response as JSON

           // Return both the access token and the patient data
            return response()->json([
                'access_token' => $token,
                'patient_data' => $response->json()
            ]);
    }



    public function get_kfa_satusehat($nama)
    {

        $config = set_satusehat::find(1);
        $BASE_URL = $config->SATUSEHAT_BASE_URL;

        // Cek nama KFA
        if (empty($nama)) {
            return response()->json(['error' => 'Nama KFA tidak boleh kosong'], 400);
        }

        // Ambil token akses
        $token = $this->get_token();
        if (!$token) {
            return response()->json(['error' => 'Unable to obtain access token'], 500);
        }


        // Memulai permintaan ke API menggunakan Guzzle untuk parallel requests
        $client = new Client();
        $response = $client->request('GET', $BASE_URL .'/kfa-v2/products/all?page=1&size=100&product_type=kfa&keyword=' . $nama, [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token,
            ]
        ]);

        // Memeriksa apakah request berhasil
        if ($response->getStatusCode() !== 200) {
            return response()->json(['error' => 'Request failed', 'details' => $response->getBody()->getContents()], 500);
        }

        $products = json_decode($response->getBody()->getContents(), true);

        // Jika data produk ada, lanjutkan pengambilan detail produk secara paralel
        if (isset($products['items']['data'])) {
            $enhancedProducts = [];
            $promises = [];

            // Memulai permintaan paralel untuk mendapatkan detail produk berdasarkan kfa_code
            foreach ($products['items']['data'] as $product) {
                $kfaCode = $product['kfa_code'];

                $promises[] = $client->getAsync($BASE_URL .'/kfa-v2/products?identifier=kfa&code=' . $kfaCode, [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $token,
                    ]
                ]);
            }

            // $responses = promise::settle($promises)->wait();
            $responses = Promise\Utils::settle($promises)->wait(); // Promise::settle() untuk menunggu semua permintaan selesai


            // Gabungkan data produk dengan detailnya
            foreach ($products['items']['data'] as $index => $product) {
                // Pastikan hanya produk aktif yang ditambahkan ke hasil akhir
                if (isset($product['active']) && $product['active'] === false) {
                    continue;
                }
                // Ambil respons detail produk
                $detailResponse = $responses[$index];

                if ($detailResponse['state'] === 'fulfilled') {
                    $productDetail = json_decode($detailResponse['value']->getBody()->getContents(), true);
                    $product['detail'] = $productDetail;
                }

                $enhancedProducts[] = $product;
            }

            // Mengembalikan data yang sudah digabungkan sebagai JSON response
            return response()->json([
                'status' => 'success',
                'data' => $enhancedProducts,
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data produk tidak ditemukan.',
            ], 404);
        }
    }



}
