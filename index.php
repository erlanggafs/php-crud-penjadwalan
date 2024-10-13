<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika belum login, redirect ke halaman login
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            text-align: center; /* Memusatkan teks di tengah */
            background-color: #f8f9fa; /* Warna latar belakang yang lembut */
            padding: 20px; /* Memberikan padding di sekitar konten */
        }
        .welcome-message {
            margin-bottom: 40px; /* Jarak bawah untuk pesan selamat datang */
        }
        .button-container {
            display: flex; /* Menggunakan flexbox untuk tata letak tombol */
            justify-content: center; /* Memusatkan tombol secara horizontal */
            gap: 20px; /* Jarak antara tombol */
            flex-wrap: wrap; /* Membuat tombol responsif */
        }
        button {
            padding: 10px 20px; /* Ukuran tombol */
            font-size: 16px; /* Ukuran font tombol */
            cursor: pointer; /* Menampilkan kursor pointer saat hover */
        }
        h2 {
            margin-top: 20px; /* Memberikan jarak atas untuk judul tombol */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary"> <!-- Mengubah menjadi navbar-dark dan bg-primary -->
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Erlangga Firmansyah</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto"> <!-- Menggunakan ms-auto untuk memposisikan menu ke kanan -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a> <!-- Tombol logout di navbar -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <h1 class="text-light welcome-message">Selamat datang, <?php echo $_SESSION['username']; ?>!</h1> <!-- Ubah teks menjadi putih untuk kontras -->
    
    <div class="button-container">
        <div class="card p-3 shadow-sm">
            <h2>Data Dosen</h2>
            <button class="btn btn-primary" onclick="window.location.href='admin/dosen/index.php'">Lihat Data Dosen</button>
        </div>
        <div class="card p-3 shadow-sm">
            <h2>Data Mahasiswa</h2>
            <button class="btn btn-primary" onclick="window.location.href='admin/mahasiswa/index.php'">Lihat Data Mahasiswa</button>
        </div>
        <div class="card p-3 shadow-sm">
            <h2>Data Mata Kuliah</h2>
            <button class="btn btn-primary" onclick="window.location.href='admin/matakuliah/index.php'">Lihat Data Mata Kuliah</button>
        </div>
        <!-- Tambahkan tombol untuk Data Semester -->
        <div class="card p-3 shadow-sm">
            <h2>Data Semester</h2>
            <button class="btn btn-primary" onclick="window.location.href='admin/semester/index.php'">Lihat Data Semester</button>
        </div>
    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
