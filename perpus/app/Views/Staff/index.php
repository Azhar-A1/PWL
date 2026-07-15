<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Kelola Staff</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

body{

    background:#f4f6fb;

}

.header{

    background:white;

    border-radius:20px;

    padding:25px;

    box-shadow:0 5px 20px rgba(0,0,0,.08);

}

.staff-card{

    border:none;

    border-radius:20px;

    transition:.3s;

    box-shadow:0 5px 15px rgba(0,0,0,.08);

}

.staff-card:hover{

    transform:translateY(-6px);

    box-shadow:0 15px 30px rgba(0,0,0,.15);

}

.avatar{

    width:70px;

    height:70px;

    border-radius:50%;

    background:#0d6efd;

    color:white;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:30px;

    font-weight:bold;

}

.stat{

    border:none;

    border-radius:20px;

    color:white;

}

</style>

</head>

<body>

<div class="container py-5">

<div class="header mb-4">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2>

<i class="fa-solid fa-user-tie"></i>

Kelola Staff

</h2>

<p class="text-muted">

Kelola seluruh akun Staff Perpustakaan

</p>

</div>

<div>

<a href="/dashboard"

class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Dashboard

</a>

<a href="/staff/create"

class="btn btn-success">

<i class="fa-solid fa-user-plus"></i>

Tambah Staff

</a>

</div>

</div>

</div>

<?php if(session()->getFlashdata('success')): ?>

<div class="alert alert-success">

<?= session()->getFlashdata('success'); ?>

</div>

<?php endif; ?>

<div class="row mb-4">

<div class="col-md-3">

<div class="card stat bg-primary">

<div class="card-body text-center">

<h1>

<?= $totalStaff ?>

</h1>

Total Staff

</div>

</div>

</div>

</div>

<form method="get">

<div class="input-group mb-4">

<input

type="text"

name="search"

class="form-control"

placeholder="Cari Staff..."

value="<?= esc($_GET['search'] ?? '') ?>">

<button class="btn btn-primary">

<i class="fa fa-search"></i>

Cari

</button>

</div>

</form>

<div class="row">

<?php foreach($staff as $s): ?>

<div class="col-lg-6 mb-4">

<div class="card staff-card">

<div class="card-body">

<div class="d-flex">

<div class="avatar me-3">

<?= strtoupper(substr($s['username'],0,1)); ?>

</div>

<div>

<h4>

<?= esc($s['name'] ?? '-'); ?>

</h4>

<p class="text-muted mb-1">

@<?= esc($s['username']); ?>

</p>

<p>

<i class="fa-solid fa-envelope"></i>

<?= esc($s['email']); ?>

</p>

<?php if(!empty($s['phone'])): ?>

<p>

<i class="fa-solid fa-phone"></i>

<?= esc($s['phone']); ?>

</p>

<?php endif; ?>

<span class="badge bg-primary">

Staff

</span>

</div>

</div>

<hr>

<div class="d-flex justify-content-between">

<a href="/staff/edit/<?= $s['id']; ?>"

class="btn btn-warning">

<i class="fa-solid fa-pen"></i>

Edit

</a>

<a href="/staff/delete/<?= $s['id']; ?>"

onclick="return confirm('Yakin ingin menghapus staff ini?')"

class="btn btn-danger">

<i class="fa-solid fa-trash"></i>

Hapus

</a>

</div>

</div>

</div>

</div>

<?php endforeach; ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>