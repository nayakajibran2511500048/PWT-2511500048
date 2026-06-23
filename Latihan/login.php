<?php
include "config/koneksi.php";
session_start();

$error_message = "";

if (isset($_POST['login'])) { 
    // Mengamankan input dari karakter aneh (SQL Injection)
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    if (empty($username) || empty($password)) {
        $error_message = "Username dan Password tidak boleh kosong!";
    } else {
        // SUDAH DIUBAH: Menggunakan tabel 'user' sesuai phpMyAdmin Anda
        $query_text = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
        $eksekusi   = mysqli_query($koneksi, $query_text);

        // Cek jika ada kesalahan struktur kolom pada tabel
        if (!$eksekusi) {
            die("Query Error: " . mysqli_error($koneksi)); 
        }

        $userquery = mysqli_fetch_array($eksekusi);

        if ($userquery) {
            // Menyimpan data login ke session
            $_SESSION['role']     = $userquery['role']; // Pastikan di tabel ada kolom 'role'
            $_SESSION['username'] = $username;
            
            // Alihkan ke halaman utama
            header("Location: index.php");
            exit(); 
        } else {
            $error_message = "Login gagal! Username atau Password salah.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Admin</b>LTE</a>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Sign in to start your session</p>

            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-ban"></i> Alert!</h5>
                    <?= $error_message; ?>
                </div>
            <?php endif; ?>

            <form action="" method="post">
                <div class="input-group mb-3">
                    <input type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="submit" name="login" value="Login" class="btn btn-primary btn-block">
                    </div>
                </div>
            </form>
        </div>
        </div>
</div>
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>