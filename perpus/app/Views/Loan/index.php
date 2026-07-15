<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Manajemen Peminjaman</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

body{
    background:#f5f7fb;
}

.header{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.stat{
    border:none;
    border-radius:20px;
    color:white;
}

.table-card{
    background:white;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
}

.cover{
    width:60px;
    height:80px;
    object-fit:cover;
    border-radius:10px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="header mb-4">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>

<i class="fa-solid fa-book"></i>

Manajemen Peminjaman

</h2>

<p class="text-muted">

Kelola seluruh transaksi peminjaman buku.

</p>

</div>

<a href="/dashboard" class="btn btn-secondary">

<i class="fa fa-arrow-left"></i>

Dashboard

</a>

</div>

</div>

<div class="row my-4">

<div class="col-md-4">

<div class="card stat bg-primary">

<div class="card-body text-center">

<h2><?= count($loans); ?></h2>

Total Peminjaman

</div>

</div>

</div>

<div class="col-md-4">

<div class="card stat bg-success">

<div class="card-body text-center">

<h2><?= count(array_filter($loans, fn($l)=>$l['loan_status']=="borrowed")); ?></h2>

Sedang Dipinjam

</div>

</div>

</div>

<div class="col-md-4">

<div class="card stat bg-danger">

<div class="card-body text-center">

<h2><?= count(array_filter($loans, fn($l)=>$l['loan_status']=="returned")); ?></h2>

Terlambat

</div>

</div>

</div>

</div>

<div class="table-card p-4">

<table class="table table-hover align-middle">

<thead>

<tr>

<th>Cover</th>

<th>Buku</th>

<th>Member</th>

<th>Pinjam</th>

<th>Jatuh Tempo</th>

<th>Status</th>

<th>Aksi</th>

</tr>

</thead>

<tbody>

<?php foreach($loans as $loan): ?>

<tr>

<td>

<img src="/uploads/<?= $loan['cover']; ?>" class="cover">

</td>

<td>

<b><?= $loan['title']; ?></b>

</td>

<td>

<?= $loan['name']; ?>

</td>

<td>

<?= $loan['borrow_date']; ?>

</td>

<td>

<?= $loan['due_date']; ?>

</td>

<td>

<?php

$warna='success';

if($loan['loan_status']=='returned'){

    $warna='secondary';

}

if($loan['loan_status']=='late'){

    $warna='danger';

}

?>

<span class="badge bg-<?= $warna ?>">

<?= ucfirst($loan['loan_status']) ?>

</span>

</td>

<td>

<a href="/peminjaman/detail/<?= $loan['id']; ?>" class="btn btn-info btn-sm">

<i class="fa fa-eye"></i>

</a>

<?php if($loan['loan_status'] == 'borrowed'): ?>

<a href="/peminjaman/return/<?= $loan['id']; ?>"
onclick="return confirm('Yakin buku sudah dikembalikan?')"
class="btn btn-success btn-sm">

<i class="fa-solid fa-right-left"></i>

Kembalikan

</a>

<?php else: ?>

<span class="badge bg-secondary">

Sudah Dikembalikan

</span>

<?php endif; ?>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

</div>

</div>

</body>

</html>