<?php

namespace App\Controllers;

use App\Models\LoanModel;
use App\Models\BookModel;
use App\Models\UserModel;
use App\Libraries\WahaService;

class Peminjaman extends BaseController
{
    protected $loanModel;
    protected $bookModel;
    protected $userModel;
    protected $waha;

    public function __construct()
    {
        $this->loanModel = new LoanModel();
        $this->bookModel = new BookModel();
        $this->userModel = new UserModel();
        $this->waha      = new WahaService();
    }

    // ============================================
    // FORM PINJAM
    // ============================================

    public function form($id)
    {
        $book = $this->bookModel->find($id);

        if (!$book) {

            return redirect()->to('/books');

        }

        return view('peminjaman/form', [

            'book' => $book

        ]);
    }

    // ============================================
    // SIMPAN PEMINJAMAN
    // ============================================

    public function store()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');

        }

        $book_id = $this->request->getPost('book_id');

        $lama = $this->request->getPost('lama');

        $book = $this->bookModel->find($book_id);

        if (!$book) {

            return redirect()->back()
                ->with('error','Buku tidak ditemukan.');

        }

        if ($book['stock'] <= 0) {

            return redirect()->back()
                ->with('error','Stok buku habis.');

        }

        $borrowDate = date('Y-m-d');

        $dueDate = date(
            'Y-m-d',
            strtotime("+{$lama} days")
        );

        $this->loanModel->save([

            'user_id' => session()->get('user_id'),

            'book_id' => $book_id,

            'borrow_date' => $borrowDate,

            'due_date' => $dueDate,

            'return_date' => null,

            'fine' => 0,

            // belum ada denda
            'payment_status' => 'paid',

            'loan_status' => 'borrowed'

        ]);

        $this->bookModel->update($book_id,[

            'stock'=>$book['stock']-1

        ]);

        // =============================
        // KIRIM WHATSAPP
        // =============================

        $user = $this->userModel
            ->find(session()->get('user_id'));

        if($user && !empty($user['phone'])){

            $message =
            "📚 *PERPUSTAKAAN*

            Halo {$user['name']}

            Peminjaman buku berhasil.

            📖 Judul :
            {$book['title']}

            📅 Tanggal Pinjam :
            {$borrowDate}

            📅 Jatuh Tempo :
            {$dueDate}

            Selamat membaca 😊";

                        $this->waha->sendMessage(

                            $user['phone'],

                            $message

                        );

                    }

                    return redirect()
                        ->to('/pinjam')
                        ->with(
                            'success',
                            'Peminjaman berhasil.'
                        );

                }

        // ============================================
    // DAFTAR PEMINJAMAN
    // ============================================

    public function index()
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');

        }

        $today = date('Y-m-d');

        // ==========================
        // UPDATE DENDA OTOMATIS
        // ==========================

        $borrowed = $this->loanModel
            ->where('loan_status','borrowed')
            ->findAll();

        foreach($borrowed as $item){

            if(strtotime($today) > strtotime($item['due_date'])){

                $daysLate = floor(

                    (strtotime($today)-strtotime($item['due_date']))/86400

                );

                $fine = $daysLate * 5000;

                $data = [

                    'fine'=>$fine

                ];

                // jangan ubah lagi kalau sudah lunas

                if($item['payment_status'] != 'paid'){

                    $data['payment_status']='unpaid';

                }

                $this->loanModel->update(

                    $item['id'],

                    $data

                );

            }

        }

        // ==========================
        // AMBIL DATA USER
        // ==========================

        $loans = $this->loanModel

            ->select('

                peminjaman.*,

                books.title,

                books.author,

                books.publisher,

                books.year,

                books.cover

            ')

            ->join(

                'books',

                'books.id=peminjaman.book_id'

            )

            ->where(

                'user_id',

                session()->get('user_id')

            )

            ->orderBy(

                'borrow_date',

                'DESC'

            )

            ->findAll();

        return view(

            'peminjaman/index',

            [

                'loans'=>$loans

            ]

        );

    }

    // ============================================
    // DETAIL PEMINJAMAN
    // ============================================

    public function detail($id)
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

            ->join(

                'books',

                'books.id=peminjaman.book_id'

            )

            ->where(

                'peminjaman.id',

                $id

            )

            ->where(

                'user_id',

                session()->get('user_id')

            )

            ->first();

        if(!$loan){

            return redirect()->to('/pinjam');

        }

        $today = date('Y-m-d');

        // ==========================
        // UPDATE DENDA OTOMATIS
        // ==========================

        if(

            $loan['loan_status']=="borrowed"

            &&

            strtotime($today) > strtotime($loan['due_date'])

        ){

            $daysLate = floor(

                (strtotime($today)-strtotime($loan['due_date']))/86400

            );

            $fine = $daysLate * 5000;

            $data=[

                'fine'=>$fine

            ];

            if($loan['payment_status']!='paid'){

                $data['payment_status']='unpaid';

            }

            $this->loanModel->update(

                $loan['id'],

                $data

            );

            $loan['fine']=$fine;

            if($loan['payment_status']!='paid'){

                $loan['payment_status']='unpaid';

            }

        }

        return view(

            'peminjaman/detail',

            [

                'loan'=>$loan

            ]

        );

    }

        // ============================================
    // PENGEMBALIAN BUKU
    // ============================================

    public function kembali($id)
    {
        if (!session()->get('logged_in')) {

            return redirect()->to('/login');

        }

        $loan = $this->loanModel->find($id);

        if (!$loan) {

            return redirect()->to('/pinjam')
                ->with('error','Data peminjaman tidak ditemukan.');

        }

        if($loan['loan_status']=="returned"){

            return redirect()->back()
                ->with('error','Buku sudah dikembalikan.');

        }

        $today = date('Y-m-d');

        // ======================================
        // HITUNG DENDA
        // ======================================

        $fine = 0;

        if(strtotime($today) > strtotime($loan['due_date'])){

            $daysLate = floor(

                (strtotime($today)-strtotime($loan['due_date']))/86400

            );

            $fine = $daysLate * 5000;

        }

        // ======================================
        // STATUS PEMBAYARAN
        // ======================================

        $paymentStatus = ($fine > 0)
            ? 'unpaid'
            : 'paid';

        // ======================================
        // UPDATE PEMINJAMAN
        // ======================================

        $this->loanModel->update($id,[

            'return_date'=>$today,

            'fine'=>$fine,

            'payment_status'=>$paymentStatus,

            'loan_status'=>'returned'

        ]);

        // ======================================
        // TAMBAH STOK BUKU
        // ======================================

        $book = $this->bookModel->find($loan['book_id']);

        if($book){

            $this->bookModel->update(

                $loan['book_id'],

                [

                    'stock'=>$book['stock']+1

                ]

            );

        }

        // ======================================
        // KIRIM WHATSAPP
        // ======================================

        $user = $this->userModel->find($loan['user_id']);

        if($user && !empty($user['phone'])){

            if($fine > 0){

                $message =
            "📚 *PERPUSTAKAAN*

            Halo {$user['name']}

            Buku berhasil dikembalikan.

            📖 ID Peminjaman :
            {$loan['id']}

            💰 Denda :
            Rp ".number_format($fine)."

            Silakan lakukan pembayaran melalui website.

            Terima kasih.";

            }else{

                $message =
            "📚 *PERPUSTAKAAN*

            Halo {$user['name']}

            Buku berhasil dikembalikan.

            Tidak ada denda.

            Terima kasih telah menggunakan layanan perpustakaan.";

            }

            $this->waha->sendMessage(

                $user['phone'],

                $message

            );

        }

        if($fine > 0){

            return redirect()

                ->to('/pinjam/detail/'.$id)

                ->with(

                    'warning',

                    'Buku berhasil dikembalikan. Silakan lakukan pembayaran denda.'

                );

        }

        return redirect()

            ->to('/pinjam/detail/'.$id)

            ->with(

                'success',

                'Buku berhasil dikembalikan.'

            );

    }

}