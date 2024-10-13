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
    echo "<script>alert('Koneksi gagal: " . $conn->connect_error . "');</script>";
    exit();
}

$mahasiswa_sql = "SELECT * FROM tbl_mahasiswa";
$mahasiswa_result = $conn->query($mahasiswa_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
</head>

<body class="container mt-5">
    <h1 class="text-center">Data Mahasiswa</h1>

    <button onclick="window.location.href='tambah.php'" class="btn btn-success mb-3">Tambah Mahasiswa</button>

    <table class="table table-bordered table-striped">
        <thead class="thead-light">
            <tr>
                <th style="text-align: center;">NIM</th>
                <th style="text-align: center;">Nama</th>
                <th style="text-align: center;">Alamat</th>
                <th style="text-align: center;">Jurusan</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($mahasiswa_result->num_rows > 0) { ?>
                <?php while ($row = $mahasiswa_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nim']); ?></td>
                        <td><?php echo htmlspecialchars($row['nama_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($row['alamat_mahasiswa']); ?></td>
                        <td><?php echo htmlspecialchars($row['jurusan']); ?></td>
                        <td style="text-align: center;">
                            <a href="edit.php?id=<?php echo urlencode($row['nim']); ?>" class="btn btn-warning">Edit</a>
                            <a href="#" class="btn btn-danger" onclick="confirmDelete('<?php echo urlencode($row['nim']); ?>')">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data mahasiswa ditemukan.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <button onclick="window.location.href='../../index.php'" class="btn btn-primary">Kembali ke Index</button>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function confirmDelete(nim) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data mahasiswa akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "hapus.php?id=" + nim;
                }
            });
        }
    </script>
</body>

</html>

<?php
$conn->close();
?>
