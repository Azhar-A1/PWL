<?php

namespace App\Controllers;

use App\Libraries\WahaService;

class TestWa extends BaseController
{
    public function index()
    {
        $wa = new WahaService();

        $result = $wa->sendMessage(
            '6289672617799', // Ganti dengan nomor WhatsApp Anda
            "📚 Tes WAHA berhasil!\n\nPesan ini dikirim dari Website Perpustakaan."
        );

        echo "<pre>";
        print_r($result);
    }
}