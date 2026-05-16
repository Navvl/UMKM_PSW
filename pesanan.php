<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$role = $_SESSION['role'];

/* ADMIN = LIHAT SEMUA PESANAN */
if ($role == 'admin') {

    $orders = mysqli_query($conn, "
        SELECT orders.*, users.username 
        FROM orders
        JOIN users ON orders.id_user = users.id_user
        ORDER BY orders.id_order DESC
    ");

} else {

    /* USER = LIHAT PESANAN SENDIRI */
    $orders = mysqli_query($conn, "
        SELECT * FROM orders
        WHERE id_user='$id_user'
        ORDER BY id_order DESC
    ");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan</title>

    <!-- BOOTSTRAP CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- STYLE CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="order-page">


<?php include "components/navbar.php"; ?>

<div class="order-container">

    <h2 class="order-title">
        <?= $role == 'admin' ? 'Data Pesanan Customer' : 'Pesanan Saya' ?>
    </h2>

    <div class="order-card">

        <h3>
            <?= $role == 'admin' ? 'Semua Data Pesanan' : 'Riwayat Pesanan' ?>
        </h3>

        <div style="overflow-x:auto;">

        <table class="order-table">

            <tr>

                <th>No</th>

                <?php if ($role == 'admin') { ?>
                    <th>Username</th>
                <?php } ?>

                <th>Status</th>
                <th>Catatan</th>
                <th>Tanggal</th>
                <th>Detail</th>

            </tr>

            <?php
            $no = 1;

            while ($row = mysqli_fetch_assoc($orders)) {
            ?>

            <tr>

                <td><?= $no++ ?></td>

                <?php if ($role == 'admin') { ?>
                    <td><?= $row['username'] ?></td>
                <?php } ?>

                <td>
                    <span class="status-<?= $row['status'] ?>">
                        <?= ucfirst($row['status']) ?>
                    </span>
                </td>

                <td><?= $row['catatan'] ?></td>

                <td><?= $row['created_at'] ?></td>

                <td>
                    <a href="detail_pesanan.php?id_order=<?= $row['id_order'] ?>" 
                       class="btn-order btn-detail">
                        Detail
                    </a>
                </td>

            </tr>

            <?php } ?>

        </table>

        </div>

    </div>

</div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>