<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$role = $_SESSION['role'];

if (!isset($_GET['id_order'])) {
    header("Location: Pesanan.php");
    exit;
}

$id_order = $_GET['id_order'];

/* ADMIN UPDATE STATUS */
if (isset($_POST['update_status']) && $role == 'admin') {
    $status = $_POST['status'];

    $cek_order = mysqli_query($conn, "
        SELECT * FROM orders 
        WHERE id_order='$id_order'
    ");

    $data_order = mysqli_fetch_assoc($cek_order);

    if ($status == 'dikonfirmasi' && $data_order['stock_dikurangi'] == 'belum') {

        $detail = mysqli_query($conn, "
            SELECT * FROM order_detail 
            WHERE id_order='$id_order'
        ");

        while ($d = mysqli_fetch_assoc($detail)) {
            mysqli_query($conn, "
                UPDATE products 
                SET stok = stok - {$d['jumlah']}
                WHERE id_product='{$d['id_product']}'
            ");
        }

        mysqli_query($conn, "
            UPDATE orders 
            SET status='dikonfirmasi',
                stock_dikurangi='sudah'
            WHERE id_order='$id_order'
        ");

    } else {

        mysqli_query($conn, "
            UPDATE orders 
            SET status='$status'
            WHERE id_order='$id_order'
        ");
    }

    header("Location: detail_pesanan.php?id_order=$id_order");
    exit;
}

/* ADMIN DELETE */
if (isset($_POST['delete_order']) && $role == 'admin') {
    mysqli_query($conn, "
        DELETE FROM orders 
        WHERE id_order='$id_order'
    ");

    header("Location: Pesanan.php");
    exit;
}

/* AMBIL DATA ORDER */
if ($role == 'admin') {
    $order = mysqli_query($conn, "
        SELECT orders.*, users.username 
        FROM orders
        JOIN users ON orders.id_user = users.id_user
        WHERE orders.id_order='$id_order'
    ");
} else {
    $order = mysqli_query($conn, "
        SELECT orders.*, users.username 
        FROM orders
        JOIN users ON orders.id_user = users.id_user
        WHERE orders.id_order='$id_order'
        AND orders.id_user='$id_user'
    ");
}

$data = mysqli_fetch_assoc($order);

if (!$data) {
    echo "Data pesanan tidak ditemukan.";
    exit;
}

$details = mysqli_query($conn, "
    SELECT order_detail.*, products.nama_product, products.gambar
    FROM order_detail
    JOIN products ON order_detail.id_product = products.id_product
    WHERE order_detail.id_order='$id_order'
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body class="order-page">

<?php include "components/navbar.php"; ?>

<div class="order-container">

    <h2 class="order-title">Detail Pesanan</h2>

    <div class="order-card">
        <h3>Informasi Pesanan</h3>

        <table class="order-table">
            <tr>
                <th>Username</th>
                <td><?= $data['username'] ?></td>
            </tr>

            <tr>
                <th>Status</th>
                <td>
                    <span class="status-<?= $data['status'] ?>">
                        <?= $data['status'] ?>
                    </span>
                </td>
            </tr>

            <tr>
                <th>Catatan</th>
                <td><?= $data['catatan'] ?></td>
            </tr>

            <tr>
                <th>Tanggal</th>
                <td><?= $data['created_at'] ?></td>
            </tr>
        </table>
    </div>

    <div class="order-card">
        <h3>Produk yang Dipesan</h3>

        <table class="order-table">
            <tr>
                <th>Gambar</th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>

            <?php
            $total = 0;
            while ($d = mysqli_fetch_assoc($details)) {
                $subtotal = $d['jumlah'] * $d['harga'];
                $total += $subtotal;
            ?>
            <tr>
                <td>
                    <img src="assets/img/<?= $d['gambar'] ?>" width="80">
                </td>
                <td><?= $d['nama_product'] ?></td>
                <td><?= $d['jumlah'] ?></td>
                <td>Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
            </tr>
            <?php } ?>

            <tr>
                <th colspan="4">Total</th>
                <th>Rp <?= number_format($total, 0, ',', '.') ?></th>
            </tr>
        </table>
    </div>

    <?php if ($role == 'admin') { ?>
    <div class="order-card">
        <h3>Kelola Pesanan</h3>

        <form method="POST" class="order-form">
            <select name="status" required>
                <option value="pending" <?= $data['status'] == 'pending' ? 'selected' : '' ?>>
                    Pending
                </option>

                <option value="dikonfirmasi" <?= $data['status'] == 'dikonfirmasi' ? 'selected' : '' ?>>
                    Dikonfirmasi
                </option>

                <option value="ditolak" <?= $data['status'] == 'ditolak' ? 'selected' : '' ?>>
                    Ditolak
                </option>
            </select>

            <button type="submit" name="update_status" class="btn-order btn-edit">
                Update Status
            </button>

            <button type="submit" name="delete_order" class="btn-order btn-delete"
                    onclick="return confirm('Yakin ingin menghapus pesanan ini?')">
                Delete Pesanan
            </button>
        </form>
    </div>
    <?php } ?>

    <a href="Pesanan.php" class="btn-order btn-detail">
        Kembali
    </a>

</div>

</body>
</html>