<?php
class koneksi
{
    public function get_koneksi()
    {
        $conn=mysqli_connect("localhost","root","","db_pelatihan"); // masukan nama database yang sudah dibuat
        if(mysqli_connect_errno()){
            echo "Koneksi database gagal : " . mysqli_connect_error();
           }
           return $conn;
    }
}

$konek=new koneksi();
$koneksi=$konek->get_koneksi();
?>