<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Pembayaran Denda</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

<style>

body{

background:#eef3f9;

}

.payment-card{

max-width:700px;

margin:auto;

margin-top:70px;

border:none;

border-radius:25px;

overflow:hidden;

box-shadow:0 10px 35px rgba(0,0,0,.12);

}

.header{

background:linear-gradient(135deg,#0d6efd,#5b8cff);

padding:30px;

color:white;

}

.total{

font-size:45px;

font-weight:bold;

color:#dc3545;

}

.info{

background:#f8f9fa;

padding:18px;

border-radius:15px;

margin-bottom:15px;

}

.pay-btn{

padding:15px;

font-size:22px;

border-radius:15px;

}

.footer{

font-size:14px;

color:#777;

}

.btn-outline-secondary{

    border-radius:15px;

    padding:14px;

    font-size:20px;

}

.btn-outline-secondary:hover{

    background:#6c757d;

    color:white;

}

</style>

</head>

<body>

<div class="card payment-card">

<div class="header">

<h2>

<i class="fa-solid fa-credit-card"></i>

Pembayaran Denda

</h2>

<p class="mb-0">

Silakan selesaikan pembayaran untuk menyelesaikan transaksi.

</p>

</div>

<div class="card-body p-5">

<div class="info">

<h4>

<?= esc($loan['title']); ?>

</h4>

<p class="text-muted">

ID Peminjaman :

<b>#<?= $loan['id']; ?></b>

</p>

</div>

<div class="text-center">

<p>Total Denda</p>

<div class="total">

Rp <?= number_format($loan['fine']); ?>

</div>

</div>

<hr>

<div class="d-grid mt-4">

    <button
        id="pay-button"
        class="btn btn-primary pay-btn">

        <i class="fa-solid fa-wallet"></i>
        Bayar Sekarang

    </button>

</div>

<div class="d-grid mt-3">

    <a
        href="/pinjam/detail/<?= $loan['id']; ?>"
        class="btn btn-outline-secondary btn-lg">

        <i class="fa-solid fa-arrow-left"></i>
        Kembali

    </a>

</div>

<div class="footer text-center mt-4">

<i class="fa-solid fa-lock"></i>

Pembayaran diproses oleh Midtrans Sandbox

</div>

</div>

</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js"
data-client-key="<?= \Config\Midtrans::$clientKey ?>">
</script>

<script>

document.getElementById('pay-button').onclick=function(){

snap.pay('<?= $snapToken ?>',{

onSuccess:function(result){

window.location.href="/payment/finish?id=<?= $loan['id']; ?>";

},

onPending:function(result){

alert("Pembayaran masih pending");

},

onError:function(result){

alert("Pembayaran gagal");

},

onClose:function(){

alert("Popup ditutup");

}

});

}

</script>

</body>

</html>