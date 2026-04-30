<?php
// koneksi database
include 'koneksi.php';

// menangkap datayang di kirim dari form
$id = $_POST['id'];
$nis = $_POST['nis'];
$nama = $_POST['nama'];
$kelas = $_POST['kelas'];
$jurusan = $_POST['jurusan'];

// menginput data ke database 
mysqli_query($koneksi, "insert into data_siswa values('','$nis','$nama','$kelas','$jurusan')");

// mengalihkan halaman kembali ke index.php
header("location:order.php");

?>