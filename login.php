<?php
include "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Menambahkan CSS Bootstrap melalui CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Warna latar belakang */
        }
        .container {
            max-width: 400px; /* Lebar maksimal container */
            margin-top: 100px; /* Margin atas untuk sentralisasi */
        }
        .login-header {
            color: #007bff; /* Warna biru untuk judul */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="login-header text-center">Login</h2>
        <br />
        <!-- Cek pesan notifikasi -->
        <?php
        if (isset($_GET['pesan'])) {
            echo '<div class="alert alert-danger text-center" role="alert">';
            if ($_GET['pesan'] == "gagal") {
                echo "Login gagal! username dan password salah!";
            } else if ($_GET['pesan'] == "logout") {
                echo "Anda telah berhasil logout";
            } else if ($_GET['pesan'] == "belum_login") {
                echo "Anda harus login untuk mengakses halaman admin";
            }
            echo '</div>';
        }
        ?>
        <br />
        <form method="post" action="cek_login.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">LOGIN</button>
        </form>
    </div>

    <!-- Menambahkan JS Bootstrap melalui CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
