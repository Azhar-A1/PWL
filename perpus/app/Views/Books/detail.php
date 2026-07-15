<!DOCTYPE html>
<html>

<head>

<title><?= $book['title']; ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
rel="stylesheet">

<style>

body{

background:#f6f6f6;

}

.cover{

border-radius:20px;

box-shadow:0 10px 25px rgba(0,0,0,.2);

}

.card{

border:none;

border-radius:20px;

}

</style>

</head>

<body>

<div class="container mt-5">

<a href="/books"

class="btn btn-secondary mb-4">

← Kembali

</a>

<div class="card shadow">

<div class="row">

<div class="col-md-4 text-center p-4">

<img

src="/uploads/<?= $book['cover']; ?>"

class="img-fluid cover">

</div>

<div class="col-md-8 p-5">

<h2>

<?= $book['title']; ?>

</h2>

<hr>

<p>

<strong>ISBN :</strong>

<?= $book['isbn']; ?>

</p>

<p>

<strong>Penulis :</strong>

<?= $book['author']; ?>

</p>

<p>

<strong>Penerbit :</strong>

<?= $book['publisher']; ?>

</p>

<p>

<strong>Tahun :</strong>

<?= $book['year']; ?>

</p>

<p>

<strong>Stok :</strong>

<?= $book['stock']; ?>

</p>

<?php if(session()->get('role_id')==3): ?>

<?php if($book['stock']>0): ?>

<a

href="/pinjam/form/<?= $book['id']; ?>"

class="btn btn-success btn-lg">

📚 Pinjam Buku

</a>

<?php else: ?>

<button

class="btn btn-danger"

disabled>

Stok Habis

</button>

<?php endif; ?>

<?php endif; ?>

</div>

</div>

</div>

</div>

</body>

</html>