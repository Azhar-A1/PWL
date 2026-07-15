<!DOCTYPE html>
<html lang="id">
    <head>

        <meta charset="UTF-8">

            <meta name="viewport"
                content="width=device-width, initial-scale=1">

                <title>PerpusKu</title>

                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

                    <link rel="stylesheet"
                    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

                    <style>

                        body{

                            background:#f5f5f5;

                            padding-top:110px;

                        }

                        .navbar{

                            position:fixed;

                            top:0;

                            left:0;

                            right:0;

                            z-index:9999;

                            background:white;

                            padding:15px 30px;

                            box-shadow:0 3px 15px rgba(0,0,0,.1);

                        }

                        .search{

                            border-radius:30px;

                        }

                        .role{

                            color:#5b46d6;

                            font-weight:bold;

                        }

                        .banner{

                            background:#ead9cd;

                            border-radius:25px;

                            overflow:hidden;

                        }

                        .banner h2{

                            font-size:52px;

                            font-weight:bold;

                        }

                        .book-card{

                            transition:.3s;

                            cursor:pointer;

                        }

                        .book-card:hover{

                            transform:translateY(-10px);

                            box-shadow:0 15px 35px rgba(0,0,0,.25);

                        }

                        .book-card img{

                            transition:.4s;

                        }

                        .book-card:hover img{

                            transform:scale(1.05);

                        }

                        .offcanvas{

                            width:270px;

                        }

                        .list-group-item{

                            border:none;

                            border-radius:10px;

                            margin-bottom:5px;

                        }

                        .list-group-item:hover{

                            background:#4f46e5;

                            color:white;

                        }

                        .dropdown-toggle::after{

                            display:none;

                        }

                        .profile{

                            cursor:pointer;

                            font-weight:bold;

                            color:#4f46e5;

                        }

                        </style>

                        </head>

                    <body>

                    <!-- ========================= -->
                    <!-- SIDEBAR -->
                    <!-- ========================= -->

                    <div class="offcanvas offcanvas-start"
                        tabindex="-1"
                        id="sidebar">

                    <div class="offcanvas-header">

                    <h4 class="fw-bold text-primary">

                    📚 PerpusKu

                    </h4>

                    <button class="btn-close"
                            data-bs-dismiss="offcanvas">

                    </button>

                    </div>

                    <div class="offcanvas-body">

                    <div class="list-group">

                    <a href="/dashboard"
                    class="list-group-item list-group-item-action">

                    <i class="fa fa-house"></i>

                    Dashboard

                    </a>

                    <a href="/books"
                    class="list-group-item list-group-item-action">

                    <i class="fa fa-book"></i>

                    Koleksi Buku

                    </a>

                    <?php if(session()->get('role_id')==1): ?>

                    <a href="/staff"
                    class="list-group-item list-group-item-action">

                    <i class="fa fa-users"></i>

                    Kelola User

                    </a>

                    <a href="/peminjaman"
                    class="list-group-item list-group-item-action">

                    <i class="fa fa-repeat"></i>

                    Peminjaman

                    </a>


                    <?php endif; ?>

                    <?php if(session()->get('role_id')==2): ?>

                    <a href="/books"
                    class="list-group-item list-group-item-action">

                    <i class="fa fa-box"></i>

                    Kelola Stok

                    </a>

                    <?php endif; ?>

                    <?php if(session()->get('role_id')==3): ?>

                    <a href="/pinjam"
                    class="list-group-item list-group-item-action">

                    <i class="fa fa-book-open"></i>

                    Buku Saya

                    </a>

                    <a href="/history"
                    class="list-group-item list-group-item-action">

                    <i class="fa fa-clock"></i>

                    Riwayat

                    </a>

                    <?php endif; ?>

                    </div>

                    </div>

                    </div>

                    <!-- ========================= -->
                    <!-- CONTENT -->
                    <!-- ========================= -->

                    <div class="container py-4">

                    <nav class="navbar navbar-expand-lg bg-white shadow px-4 py-3">

                    <div class="container-fluid">

                    <div class="d-flex align-items-center">

                    <button
                    class="btn btn-light me-3"

                    data-bs-toggle="offcanvas"

                    data-bs-target="#sidebar">

                    <i class="fa-solid fa-bars"></i>

                    </button>

                    <a class="navbar-brand fw-bold text-primary">

                    📚 PerpusKu

                    </a>

                    </div>

                    <div class="mx-auto w-50">

                    <input

                    id="search"

                    class="form-control search"

                    placeholder="Cari buku...">

                    </div>

                    <div class="dropdown">

                    <a

                    class="text-decoration-none profile dropdown-toggle"

                    data-bs-toggle="dropdown">

                    <?php

                    if(session()->get('role_id')==1){

                    echo "Admin 👑";

                    }

                    elseif(session()->get('role_id')==2){

                    echo "Staff 👨‍💼";

                    }

                    else{

                    echo "Member 👤";

                    }

                    ?>

                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow">

                    <li>

                    <a class="dropdown-item"

                    href="#">

                    <i class="fa fa-user"></i>

                    Profil

                    </a>

                    </li>

                    <li>

                    <hr class="dropdown-divider">

                    </li>

                    <li>

                    <a class="dropdown-item text-danger"

                    href="/logout">

                    <i class="fa fa-right-from-bracket"></i>

                    Logout

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>

<!-- ========================= -->
<!-- BANNER -->
<!-- ========================= -->

<div class="banner mt-4 shadow">

    <div class="row align-items-center">

        <div class="col-lg-6 p-5">

            <span class="badge bg-dark mb-3">

                DIGITAL LIBRARY

            </span>

            <h2>

                Build Your Library

            </h2>

            <p class="text-dark">

                Temukan berbagai koleksi buku terbaik dari
                perpustakaan digital kami.
                Pinjam buku dengan mudah dan cepat kapan saja.

            </p>

            <a href="/books"
               class="btn btn-dark rounded-pill px-4">

                📚 Lihat Semua Buku

            </a>

        </div>

        <div class="col-lg-6 text-center">

            <img src="https://cdn-icons-png.flaticon.com/512/2702/2702134.png"
                 class="img-fluid p-4"
                 style="max-height:380px;">

        </div>

    </div>

</div>

<!-- ========================= -->
<!-- DAFTAR BUKU -->
<!-- ========================= -->

<div class="d-flex justify-content-between align-items-center mt-5 mb-4">

    <div>

        <h3 class="fw-bold">

            📚 Daftar Buku

        </h3>

        <small class="text-muted">

            Koleksi buku yang tersedia di PerpusKu

        </small>

    </div>

    <a href="/books"
       class="btn btn-outline-primary rounded-pill">

        Lihat Semua

    </a>

</div>

<div class="row" id="bookContainer">

<?php foreach($books as $book): ?>

<div class="col-lg-2 col-md-4 mb-4">

<a href="/books/detail/<?= $book['id']; ?>"
class="text-decoration-none text-dark">

    <div class="card book-card shadow h-100">

        <img
        src="/uploads/<?= $book['cover']; ?>"
        class="card-img-top">

        <div class="card-body">

            <h6 class="fw-bold">

                <?= $book['title']; ?>

            </h6>

            <small class="text-muted">

                <?= $book['author']; ?>

            </small>

            <br><br>

            <span class="badge bg-success">

                Stok <?= $book['stock']; ?>

            </span>

        </div>

    </div>

</a>

</div>

<?php endforeach; ?>

</div>

<!-- ========================= -->
<!-- STATISTIK -->
<!-- ========================= -->

<div class="row mt-5">

<div class="col-md-4 mb-3">

<div class="card border-0 shadow rounded-4">

<div class="card-body">

<h1>

📚

</h1>

<h5>

Total Buku

</h5>

<h2>

<?= count($books); ?>

</h2>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card border-0 shadow rounded-4">

<div class="card-body">

<h1>

👤

</h1>

<h5>

Role

</h5>

<h4>

<?php

if(session()->get('role_id')==1){

echo "Administrator";

}elseif(session()->get('role_id')==2){

echo "Staff";

}else{

echo "Member";

}

?>

</h4>

</div>

</div>

</div>

<div class="col-md-4 mb-3">

<div class="card border-0 shadow rounded-4">

<div class="card-body">

<h1>

⭐

</h1>

<h5>

PerpusKu

</h5>

<p>

Sistem Perpustakaan Digital berbasis
CodeIgniter 4

</p>

</div>

</div>

</div>

</div>

</div>


<!-- ========================= -->
<!-- FOOTER -->
<!-- ========================= -->

<footer class="mt-5 py-4">

    <div class="text-center text-muted">

        <hr>

        <h6>

            📚 PerpusKu Digital Library

        </h6>

        <small>

            © <?= date('Y'); ?> PerpusKu.
            All Rights Reserved.

        </small>

    </div>

</footer>

</div>

<!-- ========================= -->
<!-- Bootstrap JS -->
<!-- ========================= -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- ========================= -->
<!-- SEARCH REALTIME -->
<!-- ========================= -->

<script>

const search=document.getElementById("search");

search.addEventListener("keyup",function(){

let keyword=this.value.toLowerCase();

let books=document.querySelectorAll(".bookItem");

books.forEach(function(book){

let text=book.innerText.toLowerCase();

if(text.indexOf(keyword)>-1){

book.style.display="block";

}else{

book.style.display="none";

}

});

});

</script>

<!-- ========================= -->
<!-- ANIMASI CARD -->
<!-- ========================= -->

<script>

const cards=document.querySelectorAll(".book-card");

cards.forEach(function(card){

card.addEventListener("mouseenter",function(){

this.style.transform="translateY(-10px) scale(1.02)";

});

card.addEventListener("mouseleave",function(){

this.style.transform="translateY(0px)";

});

});

</script>

<!-- ========================= -->
<!-- TOOLTIP -->
<!-- ========================= -->

<script>

const tooltipTriggerList=[].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))

tooltipTriggerList.map(function(el){

return new bootstrap.Tooltip(el)

})

</script>

<!-- ========================= -->
<!-- LOADING BUTTON -->
<!-- ========================= -->

<script>

document.querySelectorAll("a.btn").forEach(function(btn){

btn.addEventListener("click",function(){

this.innerHTML="Loading...";

});

});

</script>

</body>

</html>

</body>
</html>