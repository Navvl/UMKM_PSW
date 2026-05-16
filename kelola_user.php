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

$users = mysqli_query($conn, "
    SELECT id_user, username, role 
    FROM users 
    ORDER BY id_user DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola User</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="order-page">

<div class="order-container">

    <h2 class="order-title">Kelola User</h2>

    <div class="order-card">
        <h3>Data User</h3>

        <table class="order-table">
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role Saat Ini</th>
                <th>Ubah Role</th>
            </tr>

            <?php
            $no = 1;
            while ($u = mysqli_fetch_assoc($users)) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $u['username'] ?></td>
                <td><?= $u['role'] ?></td>
                <td>
                    <form method="POST" class="order-form">
                        <input type="hidden" name="id_user" value="<?= $u['id_user'] ?>">

                        <select name="role" required>
                            <option value="user" <?= $u['role'] == 'user' ? 'selected' : '' ?>>
                                User
                            </option>
                            <option value="admin" <?= $u['role'] == 'admin' ? 'selected' : '' ?>>
                                Admin
                            </option>
                        </select>

                        <button type="submit" name="update_role" class="btn-order btn-edit">
                            Update
                        </button>
                    </form>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <a href="index.php" class="btn-order btn-detail">Kembali</a>

</div>

</body>
</html>