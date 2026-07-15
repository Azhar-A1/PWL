<?php

namespace App\Controllers\Api;

use CodeIgniter\RESTful\ResourceController;
use App\Models\BookModel;

class BooksApi extends ResourceController
{
    protected $modelName = BookModel::class;
    protected $format    = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $book = $this->model->find($id);

        if(!$book)
        {
            return $this->failNotFound('Buku tidak ditemukan');
        }

        return $this->respond($book);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        $this->model->insert($data);

        return $this->respondCreated([
            'message' => 'Buku berhasil ditambahkan'
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON(true);

        $this->model->update($id, $data);

        return $this->respond([
            'message' => 'Buku berhasil diupdate'
        ]);
    }

    public function delete($id = null)
    {
        $this->model->delete($id);

        return $this->respond([
            'message' => 'Buku berhasil dihapus'
        ]);
    }
}