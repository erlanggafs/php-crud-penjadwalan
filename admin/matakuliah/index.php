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

$matkul_sql = "SELECT * FROM tbl_matkul";
$matkul_result = $conn->query($matkul_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mata Kuliah</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include SweetAlert CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h1 class="text-center mb-4">Data Mata Kuliah</h1>

    <!-- Tombol Tambah Mata Kuliah -->
    <div class="text-left mb-3">
        <button onclick="window.location.href='tambah.php'" class="btn btn-success">Tambah Mata Kuliah</button>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th class="text-center">ID Mata Kuliah</th>
                <th class="text-center">Nama Mata Kuliah</th>
                <th class="text-center">SKS</th>
                <th class="text-center">Aksi</th> <!-- Kolom Aksi -->
            </tr>
        </thead>
        <tbody>
            <?php if ($matkul_result->num_rows > 0) { ?>
                <?php while ($row = $matkul_result->fetch_assoc()) { ?>
                    <tr>
                        <td class="text-center"><?php echo $row['kd_matkul']; ?></td>
                        <td><?php echo $row['nama_matkul']; ?></td>
                        <td class="text-center"><?php echo $row['sks']; ?></td>
                        <td class="text-center">
                            <a href="edit.php?kd_matkul=<?php echo $row['kd_matkul']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm" onclick="confirmDelete('<?php echo $row['kd_matkul']; ?>')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data mata kuliah ditemukan.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Tombol Kembali ke Index -->
    <div class="text-left mt-3">
        <button onclick="window.location.href='../../index.php'" class="btn btn-primary">Kembali ke Index</button>
    </div>

    <!-- Include jQuery and Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Include SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(kd_matkul) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data mata kuliah akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "hapus.php?kd_matkul=" + kd_matkul;
                }
            });
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>
