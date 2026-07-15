<?php

namespace App\Controllers;

use App\Models\BookModel;

class Books extends BaseController
{
    protected $bookModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
    }

    public function store()
    {
        // HANYA ADMIN
        if(session()->get('role_id') != 1){

            return redirect()->to('/books');

        }

        // VALIDASI
        $rules = [

            'title' => 'required',

            'author' => 'required',

            'stock' => 'required|numeric',

            'cover' => 'uploaded[cover]|max_size[cover,2048]|is_image[cover]'

        ];

        if(!$this->validate($rules)){

            return redirect()->back()
                ->withInput()
                ->with('error', 'Data tidak valid');

        }

        // AMBIL FILE
        $file = $this->request->getFile('cover');

        // NAMA RANDOM
        $newName = $file->getRandomName();

        // PINDAHKAN FILE
        $file->move('uploads', $newName);

        // SIMPAN DATABASE
        $this->bookModel->save([

            'isbn'      => $this->request->getPost('isbn'),

            'title'     => $this->request->getPost('title'),

            'author'    => $this->request->getPost('author'),

            'publisher' => $this->request->getPost('publisher'),

            'year'      => $this->request->getPost('year'),

            'stock'     => $this->request->getPost('stock'),

            'cover'     => $newName

        ]);

        // FLASH MESSAGE
        return redirect()->to('/books')
            ->with('success', 'Buku berhasil ditambahkan');
    }

  public function fetchBook($isbn)
{
    $cache = cache();

    // Cek cache dulu
    $cacheKey = 'book_'.$isbn;

    if($data = $cache->get($cacheKey))
    {
        return $this->response->setJSON([
            'status' => true,
            'data' => $data
        ]);
    }

    try {
        $client = \Config\Services::curlrequest();

               $response = $client->get(
               "https://openlibrary.org/api/books?bibkeys=ISBN:$isbn&format=json&jscmd=data"
);

                $result = json_decode($response->getBody(), true);

                $key = "ISBN:$isbn";

                if(empty($result[$key]))
                {
                    return $this->response->setJSON([
                        'status' => false,
                        'message' => 'ISBN tidak ditemukan'
                    ]);
                }

                $book = $result[$key];

                $data = [

                    'title' => $book['title'] ?? '',

                    'author' => $book['authors'][0]['name'] ?? '',

                    'publisher' => $book['publishers'][0]['name'] ?? '',

                    'year' => substr(
                        $book['publish_date'] ?? '',
                        -4
                    )

                ];

                // Simpan cache 1 jam
                $cache->save(
                    $cacheKey,
                    $data,
                    3600
                );

                return $this->response->setJSON([
                    'status' => true,
                    'data' => $data
                ]);

            } catch (\Exception $e) {

            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);

            }
}
}