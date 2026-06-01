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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile | BananaGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Menggunakan file CSS baru khusus profil -->
    <link rel="stylesheet" href="assets/css/profil.css">
</head>

<body class="profile-bg-clean">

<?php include "components/navbar.php"; ?>

<!-- Padding top 140px agar aman dari navbar fixed -->
<div class="container pb-5" style="padding-top: 140px;">

    <div class="d-flex align-items-center gap-3 mb-5">
        <h3 class="fw-bold m-0 profile-main-title text-uppercase">My Profile</h3>
    </div>

    <div class="row g-4">
        
        <!-- KOLOM KIRI: KARTU IDENTITAS USER -->
        <div class="col-lg-4">
            <div class="profile-card-modern text-center">
                <div class="profile-avatar mx-auto mb-3">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h4 class="fw-bold profile-username"><?= $data_user['username'] ?></h4>
                <span class="profile-role-badge <?= $data_user['role'] == 'admin' ? 'admin-badge' : 'user-badge' ?>">
                    <?= ucfirst($data_user['role']) ?>
                </span>
                
                <hr class="profile-divider my-4">
                
                <div class="profile-info-row text-start">
                    <span class="info-label">User ID</span>
                    <span class="info-value">#<?= str_pad($data_user['id_user'], 4, '0', STR_PAD_LEFT) ?></span>
                </div>
                <div class="profile-info-row text-start mt-3">
                    <span class="info-label">Account Status</span>
                    <span class="info-value text-success"><i class="bi bi-check-circle-fill me-1"></i> Active</span>
                </div>

                <div class="mt-4 pt-2">
                    <a href="logout.php" class="btn-logout-full w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> Log Out
                    </a>
                </div>
            </div>
        </div>

        <!-- KOLOM KANAN: KONTEN BERDASARKAN ROLE -->
        <div class="col-lg-8">
            
            <!-- KHUSUS USER: RIWAYAT PESANAN -->
            <?php if($data_user['role'] == 'user'): ?>
            <div class="profile-content-card">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-receipt"></i> Order History
                </h5>

                <?php if(mysqli_num_rows($orders) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle profile-table-minimal">
                        <thead>
                            <tr>
                                <th class="text-uppercase small">No</th>
                                <th class="text-uppercase small">Date</th>
                                <th class="text-uppercase small">Notes</th>
                                <th class="text-uppercase small text-center">Status</th>
                                <th class="text-uppercase small text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while($o = mysqli_fetch_assoc($orders)) {
                            ?>
                            <tr class="border-bottom">
                                <td class="fw-bold text-muted">#<?= $no++ ?></td>
                                <!-- Menampilkan format tanggal yang rapi -->
                                <td><?= date('d M Y, H:i', strtotime($o['created_at'])) ?></td>
                                <td class="text-muted small">
                                    <?= empty($o['catatan']) ? '-' : (strlen($o['catatan']) > 20 ? substr($o['catatan'], 0, 20).'...' : $o['catatan']) ?>
                                </td>
                                <td class="text-center">
                                    <span class="order-status-badge status-<?= strtolower($o['status']) ?>">
                                        <?= ucfirst($o['status']) ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <a href="detail_pesanan.php?id_order=<?= $o['id_order'] ?>" class="btn-detail-pill">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <div class="text-center py-5 text-muted">
                    <i class="bi bi-bag-x fs-1 d-block mb-3"></i>
                    <p>You haven't placed any orders yet.</p>
                    <a href="produk.php" class="btn-detail-pill mt-2">Start Shopping</a>
                </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            <!-- KHUSUS ADMIN: DASHBOARD QUICK LINKS -->
            <?php if($data_user['role'] == 'admin'): ?>
            <div class="profile-content-card">
                <h5 class="fw-bold mb-4 d-flex align-items-center gap-2">
                    <i class="bi bi-grid-1x2-fill"></i> Admin Dashboard
                </h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <a href="kelola_user.php" class="admin-quick-card">
                            <div class="icon-wrapper"><i class="bi bi-people-fill"></i></div>
                            <div class="text-wrapper">
                                <span class="title">Manage Users</span>
                                <span class="desc">View and edit user access</span>
                            </div>
                            <i class="bi bi-chevron-right ms-auto arrow-icon"></i>
                        </a>
                    </div>
                    
                    <div class="col-md-6">
                        <a href="produk.php" class="admin-quick-card">
                            <div class="icon-wrapper"><i class="bi bi-box-seam-fill"></i></div>
                            <div class="text-wrapper">
                                <span class="title">Manage Products</span>
                                <span class="desc">Add, edit, or delete menu</span>
                            </div>
                            <i class="bi bi-chevron-right ms-auto arrow-icon"></i>
                        </a>
                    </div>

                    <div class="col-md-12">
                        <div class="col-md-12">
    <a href="admin_messages.php" class="admin-quick-card">
        <div class="icon-wrapper">
            <i class="bi bi-envelope-fill"></i>
        </div>

        <div class="text-wrapper">
            <span class="title">Customer Messages</span>
            <span class="desc">View messages from contact form</span>
        </div>

        <i class="bi bi-chevron-right ms-auto arrow-icon"></i>
    </a>
</div>
                        <a href="Pesanan.php" class="admin-quick-card primary-action">
                            <div class="icon-wrapper"><i class="bi bi-clipboard2-check-fill"></i></div>
                            <div class="text-wrapper">
                                <span class="title">Incoming Orders</span>
                                <span class="desc">Process and manage customer transactions</span>
                            </div>
                            <i class="bi bi-chevron-right ms-auto arrow-icon"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php include "components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>