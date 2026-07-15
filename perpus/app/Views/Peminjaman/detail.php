<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Detail Peminjaman</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>

        body{
            background:#f5f7fb;
        }

        .header-card{
            background:white;
            border-radius:20px;
            padding:25px;
            box-shadow:0 5px 20px rgba(0,0,0,.08);
            margin-bottom:30px;
        }

        .detail-card{
            border:none;
            border-radius:25px;
            overflow:hidden;
            box-shadow:0 10px 30px rgba(0,0,0,.1);
        }

        .cover{

            width:100%;
            height:480px;
            object-fit:cover;
            border-radius:20px;

        }

        .title{

            font-size:35px;
            font-weight:bold;

        }

        .info-box{

            background:#f8f9fa;
            border-radius:15px;
            padding:15px;
            margin-bottom:15px;

        }

        .badge-status{

            font-size:15px;
            padding:8px 18px;

        }

        .price{

            font-size:30px;
            color:#dc3545;
            font-weight:bold;

        }

        .timeline{

            border-left:4px solid #0d6efd;
            padding-left:20px;

        }

        .timeline-item{

            margin-bottom:20px;

        }

    </style>

</head>

<body>

<div class="container py-5">

    <!-- HEADER -->

    <div class="header-card">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h2>

                    <i class="fa-solid fa-book-open"></i>

                    Detail Peminjaman

                </h2>

                <p class="text-muted mb-0">

                    Informasi lengkap mengenai peminjaman buku.

                </p>

            </div>

            <a href="/pinjam"

               class="btn btn-secondary">

                <i class="fa-solid fa-arrow-left"></i>

                Kembali

            </a>

        </div>

    </div>

    <!-- CONTENT -->

    <div class="card detail-card">

            <div class="row">

                <!-- COVER -->

                <div class="col-lg-4">

                    <img
                    src="/uploads/<?= $loan['cover']; ?>"
                    class="cover">

                </div>

                <!-- DETAIL -->

                <div class="col-lg-8">

                    <div class="title">

                        <?= esc($loan['title']); ?>

                    </div>

                    <h5 class="text-muted mb-4">

                        <?= esc($loan['author']); ?>

                    </h5>

                    <div class="row">

                        <div class="col-md-6">

                            <div class="info-box">

                                <b>

                                    <i class="fa-solid fa-building"></i>

                                    Penerbit

                                </b>

                                <br>

                                <?= esc($loan['publisher']); ?>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="info-box">

                                <b>

                                    <i class="fa-solid fa-calendar"></i>

                                    Tahun

                                </b>

                                <br>

                                <?= esc($loan['year']); ?>

                            </div>

                        </div>

                    </div>

                    <hr>

                    <h5 class="mb-4">

                        <i class="fa-solid fa-clock"></i>

                        Timeline Peminjaman

                    </h5>

                    <div class="timeline">

                        <div class="timeline-item">

                            <strong>Dipinjam</strong>

                            <br>

                            <?= $loan['borrow_date']; ?>

                        </div>

                        <div class="timeline-item">

                            <strong>Jatuh Tempo</strong>

                            <br>

                            <?= $loan['due_date']; ?>

                        </div>

                        <div class="timeline-item">

                            <strong>Dikembalikan</strong>

                            <br>

                            <?= $loan['return_date'] ?: '-'; ?>

                        </div>

                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-md-6">

                            <h5>Status</h5>

                            <?php

                            $warna='bg-success';

                            if($loan['loan_status']=="returned"){

                                $warna='bg-secondary';

                            }

                            ?>

                            <span class="badge <?= $warna ?> badge-status">

                                <?= $loan['loan_status']=="borrowed" ? "Sedang Dipinjam" : "Sudah Dikembalikan"; ?>

                            </span>

                        </div>

                        <div class="col-md-6">

                            <h5>Pembayaran</h5>

                            <?php

                            switch($loan['payment_status']){

                                case 'paid':

                                    $badge = 'success';
                                    $text  = 'Sudah Lunas';

                                break;

                                case 'pending':

                                    $badge = 'warning';
                                    $text  = 'Menunggu Pembayaran';

                                break;

                                case 'expired':

                                    $badge = 'secondary';
                                    $text  = 'Expired';

                                break;

                                case 'cancel':

                                    $badge = 'danger';
                                    $text  = 'Dibatalkan';

                                break;

                                case 'deny':

                                    $badge = 'dark';
                                    $text  = 'Ditolak';

                                break;

                                default:

                                    $badge = 'danger';
                                    $text  = 'Belum Bayar';

                            }

                            ?>

                            <span class="badge bg-<?= $badge ?> badge-status">

                                <?= $text ?>

                            </span>

                        </div>
                    </div>

                    <hr>

                    <div class="row align-items-center">

                        <div class="col-md-6">

                            <small class="text-muted">

                                Total Denda

                            </small>

                            <div class="price">

                                Rp <?= number_format($loan['fine']); ?>

                            </div>

                        </div>

                        <div class="col-md-6 text-end">

                            <div class="col-md-6 text-end">

                            <!-- Tombol Pengembalian -->
                            <?php if($loan['loan_status'] == 'borrowed'): ?>

                                <a href="/pinjam/kembali/<?= $loan['id']; ?>"
                                class="btn btn-success btn-lg mb-2"
                                onclick="return confirm('Yakin ingin mengembalikan buku ini?')">

                                    <i class="fa-solid fa-book"></i>

                                    Kembalikan Buku

                                </a>

                            <?php endif; ?>

                            <br>

                            <!-- Tombol Pembayaran -->

                            <?php if($loan['fine'] > 0): ?>

                                <?php if($loan['payment_status']=="unpaid"): ?>

                                    <a href="/payment/pay/<?= $loan['id']; ?>"
                                    class="btn btn-danger btn-lg">

                                        <i class="fa-solid fa-credit-card"></i>

                                        Bayar Denda

                                    </a>

                                <?php elseif($loan['payment_status']=="pending"): ?>

                                    <button class="btn btn-warning btn-lg" disabled>

                                        <i class="fa-solid fa-clock"></i>

                                        Menunggu Pembayaran

                                    </button>

                                <?php elseif($loan['payment_status']=="paid"): ?>

                                    <button class="btn btn-success btn-lg" disabled>

                                        <i class="fa-solid fa-circle-check"></i>

                                        Denda Sudah Lunas

                                    </button>

                                <?php else: ?>

                                    <button class="btn btn-secondary btn-lg" disabled>

                                        Status Tidak Diketahui

                                    </button>

                                <?php endif; ?>

                            <?php else: ?>

                                <?php if($loan['loan_status']=="returned"): ?>

                                    <button class="btn btn-success btn-lg" disabled>

                                        <i class="fa-solid fa-circle-check"></i>

                                        Tidak Ada Denda

                                    </button>

                                <?php endif; ?>

                            <?php endif; ?>

                        </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="<?= \Config\Midtrans::$clientKey ?>">
</script>

</body>

</html>