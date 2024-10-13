<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Koneksi ke database
$host = "localhost"; // Ganti dengan host database jika diperlukan
$username = "root";  // Ganti dengan username database
$password = "";      // Ganti dengan password database
$dbname = "db_pelatihan"; // Ganti dengan nama database

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$dosen_sql = "SELECT * FROM tbl_dosen";
$dosen_result = $conn->query($dosen_sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Dosen</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        table {
            border-collapse: collapse;
            /* Menghilangkan jarak antar border */
            width: 100%;
        }

        th,
        td {
            padding: 10px;
            /* Padding dalam sel */
            text-align: left;
            border: 1px solid #dee2e6;
            /* Menambahkan border pada sel */
        }

        th {
            background-color: #f2f2f2;
            /* Warna background untuk header */
        }

        .container {
            margin-top: 20px;
        }

        button {
            margin-top: 20px;
        }

        /* Hover effect untuk baris tabel */
        tr:hover {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mb-4">Data Dosen</h1>

        <!-- Menampilkan pesan jika ada -->
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success">
                <?= htmlspecialchars($_GET['message']) ?>
            </div>
        <?php endif; ?>

        <!-- Tombol Tambahkan Dosen -->
        <button type="button" class="btn btn-success mb-4" onclick="window.location.href='tambah.php'">Tambahkan Dosen</button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="text-align: center; vertical-align: middle;">Kode Dosen</th>
                    <th style="text-align: center; vertical-align: middle;">Nama Dosen</th>
                    <th style="text-align: center; vertical-align: middle;">Alamat Dosen</th>
                    <th style="text-align: center; vertical-align: middle;">Aksi</th> <!-- Kolom Aksi -->
                </tr>
            </thead>
            <tbody>
                <?php
                if ($dosen_result->num_rows > 0) {
                    // Menampilkan data dosen jika tersedia
                    while ($row = $dosen_result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['kd_dosen']}</td>
                                <td>{$row['nama_dosen']}</td>
                                <td>{$row['alamat_dosen']}</td>
                                <td>
                                    <a href='edit.php?id={$row['kd_dosen']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='hapus.php?id={$row['kd_dosen']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus data ini?\");'>Hapus</a>
                                </td>
                              </tr>";
                    }
                } else {
                    // Pesan jika tidak ada data dosen
                    echo "<tr>
                            <td colspan='4' style='text-align:center;'>Tidak ada data dosen yang tersedia.</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Tombol Kembali ke Index -->
        <button type="button" class="btn btn-primary" onclick="window.location.href='../../index.php'">Kembali ke Index</button>

    </div>

    <!-- Bootstrap JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>