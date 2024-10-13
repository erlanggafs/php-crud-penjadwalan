<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "db_pelatihan";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $kd_dosen = $_POST['kd_dosen'];
    $nama_dosen = $_POST['nama_dosen'];
    $alamat_dosen = $_POST['alamat_dosen'];

    // Menyimpan data ke database
    $sql = "INSERT INTO tbl_dosen (kd_dosen, nama_dosen, alamat_dosen) VALUES ('$kd_dosen', '$nama_dosen', '$alamat_dosen')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data dosen berhasil ditambahkan'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Tambah Dosen</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="kd_dosen" class="form-label">Kode Dosen</label>
                <input type="text" class="form-control" id="kd_dosen" name="kd_dosen" required>
            </div>
            <div class="mb-3">
                <label for="nama_dosen" class="form-label">Nama Dosen</label>
                <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" required>
            </div>
            <div class="mb-3">
                <label for="alamat_dosen" class="form-label">Alamat Dosen</label>
                <input type="text" class="form-control" id="alamat_dosen" name="alamat_dosen" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan</button>
            <a href="data_dosen.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>
