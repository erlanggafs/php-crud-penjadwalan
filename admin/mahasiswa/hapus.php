<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$host = "localhost";
$username = "root";
$password = "";
$dbname = "db_pelatihan";

$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . htmlspecialchars($conn->connect_error));
}

if (isset($_GET['nim'])) {
    $nim = (int)$_GET['nim']; // Menggunakan NIM dari URL dan casting ke int

    // Query untuk menghapus data mahasiswa dengan prepared statement
    $stmt = $conn->prepare("DELETE FROM tbl_mahasiswa WHERE nim = ?");
    $stmt->bind_param("i", $nim); // Mengikat parameter sebagai integer

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . htmlspecialchars($stmt->error);
    }

    $stmt->close(); // Menutup statement
} else {
    header("Location: index.php");
    exit();
}

$conn->close();
?>
