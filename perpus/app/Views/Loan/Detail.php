<!DOCTYPE html>
<html>
<head>
    <title>Detail Peminjaman</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-5">

    <h2>Detail Peminjaman</h2>

    <table class="table table-bordered">

        <tr>
            <th>Buku</th>
            <td><?= $loan['title']; ?></td>
        </tr>

        <tr>
            <th>Peminjam</th>
            <td><?= $loan['name']; ?></td>
        </tr>

        <tr>
            <th>Tanggal Pinjam</th>
            <td><?= $loan['borrow_date']; ?></td>
        </tr>

        <tr>
            <th>Jatuh Tempo</th>
            <td><?= $loan['due_date']; ?></td>
        </tr>

        <tr>
            <th>Status</th>
            <td><?= ucfirst($loan['loan_status']); ?></td>
        </tr>

    </table>

    <a href="/peminjaman" class="btn btn-secondary">
        Kembali
    </a>

</div>

</body>
</html>