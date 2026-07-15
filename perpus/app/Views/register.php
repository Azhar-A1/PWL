<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registrasi Member</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>

        body{
            background:linear-gradient(135deg,#0d6efd,#6f42c1);
        }

        .card{
            border:none;
            border-radius:20px;
        }

        .form-control{
            border-radius:12px;
        }

        .input-group-text{
            border-radius:12px 0 0 12px;
        }

        .btn{
            border-radius:12px;
        }

    </style>

</head>

<body>

<div class="container d-flex justify-content-center align-items-center vh-100">

    <div class="card shadow-lg" style="width:520px;">

        <div class="card-body p-5">

            <h2 class="text-center mb-4">

                <i class="fa-solid fa-book-open-reader text-primary"></i>

                Registrasi Member

            </h2>

            <?php if(session()->getFlashdata('error')): ?>

                <div class="alert alert-danger">

                    <?= session()->getFlashdata('error'); ?>

                </div>

            <?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>

                <div class="alert alert-success">

                    <?= session()->getFlashdata('success'); ?>

                </div>

            <?php endif; ?>

            <form action="/register/process" method="post">

                <div class="mb-3">

                    <label class="form-label">

                        Nama Lengkap

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fa-solid fa-user"></i>

                        </span>

                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            placeholder="Nama Lengkap"
                            required>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Username

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fa-solid fa-user-tag"></i>

                        </span>

                        <input
                            type="text"
                            name="username"
                            class="form-control"
                            placeholder="Username"
                            required>

                    </div>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Email

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fa-solid fa-envelope"></i>

                        </span>

                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="email@example.com"
                            required>

                    </div>

                </div>

                <!-- NOMOR WHATSAPP -->

                <div class="mb-3">

                    <label class="form-label">

                        Nomor WhatsApp

                    </label>

                    <div class="input-group">

                        <span class="input-group-text bg-success text-white">

                            <i class="fa-brands fa-whatsapp"></i>

                        </span>

                        <input
                            type="text"
                            name="phone"
                            class="form-control"
                            placeholder="6281234567890"
                            required>

                    </div>

                    <small class="text-muted">

                        Gunakan format <b>628xxxxxxxxxx</b>

                    </small>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Password

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fa-solid fa-lock"></i>

                        </span>

                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>

                    </div>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Konfirmasi Password

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">

                            <i class="fa-solid fa-lock"></i>

                        </span>

                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control"
                            required>

                    </div>

                </div>

                <button type="submit" class="btn btn-success w-100">

                    <i class="fa-solid fa-user-plus"></i>

                    Daftar

                </button>

            </form>

            <hr>

            <div class="text-center">

                Sudah punya akun?

                <br>

                <a href="/login" class="text-decoration-none">

                    Login Sekarang

                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>