<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Edit Buku</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{
            background:#f4f6f9;
        }

        .card{
            border:none;
            border-radius:20px;
        }

        .form-control{
            border-radius:12px;
        }

        .btn{
            border-radius:10px;
        }

        .cover-preview{
            width:180px;
            border-radius:15px;
            box-shadow:0 5px 15px rgba(0,0,0,.2);
        }

    </style>

</head>

<body>

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-body p-5">

                    <!-- Header -->

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h2>

                            ✏ Edit Buku

                        </h2>

                        <a href="/books" class="btn btn-secondary">

                            ← Kembali

                        </a>

                    </div>

                    <!-- Informasi Staff -->

                    <?php if(session()->get('role_id')==2): ?>

                    <div class="alert alert-info">

                        <strong>Mode Staff</strong><br>

                        Anda hanya dapat memperbarui stok buku.

                    </div>

                    <?php endif; ?>

                    <form action="/books/update/<?= $book['id']; ?>" method="post" enctype="multipart/form-data">

                        <!-- Cover -->

                        <div class="text-center mb-4">

                            <img
                            src="/uploads/<?= esc($book['cover']); ?>"
                            class="cover-preview">

                        </div>

                        <!-- Judul -->

                        <div class="mb-3">

                            <label class="form-label">

                                Judul Buku

                            </label>

                            <input
                            type="text"
                            name="title"
                            class="form-control"
                            value="<?= esc($book['title']); ?>"
                            <?= session()->get('role_id')==2 ? 'readonly' : '' ?>>

                        </div>

                        <!-- Penulis -->

                        <div class="mb-3">

                            <label class="form-label">

                                Penulis

                            </label>

                            <input
                            type="text"
                            name="author"
                            class="form-control"
                            value="<?= esc($book['author']); ?>"
                            <?= session()->get('role_id')==2 ? 'readonly' : '' ?>>

                        </div>

                        <!-- Penerbit -->

                        <div class="mb-3">

                            <label class="form-label">

                                Penerbit

                            </label>

                            <input
                            type="text"
                            name="publisher"
                            class="form-control"
                            value="<?= esc($book['publisher']); ?>"
                            <?= session()->get('role_id')==2 ? 'readonly' : '' ?>>

                        </div>

                        <div class="row">

                            <!-- Tahun -->

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Tahun Terbit

                                    </label>

                                    <input
                                    type="number"
                                    name="year"
                                    class="form-control"
                                    value="<?= esc($book['year']); ?>"
                                    <?= session()->get('role_id')==2 ? 'readonly' : '' ?>>

                                </div>

                            </div>

                            <!-- Stock -->

                            <div class="col-md-6">

                                <div class="mb-3">

                                    <label class="form-label">

                                        Stok Buku

                                    </label>

                                    <input
                                    type="number"
                                    name="stock"
                                    class="form-control"
                                    value="<?= esc($book['stock']); ?>">

                                </div>

                            </div>

                        </div>

                        <!-- Sinopsis -->

                        <div class="mb-3">

                            <label class="form-label">

                                Sinopsis

                            </label>

                            <textarea
                            name="sinopsis"
                            rows="7"
                            class="form-control"
                            <?= session()->get('role_id')==2 ? 'readonly' : '' ?>><?= esc($book['sinopsis']); ?></textarea>

                        </div>

                        <!-- Cover Baru (Admin saja) -->

                        <?php if(session()->get('role_id')==1): ?>

                        <div class="mb-4">

                            <label class="form-label">

                                Ganti Cover (Opsional)

                            </label>

                            <input
                            type="file"
                            name="cover"
                            class="form-control">

                        </div>

                        <?php endif; ?>

                        <!-- Tombol -->

                        <div class="d-grid">

                            <button
                            type="submit"
                            class="btn btn-primary btn-lg">

                                <?php if(session()->get('role_id')==1): ?>

                                    💾 Simpan Perubahan

                                <?php else: ?>

                                    📦 Update Stok

                                <?php endif; ?>

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>