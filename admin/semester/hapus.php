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

$id = $_GET['id'];

// Pastikan $id adalah tipe data yang benar (misalnya, string jika kd_semester adalah VARCHAR)
$delete_sql = "DELETE FROM tbl_semester WHERE kd_semester = ?";
$stmt = $conn->prepare($delete_sql);
$stmt->bind_param("s", $id); // Ganti "i" menjadi "s" jika kd_semester adalah string

if ($stmt->execute()) {
    header("Location: index.php?message=Semester berhasil dihapus.");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$conn->close();
?>
