<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    header("Location: profil.php");
    exit;
}

$id_user = $_SESSION['id_user'];

/* UPDATE ROLE LOGIC */
if (isset($_POST['update_role'])) {
    $id_user = $_POST['id_user'];
    $role_baru = $_POST['role'];

    mysqli_query($conn, "
        UPDATE users 
        SET role='$role_baru' 
        WHERE id_user='$id_user'
    ");

    header("Location: kelola_user.php");
    exit;
}

/* GET USERS */
$users = mysqli_query($conn, "
    SELECT id_user, username, role 
    FROM users 
    ORDER BY id_user DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banana Go</title>
    <link rel="icon" type="image/jpeg" href="assets/img/icon.png">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Panggil CSS khusus halaman kelola user -->
    <link rel="stylesheet" href="assets/css/kelola_user.css">
</head>

<body class="kelola-bg-clean">

<?php include "components/navbar.php"; ?>

<div class="container pb-5" style="padding-top: 140px;">

    <!-- HEADER -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="profil.php" class="text-dark fs-4 text-decoration-none" title="Back to Profile"><i class="bi bi-arrow-left"></i></a>
        <h3 class="fw-bold m-0 kelola-main-title text-uppercase">
            <i class="bi bi-people-fill me-2"></i> Manage Users
        </h3>
    </div>

    <!-- MAIN CARD -->
    <div class="kelola-card-modern">
        
        <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
            <h5 class="fw-bold m-0 text-muted">User Directory</h5>
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
                Total: <?= mysqli_num_rows($users) ?> Users
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-borderless align-middle kelola-table-minimal">
                <thead>
                    <tr>
                        <th class="text-uppercase small">User ID</th>
                        <th class="text-uppercase small">Username</th>
                        <th class="text-uppercase small text-center">Current Role</th>
                        <th class="text-uppercase small text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    while ($u = mysqli_fetch_assoc($users)) {
                    ?>
                    <tr class="border-bottom">
                        
                        <td class="fw-bold text-muted">
                            #<?= str_pad($u['id_user'], 4, '0', STR_PAD_LEFT) ?>
                        </td>
                        
                        <td class="fw-bold text-dark">
                            <i class="bi bi-person-circle text-muted me-2"></i><?= $u['username'] ?>
                        </td>
                        
                        <td class="text-center">
                            <span class="role-badge <?= $u['role'] == 'admin' ? 'badge-admin' : 'badge-user' ?>">
                                <?= ucfirst($u['role']) ?>
                            </span>
                        </td>
                        
                        <td class="text-end">
                            <form method="POST" class="d-flex align-items-center justify-content-end gap-2 m-0">
                                <input type="hidden" name="id_user" value="<?= $u['id_user'] ?>">

                                <select name="role" class="form-select kelola-select" required>
                                    <option value="user" <?= $u['role'] == 'user' ? 'selected' : '' ?>>User</option>
                                    <option value="admin" <?= $u['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                </select>


                                    <button type="submit" name="update_role" class="btn-kelola-update" title="Update Role">
                                        <i class="bi bi-check2"></i> Update
                                    </button>
                            </form>
                        </td>

                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include "components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>