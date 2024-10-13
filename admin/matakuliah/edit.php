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

    // Mengambil data mata kuliah berdasarkan kd_matkul
    $matkul_sql = "SELECT * FROM tbl_matkul WHERE kd_matkul = ?";
    $stmt = $conn->prepare($matkul_sql);
    $stmt->bind_param("s", $kd_matkul);
    $stmt->execute();
    $matkul_result = $stmt->get_result();

    if ($matkul_result->num_rows > 0) {
        $row = $matkul_result->fetch_assoc();
        $nama_matkul = $row['nama_matkul'];
        $sks = $row['sks'];
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location.href = 'index.php';</script>";
        exit();
    }
    $stmt->close();
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_matkul = $_POST['nama_matkul'];
    $sks = $_POST['sks'];

    // Query untuk mengupdate data
    $update_sql = "UPDATE tbl_matkul SET nama_matkul = ?, sks = ? WHERE kd_matkul = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("sis", $nama_matkul, $sks, $kd_matkul);

    if ($stmt->execute()) {
        echo "<script>
            alert('Data mata kuliah berhasil diupdate.');
            window.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mata Kuliah</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1 class="text-center mb-4">Edit Mata Kuliah</h1>

    <!-- Menampilkan kd_matkul -->
    <div class="form-group">
        <label for="kd_matkul">ID Mata Kuliah</label>
        <input type="text" class="form-control" id="kd_matkul" value="<?php echo htmlspecialchars($kd_matkul); ?>" readonly>
    </div>

    <form method="POST" action="">
        <div class="form-group">
            <label for="nama_matkul">Nama Mata Kuliah</label>
            <input type="text" class="form-control" id="nama_matkul" name="nama_matkul" value="<?php echo htmlspecialchars($nama_matkul); ?>" required>
        </div>
        <div class="form-group">
            <label for="sks">SKS</label>
            <input type="number" class="form-control" id="sks" name="sks" value="<?php echo htmlspecialchars($sks); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn btn-secondary" onclick="window.location.href='index.php'">Kembali</button>
    </form>
</body>
</html>

<?php
$conn->close();
?>
