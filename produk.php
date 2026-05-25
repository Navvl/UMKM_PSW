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
    mysqli_query($conn, "INSERT INTO products(nama_product, harga, gambar, stok) VALUES('$nama_product', '$harga', '$gambar', '$stok')");
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
        mysqli_query($conn, "UPDATE products SET nama_product='$nama_product', harga='$harga', stok='$stok', gambar='$gambar' WHERE id_product='$id_product'");
    } else {
        mysqli_query($conn, "UPDATE products SET nama_product='$nama_product', harga='$harga', stok='$stok' WHERE id_product='$id_product'");
    }
    header("Location: produk.php");
    exit;
}

/* ADMIN HAPUS PRODUK */
if (isset($_GET['hapus']) && $role == 'admin') {
    $id_product = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM products WHERE id_product='$id_product'");
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

$products = mysqli_query($conn, "SELECT * FROM products ORDER BY id_product DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop | BananaGo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/product.css">
</head>
<body class="shop-bg-clean">

<?php include "components/navbar.php"; ?>

<div class="container pb-5" style="padding-top: 100px;">
    
    <div class="d-flex justify-content-between align-items-center mb-5 mt-2">
        <h2 class="shop-main-title text-uppercase m-0">Our Menu</h2>
    </div>

    <?php if ($role == 'admin') { ?>
        <div class="admin-panel-clean mb-5">
            <h5 class="fw-bold mb-4 d-flex align-items-center gap-2"><i class="bi bi-box-seam"></i> Add New Product</h5>
            <form method="POST" enctype="multipart/form-data" class="row g-4 align-items-end">
                <div class="col-md-3">
                    <label class="form-label admin-label">Product Name</label>
                    <input type="text" name="nama_product" class="form-control admin-input" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label admin-label">Price (Rp)</label>
                    <input type="number" name="harga" class="form-control admin-input" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label admin-label">Stock</label>
                    <input type="number" name="stok" class="form-control admin-input" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label admin-label">Image</label>
                    <input type="file" name="gambar" class="form-control admin-input" required>
                </div>
                <div class="col-md-1">
                    <button type="submit" name="tambah_produk" class="btn-admin-submit w-100"><i class="bi bi-plus-lg"></i></button>
                </div>
            </form>
        </div>

        <?php
        if (isset($_GET['edit'])) {
            $id_product = $_GET['edit'];
            $edit = mysqli_query($conn, "SELECT * FROM products WHERE id_product='$id_product'");
            $data = mysqli_fetch_assoc($edit);
            if ($data) {
        ?>
        <div class="admin-panel-clean edit-mode mb-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="fw-bold m-0"><i class="bi bi-pencil-square"></i> Edit Product</h5>
                <a href="produk.php" class="btn-cancel-icon"><i class="bi bi-x-lg"></i></a>
            </div>
            <form method="POST" enctype="multipart/form-data" class="row g-4 align-items-end">
                <input type="hidden" name="id_product" value="<?= $data['id_product'] ?>">
                <div class="col-md-3">
                    <label class="form-label admin-label">Product Name</label>
                    <input type="text" name="nama_product" class="form-control admin-input" value="<?= $data['nama_product'] ?>" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label admin-label">Price (Rp)</label>
                    <input type="number" name="harga" class="form-control admin-input" value="<?= $data['harga'] ?>" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label admin-label">Stock</label>
                    <input type="number" name="stok" class="form-control admin-input" value="<?= $data['stok'] ?>" required>
                </div>
                <div class="col-md-3">
                    <input type="file" name="gambar" class="form-control admin-input">
                </div>
                <div class="col-md-1">
                    <button type="submit" name="update_produk" class="btn-admin-submit w-100"><i class="bi bi-check2"></i></button>
                </div>
            </form>
        </div>
        <?php } } ?>
    <?php } ?>

    <div class="row g-4">
        <?php while ($p = mysqli_fetch_assoc($products)) { ?>
        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
            <div class="product-card-modern">
                <div class="card-img-wrapper">
                    <img src="assets/img/<?= $p['gambar'] ?>" alt="<?= $p['nama_product'] ?>">
                    <?php if($p['stok'] <= 5 && $p['stok'] > 0) { echo '<span class="status-badge-clean warning">Low Stock</span>'; } ?>
                    <?php if($p['stok'] == 0) { echo '<span class="status-badge-clean danger">Sold Out</span>'; } ?>
                </div>
                <div class="card-body-content">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h3 class="product-name"><?= $p['nama_product'] ?></h3>
                        <span class="product-price">Rp <?= number_format($p['harga'], 0, ',', '.') ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="star-rating">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <span class="product-stock text-muted">Stock: <?= $p['stok'] ?></span>
                    </div>

                    <?php if ($role == 'user' && $p['stok'] > 0) { ?>
                    <form method="POST" class="d-flex align-items-center justify-content-between w-100 mt-auto pt-2 border-top">
                        <input type="hidden" name="id_product" value="<?= $p['id_product'] ?>">
                        <div class="qty-control-group">
                            <button type="button" class="qty-btn minus" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">-</button>
                            <input type="number" name="jumlah" value="1" min="1" max="<?= $p['stok'] ?>" class="qty-input-manual" required>
                            <button type="button" class="qty-btn plus" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">+</button>
                        </div>
                        <button type="submit" name="add_cart" class="btn-add-cart-icon"><i class="bi bi-cart-plus-fill"></i></button>
                    </form>
                    <?php } elseif ($role == 'user' && $p['stok'] == 0) { ?>
                        <div class="d-flex justify-content-between align-items-center w-100 mt-auto pt-2 border-top">
                            <span class="text-muted fw-bold small">SOLD OUT</span>
                            <button class="btn-add-cart-icon disabled" disabled><i class="bi bi-x-circle"></i></button>
                        </div>
                    <?php } ?>

                    <?php if ($role == 'admin') { ?>
                    <div class="admin-actions-icon mt-auto pt-3 border-top d-flex justify-content-end gap-2">
                        <a href="produk.php?edit=<?= $p['id_product'] ?>" class="admin-icon-btn edit-btn"><i class="bi bi-pencil-fill"></i></a>
                        <a href="produk.php?hapus=<?= $p['id_product'] ?>" class="admin-icon-btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?')"><i class="bi bi-trash3-fill"></i></a>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<?php include "components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>