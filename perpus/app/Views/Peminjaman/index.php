<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Riwayat Peminjaman</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

body{
    background:#f4f6fb;
}

.header{
    background:white;
    padding:25px;
    border-radius:20px;
    box-shadow:0 5px 20px rgba(0,0,0,.08);
    margin-bottom:30px;
}

.loan-card{
    border:none;
    border-radius:20px;
    overflow:hidden;
    transition:.3s;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.loan-card:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 35px rgba(0,0,0,.15);
}

.loan-card img{
    height:250px;
    object-fit:cover;
}

.status{
    font-size:14px;
}

</style>

</head>

<body>

<div class="container py-5">

<div class="header">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>

<i class="fa-solid fa-book"></i>

Riwayat Peminjaman Saya

</h2>

<p class="text-muted mb-0">

Seluruh buku yang pernah Anda pinjam.

</p>

</div>

<a href="/dashboard" class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Dashboard

</a>

</div>

</div>

<?php if(session()->getFlashdata('success')): ?>

<div class="alert alert-success">

<?= session()->getFlashdata('success'); ?>

</div>

<?php endif; ?>

<div class="row">

<?php if(empty($loans)): ?>

<div class="col-12">

<div class="alert alert-info">

Anda belum pernah meminjam buku.

</div>

</div>

<?php endif; ?>

<?php foreach($loans as $loan): ?>

<div class="col-lg-4 mb-4">

<div class="card loan-card">

<img src="/uploads/<?= esc($loan['cover']); ?>" class="card-img-top">

<div class="card-body">

<h5 class="fw-bold">

<?= esc($loan['title']); ?>

</h5>

<p class="text-muted">

<?= esc($loan['author']); ?>

</p>

<hr>

<p>

<i class="fa-solid fa-calendar"></i>

<b>Tanggal Pinjam :</b>

<?= $loan['borrow_date']; ?>

</p>

<p>

<i class="fa-solid fa-clock"></i>

<b>Jatuh Tempo :</b>

<?= $loan['due_date']; ?>

</p>

<p>

<b>Status :</b>

<?php if($loan['loan_status']=="borrowed"): ?>

<span class="badge bg-success status">

Sedang Dipinjam

</span>

<?php else: ?>

<span class="badge bg-secondary status">

Sudah Dikembalikan

</span>

<?php endif; ?>

</p>

<p>

<b>Denda :</b>

Rp <?= number_format($loan['fine']); ?>

</p>

<p>

<b>Pembayaran :</b>

<?php if($loan['payment_status']=="paid"): ?>

<span class="badge bg-success">

Lunas

</span>

<?php else: ?>

<span class="badge bg-warning text-dark">

Belum Bayar

</span>

<?php endif; ?>

</p>

<a
href="/pinjam/detail/<?= $loan['id']; ?>"
class="btn btn-primary w-100">

<i class="fa-solid fa-eye"></i>

Lihat Detail

</a>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

</div>

</body>

</html>