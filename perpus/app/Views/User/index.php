<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Kelola User</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>

        body{
            background:#f4f7fb;
        }

        .page-header{
            background:white;
            border-radius:20px;
            padding:25px;
            box-shadow:0 10px 30px rgba(0,0,0,.08);
            margin-bottom:25px;
        }

        .stat-card{
            border:none;
            border-radius:20px;
            color:white;
            transition:.3s;
        }

        .stat-card:hover{
            transform:translateY(-5px);
        }

        .user-card{
            border:none;
            border-radius:20px;
            transition:.3s;
            box-shadow:0 5px 20px rgba(0,0,0,.08);
        }

        .user-card:hover{
            transform:translateY(-5px);
            box-shadow:0 15px 30px rgba(0,0,0,.12);
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

        .badge-role{
            font-size:13px;
            padding:8px 12px;
        }

        .search-box{
            border-radius:50px;
        }

        .btn{
            border-radius:12px;
        }

    </style>

</head>

<body>

<div class="container py-5">

<div class="page-header">

<div class="d-flex justify-content-between align-items-center">

<div>

<h2 class="fw-bold">

<i class="fa-solid fa-users"></i>

Kelola User

</h2>

<p class="text-muted">

Kelola seluruh akun Admin, Staff dan Member.

</p>

</div>

<div>

<button
class="btn btn-success me-2"
data-bs-toggle="modal"
data-bs-target="#staffModal">

<i class="fa-solid fa-user-plus"></i>

Tambah Staff

</button>

<a
href="/dashboard"
class="btn btn-secondary">

<i class="fa-solid fa-arrow-left"></i>

Dashboard

</a>

</div>

</div>

</div>

<!-- Statistik -->

<div class="row mb-4">

<div class="col-md-3">

<div class="card stat-card bg-primary">

<div class="card-body text-center">

<h1><?= $totalUser ?></h1>

Total User

</div>

</div>

</div>

<div class="col-md-3">

<div class="card stat-card bg-danger">

<div class="card-body text-center">

<h1><?= $totalAdmin ?></h1>

Admin

</div>

</div>

</div>

<div class="col-md-3">

<div class="card stat-card bg-info">

<div class="card-body text-center">

<h1><?= $totalStaff ?></h1>

Staff

</div>

</div>

</div>

<div class="col-md-3">

<div class="card stat-card bg-success">

<div class="card-body text-center">

<h1><?= $totalMember ?></h1>

Member

</div>

</div>

</div>

</div>

<!-- Flash -->

<?php if(session()->getFlashdata('success')): ?>

<div class="alert alert-success">

<?= session()->getFlashdata('success'); ?>

</div>

<?php endif; ?>

<?php if(session()->getFlashdata('error')): ?>

<div class="alert alert-danger">

<?= session()->getFlashdata('error'); ?>

</div>

<?php endif; ?>

<!-- Search -->

<form method="get">

<div class="input-group mb-4">

<input
type="text"
name="search"
class="form-control search-box"
placeholder="Cari nama, username atau email..."
value="<?= esc($_GET['search'] ?? '') ?>">

<button class="btn btn-primary">

<i class="fa fa-search"></i>

Cari

</button>

</div>

</form>

<div class="row">

<?php foreach($users as $user): ?>

    <div class="col-lg-6 mb-4">

    <div class="card user-card">

        <div class="card-body">

            <div class="d-flex">

                <!-- Avatar -->

                <div class="avatar me-3">

                    <?= strtoupper(substr($user['name'],0,1)); ?>

                </div>

                <!-- Data User -->

                <div class="flex-grow-1">

                    <h4 class="fw-bold mb-1">

                        <?= esc($user['name']); ?>

                    </h4>

                    <div class="text-muted mb-2">

                        @<?= esc($user['username']); ?>

                    </div>

                    <div class="mb-2">

                        <i class="fa-solid fa-envelope text-primary"></i>

                        <?= esc($user['email']); ?>

                    </div>

                    <div class="mb-3">

                        <i class="fa-solid fa-phone text-success"></i>

                        <?= !empty($user['phone']) ? esc($user['phone']) : '-' ?>

                    </div>

                    <!-- Role -->

                    <?php if($user['role_id']==1): ?>

                        <span class="badge bg-danger badge-role">

                            👑 Admin

                        </span>

                    <?php elseif($user['role_id']==2): ?>

                        <span class="badge bg-primary badge-role">

                            👨‍💼 Staff

                        </span>

                    <?php else: ?>

                        <span class="badge bg-success badge-role">

                            👤 Member

                        </span>

                    <?php endif; ?>

                </div>

            </div>

            <hr>

            <!-- Tombol -->

            <div class="d-flex justify-content-between align-items-center">

                <div>

                    <?php if($user['role_id']!=1): ?>

                        <?php if($user['role_id']==3): ?>

                            <a
                            href="/users/role/<?= $user['id']; ?>"
                            class="btn btn-warning">

                                <i class="fa-solid fa-user-gear"></i>

                                Jadikan Staff

                            </a>

                        <?php else: ?>

                            <a
                            href="/users/role/<?= $user['id']; ?>"
                            class="btn btn-info text-white">

                                <i class="fa-solid fa-user"></i>

                                Jadikan Member

                            </a>

                        <?php endif; ?>

                    <?php endif; ?>

                </div>

                <div>

                    <?php if($user['role_id']!=1): ?>

                        <a
                        href="/users/delete/<?= $user['id']; ?>"
                        onclick="return confirm('Yakin ingin menghapus user ini?')"
                        class="btn btn-danger">

                            <i class="fa-solid fa-trash"></i>

                            Hapus

                        </a>

                    <?php else: ?>

                        <button
                        class="btn btn-secondary"
                        disabled>

                            Akun Admin

                        </button>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php endforeach; ?>

</div>

<!-- ========================= -->
<!-- MODAL TAMBAH STAFF -->
<!-- ========================= -->

<div class="modal fade"
     id="staffModal"
     tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header bg-primary text-white">

                <h4 class="modal-title">

                    <i class="fa-solid fa-user-plus"></i>

                    Tambah Staff

                </h4>

                <button
                    class="btn-close btn-close-white"
                    data-bs-dismiss="modal">

                </button>

            </div>

            <form action="/users/storeStaff"
                  method="post">

                <?= csrf_field(); ?>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Nama Lengkap

                            </label>

                            <input
                            type="text"
                            name="name"
                            class="form-control"
                            required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Username

                            </label>

                            <input
                            type="text"
                            name="username"
                            class="form-control"
                            required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Email

                            </label>

                            <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>

                        </div>

                        <div class="col-md-6 mb-3">

                            <label class="form-label">

                                Nomor HP

                            </label>

                            <input
                            type="text"
                            name="phone"
                            class="form-control">

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">

                                Password

                            </label>

                            <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>

                        </div>

                    </div>

                </div>

                <div class="modal-footer">

                    <button
                    class="btn btn-secondary"
                    data-bs-dismiss="modal">

                        Batal

                    </button>

                    <button
                    type="submit"
                    class="btn btn-success">

                        <i class="fa-solid fa-floppy-disk"></i>

                        Simpan Staff

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>