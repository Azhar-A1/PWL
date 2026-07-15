<!DOCTYPE html>
<html>

<head>

    <title>Daftar Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f5f5f5;
        }

        .card{
            border:none;
            border-radius:20px;
        }

        table img{
            border-radius:10px;
            transition:.3s;
        }

        table img:hover{
            transform:scale(1.08);
        }

        .table tbody tr:hover{
            background:#f8f9fa;
        }

        .stock{
            font-size:15px;
        }

        a{
            text-decoration:none;
        }

    </style>

</head>

<body>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-body">

            <!-- HEADER -->
            <div class="d-flex align-items-center justify-content-between mb-4">

                <div>

                    <a href="/dashboard"
                    class="btn btn-outline-secondary">

                        ← Kembali

                    </a>

                </div>

                <h2 class="mb-0">

                    📚 Daftar Buku

                </h2>

                <div>

                    <?php if(session()->get('role_id')==1): ?>

                        <a href="/books/create"
                        class="btn btn-success">

                            + Tambah Buku

                        </a>

                    <?php endif; ?>

                </div>

            </div>

            <!-- FLASH SUCCESS -->

            <?php if(session()->getFlashdata('success')): ?>

                <div class="alert alert-success">

                    <?= session()->getFlashdata('success'); ?>

                </div>

            <?php endif; ?>

            <!-- FLASH ERROR -->

            <?php if(session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">

                    <?= session()->getFlashdata('error'); ?>

                </div>

            <?php endif; ?>

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th width="100">Cover</th>

                        <th>Judul</th>

                        <th>Penulis</th>

                        <th>Stok</th>

                        <th width="300">Aksi</th>

                    </tr>

                </thead>

                <tbody>

                <?php foreach($books as $book): ?>

                <tr>

                    <!-- COVER -->

                    <td>

                        <a href="/books/detail/<?= $book['id']; ?>">

                            <img src="/uploads/<?= $book['cover']; ?>"
                                 width="70"
                                 class="shadow-sm">

                        </a>

                    </td>

                    <!-- JUDUL -->

                    <td>

                        <a href="/books/detail/<?= $book['id']; ?>"
                           class="fw-bold text-dark">

                            <?= $book['title']; ?>

                        </a>

                    </td>

                    <!-- PENULIS -->

                    <td>

                        <?= $book['author']; ?>

                    </td>

                    <!-- STOK -->

                    <td>

                        <?php if($book['stock'] > 5): ?>

                            <span class="badge bg-success stock">

                                <?= $book['stock']; ?>

                            </span>

                        <?php elseif($book['stock'] > 0): ?>

                            <span class="badge bg-warning text-dark stock">

                                <?= $book['stock']; ?>

                            </span>

                        <?php else: ?>

                            <span class="badge bg-danger stock">

                                Habis

                            </span>

                        <?php endif; ?>

                    </td>

                    <!-- AKSI -->

                    <td>

                        <td>

                <!-- ADMIN -->
                <?php if(session()->get('role_id') == 1): ?>

                    <a href="/books/edit/<?= $book['id']; ?>"
                    class="btn btn-warning btn-sm">

                        ✏ Edit

                    </a>

                    <a href="/books/delete/<?= $book['id']; ?>"
                    onclick="return confirm('Yakin ingin menghapus buku ini?')"
                    class="btn btn-danger btn-sm">

                        🗑 Hapus

                    </a>

                <?php endif; ?>


                <!-- STAFF -->
                <?php if(session()->get('role_id') == 2): ?>

                    <a href="/books/edit/<?= $book['id']; ?>"
                    class="btn btn-info btn-sm">

                        📦 Update Stok

                    </a>

                <?php endif; ?>


                <!-- MEMBER -->
                <?php if(session()->get('role_id') == 3): ?>

                    <?php if($book['stock'] > 0): ?>

                        <a href="/pinjam/form/<?= $book['id']; ?>"
                        class="btn btn-primary btn-sm">

                            📖 Pinjam

                        </a>

                    <?php else: ?>

                        <button class="btn btn-secondary btn-sm" disabled>

                            Stok Habis

                        </button>

                    <?php endif; ?>

                <?php endif; ?>

            </td>

                </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>

</html>