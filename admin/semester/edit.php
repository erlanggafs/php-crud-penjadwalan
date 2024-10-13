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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $kd_semester = $_POST['kd_semester']; // Ambil Kode Semester
    $semester = $_POST['semester']; // Ambil Nama Semester
    
    $update_sql = "UPDATE tbl_semester SET kd_semester = ?, semester = ? WHERE kd_semester = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("ssi", $kd_semester, $semester, $id);
    
    if ($stmt->execute()) {
        header("Location: index.php?message=Semester berhasil diubah.");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    $semester_sql = "SELECT * FROM tbl_semester WHERE kd_semester = ?";
    $stmt = $conn->prepare($semester_sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $semester_data = $result->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Semester</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="mt-4">Edit Semester</h1>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="kd_semester" class="form-label">Kode Semester</label>
            <input type="text" class="form-control" id="kd_semester" name="kd_semester" value="<?= htmlspecialchars($semester_data['kd_semester']) ?>" required>
        </div>
        <div class="mb-3">
            <label for="semester" class="form-label">Nama Semester</label>
            <input type="text" class="form-control" id="semester" name="semester" value="<?= htmlspecialchars($semester_data['semester']) ?>" required>
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
