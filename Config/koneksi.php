<?php
$conn = mysqli_connect("localhost", "root", "", "banana_go");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>