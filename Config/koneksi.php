<?php
$conn = mysqli_connect("localhost", "root", "", "umkm_psw");

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>