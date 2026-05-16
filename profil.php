<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$user = mysqli_query($conn, "
    SELECT id_user, username, role 
    FROM users 
    WHERE id_user='$id_user'
");

$data_user = mysqli_fetch_assoc($user);

/* DATA PESANAN USER */
$orders = mysqli_query($conn, "
    SELECT * FROM orders 
    WHERE id_user='$id_user'
    ORDER BY id_order DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya</title>

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="order-page">

<div class="order-container">

    <h2 class="order-title">Profil Saya</h2>

    <!-- DETAIL USER -->
    <div class="order-card">
        <h3>Detail User</h3>

        <table class="order-table">
            <tr>
                <th>ID User</th>
                <td><?= $data_user['id_user'] ?></td>
            </tr>

            <tr>
                <th>Username</th>
                <td><?= $data_user['username'] ?></td>
            </tr>

            <tr>
                <th>Role</th>
                <td><?= ucfirst($data_user['role']) ?></td>
            </tr>
        </table>
    </div>

    <!-- KHUSUS USER -->
    <?php if($data_user['role'] == 'user'): ?>

    <div class="order-card">
        <h3>Data Pemesanan Saya</h3>

        <table class="order-table">
            <tr>
                <th>No</th>
                <th>Status</th>
                <th>Catatan</th>
                <th>Tanggal</th>
                <th>Detail</th>
            </tr>

            <?php
            $no = 1;

            while($o = mysqli_fetch_assoc($orders)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>

                <td>
                    <span class="status-<?= $o['status'] ?>">
                        <?= $o['status'] ?>
                    </span>
                </td>

                <td><?= $o['catatan'] ?></td>

                <td><?= $o['created_at'] ?></td>

                <td>
                    <a href="detail_pesanan.php?id_order=<?= $o['id_order'] ?>" 
                       class="btn-order btn-detail">
                        Detail
                    </a>
                </td>
            </tr>
            <?php } ?>

        </table>
    </div>

    <?php endif; ?>

    <!-- KHUSUS ADMIN -->
    <?php if($data_user['role'] == 'admin'): ?>

    <div class="order-card">
        <h3>Menu Admin</h3>

        <a href="kelola_user.php" class="btn-order">
            Kelola User
        </a>

        <a href="produk.php" class="btn-order btn-edit">
            Kelola Produk
        </a>

        <a href="Pesanan.php" class="btn-order btn-detail">
            Data Pesanan
        </a>
    </div>

    <?php endif; ?>

    <a href="index.php" class="btn-order btn-detail">
        Kembali
    </a>

</div>

</body>
</html>