<?php
session_start();
include "config/koneksi.php";

$is_login = isset($_SESSION['login']) && $_SESSION['login'] === true;

$id_user = $is_login ? $_SESSION['id_user'] : null;
$role = $is_login ? $_SESSION['role'] : 'guest';

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* ADMIN TAMBAH PRODUK */
if (isset($_POST['tambah_produk']) && $role == 'admin') {
    $nama_product = mysqli_real_escape_string($conn, $_POST['nama_product']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];

    move_uploaded_file($tmp, "assets/img/" . $gambar);

    mysqli_query($conn, "
        INSERT INTO products(nama_product, harga, gambar, stok)
        VALUES('$nama_product', '$harga', '$gambar', '$stok')
    ");

    header("Location: produk.php");
    exit;
}

/* ADMIN UPDATE PRODUK */
if (isset($_POST['update_produk']) && $role == 'admin') {
    $id_product = $_POST['id_product'];
    $nama_product = mysqli_real_escape_string($conn, $_POST['nama_product']);
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];

    if ($_FILES['gambar']['name'] != "") {
        $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];

        move_uploaded_file($tmp, "assets/img/" . $gambar);

        mysqli_query($conn, "
            UPDATE products SET
            nama_product='$nama_product',
            harga='$harga',
            stok='$stok',
            gambar='$gambar'
            WHERE id_product='$id_product'
        ");
    } else {
        mysqli_query($conn, "
            UPDATE products SET
            nama_product='$nama_product',
            harga='$harga',
            stok='$stok'
            WHERE id_product='$id_product'
        ");
    }

    header("Location: produk.php");
    exit;
}

/* ADMIN HAPUS PRODUK */
if (isset($_GET['hapus']) && $role == 'admin') {
    $id_product = $_GET['hapus'];

    mysqli_query($conn, "
        DELETE FROM products 
        WHERE id_product='$id_product'
    ");

    header("Location: produk.php");
    exit;
}

/* USER TAMBAH KE KERANJANG */
if (isset($_POST['add_cart']) && $role == 'user') {
    $id_product = $_POST['id_product'];
    $jumlah = $_POST['jumlah'];

    if (isset($_SESSION['cart'][$id_product])) {
        $_SESSION['cart'][$id_product] += $jumlah;
    } else {
        $_SESSION['cart'][$id_product] = $jumlah;
    }

    header("Location: produk.php");
    exit;
}

/* USER HAPUS ITEM KERANJANG */
if (isset($_GET['hapus_cart']) && $role == 'user') {
    $id_product = $_GET['hapus_cart'];
    unset($_SESSION['cart'][$id_product]);

    header("Location: produk.php");
    exit;
}

/* USER CHECKOUT */
if (isset($_POST['checkout']) && $role == 'user') {
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);

    if (!empty($_SESSION['cart'])) {
        mysqli_query($conn, "
            INSERT INTO orders(id_user, catatan, status, stock_dikurangi)
            VALUES('$id_user', '$catatan', 'pending', 'belum')
        ");

        $id_order = mysqli_insert_id($conn);

        foreach ($_SESSION['cart'] as $id_product => $jumlah) {
            $product = mysqli_query($conn, "
                SELECT * FROM products 
                WHERE id_product='$id_product'
            ");

            $p = mysqli_fetch_assoc($product);

            mysqli_query($conn, "
                INSERT INTO order_detail(id_order, id_product, jumlah, harga)
                VALUES('$id_order', '$id_product', '$jumlah', '{$p['harga']}')
            ");
        }

        $_SESSION['cart'] = [];
    }

    header("Location: Pesanan.php");
    exit;
}

$products = mysqli_query($conn, "
    SELECT * FROM products 
    ORDER BY id_product DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk BananaGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="order-page">

<?php include "components/navbar.php"; ?>

<div class="order-container">

    <h2 class="order-title">Produk BananaGo</h2>

    <?php if ($role == 'admin') { ?>
    <div class="order-card">
        <h3>Tambah Produk</h3>

        <form method="POST" enctype="multipart/form-data" class="order-form">
            <input type="text" name="nama_product" placeholder="Nama Produk" required>

            <input type="number" name="harga" placeholder="Harga" required>

            <input type="number" name="stok" placeholder="Stok" required>

            <input type="file" name="gambar" required>

            <button type="submit" name="tambah_produk" class="btn-order">
                Tambah Produk
            </button>
        </form>
    </div>
    <?php } ?>

    <div class="order-card">
        <h3>Daftar Produk</h3>

        <div class="product-grid">

            <?php while ($p = mysqli_fetch_assoc($products)) { ?>
            <div class="product-card">

                <img src="assets/img/<?= $p['gambar'] ?>" alt="<?= $p['nama_product'] ?>">

                <div class="product-card-content">

                    <h4><?= $p['nama_product'] ?></h4>

                    <p class="product-price">
                        Rp <?= number_format($p['harga'], 0, ',', '.') ?>
                    </p>

                    <p class="product-stock">
                        Stok: <?= $p['stok'] ?>
                    </p>

                    <?php if ($role == 'user') { ?>

                    <form method="POST" class="product-form">
                        <input type="hidden" name="id_product" value="<?= $p['id_product'] ?>">

                        <input type="number" name="jumlah" value="1" min="1" max="<?= $p['stok'] ?>" required>

                        <button type="submit" name="add_cart" class="btn-order">
                            Tambah ke Keranjang
                        </button>
                    </form>

                    <?php } elseif ($role == 'guest') { ?>



                    <?php } ?>

                    <?php if ($role == 'admin') { ?>
                    <div class="product-action">
                        <a href="produk.php?edit=<?= $p['id_product'] ?>" class="btn-order btn-edit">
                            Edit
                        </a>

                        <a href="produk.php?hapus=<?= $p['id_product'] ?>" 
                           class="btn-order btn-delete"
                           onclick="return confirm('Yakin ingin menghapus produk ini?')">
                            Hapus
                        </a>
                    </div>
                    <?php } ?>

                </div>

            </div>
            <?php } ?>

        </div>
    </div>

    <?php if ($role == 'user') { ?>
    <div class="cart-box">
        <h3>Keranjang Saya</h3>

        <table class="order-table">
            <tr>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>

            <?php
            $total = 0;

            if (!empty($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $id_product => $jumlah) {
                    $q = mysqli_query($conn, "
                        SELECT * FROM products 
                        WHERE id_product='$id_product'
                    ");

                    $item = mysqli_fetch_assoc($q);
                    $subtotal = $item['harga'] * $jumlah;
                    $total += $subtotal;
            ?>

            <tr>
                <td><?= $item['nama_product'] ?></td>
                <td><?= $jumlah ?></td>
                <td>Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                <td>
                    <a href="produk.php?hapus_cart=<?= $id_product ?>" class="btn-order btn-delete">
                        Hapus
                    </a>
                </td>
            </tr>

            <?php 
                }
            } else { 
            ?>

            <tr>
                <td colspan="5">Keranjang masih kosong</td>
            </tr>

            <?php } ?>

            <tr>
                <th colspan="3">Total</th>
                <th colspan="2">Rp <?= number_format($total, 0, ',', '.') ?></th>
            </tr>
        </table>

        <?php if (!empty($_SESSION['cart'])) { ?>
        <form method="POST" class="order-form">
            <textarea name="catatan" placeholder="Catatan pesanan"></textarea>

            <button type="submit" name="checkout" class="btn-order">
                Checkout
            </button>
        </form>
        <?php } ?>

    </div>
    <?php } ?>

    <?php
    if (isset($_GET['edit']) && $role == 'admin') {
        $id_product = $_GET['edit'];

        $edit = mysqli_query($conn, "
            SELECT * FROM products 
            WHERE id_product='$id_product'
        ");

        $data = mysqli_fetch_assoc($edit);

        if ($data) {
    ?>

    <div class="order-card">
        <h3>Edit Produk</h3>

        <form method="POST" enctype="multipart/form-data" class="order-form">

            <input type="hidden" name="id_product" value="<?= $data['id_product'] ?>">

            <input type="text" name="nama_product" value="<?= $data['nama_product'] ?>" required>

            <input type="number" name="harga" value="<?= $data['harga'] ?>" required>

            <input type="number" name="stok" value="<?= $data['stok'] ?>" required>

            <p>Gambar saat ini:</p>
            <img src="assets/img/<?= $data['gambar'] ?>" width="120">

            <br><br>

            <input type="file" name="gambar">

            <button type="submit" name="update_produk" class="btn-order btn-edit">
                Update Produk
            </button>

        </form>
    </div>

    <?php 
        }
    }
    ?>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>