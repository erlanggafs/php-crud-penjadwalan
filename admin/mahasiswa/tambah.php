<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_pelatihan";

    // Membuat koneksi
    $conn = new mysqli($host, $username, $password, $dbname);

    // Cek koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data dari form
    $nim = $conn->real_escape_string($_POST['nim']);
    $nama_mahasiswa = $conn->real_escape_string($_POST['nama_mahasiswa']);
    $alamat_mahasiswa = $conn->real_escape_string($_POST['alamat_mahasiswa']);
    $jurusan = $conn->real_escape_string($_POST['jurusan']);

    // Cek apakah NIM sudah ada
    $check_nim = "SELECT * FROM tbl_mahasiswa WHERE nim = '$nim'";
    $result = $conn->query($check_nim);

    if ($result->num_rows > 0) {
        echo "<script>alert('NIM sudah ada!'); window.location.href='tambah.php';</script>";
    } else {
        // Query untuk menambah data mahasiswa
        $sql = "INSERT INTO tbl_mahasiswa (nim, nama_mahasiswa, alamat_mahasiswa, jurusan) VALUES ('$nim', '$nama_mahasiswa', '$alamat_mahasiswa', '$jurusan')";
        
        if ($conn->query($sql) === TRUE) {
            header("Location: index.php"); // Ganti kembali ke data_mahasiswa.php
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Tutup koneksi
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">Tambah Mahasiswa</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" class="form-control" name="nim" required>
        </div>
        <div class="form-group">
            <label for="nama_mahasiswa">Nama Mahasiswa:</label>
            <input type="text" class="form-control" name="nama_mahasiswa" required>
        </div>
        <div class="form-group">
            <label for="alamat_mahasiswa">Alamat Mahasiswa:</label>
            <input type="text" class="form-control" name="alamat_mahasiswa" required>
        </div>
        <div class="form-group">
            <label for="jurusan">Jurusan:</label>
            <input type="text" class="form-control" name="jurusan" required>
        </div>
        <button type="submit" class="btn btn-success">Tambah</button>
    </form>
    <button onclick="window.location.href='index.php'" class="btn btn-primary mt-3">Kembali</button>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
