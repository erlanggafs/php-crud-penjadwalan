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

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . htmlspecialchars($conn->connect_error));
}

if (isset($_GET['id'])) {
    $nim = (int)$_GET['id']; // Menggunakan NIM dari URL dan casting ke int
    
    // Ambil data mahasiswa untuk ditampilkan di form dengan prepared statement
    $stmt = $conn->prepare("SELECT * FROM tbl_mahasiswa WHERE nim = ?");
    $stmt->bind_param("i", $nim); // NIM adalah integer
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ambil data dari form
            $nim = (int)$_POST['nim']; // Pastikan nim tetap sebagai integer
            $nama_mahasiswa = $conn->real_escape_string($_POST['nama_mahasiswa']);
            $alamat_mahasiswa = $conn->real_escape_string($_POST['alamat_mahasiswa']);
            $jurusan = $conn->real_escape_string($_POST['jurusan']);

            // Query untuk memperbarui data mahasiswa dengan prepared statement
            $update_stmt = $conn->prepare("UPDATE tbl_mahasiswa SET nim=?, nama_mahasiswa=?, alamat_mahasiswa=?, jurusan=? WHERE nim=?");
            $update_stmt->bind_param("ssssi", $nim, $nama_mahasiswa, $alamat_mahasiswa, $jurusan, $row['nim']); // Menggunakan NIM yang asli sebagai identifikasi
            
            if ($update_stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                echo "Error: " . $update_stmt->error;
            }
            $update_stmt->close(); // Menutup statement
        }
    } else {
        echo "Data mahasiswa tidak ditemukan.";
        exit();
    }

    // Tutup statement
    $stmt->close();
} else {
    header("Location: index.php");
    exit();
}

// Tutup koneksi
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mahasiswa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Edit Mahasiswa</h1>
    <form method="POST" action="">
        <div class="form-group">
            <label for="nim">NIM:</label>
            <input type="text" class="form-control" name="nim" value="<?php echo htmlspecialchars($row['nim']); ?>" required>
        </div>

        <div class="form-group">
            <label for="nama_mahasiswa">Nama Mahasiswa:</label>
            <input type="text" class="form-control" name="nama_mahasiswa" value="<?php echo htmlspecialchars($row['nama_mahasiswa']); ?>" required>
        </div>

        <div class="form-group">
            <label for="alamat_mahasiswa">Alamat Mahasiswa:</label>
            <input type="text" class="form-control" name="alamat_mahasiswa" value="<?php echo htmlspecialchars($row['alamat_mahasiswa']); ?>" required>
        </div>

        <div class="form-group">
            <label for="jurusan">Jurusan:</label>
            <input type="text" class="form-control" name="jurusan" value="<?php echo htmlspecialchars($row['jurusan']); ?>" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
    <button onclick="window.location.href='index.php'" class="btn btn-primary mt-3">Kembali</button>
</body>
</html>
