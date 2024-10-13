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

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan kd_matkul dari URL
if (isset($_GET['kd_matkul'])) {
    $kd_matkul = $_GET['kd_matkul'];

    // Query untuk menghapus data mata kuliah
    $delete_sql = "DELETE FROM tbl_matkul WHERE kd_matkul = '$kd_matkul'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<script>
            alert('Data mata kuliah berhasil dihapus.');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Data tidak ditemukan!";
}

$conn->close();
?>
