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
    $kd_semester = $_POST['kd_semester']; // Ambil Kode Semester
    $semester = $_POST['semester']; // Ambil Nama Semester
    
    $insert_sql = "INSERT INTO tbl_semester (kd_semester, semester) VALUES (?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ss", $kd_semester, $semester);
    
    if ($stmt->execute()) {
        header("Location: index.php?message=Semester berhasil ditambahkan.");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Semester</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Tambah Semester</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="kd_semester" class="form-label">Kode Semester</label>
            <input type="text" class="form-control" id="kd_semester" name="kd_semester" required>
        </div>
        <div class="mb-3">
            <label for="semester" class="form-label">Nama Semester</label>
            <input type="text" class="form-control" id="semester" name="semester" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
