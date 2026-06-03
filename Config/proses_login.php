<?php
session_start();
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

} else {

    header("Location: ../Login.php");
    exit;
}

$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

if (!$query) {
    die("Query error: " . mysqli_error($conn));
}

if (mysqli_num_rows($query) === 1) {

    $user = mysqli_fetch_assoc($query);

    if (password_verify($password, $user['password'])) {

        $_SESSION['login'] = true;
        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        $judul = "Berhasil!";
        $notifikasi = "Welcome " . $user['username'];
        $tipe = "success";
        $timer = 1500;
        $redirect = "../index.php";

    } else {

        $judul = "Gagal!";
        $notifikasi = "Password salah";
        $tipe = "error";
        $timer = 2000;
        $redirect = "../login.php";
    }

} else {

    $judul = "Gagal!";
    $notifikasi = "Username tidak ditemukan";
    $tipe = "error";
    $timer = 2000;
    $redirect = "../login.php";
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