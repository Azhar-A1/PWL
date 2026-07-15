<!DOCTYPE html>
<html>
<head>

    <title>Tambah Buku</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- STYLE -->
    <style>

        body{
            background-color: #f5f6fa;
        }

        .card-form{
            border-radius: 20px;
        }

    </style>

</head>

<body>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <!-- CARD -->
            <div class="card shadow card-form">

                <div class="card-body p-5">

                    <!-- JUDUL -->
                    <h2 class="mb-4 text-center text-primary">

                        📚 Tambah Buku

                    </h2>

                    <!-- FLASH ERROR -->
                    <?php if(session()->getFlashdata('error')) : ?>

                        <div class="alert alert-danger">

                            <?= session()->getFlashdata('error'); ?>

                        </div>

                    <?php endif; ?>

                    <!-- FORM -->
                    <form action="/books/store"
                          method="post"
                          enctype="multipart/form-data">

                        <!-- ISBN -->
                        <div class="mb-3">

                            <label class="form-label">
                                ISBN
                            </label>

                            <div class="input-group">

                                <input type="text"
                                    id="isbn"
                                    name="isbn"
                                    class="form-control"
                                    placeholder="Masukkan ISBN">

                                <button type="button"
                                        class="btn btn-primary"
                                        onclick="fetchBook()">

                                    Cari Data

                                </button>

                            </div>

                        </div>
                        <!-- JUDUL -->
                        <div class="mb-3">

                            <label class="form-label">

                                Judul Buku

                            </label>

                            <input type="text"
                                   id="title"
                                   name="title"
                                   class="form-control"
                                   placeholder="Masukkan Judul Buku">

                        </div>

                        <!-- PENULIS -->
                        <div class="mb-3">

                            <label class="form-label">

                                Penulis

                            </label>

                            <input type="text"
                                 id="author"
                                   name="author"
                                   class="form-control"
                                   placeholder="Masukkan Nama Penulis">

                        </div>

                        <!-- PENERBIT -->
                        <div class="mb-3">

                            <label class="form-label">

                                Penerbit

                            </label>

                            <input type="text"
                                   id="publisher"
                                   name="publisher"
                                   class="form-control"
                                   placeholder="Masukkan Nama Penerbit">

                        </div>

                        <!-- TAHUN -->
                        <div class="mb-3">

                            <label class="form-label">

                                Tahun Terbit

                            </label>
                            <div class="mb-3">

                                <label class="form-label">

                                    Sinopsis

                                </label>

                                <textarea
                                    name="sinopsis"
                                    rows="6"
                                    class="form-control"
                                    placeholder="Masukkan sinopsis buku"></textarea>

                            </div>

                            <input type="number"
                                   id="year"    
                                   name="year"
                                   class="form-control"
                                   placeholder="2026">

                        </div>

                        <!-- STOK -->
                        <div class="mb-3">

                            <label class="form-label">

                                Stok Buku

                            </label>

                            <input type="number"
                                   name="stock"
                                   class="form-control"
                                   placeholder="Masukkan Jumlah Stok">

                        </div>

                        <!-- COVER -->
                        <div class="mb-4">

                            <label class="form-label">

                                Upload Cover Buku

                            </label>

                            <input type="file"
                                   name="cover"
                                   class="form-control">

                        </div>

                        <!-- BUTTON -->
                        <div class="d-grid gap-2">

                            <button type="submit"
                                    class="btn btn-primary">

                                💾 Simpan Buku

                            </button>

                            <a href="/books"
                               class="btn btn-secondary">

                               ← Kembali

                            </a>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function fetchBook()
{
    let isbn =
        document.getElementById('isbn').value;

    fetch('/books/fetch/' + isbn)

    .then(response => response.json())

    .then(result => {

        if(result.status === false)
        {
            alert(result.message);
            return;
        }

        document.getElementById('title').value =
            result.data.title;

        document.getElementById('author').value =
            result.data.author;

        document.getElementById('publisher').value =
            result.data.publisher;

        document.getElementById('year').value =
            result.data.year;

    })

    .catch(error => {

        alert('Gagal koneksi API');

    });
}

</script>

</body>
</html>