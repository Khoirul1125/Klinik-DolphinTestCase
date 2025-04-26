<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DolphiController extends Controller
{
    private $pineconeApiKey;
    private $pineconeEnvironment;
    private $flowiseApiUrl;
    private $openaiApiKey;

    public function __construct()
    {
        $this->pineconeEnvironment = "https://flowaise-ubpsxr7.svc.aped-4627-b74a.pinecone.io/vectors/upsert";
        $this->pineconeApiKey = "pcsk_eg9oT_9GcW8qsJceFNuEMx5cG37k98PtXcWehPZFrbKJcfyfvkeieEqAAKM9k9EaSoGGP";
        $this->openaiApiKey = "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";
        $this->flowiseApiUrl = "http://100.94.229.86:3000/api/v1/prediction/c84a1102-f61e-44b7-be40-944afbc0ff3c";
    }
     /**
     * Menangani data form dan mengirimkan permintaan ke API eksternal.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function predict(Request $request)
    {
        // Validasi input agar tidak kosong
        $request->validate([
            'question' => 'required|string'
        ]);

        $question = $request->input('question');

        // Kirim permintaan ke Flowise API
        $response = Http::timeout(30)->post($this->flowiseApiUrl, [
            'question' => $question
        ]);

        if ($response->successful()) {
            $responseData = $response->json();

            // Cek apakah respons memiliki struktur yang diharapkan
            if (!isset($responseData['text'], $responseData['question'], $responseData['agentReasoning'])) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid response structure'
                ], 422);
            }

            $text = $responseData['text'];
            $question = $responseData['question'];

            // Cek apakah `usedTools` dalam `agentReasoning` memiliki tool dengan "flowaise"
            $shouldStoreToPinecone = false;

            foreach ($responseData['agentReasoning'] as $agent) {
                if (isset($agent['usedTools']) && is_array($agent['usedTools'])) {
                    foreach ($agent['usedTools'] as $tool) {
                        // Cek apakah tool adalah array dan mengandung key 'tool' dengan nilai 'flowaise'
                        if (is_array($tool) && isset($tool['tool']) && $tool['tool'] === "flowaise") {
                            $shouldStoreToPinecone = true;
                            break 2; // Keluar dari kedua loop jika ditemukan
                        }
                    }
                }
            }

            // Simpan ke Pinecone jika ada "tool" dengan nilai "flowaise"
            if ($shouldStoreToPinecone) {
                $embedding = $this->getEmbeddingFromOpenAI($text,$question);
                if ($embedding) {
                    $this->storeToPinecone($text, $embedding, $question);
                }
            }

            return response()->json([
                'status' => 'success',
                'data' => [
                    'text' => $text,
                    'question' => $question,
                    'storedToPinecone' => $shouldStoreToPinecone
                ]
            ]);
        } else {
            // Respons gagal dari server
            $errorMessage = $response->body();
            Log::error("Flowise API Error: " . $errorMessage); // Logging error untuk debugging
            return response()->json([
                'status' => 'error',
                'message' => 'Server error',
                'detail' => $errorMessage
            ], 500);
        }

    }

    /**
     * Menggunakan OpenAI untuk mendapatkan embedding dari teks
     */
    private function getEmbeddingFromOpenAI($text,$question)
    {

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->openaiApiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/embeddings', [
            'input' => "Soal: " . $question . " Jawaban: " . $text,
            'model' => 'text-embedding-3-large'
        ]);

        if ($response->successful()) {
            return $response->json()['data'][0]['embedding'] ?? null;
        }

        return null;
    }

    /**
     * Menyimpan embedding ke Pinecone
     */
    private function storeToPinecone($text, $embedding, $question)
    {
        $pineconeUrl = $this->pineconeEnvironment;

        $response = Http::withHeaders([
            'Api-Key' => $this->pineconeApiKey,
            'Content-Type' => 'application/json',
        ])->post($pineconeUrl, [
            'vectors' => [
                [
                    'id' => md5($text), // ID unik berdasarkan teks
                    'values' => $embedding, // Embedding dari OpenAI
                    'metadata' => [
                        'Soal' => $question,
                        'Jawaban' => $text
                    ]
                ]
            ]
        ]);

        return $response->successful();
    }

        public function processSpeech(Request $request)
        {
            // Validasi request
            $request->validate([
                'question' => 'required|string',
            ]);

            // Ambil teks dari request
            $text = $request->input('question');

            // Perbaiki teks menggunakan NLP atau regex sederhana

            // Kirim ke API AI
            $response = $this->sendToAI($text);

            return response()->json([
                'ai_response' => $response
            ]);
        }


        private function sendToAI($text)
        {
            // URL API AI
            $apiUrl = "http://100.94.229.86:3000/api/v1/prediction/7f9effdc-28d6-406d-9f64-3109f7124be1";

            // Kirim permintaan ke API AI
            $client = new \GuzzleHttp\Client();
            try {
                $response = $client->post($apiUrl, [
                    'json' => ['question' => $text],
                    'headers' => ['Content-Type' => 'application/json']
                ]);

                return json_decode($response->getBody()->getContents(), true);
            } catch (\Exception $e) {
                return ['error' => 'Gagal menghubungi AI: ' . $e->getMessage()];
            }
        }

    // {
    //     // Mengambil data dari request
    //     $question = $request->input('question');

    //     // OpenAI API Key dan Assistant ID
    //     $apiKey = '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'; // Ganti dengan API Key Anda
    //     $assistantId = 'asst_nm4jNLFBuAddv2WFNXeD2YfX'; // Ganti dengan ID Assistant Anda

    //     // Step 1: Membuat Thread
    //     $response = Http::withHeaders([
    //         'Authorization' => 'Bearer ' . $apiKey,
    //         'Content-Type' => 'application/json',
    //         'OpenAI-Beta' => 'assistants=v2'
    //     ])->post('https://api.openai.com/v1/threads');

    //     if ($response->successful()) {
    //         $threadData = $response->json();
    //         $threadId = $threadData['id'];  // Menyimpan thread ID untuk request berikutnya

    //         // Step 2: Mengirim Pesan ke Thread
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $apiKey,
    //             'Content-Type' => 'application/json',
    //             'OpenAI-Beta' => 'assistants=v2'
    //         ])->post("https://api.openai.com/v1/threads/{$threadId}/messages", [
    //             'role' => 'user',
    //             'content' => [
    //                 [
    //                     'type' => 'text',
    //                     'text' => $question  // Input pertanyaan dari pengguna
    //                 ]
    //             ]
    //         ]);

    //         if ($response->successful()) {
    //             // Step 3: Menjalankan Thread untuk Mendapatkan Respon
    //             $runResponse = Http::withHeaders([
    //                 'Authorization' => 'Bearer ' . $apiKey,
    //                 'Content-Type' => 'application/json',
    //                 'OpenAI-Beta' => 'assistants=v2'
    //             ])->post("https://api.openai.com/v1/threads/{$threadId}/runs", [
    //                 'assistant_id' => $assistantId
    //             ]);

    //             if ($runResponse->successful()) {
    //                 $runData = $runResponse->json();
    //                 $runId = $runData['id'];

    //                 // Step 3.1: Polling untuk Cek Status Run
    //                 $maxRetries = 10; // Jumlah maksimal percobaan polling
    //                 $retryDelay = 10; // Delay dalam detik di antara polling
    //                 $status = null;

    //                 for ($i = 0; $i < $maxRetries; $i++) {
    //                     // Cek status run
    //                     $statusResponse = Http::withHeaders([
    //                         'Authorization' => 'Bearer ' . $apiKey,
    //                         'Content-Type' => 'application/json',
    //                         'OpenAI-Beta' => 'assistants=v2'
    //                     ])->get("https://api.openai.com/v1/threads/{$threadId}/runs/{$runId}");

    //                     if ($statusResponse->successful()) {
    //                         $statusData = $statusResponse->json();
    //                         $status = $statusData['status'] ?? null;

    //                         if ($status === 'completed') {
    //                             break; // Keluar dari loop jika status sudah completed
    //                         }
    //                     }

    //                     sleep($retryDelay); // Tunggu sebelum mencoba lagi
    //                 }

    //                 if ($status === 'completed') {
    //                     // Step 4: Mengambil Pesan dari Thread
    //                     $response = Http::withHeaders([
    //                         'Authorization' => 'Bearer ' . $apiKey,
    //                         'Content-Type' => 'application/json',
    //                         'OpenAI-Beta' => 'assistants=v2'
    //                     ])->get("https://api.openai.com/v1/threads/{$threadId}/messages");

    //                     if ($response->successful()) {
    //                         $data = $response->json()['data'];

    //                         if (!empty($data)) {
    //                             // Cari pesan dengan role 'assistant'
    //                             $assistantMessage = collect($data)->firstWhere('role', 'assistant');

    //                             if ($assistantMessage && isset($assistantMessage['content'][0]['text']['value'])) {
    //                                 $firstMessage = $assistantMessage['content'][0]['text']['value'];
    //                                 return response()->json([
    //                                     'status' => 'success',
    //                                     'message' => $firstMessage
    //                                 ]);
    //                             } else {
    //                                 // Jika pesan 'assistant' tidak ditemukan
    //                                 return response()->json([
    //                                     'status' => 'error',
    //                                     'message' => 'No assistant response found in the data.'
    //                                 ]);
    //                             }
    //                         } else {
    //                             // Jika data kosong
    //                             return response()->json([
    //                                 'status' => 'error',
    //                                 'message' => 'No data available in the response.'
    //                             ]);
    //                         }
    //                     } else {
    //                         // Jika respons HTTP tidak berhasil
    //                         return response()->json([
    //                             'status' => 'error',
    //                             'message' => 'Request to the API failed.'
    //                         ]);
    //                     }
    //                     return response()->json([
    //                         'status' => 'error',
    //                         'message' => 'Failed to fetch messages',
    //                         'detail' => $response->body()
    //                     ], 500);
    //                 } else {
    //                     return response()->json([
    //                         'status' => 'error',
    //                         'message' => 'Run did not complete within the expected time'
    //                     ], 500);
    //                 }
    //             } else {
    //                 return response()->json([
    //                     'status' => 'error',
    //                     'message' => 'Failed to run thread',
    //                     'detail' => $runResponse->body()
    //                 ], 500);
    //             }
    //         } else {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'Failed to send message',
    //                 'detail' => $response->body()
    //             ], 500);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'Failed to create thread',
    //             'detail' => $response->body()
    //         ], 500);
    //     }
    // }

}
