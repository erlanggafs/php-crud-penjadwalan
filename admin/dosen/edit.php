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

if (isset($_GET['id'])) {
    $kd_dosen = $_GET['id'];
    
    // Mengambil data dosen dari database dengan prepared statement
    $stmt = $conn->prepare("SELECT * FROM tbl_dosen WHERE kd_dosen = ?");
    $stmt->bind_param("s", $kd_dosen);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    if (!$row) {
        die("Data tidak ditemukan");
    }
    $stmt->close(); // Tutup statement setelah selesai
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $kd_dosen = $_POST['kd_dosen'];
    $nama_dosen = $_POST['nama_dosen'];
    $alamat_dosen = $_POST['alamat_dosen'];

    // Memperbarui data dosen di database dengan prepared statement
    $stmt = $conn->prepare("UPDATE tbl_dosen SET nama_dosen = ?, alamat_dosen = ? WHERE kd_dosen = ?");
    $stmt->bind_param("sss", $nama_dosen, $alamat_dosen, $kd_dosen);
    
    if ($stmt->execute() === TRUE) {
        echo "<script>alert('Data dosen berhasil diperbarui'); window.location.href='index.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    
    $stmt->close(); // Tutup statement setelah selesai
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Dosen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1>Edit Dosen</h1>
        <form method="POST" action="">
            <input type="hidden" name="kd_dosen" value="<?php echo htmlspecialchars($row['kd_dosen']); ?>">
            <div class="mb-3">
                <label for="nama_dosen" class="form-label">Nama Dosen</label>
                <input type="text" class="form-control" id="nama_dosen" name="nama_dosen" value="<?php echo htmlspecialchars($row['nama_dosen']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="alamat_dosen" class="form-label">Alamat Dosen</label>
                <input type="text" class="form-control" id="alamat_dosen" name="alamat_dosen" value="<?php echo htmlspecialchars($row['alamat_dosen']); ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</body>

</html>
