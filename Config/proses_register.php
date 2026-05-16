<?php
session_start();
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../register.php");
    exit;
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$username = mysqli_real_escape_string($conn, $username);
$password = mysqli_real_escape_string($conn, $password);

/* CHECK USERNAME */
$cek = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");

if (!$cek) {
    die("Query Error: " . mysqli_error($conn));
}

if (mysqli_num_rows($cek) > 0) {

    $judul = "Gagal!";
    $notifikasi = "Username sudah digunakan";
    $tipe = "error";
    $timer = 2000;
    $redirect = "../register.php";

} else {

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = mysqli_query($conn, "
        INSERT INTO users(username, password, role)
        VALUES('$username', '$password_hash', 'user')
    ");

    if ($query) {

        $judul = "Berhasil!";
        $notifikasi = "Register berhasil 🎉";
        $tipe = "success";
        $timer = 1500;
        $redirect = "../login.php";

    } else {

        $judul = "Gagal!";
        $notifikasi = "Register gagal";
        $tipe = "error";
        $timer = 2000;
        $redirect = "../register.php";
    }
}
?>

<link rel="stylesheet" href="../sweetalert/sweetalert2.css">
<script src="../sweetalert/sweetalert2.all.js"></script>

<script>
setTimeout(function () {

    Swal.fire({
        title: '<?php echo $judul; ?>',
        text: '<?php echo $notifikasi; ?>',
        icon: '<?php echo $tipe; ?>',
        timer: <?php echo $timer; ?>,
        showConfirmButton: true,
        confirmButtonColor: '#4c2013'
    }).then(() => {
        window.location = '<?php echo $redirect; ?>';
    });

}, 10);
</script>