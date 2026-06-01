<?php

include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama  = $_POST['nama'];
    $email = $_POST['email'];
    $pesan = $_POST['pesan'];

    $query = "INSERT INTO messages (nama, email, pesan)
              VALUES ('$nama', '$email', '$pesan')";

    $insert = mysqli_query($conn, $query);

    if ($insert) {

        echo "
        <script>
            alert('Pesan berhasil dikirim!');
            window.location.href='../contact.php';
        </script>
        ";

    } else {

        echo "
        <script>
            alert('Pesan gagal dikirim!');
            window.location.href='../contact.php';
        </script>
        ";
    }

} else {

    header("Location: ../contact.php");
    exit;
}

?>