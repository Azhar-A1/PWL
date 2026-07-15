<?php

namespace App\Controllers;

use App\Models\LoanModel;
use App\Models\BookModel;
use App\Models\UserModel;

class LoanController extends BaseController
{
    protected $loanModel;
    protected $bookModel;
    protected $userModel;

    public function __construct()
    {
        $this->loanModel=new LoanModel();
        $this->bookModel=new BookModel();
        $this->userModel=new UserModel();
    }

    public function index()
    {

        if(session()->get('role_id')==3){

            return redirect()->to('/dashboard');

        }

        $loans=$this->loanModel
            ->select('
                peminjaman.*,
                books.title,
                books.cover,
                users.name,
                users.username
            ')
            ->join('books','books.id=peminjaman.book_id')
            ->join('users','users.id=peminjaman.user_id')
            ->orderBy('borrow_date','DESC')
            ->findAll();

        return view('loan/index',[

            'loans'=>$loans

        ]);

    }

    public function detail($id)
    {
        $loan = $this->loanModel
            ->select('
                peminjaman.*,
                books.*,
                users.name,
                users.email
            ')
            ->join('books','books.id=peminjaman.book_id')
            ->join('users','users.id=peminjaman.user_id')
            ->where('peminjaman.id',$id)
            ->first();

        return view('loan/detail',[

            'loan'=>$loan

        ]);
    }
    public function returnBook($id)
{
    // Hanya Admin dan Staff
    if(session()->get('role_id') != 1 && session()->get('role_id') != 2){

        return redirect()->to('/dashboard');

    }

    // Cari data peminjaman
    $loan = $this->loanModel->find($id);

    if(!$loan){

        return redirect()->back()
            ->with('error','Data peminjaman tidak ditemukan.');

    }

    // Jika sudah dikembalikan
    if($loan['loan_status'] == 'returned'){

        return redirect()->back()
            ->with('error','Buku sudah dikembalikan.');

    }

    // Ambil data buku
    $book = $this->bookModel->find($loan['book_id']);

    if(!$book){

        return redirect()->back()
            ->with('error','Data buku tidak ditemukan.');

    }

    // ==========================
    // Hitung denda
    // ==========================

    $returnDate = date('Y-m-d');
    $fine = 0;

    if(strtotime($returnDate) > strtotime($loan['due_date'])){

        $daysLate = floor(
            (strtotime($returnDate) - strtotime($loan['due_date']))
            / (60 * 60 * 24)
        );

        // Denda Rp2.000 per hari
        $fine = $daysLate * 2000;

    }

    // ==========================
    // Update data peminjaman
    // ==========================

    $this->loanModel->update($id,[

        'return_date'    => $returnDate,

        'loan_status'    => 'returned',

        'fine'           => $fine,

        'payment_status' => $fine > 0 ? 'unpaid' : 'paid'

    ]);

    // ==========================
    // Tambah stok buku
    // ==========================

    $this->bookModel->update($book['id'],[

        'stock' => $book['stock'] + 1

    ]);

    return redirect()->to('/peminjaman')
        ->with('success','Buku berhasil dikembalikan.');
}

}