<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<!-- 🔷 NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
    <a class="navbar-brand fw-bold text-primary" href="#">📚 PerpusKu</a>

    <div class="ms-4 w-50">
        <input type="text" class="form-control" placeholder="Cari buku, penulis...">
    </div>

    <div class="ms-auto">
        <span class="me-3">Dashboard</span>
        <span class="me-3">Kategori</span>
        <span>Profil</span>
    </div>
</nav>

<!-- 🔷 CONTAINER -->
<div class="container mt-4">

    <!-- 🔶 BANNER -->
    <div class="card bg-primary text-white p-4 mb-4 shadow-sm">
        <h4>📢 Promo Perpustakaan</h4>
        <p>Pinjam buku sekarang dan dapatkan bonus bebas denda 1 hari!</p>
    </div>

    <!-- 🔶 MENU GRID -->
    <div class="row text-center">

        <div class="col-md-3 mb-3">
            <div class="card p-4 shadow-sm">
                📚
                <h5 class="mt-2">Koleksi Buku</h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card p-4 shadow-sm">
                👤
                <h5 class="mt-2">Anggota</h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card p-4 shadow-sm">
                🔄
                <h5 class="mt-2">Peminjaman</h5>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card p-4 shadow-sm">
                💰
                <h5 class="mt-2">Denda</h5>
            </div>
        </div>

    </div>

</div>

<!-- 🔴 LOGOUT FIXED KIRI BAWAH -->
<a href="/logout" class="btn btn-danger position-fixed" 
   style="bottom: 20px; left: 20px;">
   Logout
</a>

</body>
</html>