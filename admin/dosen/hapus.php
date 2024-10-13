<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$host = "localhost"; // Ganti dengan host database jika diperlukan
$username = "root";  // Ganti dengan username database
$password = "";      // Ganti dengan password database
$dbname = "db_pelatihan"; // Ganti dengan nama database

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan id dosen yang akan dihapus
if (isset($_GET['id'])) {
    $kd_dosen = $_GET['id'];

    // Query untuk menghapus data dosen
    $hapus_sql = "DELETE FROM tbl_dosen WHERE kd_dosen = ?";
    $stmt = $conn->prepare($hapus_sql);
    $stmt->bind_param("s", $kd_dosen); // Asumsi kd_dosen adalah string

    if ($stmt->execute()) {
        // Redirect ke index.php setelah berhasil menghapus
        header("Location: index.php?message=Data%20dosen%20berhasil%20dihapus");
        exit();
    } else {
        echo "Error: " . $hapus_sql . "<br>" . $conn->error;
    }

    $stmt->close();
} else {
    echo "ID tidak ditemukan.";
}

$conn->close();
?>
