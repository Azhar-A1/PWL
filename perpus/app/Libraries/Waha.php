<?php

namespace App\Libraries;

class Waha
{
    public function send($phone,$message)
    {
        $url = \Config\Waha::$url;

        $data = [

            "chatId"=>$phone."@c.us",

            "text"=>$message,

            "session"=>\Config\Waha::$session

        ];

        $curl=curl_init();

        curl_setopt_array($curl,[

            CURLOPT_URL=>$url,

            CURLOPT_RETURNTRANSFER=>true,

            CURLOPT_POST=>true,

            CURLOPT_POSTFIELDS=>json_encode($data),

            CURLOPT_HTTPHEADER=>[

                "Content-Type: application/json",

                "X-Api-Key: ".\Config\Waha::$token

            ]

        ]);

        curl_exec($curl);

        curl_close($curl);
    }
}