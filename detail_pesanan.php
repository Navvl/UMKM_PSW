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
    SELECT order_detail.*, products.nama_product, products.gambar, products.categories
    FROM order_detail
    JOIN products ON order_detail.id_product = products.id_product
    WHERE order_detail.id_order='$id_order'
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details | BananaGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/detail_pesanan.css">
</head>

<body class="detail-bg-clean">

<?php include "components/navbar.php"; ?>

<div class="container pb-5" style="padding-top: 140px;">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="Pesanan.php" class="text-dark fs-4 text-decoration-none" title="Back to Orders"><i class="bi bi-arrow-left"></i></a>
        <h3 class="fw-bold m-0 detail-main-title text-uppercase">Order Details <span class="text-muted">#<?= str_pad($id_order, 4, '0', STR_PAD_LEFT) ?></span></h3>
    </div>

    <div class="row g-4">
        
        <div class="col-lg-4">
            
            <div class="detail-card-modern mb-4">
                <h5 class="fw-bold mb-4 border-bottom pb-3">Order Information</h5>
                
                <div class="info-group">
                    <span class="info-label">Customer</span>
                    <span class="info-value"><i class="bi bi-person-fill text-muted me-1"></i> <?= $data['username'] ?></span>
                </div>
                
                <div class="info-group">
                    <span class="info-label">Date</span>
                    <span class="info-value"><i class="bi bi-calendar-event text-muted me-1"></i> <?= date('d M Y, H:i', strtotime($data['created_at'])) ?></span>
                </div>

                <div class="info-group">
                    <span class="info-label">Status</span>
                    <div>
                        <span class="order-status-badge status-<?= strtolower($data['status']) ?>">
                            <?= ucfirst($data['status']) ?>
                        </span>
                    </div>
                </div>

                <div class="info-group mb-0">
                    <span class="info-label">Order Notes</span>
                    <span class="info-value text-muted" style="font-size: 0.9rem;">
                        <?= empty($data['catatan']) ? '-' : $data['catatan'] ?>
                    </span>
                </div>
            </div>

            <?php if ($role == 'admin') { ?>
            <div class="detail-card-modern bg-admin-panel">
                <h5 class="fw-bold mb-3"><i class="bi bi-sliders"></i> Manage Order</h5>
                
                <form method="POST" class="d-flex flex-column gap-3">
                    <div>
                        <label class="info-label mb-2">Update Status</label>
                        <select name="status" class="form-select custom-select-admin" required>
                            <option value="pending" <?= $data['status'] == 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="dikonfirmasi" <?= $data['status'] == 'dikonfirmasi' ? 'selected' : '' ?>>Confirmed</option>
                            <option value="ditolak" <?= $data['status'] == 'ditolak' ? 'selected' : '' ?>>Rejected</option>
                        </select>
                    </div>

                    <button type="submit" name="update_status" class="btn-action-primary w-100">
                        Save Changes
                    </button>

                    <button type="submit" name="delete_order" class="btn-action-danger w-100" onclick="return confirm('Are you sure you want to delete this order?')">
                        Delete Order
                    </button>
                </form>
            </div>
            <?php } ?>

        </div>

        <div class="col-lg-8">
            <div class="detail-card-modern h-100">
                <h5 class="fw-bold mb-4 border-bottom pb-3">Items Ordered</h5>

                <div class="table-responsive">
                    <table class="table table-borderless align-middle item-table-minimal">
                        <thead>
                            <tr>
                                <th class="text-uppercase small text-muted">Product</th>
                                <th class="text-uppercase small text-muted text-center">Qty</th>
                                <th class="text-uppercase small text-muted text-end">Price</th>
                                <th class="text-uppercase small text-muted text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total = 0;
                            while ($d = mysqli_fetch_assoc($details)) {
                                $subtotal = $d['jumlah'] * $d['harga'];
                                $total += $subtotal;
                            ?>
                            <tr class="border-bottom">
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="item-img-wrapper">
                                            <img src="assets/img/<?= $d['gambar'] ?>" alt="<?= $d['nama_product'] ?>">
                                        </div>
                                        <div>
                                            <span class="category-badge-detail mb-1"><?= $d['categories'] ?? 'Unknown' ?></span>
                                            <div class="fw-bold text-dark"><?= $d['nama_product'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-light text-dark px-3 py-2 border rounded-pill"><?= $d['jumlah'] ?></span>
                                </td>
                                <td class="text-end text-muted">Rp <?= number_format($d['harga'], 0, ',', '.') ?></td>
                                <td class="text-end fw-bold text-dark">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-4 pt-3 border-top border-2">
                    <div class="text-end">
                        <span class="text-uppercase fw-bold text-muted small">Total Amount</span>
                        <h3 class="fw-bold m-0 detail-main-title mt-1">Rp <?= number_format($total, 0, ',', '.') ?></h3>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php include "components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>