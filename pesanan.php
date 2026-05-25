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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders | BananaGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Panggil CSS Baru khusus Halaman Pesanan -->
    <link rel="stylesheet" href="assets/css/pesanan.css">
</head>

<body class="order-bg-clean">

<?php include "components/navbar.php"; ?>

<div class="container pb-5" style="padding-top: 140px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="profil.php" class="text-dark fs-4 text-decoration-none" title="Back to Profile"><i class="bi bi-arrow-left"></i></a>
        <h3 class="fw-bold m-0 order-main-title text-uppercase">
            <?= $role == 'admin' ? 'Customer Orders' : 'My Orders' ?>
            <i class="bi bi-card-list me-2"></i> 
        </h3>
    </div>

    <div class="order-card-modern">
        
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <h5 class="fw-bold m-0 text-muted">
                <?= $role == 'admin' ? 'All Order Data' : 'Order History' ?>
            </h5>
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                Total: <?= mysqli_num_rows($orders) ?> Orders
            </span>
        </div>

        <?php if(mysqli_num_rows($orders) > 0): ?>
        <div class="table-responsive">
            <table class="table table-borderless align-middle order-table-minimal">
                <thead>
                    <tr>
                        <th class="text-uppercase small">Order ID</th>
                        
                        <?php if ($role == 'admin') { ?>
                            <th class="text-uppercase small">Customer</th>
                        <?php } ?>
                        
                        <th class="text-uppercase small">Date</th>
                        <th class="text-uppercase small">Notes</th>
                        <th class="text-uppercase small text-center">Status</th>
                        <th class="text-uppercase small text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($orders)) {
                    ?>
                    <tr class="border-bottom">
                        
                        <!-- Order ID Format -->
                        <td class="fw-bold text-dark">
                            #<?= str_pad($row['id_order'], 4, '0', STR_PAD_LEFT) ?>
                        </td>

                        <?php if ($role == 'admin') { ?>
                            <td class="fw-semibold text-muted">
                                <i class="bi bi-person-fill me-1"></i> <?= $row['username'] ?>
                            </td>
                        <?php } ?>

                        <!-- Format Tanggal Rapi -->
                        <td class="text-muted small">
                            <i class="bi bi-clock me-1"></i> <?= date('d M Y, H:i', strtotime($row['created_at'])) ?>
                        </td>

                        <!-- Potong text catatan jika terlalu panjang biar tabel ga rusak -->
                        <td class="text-muted small">
                            <?= empty($row['catatan']) ? '-' : (strlen($row['catatan']) > 25 ? substr($row['catatan'], 0, 25).'...' : $row['catatan']) ?>
                        </td>

                        <!-- Status Badge -->
                        <td class="text-center">
                            <span class="status-badge-order status-<?= strtolower($row['status']) ?>">
                                <?= ucfirst($row['status']) ?>
                            </span>
                        </td>

                        <!-- Action Button -->
                        <td class="text-end">
                            <a href="detail_pesanan.php?id_order=<?= $row['id_order'] ?>" class="btn-view-detail">
                                View Details <i class="bi bi-arrow-right-short"></i>
                            </a>
                        </td>

                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        
        <!-- EMPTY STATE (JIKA BELUM ADA PESANAN) -->
        <div class="text-center py-5 my-4 text-muted">
            <div class="empty-state-icon mb-3">
                <i class="bi bi-receipt"></i>
            </div>
            <h5 class="fw-bold text-dark">No Orders Found</h5>
            <p>There are currently no orders in the system.</p>
            <?php if ($role == 'user') { ?>
                <a href="produk.php" class="btn-view-detail px-4 py-2 mt-2">Start Shopping</a>
            <?php } ?>
        </div>

        <?php endif; ?>

    </div>
</div>

<?php include "components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>