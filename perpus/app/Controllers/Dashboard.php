<?php

namespace App\Controllers;

use App\Models\BookModel;

class Dashboard extends BaseController
{
    protected $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        // ambil 6 buku terbaru
        $books = $this->bookModel
                      ->orderBy('id', 'DESC')
                      ->findAll(6);

        return view('dashboard', [
            'books' => $books
        ]);
    }
}