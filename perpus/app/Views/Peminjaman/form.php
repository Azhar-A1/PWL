<!DOCTYPE html>
<html>

<head>

    <title>Pinjam Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>Form Peminjaman Buku</h3>

</div>

<div class="card-body">

<form action="/pinjam/store" method="post">

<input type="hidden"
name="book_id"
value="<?= $book['id']; ?>">

<div class="mb-3">

<label>Judul Buku</label>

<input
type="text"
class="form-control"
value="<?= $book['title']; ?>"
readonly>

</div>

<div class="mb-3">

<label>Tanggal Pinjam</label>

<input
type="date"
name="borrow_date"
class="form-control"
value="<?= date('Y-m-d'); ?>"
readonly>

</div>

<div class="mb-3">

<label>Lama Peminjaman</label>

<select
name="lama"
class="form-select">

<option value="1">1 Hari</option>

<option value="3">3 Hari</option>

<option value="7">7 Hari</option>

<option value="14">14 Hari</option>

<option value="21">21 Hari</option>

<option value="30">1 Bulan</option>

</select>

</div>

<button
class="btn btn-success">

Pinjam Buku

</button>

<a href="/books"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

</body>

</html>