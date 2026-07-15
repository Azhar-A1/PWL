<?php

namespace App\Controllers;

use App\Models\BookModel;

class BookController extends BaseController
{
    protected $book;

    public function __construct()
    {
        $this->book = new BookModel();
    }

    // ===========================
    // DAFTAR BUKU
    // ===========================
    public function index()
    {
        $data['books'] = $this->book->findAll();

        return view('books/index', $data);
    }

    // ===========================
    // DETAIL BUKU
    // ===========================
    public function detail($id)
    {
        $book = $this->book->find($id);

        if (!$book) {

            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        }

        // Buku rekomendasi
        $recommended = $this->book
            ->where('id !=', $id)
            ->orderBy('RAND()')
            ->findAll(4);

        return view('books/detail', [
            'book' => $book,
            'recommended' => $recommended
        ]);
    }

    // ===========================
    // FORM TAMBAH
    // ===========================
    public function create()
    {
        return view('books/create');
    }

    // ===========================
    // SIMPAN BUKU
    // ===========================
    public function store()
    {
        $rules = [

            'title'  => 'required',

            'author' => 'required',

            'cover'  => 'uploaded[cover]|is_image[cover]'

        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Data gagal disimpan.');

        }

        $cover = $this->request->getFile('cover');

        $namaCover = $cover->getRandomName();

        $cover->move('uploads', $namaCover);

        $this->book->save([

            'isbn'      => $this->request->getPost('isbn'),

            'title'     => $this->request->getPost('title'),

            'author'    => $this->request->getPost('author'),

            'publisher' => $this->request->getPost('publisher'),

            'year'      => $this->request->getPost('year'),

            'stock'     => $this->request->getPost('stock'),

            'cover' => $namaCover,

            'sinopsis' => $this->request->getPost('sinopsis')

            // aktifkan nanti setelah kolom sinopsis dibuat
            //'sinopsis' => $this->request->getPost('sinopsis')

        ]);

        return redirect()->to('/books')
            ->with('success', 'Buku berhasil ditambahkan.');
    }

    // ===========================
    // FORM EDIT
    // ===========================
    public function edit($id)
    {
        if(session()->get('role_id')!=1 && session()->get('role_id')!=2){

        return redirect()->to('/dashboard');

    }
        $data['book'] = $this->book->find($id);

        return view('books/edit', $data);
    }

    // ===========================
    // UPDATE
    // ===========================
    public function update($id)
{
    // Hanya Admin dan Staff
    if(session()->get('role_id') != 1 && session()->get('role_id') != 2){

        return redirect()->to('/dashboard');

    }

    // ==========================
    // STAFF
    // ==========================
    if(session()->get('role_id') == 2){

        $this->book->update($id,[

            'stock'=>$this->request->getPost('stock')

        ]);

        return redirect()->to('/books')
            ->with('success','Stok berhasil diperbarui.');

    }

    // ==========================
    // ADMIN
    // ==========================

    $data=[

        'title'=>$this->request->getPost('title'),

        'author'=>$this->request->getPost('author'),

        'publisher'=>$this->request->getPost('publisher'),

        'year'=>$this->request->getPost('year'),

        'stock'=>$this->request->getPost('stock'),

        'sinopsis'=>$this->request->getPost('sinopsis')

    ];

    $cover=$this->request->getFile('cover');

    if($cover && $cover->isValid() && !$cover->hasMoved()){

        $namaCover=$cover->getRandomName();

        $cover->move('uploads',$namaCover);

        $data['cover']=$namaCover;

    }

    $this->book->update($id,$data);

    return redirect()->to('/books')
        ->with('success','Data buku berhasil diperbarui.');
}

    // ===========================
    // HAPUS
    // ===========================
    public function delete($id)
    {
        $this->book->delete($id);

        return redirect()->to('/books')
            ->with('success', 'Data berhasil dihapus.');
    }
}