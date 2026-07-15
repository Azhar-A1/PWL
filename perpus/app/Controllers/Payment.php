<?php

namespace App\Controllers;

use App\Models\LoanModel;
use Midtrans\Config;
use Midtrans\Snap;
use App\Libraries\WahaService;
use App\Models\UserModel;

class Payment extends BaseController
{
    protected $loanModel;
    protected $userModel;
    protected $waha;

    public function __construct()
    {
        $this->userModel = new UserModel();

        $this->waha = new WahaService();

        $this->loanModel = new LoanModel();

        Config::$serverKey    = \Config\Midtrans::$serverKey;
        Config::$clientKey    = \Config\Midtrans::$clientKey;
        Config::$isProduction = \Config\Midtrans::$isProduction;
        Config::$isSanitized  = \Config\Midtrans::$isSanitized;
        Config::$is3ds        = \Config\Midtrans::$is3ds;
    }

    // =========================================================
    // HALAMAN PEMBAYARAN
    // =========================================================

    public function pay($id)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        $loan = $this->loanModel
            ->select('
                peminjaman.*,
                books.title,
                books.author,
                books.publisher,
                books.year,
                books.cover
            ')
            ->join('books', 'books.id = peminjaman.book_id')
            ->where('peminjaman.id', $id)
            ->first();

        if (!$loan) {
            return redirect()->to('/pinjam')
                ->with('error', 'Data peminjaman tidak ditemukan.');
        }

        if ($loan['fine'] <= 0) {
            return redirect()->back()
                ->with('error', 'Tidak ada denda yang harus dibayar.');
        }

        if ($loan['payment_status'] == 'paid') {
            return redirect()->back()
                ->with('success', 'Denda sudah dibayar.');
        }

        $orderId = 'LOAN-' . $loan['id'] . '-' . time();

        $params = [

            'transaction_details' => [

                'order_id' => $orderId,

                'gross_amount' => $loan['fine']

            ],

            'customer_details' => [

                'first_name' => session()->get('username'),

                'email' => session()->get('email')

            ]

        ];

        $snapToken = Snap::getSnapToken($params);

        $this->loanModel->update($loan['id'], [

            'transaction_id' => $orderId,

            'midtrans_token' => $snapToken,

            'payment_status' => 'paid'

        ]);

        return view('payment/pay', [

            'loan' => $loan,

            'snapToken' => $snapToken

        ]);
    }

    // =========================================================
    // REDIRECT SETELAH PEMBAYARAN
    // =========================================================

    public function finish()
    {
        $id = $this->request->getGet('id');

        return redirect()
            ->to('/pinjam/detail/' . $id)
            ->with(
                'success',
                'Pembayaran sedang diproses. Status akan berubah otomatis setelah dikonfirmasi Midtrans.'
            );
    }

    // =========================================================
    // CALLBACK MIDTRANS
    // =========================================================

    public function notification()
    {
        $json = file_get_contents("php://input");

        $data = json_decode($json, true);

        if (!$data) {

            return $this->response
                ->setStatusCode(400)
                ->setBody('Invalid Notification');

        }

        $orderId = $data['order_id'] ?? '';

        $transactionStatus = $data['transaction_status'] ?? '';

        $fraudStatus = $data['fraud_status'] ?? '';

        $loan = $this->loanModel
            ->where('transaction_id', $orderId)
            ->first();

        if (!$loan) {

            return $this->response
                ->setStatusCode(404)
                ->setBody('Loan Not Found');

        }

        switch ($transactionStatus) {

            case 'capture':

                if ($fraudStatus == 'accept') {

                    $this->paid($loan['id']);

                }

                break;

            case 'settlement':

                $this->paid($loan['id']);

                break;

            case 'pending':

                $this->loanModel->update($loan['id'], [

                    'payment_status' => 'pending'

                ]);

                break;

            case 'expire':

                $this->loanModel->update($loan['id'], [

                    'payment_status' => 'expired'

                ]);

                break;

            case 'cancel':

                $this->loanModel->update($loan['id'], [

                    'payment_status' => 'cancel'

                ]);

                break;

            case 'deny':

                $this->loanModel->update($loan['id'], [

                    'payment_status' => 'deny'

                ]);

                break;
        }

        return $this->response
            ->setStatusCode(200)
            ->setBody('OK');
    }

    // =========================================================
    // STATUS LUNAS
    // =========================================================

    private function paid($id)
    {
        $loan = $this->loanModel
            ->select('
                peminjaman.*,
                books.title
            ')
            ->join('books', 'books.id = peminjaman.book_id')
            ->where('peminjaman.id', $id)
            ->first();

        if (!$loan) {
            return;
        }

        // Hindari kirim WA dua kali
        if ($loan['payment_status'] == 'paid') {
            return;
        }

        // Update status pembayaran
        $this->loanModel->update($id, [

            'payment_status' => 'paid',

            'paid_at' => date('Y-m-d H:i:s')

        ]);

        // Ambil data user
        $user = $this->userModel->find($loan['user_id']);

        if ($user && !empty($user['phone'])) {

                $pesan =
        "💳 *PEMBAYARAN DENDA BERHASIL*

        Halo {$user['name']},

        Pembayaran denda Anda telah berhasil.

        ━━━━━━━━━━━━━━━━━━
        📖 Buku
        {$loan['title']}

        💰 Nominal
        Rp " . number_format($loan['fine'], 0, ',', '.') . "

        📅 Waktu
        " . date('d-m-Y H:i') . "

        ✅ Status
        LUNAS
        ━━━━━━━━━━━━━━━━━━

    Terima kasih telah menggunakan
    Sistem Perpustakaan.";

            $this->waha->sendMessage(
                $user['phone'],
                $pesan
            );
        }
    }
    
}