<?php

namespace App\Libraries;

class WahaService
{
    public function sendMessage($phone, $message)
    {
        // Ubah nomor 08xxxxxxxx menjadi 628xxxxxxxx
        $phone = preg_replace('/^0/', '62', $phone);

        // Endpoint WAHA
        $url = \Config\Waha::$baseUrl . "/api/sendText";

        // Data yang dikirim ke WAHA
        $data = [
            "chatId"  => $phone . "@c.us",
            "text"    => $message,
            "session" => \Config\Waha::$session
        ];

        $curl = curl_init();

        curl_setopt_array($curl, [

            CURLOPT_URL            => $url,

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_POST           => true,

            CURLOPT_HTTPHEADER     => [

                "Content-Type: application/json",

                "X-Api-Key: " . \Config\Waha::$apiKey

            ],

            CURLOPT_POSTFIELDS     => json_encode($data),

            CURLOPT_TIMEOUT        => 30,

            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_SSL_VERIFYHOST => false

        ]);

        $response = curl_exec($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        $error = curl_error($curl);

        curl_close($curl);

        // Simpan log untuk debugging
        log_message('info', 'WAHA Status : ' . $httpCode);
        log_message('info', 'WAHA Response : ' . $response);

        if ($error) {
            log_message('error', 'WAHA CURL Error : ' . $error);
        }

        return [
            'status'   => $httpCode,
            'response' => $response,
            'error'    => $error
        ];
    }
}