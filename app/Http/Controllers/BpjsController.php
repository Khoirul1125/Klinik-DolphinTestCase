<?php

namespace App\Http\Controllers;

use App\Models\dphobarang;
use App\Models\icd10;
use App\Models\khusus;
use App\Models\kopol;
use App\Models\provider;
use App\Models\sarana;
use App\Models\set_bpjs;
use App\Models\spesiali;
use App\Models\subspesialis;
use Illuminate\Http\Request;
use LZCompressor\LZString;
use Illuminate\Support\Facades\Http;

class BpjsController extends Controller
{
    public function get_token()
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

    public function get_noka_bpjs($noka)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'peserta';
        $maxRetries = 3;
        $attempt = 0;
        $data = null;
        $responseTime = 0;

        while ($attempt < $maxRetries && $data === null) {
            try {
                $startTime = microtime(true);

                $headers = array_merge([
                    'Content-Type' => 'application/json; charset=utf-8'
                ], $this->get_token()['headers']);
                $response = Http::withHeaders($headers)->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$noka}");
                $responseBody = json_decode($response->body(), true);

                $endTime = microtime(true);
                $responseTime = $endTime - $startTime;

                // Fetch the encrypted response data
                $encryptedString = $responseBody['response'];

                // Decrypt the string using AES-256-CBC
                $key = $this->get_token()['key_decrypt'];
                $encrypt_method = 'AES-256-CBC';
                $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
                $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

                // Decrypt the base64-encoded encrypted string
                $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

                $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

                // Decompress the string
                $data = json_decode($jsonString, true);

                if ($data !== null) {
                    break;
                }
            } catch (\Exception $e) {
                if ($attempt >= $maxRetries - 1) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'response_time' => $responseTime], 400);
                }
            }
            $attempt++;
        }

        return response()->json([
            "data" => $data,
            "response_time" => number_format($responseTime, 2)
        ]);
    }

    public function get_nik_bpjs($nik)
    {
        $config = set_bpjs::find(1);
        if (!$config) {
            return response()->json(['status' => 'error', 'message' => 'Config not found'], 500);
        }

        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'peserta/nik';
        $maxRetries = 3;
        $data = null;
        $responseTime = 0;

        // Ambil token hanya sekali
        $tokenData = $this->get_token();
        if (!$tokenData || !isset($tokenData['headers'], $tokenData['key_decrypt'])) {
            return response()->json(['status' => 'error', 'message' => 'Failed to retrieve token'], 500);
        }

        $headers = array_merge([
            'Content-Type' => 'application/json; charset=utf-8'
        ], $tokenData['headers']);

        for ($attempt = 0; $attempt < $maxRetries; $attempt++) {
            try {
                $startTime = microtime(true);

                // Kirim permintaan ke API
                $response = Http::withHeaders($headers)->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$nik}");

                $endTime = microtime(true);
                $responseTime = round(($endTime - $startTime) * 1000, 2); // dalam milidetik

                // Jika respons berhasil, langsung proses dan keluar dari loop
                if ($response->successful()) {
                    $responseBody = $response->json();

                    if (!isset($responseBody['response'])) {
                        return response()->json(['status' => 'error', 'message' => 'Invalid response format'], 500);
                    }

                    // Dekripsi data
                    $encryptedString = $responseBody['response'];
                    $encrypt_method = 'AES-256-CBC';
                    $key_hash = hex2bin(hash('sha256', $tokenData['key_decrypt']));
                    $iv = substr(hex2bin(hash('sha256', $tokenData['key_decrypt'])), 0, 16);

                    $decryptedString = openssl_decrypt(
                        base64_decode($encryptedString),
                        $encrypt_method,
                        $key_hash,
                        OPENSSL_RAW_DATA,
                        $iv
                    );

                    // Dekompresi hasil dekripsi
                    $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);
                    $data = json_decode($jsonString, true);

                    if ($data !== null) {
                        break; // Keluar dari loop jika berhasil
                    }
                }
            } catch (\Exception $e) {
                if ($attempt >= $maxRetries - 1) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $e->getMessage(),
                        'response_time_ms' => $responseTime
                    ], 400);
                }
            }
        }

        return response()->json([
            "status" => "success",
            "data" => $data,
            "response_time_ms" => $responseTime
        ]);
    }


    public function get_poli_fktp_bpjs()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'poli/fktp';
        $params = '0';
        $params1 = '500';
        $maxRetries = 3;
        $attempt = 0;
        $data = null;
        $responseTime = 0;

        while ($attempt < $maxRetries && $data === null) {
            try {
                $startTime = microtime(true);

                // Assuming $this->generateHeaders() returns an array of headers
                $headers = array_merge([
                    'Content-Type' => 'application/json; charset=utf-8'
                ], $this->get_token()['headers']);

                // Make the API request
                $response = Http::withHeaders($headers)
                    ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$params}/{$params1}");

                // Decode the response body
                $responseBody = json_decode($response->body(), true);

                $endTime = microtime(true);
                $responseTime = $endTime - $startTime;

                // Fetch the encrypted response data
                $encryptedString = $responseBody['response'];

                // Decrypt the string using AES-256-CBC
                $key = $this->get_token()['key_decrypt'];
                $encrypt_method = 'AES-256-CBC';
                $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
                $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

                // Decrypt the base64-encoded encrypted string
                $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

                $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

                // Decompress the string
                $data = json_decode($jsonString, true);

                if ($data !== null) {
                    break;
                }
            } catch (\Exception $e) {
                if ($attempt >= $maxRetries - 1) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'response_time' => number_format($responseTime, 2)], 400);
                }
            }
            $attempt++;
        }

        // Check if data is null or empty
        if (empty($data) || !isset($data['list']) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found', 'response_time' => number_format($responseTime, 2)], 400);
        }

        // Transform the data
        $transformedData = array_map(function($practitioner) {
            return [
                'kode_poli' => $practitioner['kdPoli'],
                'nama_poli' => $practitioner['nmPoli'],
                'jenis_poli' => $practitioner['poliSakit'] ? 'pengobatan penyakit' : 'pelayanan kesehatan'
            ];
        }, $data['list']);

        return response()->json([
            'data' => $transformedData,
            'response_time' => number_format($responseTime, 2)
        ]);
    }



    public function get_dokter_bpjs()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'dokter';
        $params = '1';
        $params1 = '100';
        $maxRetries = 3;
        $attempt = 0;
        $data = null;
        $responseTime = 0;

        while ($attempt < $maxRetries && $data === null) {
            try {
                $startTime = microtime(true);

                // Assuming $this->generateHeaders() returns an array of headers
                $headers = array_merge([
                    'Content-Type' => 'application/json; charset=utf-8'
                ], $this->get_token()['headers']);

                // Make the API request
                $response = Http::withHeaders($headers)
                    ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$params}/{$params1}");

                // Decode the response body
                $responseBody = json_decode($response->body(), true);

                $endTime = microtime(true);
                $responseTime = $endTime - $startTime;

                // Fetch the encrypted response data
                $encryptedString = $responseBody['response'];

                // Decrypt the string using AES-256-CBC
                $key = $this->get_token()['key_decrypt'];
                $encrypt_method = 'AES-256-CBC';
                $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
                $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

                // Decrypt the base64-encoded encrypted string
                $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

                $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

                // Decompress the string
                $data = json_decode($jsonString, true);

                if ($data !== null) {
                    break;
                }
            } catch (\Exception $e) {
                if ($attempt >= $maxRetries - 1) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'response_time' => number_format($responseTime, 2)], 400);
                }
            }
            $attempt++;
        }

        // Check if data is null or empty
        if (empty($data) || !isset($data['list']) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found', 'response_time' => number_format($responseTime, 2)], 400);
        }

        // Transform the data
        $transformedData = array_map(function($practitioner) {
            return [
                'kode_dokter' => $practitioner['kdDokter'],
                'nama_dokter' => $practitioner['nmDokter']
            ];
        }, $data['list']);

        return response()->json([
            "data" => $transformedData,
            "response_time" => number_format($responseTime, 2)
        ]);
    }


    public function get_poli_anrol_bpjs()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'antrean/panggil';
        $params = date('d-m-Y');
        $maxRetries = 3;
        $attempt = 0;
        $data = null;
        $responseTime = 0;

        while ($attempt < $maxRetries && $data === null) {
            try {
                $startTime = microtime(true);

                // Assuming $this->generateHeaders() returns an array of headers
                $headers = array_merge([
                    'Content-Type' => 'application/json; charset=utf-8'
                ], $this->get_token()['headers']);

                // Make the API request
                $response = Http::withHeaders($headers)
                    ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}");

                // Decode the response body
                $responseBody = json_decode($response->body(), true);

                $endTime = microtime(true);
                $responseTime = $endTime - $startTime;

                // Fetch the encrypted response data
                $encryptedString = $responseBody['response'];

                // Decrypt the string using AES-256-CBC
                $key = $this->get_token()['key_decrypt'];
                $encrypt_method = 'AES-256-CBC';
                $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
                $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

                // Decrypt the base64-encoded encrypted string
                $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

                $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

                // Decompress the string
                $data = json_decode($jsonString, true);

                if ($data !== null) {
                    break;
                }
            } catch (\Exception $e) {
                if ($attempt >= $maxRetries - 1) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage(), 'response_time' => number_format($responseTime, 2)], 400);
                }
            }
            $attempt++;
        }

        // Check if data is null or empty
        if (empty($data) || !isset($data['list']) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found', 'response_time' => number_format($responseTime, 2)], 400);
        }

        // Transform the data
        $transformedData = array_map(function($practitioner) {
            return [
                'kode_poli' => $practitioner['kdPoli'],
                'nama_poli' => $practitioner['nmPoli'],
                'jenis_poli' => $practitioner['poliSakit'] ? 'pengobatan penyakit' : 'pelayanan kesehatan'
            ];
        }, $data['list']);

        return response()->json([
            'data' => $transformedData,
            'response_time' => number_format($responseTime, 2)
        ]);
    }


    public function get_spesialis_bpjs()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'spesialis';

        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // // Check if data is null or empty
        if (empty($data) || !isset($data['list']) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }

        // // Insert data into the database
        foreach ($data['list'] as $practitioner) {
            // Check if the practitioner already exists
            $existingPractitioner = spesiali::where('kode', $practitioner['kdSpesialis'])->first();
            if (!$existingPractitioner) {
                // If it doesn't exist, save the new record
                $newPractitioner = new spesiali();
                $newPractitioner->kode = $practitioner['kdSpesialis'];
                $newPractitioner->nama = $practitioner['nmSpesialis'];
                $newPractitioner->save();
            } else {
                // Optionally, update the existing record
                $existingPractitioner->kode = $practitioner['kdSpesialis'];
                $existingPractitioner->nama = $practitioner['nmSpesialis'];
                $existingPractitioner->save();
            }
        }


        return response()->json( $data );
    }


    public function get_sub_spesialis_bpjs($nama)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'spesialis';
        $params = $nama;
        $params1 = 'subspesialis';

        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$params}/{$params1}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // Check if data is null or empty
        if (empty($data) || !isset($data['list']) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }

        // Insert data into the database
        foreach ($data['list'] as $practitioner) {
            // Check if the practitioner already exists
            $existingPractitioner = subspesialis::where('kode', $practitioner['kdSubSpesialis'])->first();
            if (!$existingPractitioner) {
                // If it doesn't exist, save the new record
                $newPractitioner = new subspesialis();
                $newPractitioner->kode = $practitioner['kdSubSpesialis'];
                $newPractitioner->nama = $practitioner['nmSubSpesialis'];
                $newPractitioner->kode_poli = $practitioner['kdPoliRujuk'];
                $newPractitioner->kode_spesialis = $nama;
                $newPractitioner->save();
            } else {
                // Optionally, update the existing record
                $existingPractitioner->kode = $practitioner['kdSubSpesialis'];
                $existingPractitioner->nama = $practitioner['nmSubSpesialis'];
                $existingPractitioner->kode_poli = $practitioner['kdPoliRujuk'];
                $existingPractitioner->kode_spesialis = $nama;
                $existingPractitioner->save();
            }
        }

        return response()->json( $data );
    }

    public function get_ws_poli_bpjs()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE_ANTREAN;
        $feature = 'ref/poli/tanggal';
        $params = date('Y-m-d');

        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$params}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        if (is_array($responseBody) ) {
            $encryptedString = $responseBody['response'];
        } else {
            return response()->json($responseBody);
        }



        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);




        return response()->json( $data );
    }

    public function get_ws_dokter_bpjs($nama)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE_ANTREAN;
        $feature = 'ref/dokter/kodepoli';
        $params = $nama;

        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$params}/tanggal/".date('Y-m-d'));

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        return response()->json( $data );
    }


    public function get_ws_add_bpjs($data)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE_ANTREAN;
        $feature = 'antrean/add';

        try {
            // Prepare headers, including token authentication if necessary
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']); // Assuming get_token() returns headers

            // Make the API request using POST method and pass the $data
            $response = Http::withHeaders($headers)
                ->post("{$BASE_URL}/{$SERVICE_NAME}/{$feature}", $data); // Send POST request with $data

            // Decode the response body
            $responseBody = json_decode($response->body(), true);

        } catch (\Exception $e) {
            // Return error response if the API request fails
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Check if the response contains expected data
        if (empty($responseBody) || !isset($responseBody['status'])) {
            return response()->json(['status' => 'error', 'message' => 'No valid response from BPJS'], 400);
        }

        // Return the response from BPJS
        return response()->json($responseBody);
    }

    public function icd10($nama)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME =  $config->SERVICE;
        $feature = 'diagnosa';
        $params = $nama;
        $params1 = '0';
        $params2 = '500';

        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$params}/{$params1}/{$params2}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // Check if data is null or empty
        if (empty($data) || !isset($data['list']) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }

        // Insert data into the database
        foreach ($data['list'] as $practitioner) {
            // Check if the practitioner already exists
            $existingPractitioner = icd10::where('kode', $practitioner['kdDiag'])->first();
            if (!$existingPractitioner) {
                // If it doesn't exist, save the new record
                $newPractitioner = new icd10();
                $newPractitioner->kode = $practitioner['kdDiag'];
                $newPractitioner->nama = $practitioner['nmDiag'];
                $newPractitioner->save();
            } else {
                // Optionally, update the existing record
                $existingPractitioner->kode = $practitioner['kdDiag'];
                $existingPractitioner->nama = $practitioner['nmDiag'];
                $existingPractitioner->save();
            }
        }

        return response()->json( $data );
    }

    public function get_ws_panggil_bpjs($data)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE_ANTREAN;
        $feature = 'antrean/panggil';

        try {
            // Prepare headers, including token authentication if necessary
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']); // Assuming get_token() returns headers

            // Make the API request using POST method and pass the $data
            $response = Http::withHeaders($headers)
                ->post("{$BASE_URL}/{$SERVICE_NAME}/{$feature}", $data); // Send POST request with $data

            // Decode the response body
            $responseBody = json_decode($response->body(), true);

        } catch (\Exception $e) {
            // Return error response if the API request fails
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Check if the response contains expected data
        if (empty($responseBody) || !isset($responseBody['status'])) {
            return response()->json(['status' => 'error', 'message' => 'No valid response from BPJS'], 400);
        }

        // Return the response from BPJS
        return response()->json($responseBody);
    }

    public function get_ws_batal_bpjs($data)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE_ANTREAN;
        $feature = 'antrean/batal';

        try {
            // Prepare headers, including token authentication if necessary
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']); // Assuming get_token() returns headers

            // Make the API request using POST method and pass the $data
            $response = Http::withHeaders($headers)
                ->post("{$BASE_URL}/{$SERVICE_NAME}/{$feature}", $data); // Send POST request with $data

            // Decode the response body
            $responseBody = json_decode($response->body(), true);

        } catch (\Exception $e) {
            // Return error response if the API request fails
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Check if the response contains expected data
        if (empty($responseBody) || !isset($responseBody['status'])) {
            return response()->json(['status' => 'error', 'message' => 'No valid response from BPJS'], 400);
        }

        // Return the response from BPJS
        return response()->json($responseBody);
    }
    public function post_pendaftaran_bpjs($data)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'pendaftaran';
        try {
            // Prepare headers, including token authentication if necessary
            $headers = array_merge([
                'Content-Type' => 'text/plain; charset=utf-8'
            ], $this->get_token()['headers']); // Assuming get_token() returns headers

            // Make the API request using POST method and pass the $data
            $response = Http::withHeaders($headers)
                ->post("{$BASE_URL}/{$SERVICE_NAME}/{$feature}", $data); // Send POST request with $data

            // Decode the response body
            $responseBody = json_decode($response->body(), true);

              // Fetch the encrypted response data
            $encryptedString = $responseBody['response'];

            // Decrypt the string using AES-256-CBC
            $key = $this->get_token()['key_decrypt'];
            $encrypt_method = 'AES-256-CBC';
            $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
            $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

            // Decrypt the base64-encoded encrypted string
            $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

            $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

            // Decompress the string
            $dataall = json_decode($jsonString, true);
        } catch (\Exception $e) {
            // Return error response if the API request fails
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Return the response from BPJS
        return response()->json($dataall);
    }

    public function post_kunjungan_bpjs($data)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'kunjungan';



        try {
            // Prepare headers, including token authentication if necessary
            $headers = array_merge([
                'Content-Type' => 'text/plain; charset=utf-8'
            ], $this->get_token()['headers']); // Assuming get_token() returns headers

            // Make the API request using POST method and pass the $data
            $response = Http::withHeaders($headers)
                ->post("{$BASE_URL}/{$SERVICE_NAME}/{$feature}", $data); // Send POST request with $data

            // Decode the response body
            $responseBody = json_decode($response->body(), true);

              // Fetch the encrypted response data
            $encryptedString = $responseBody['response'];

            // Decrypt the string using AES-256-CBC
            $key = $this->get_token()['key_decrypt'];
            $encrypt_method = 'AES-256-CBC';
            $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
            $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

            // Decrypt the base64-encoded encrypted string
            $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

            $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

            // Decompress the string
            $dataall = json_decode($jsonString, true);
        } catch (\Exception $e) {
            // Return error response if the API request fails
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Return the response from BPJS
        return response()->json($dataall);
    }

    public function get_statpul_bpjs($nama)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'statuspulang/rawatInap';
        $params = $nama;

        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$params}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // Check if data is null or empty
        if (empty($data) || !isset($data['list']) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }

        return response()->json( $data );
    }

    public function get_kesadaran_bpjs()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'kesadaran';

        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // Check if data is null or empty
        if (empty($data) || !isset($data['list']) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }

        return response()->json( $data );
    }


    public function get_provider_bpjs()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'provider';
        $params1 = '0';
        $params2 = '50';

        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$params1}/{$params2}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // // Check if data is null or empty
        if (empty($data) || !isset($data['list']) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }

        foreach ($data['list'] as $practitioner) {
            // Check if the practitioner already exists
            $existingPractitioner = provider::where('kode', $practitioner['kdProvider'])->first();
            if (!$existingPractitioner) {
                // If it doesn't exist, save the new record
                $newPractitioner = new provider();
                $newPractitioner->kode = $practitioner['kdProvider'];
                $newPractitioner->nama = $practitioner['nmProvider'];
                $newPractitioner->save();
            } else {
                // Optionally, update the existing record
                $existingPractitioner->kode = $practitioner['kdProvider'];
                $existingPractitioner->nama = $practitioner['nmProvider'];
                $existingPractitioner->save();
            }
        }
        return response()->json( $data );
    }

    public function get_sarana_bpjs()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'spesialis/sarana';


        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // // Check if data is null or empty
        if (empty($data) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }

        // Insert data into the database
        foreach ($data['list'] as $practitioner) {
            // Check if the practitioner already exists
            $existingPractitioner = sarana::where('kode', $practitioner['kdSarana'])->first();
            if (!$existingPractitioner) {
                // If it doesn't exist, save the new record
                $newPractitioner = new sarana();
                $newPractitioner->kode = $practitioner['kdSarana'];
                $newPractitioner->nama = $practitioner['nmSarana'];
                $newPractitioner->save();
            } else {
                // Optionally, update the existing record
                $existingPractitioner->kode = $practitioner['kdSarana'];
                $existingPractitioner->nama = $practitioner['nmSarana'];
                $existingPractitioner->save();
            }
        }
        return response()->json( $data );
    }

    public function get_khusus_bpjs()
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'spesialis/khusus';


        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // // Check if data is null or empty
        if (empty($data) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }


        // Insert data into the database
        foreach ($data['list'] as $practitioner) {
            // Check if the practitioner already exists
            $existingPractitioner = khusus::where('kode', $practitioner['kdKhusus'])->first();
            if (!$existingPractitioner) {
                // If it doesn't exist, save the new record
                $newPractitioner = new khusus();
                $newPractitioner->kode = $practitioner['kdKhusus'];
                $newPractitioner->nama = $practitioner['nmKhusus'];
                $newPractitioner->save();
            } else {
                // Optionally, update the existing record
                $existingPractitioner->kode = $practitioner['kdKhusus'];
                $existingPractitioner->nama = $practitioner['nmKhusus'];
                $existingPractitioner->save();
            }
        }
        return response()->json( $data );
    }


    public function get_rujukan_bpjs($nokunjungan)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'kunjungan/rujukan';


        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$nokunjungan}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // // Check if data is null or empty
        if (empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }
        return response()->json( $data );
    }

    public function delete_rujukan_bpjs($nokunjungan)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'kunjungan';


        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->delete("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$nokunjungan}");

            // Decode the response body
            $responseBody = $response->body();
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }


        return response()->json( $responseBody );
    }


    public function get_dphoobat_bpjs($nama)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'obat/dpho';
        $feature1 = '1';
        $feature2 = '50';

        try {
            // Get headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$nama}/{$feature1}/{$feature2}");

            // Decode response
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Decrypt response
        $encryptedString = $responseBody['response'];
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        // Decompress data
        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);
        $data = json_decode($jsonString, true);

        if (empty($data)) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }

        // Simpan ke database
        foreach ($data['list'] as $item) {
            dphobarang::updateOrCreate(
                ['kode_barang' => $item['kdObat']],
                ['nama_barang' => $item['nmObat']]
            );
        }

        return response()->json(['status' => 'success', 'message' => 'Data successfully saved', 'data' => $data]);
    }


    public function get_tindakan_bpjs($row,$data)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'tindakan/kdTkp/10';


        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$row}/{$data}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // // Check if data is null or empty
        if (empty($data) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }
        return response()->json( $data );
    }

    public function get_rujukan_spesialis_bpjs($data1,$data2,$data3)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'spesialis/rujuk/subspesialis';



        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$data1}/sarana/{$data2}/tglEstRujuk/{$data3}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // // Check if data is null or empty
        if (empty($data) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }
        return response()->json( $data );
    }

    public function get_rujukan_husus_bpjs($data1,$data2,$data3)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'spesialis/rujuk/khusus';



        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$data1}/noKartu/{$data2}/tglEstRujuk/{$data3}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        // // Check if data is null or empty
        if (empty($data) || empty($data['list'])) {
            return response()->json(['status' => 'error', 'message' => 'No data found'], 400);
        }
        return response()->json( $data );
    }
    public function get_rujukan_spesialis_husus_bpjs($data1,$data2,$data3,$data4)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'spesialis/rujuk/khusus';



        try {
            // Assuming $this->generateHeaders() returns an array of headers
            $headers = array_merge([
                'Content-Type' => 'application/json; charset=utf-8'
            ], $this->get_token()['headers']);

            // Make the API request
            $response = Http::withHeaders($headers)
                ->get("{$BASE_URL}/{$SERVICE_NAME}/{$feature}/{$data1}/subspesialis/{$data2}/noKartu/{$data3}/tglEstRujuk/{$data4}");

            // Decode the response body
            $responseBody = json_decode($response->body(), true);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Fetch the encrypted response data
        $encryptedString = $responseBody['response'];

        // Decrypt the string using AES-256-CBC
        $key = $this->get_token()['key_decrypt'];
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
        $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

        // Decrypt the base64-encoded encrypted string
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        // Decompress the string
        $data = json_decode($jsonString, true);

        return response()->json( $data );
    }


    public function edit_rujukan_bpjs($data)
    {
        $config = set_bpjs::find(1);
        $BASE_URL = $config->BASE_URL;
        $SERVICE_NAME = $config->SERVICE;
        $feature = 'kunjungan';



        try {
            // Prepare headers, including token authentication if necessary
            $headers = array_merge([
                'Content-Type' => 'text/plain; charset=utf-8'
            ], $this->get_token()['headers']); // Assuming get_token() returns headers

            // Make the API request using POST method and pass the $data
            $response = Http::withHeaders($headers)
                ->put("{$BASE_URL}/{$SERVICE_NAME}/{$feature}", $data); // Send POST request with $data

            // Decode the response body
            $responseBody = json_decode($response->body(), true);

              // Fetch the encrypted response data
            $encryptedString = $responseBody['response'];

            // Decrypt the string using AES-256-CBC
            $key = $this->get_token()['key_decrypt'];
            $encrypt_method = 'AES-256-CBC';
            $key_hash = hex2bin(hash('sha256', $key));  // Get key hash
            $iv = substr(hex2bin(hash('sha256', $key)), 0, 16);  // Get IV

            // Decrypt the base64-encoded encrypted string
            $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

            $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

            // Decompress the string
            $dataall = json_decode($jsonString, true);
        } catch (\Exception $e) {
            // Return error response if the API request fails
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        // Return the response from BPJS
        return response()->json($dataall);
    }

    public function dekrip(Request $request)
    {
        // Ambil timestamp dan data dari request
        $timestamp = $request->input('timestamp');
        $encryptedString = $request->input('data'); // Langsung ambil dari body POST

        // Pastikan data tidak kosong
        if (!$encryptedString) {
            return response()->json(['error' => 'Data terenkripsi tidak boleh kosong'], 400);
        }

        // Ambil konfigurasi BPJS
        $config = set_bpjs::find(1);
        if (!$config) {
            return response()->json(['error' => 'Konfigurasi BPJS tidak ditemukan'], 500);
        }

        $cons_id = $config->CONSID;
        $secret_key = $config->SCREET_KEY;

        // Generate key dan IV untuk dekripsi
        $key = $cons_id . $secret_key . $timestamp;
        $encrypt_method = 'AES-256-CBC';
        $key_hash = hex2bin(hash('sha256', $key));
        $iv = substr($key_hash, 0, 16); // IV harus 16 byte

        // Dekripsi data yang sudah di base64_encode()
        $decryptedString = openssl_decrypt(base64_decode($encryptedString), $encrypt_method, $key_hash, OPENSSL_RAW_DATA, $iv);

        if (!$decryptedString) {
            return response()->json(['error' => 'Gagal mendekripsi data'], 500);
        }

        // Dekompresi data menggunakan LZString
        $jsonString = LZString::decompressFromEncodedURIComponent($decryptedString);

        if (!$jsonString) {
            return response()->json(['error' => 'Gagal mendekompresi data'], 500);
        }

        // Konversi ke array JSON
        $dataall = json_decode($jsonString, true);

        return response()->json([
            'message' => 'Data berhasil didekripsi!',
            'data' => $dataall
        ]);
    }
}
