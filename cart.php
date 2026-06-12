<?php
session_start();
include "config/koneksi.php";

$is_login = isset($_SESSION['login']) && $_SESSION['login'] === true;
$id_user = $is_login ? $_SESSION['id_user'] : null;
$role = $is_login ? $_SESSION['role'] : 'guest';

if ($role !== 'user') {
    header("Location: produk.php");
    exit;
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

/* BLOK AJAX DIRECT UPDATE QUANTITY TANPA RELOAD */
if (isset($_POST['ajax_update_cart'])) {
    header('Content-Type: application/json');
    $id_product = $_POST['id_product'] ?? null;
    $jumlah_baru = (int)$_POST['jumlah_update'];

    if ($jumlah_baru > 0) {
        $q_stok = mysqli_query($conn, "SELECT stok FROM products WHERE id_product='$id_product'");
        $p_data = mysqli_fetch_assoc($q_stok);
        if ($jumlah_baru > $p_data['stok']) { $jumlah_baru = $p_data['stok']; }
        $_SESSION['cart'][$id_product] = $jumlah_baru;
    } else {
        unset($_SESSION['cart'][$id_product]);
    }

    $grand_total = 0;
    $current_subtotal = 0;
    if (!empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $id => $qty) {
            $q_calc = mysqli_query($conn, "SELECT harga FROM products WHERE id_product='$id'");
            $item_calc = mysqli_fetch_assoc($q_calc);
            $sub = $item_calc['harga'] * $qty;
            $grand_total += $sub;
            if ($id == $id_product) { $current_subtotal = $sub; }
        }
    }

    echo json_encode([
        'success' => true,
        'new_qty' => $jumlah_baru,
        'subtotal' => 'Rp ' . number_format($current_subtotal, 0, ',', '.'),
        'grand_total' => 'Rp ' . number_format($grand_total, 0, ',', '.'),
        'cart_empty' => empty($_SESSION['cart'])
    ]);
    exit;
}

/* USER HAPUS ITEM */
if (isset($_GET['hapus_cart'])) {
    $id_product = $_GET['hapus_cart'];
    unset($_SESSION['cart'][$id_product]);
    header("Location: cart.php");
    exit;
}

/* USER CHECKOUT PROCESS */
if (isset($_POST['checkout'])) {
    $catatan = mysqli_real_escape_string($conn, $_POST['catatan']);
    if (!empty($_SESSION['cart'])) {
        mysqli_query($conn, "INSERT INTO orders(id_user, catatan, status, stock_dikurangi) VALUES('$id_user', '$catatan', 'pending', 'belum')");
        $id_order = mysqli_insert_id($conn);

        foreach ($_SESSION['cart'] as $id_product => $jumlah) {
            $product = mysqli_query($conn, "SELECT harga FROM products WHERE id_product='$id_product'");
            $p = mysqli_fetch_assoc($product);
            mysqli_query($conn, "INSERT INTO order_detail(id_order, id_product, jumlah, harga) VALUES('$id_order', '$id_product', '$jumlah', '{$p['harga']}')");
        }
        $_SESSION['cart'] = [];
    }
    header("Location: Pesanan.php");
    exit;
}
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
    <link rel="stylesheet" href="assets/css/cart.css">
</head>
<body class="shop-bg-clean">

<?php include "components/navbar.php"; ?>

<div class="container pb-5" style="padding-top: 140px;">
    <div class="row">
        <div class="col-lg-9 mx-auto">
            
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="produk.php" class="text-dark fs-4 text-decoration-none" title="Back to Shop"><i class="bi bi-arrow-left"></i></a>
                <h3 class="fw-bold m-0 shop-main-title text-uppercase">Shopping Cart</h3>
            </div>

            <div class="cart-wrapper-card">
                <div class="table-responsive mb-2">
                    <table class="table table-borderless align-middle cart-table-minimal">
                        <thead>
                            <tr>
                                <th class="fw-bold small text-uppercase">Product</th>
                                <th class="fw-bold small text-center text-uppercase">Qty</th>
                                <th class="fw-bold small text-end text-uppercase">Price</th>
                                <th class="fw-bold small text-end text-uppercase">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-table-body">
                            <?php
                            $total = 0;
                            if (!empty($_SESSION['cart'])) {
                                foreach ($_SESSION['cart'] as $id_product => $jumlah) {
                                    $q = mysqli_query($conn, "SELECT * FROM products WHERE id_product='$id_product'");
                                    $item = mysqli_fetch_assoc($q);
                                    if ($jumlah > $item['stok']) { $jumlah = $item['stok']; $_SESSION['cart'][$id_product] = $jumlah; }
                                    $subtotal = $item['harga'] * $jumlah;
                                    $total += $subtotal;
                            ?>
                            <tr class="cart-row border-bottom" id="row-<?= $id_product ?>">
                                <td>
                                    <span class="category-badge-cart mb-1"><?= $item['categories'] ?></span>
                                    <div class="fw-bold text-dark fs-6 mt-1"><?= $item['nama_product'] ?></div>
                                </td>
                                <td class="text-center align-middle">
                                    <div class="qty-control-cart mx-auto">
                                        <button type="button" class="qty-btn-cart" onclick="changeCartQty('<?= $id_product ?>', -1)">-</button>
                                        <input type="number" id="cart-qty-<?= $id_product ?>" value="<?= $jumlah ?>" min="1" max="<?= $item['stok'] ?>" class="qty-input-cart" onchange="changeCartQty('<?= $id_product ?>', 0)">
                                        <button type="button" class="qty-btn-cart" onclick="changeCartQty('<?= $id_product ?>', 1)">+</button>
                                    </div>
                                </td>
                                <td class="text-end text-muted">Rp <?= number_format($item['harga'], 0, ',', '.') ?></td>
                                <td class="text-end fw-bold fs-6 text-dark" id="subtotal-<?= $id_product ?>">Rp <?= number_format($subtotal, 0, ',', '.') ?></td>
                                <td class="text-end">
                                    <a href="cart.php?hapus_cart=<?= $id_product ?>" class="cart-delete-icon" title="Remove"><i class="bi bi-x-circle-fill"></i></a>
                                </td>
                            </tr>
                            <?php } } else { ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Your cart is empty.</td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>

                <div id="checkout-area" style="<?= empty($_SESSION['cart']) ? 'display: none;' : '' ?>">
                    <div class="border-top pt-4 mt-2">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <span class="fw-bold text-uppercase text-muted">Total Amount</span>
                            <h3 class="fw-bold m-0 text-dark" id="cart-grand-total">Rp <?= number_format($total, 0, ',', '.') ?></h3>
                        </div>
                        <form method="POST" class="w-100">
                            <input type="text" name="catatan" class="form-control cart-note-input mb-4" placeholder="Order notes (optional)">
                            <button type="submit" name="checkout" class="btn-checkout-premium py-3 fs-6 text-uppercase">PROCEED TO CHECKOUT</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include "components/footer.php"; ?>

<script>
function changeCartQty(productId, direction) {
    const qtyInput = document.getElementById('cart-qty-' + productId);
    let currentVal = parseInt(qtyInput.value);
    
    if (direction === 1) { if(currentVal < parseInt(qtyInput.max)) currentVal++; } 
    else if (direction === -1) { if(currentVal > 1) currentVal--; }
    qtyInput.value = currentVal;

    const formData = new FormData();
    formData.append('ajax_update_cart', '1');
    formData.append('id_product', productId);
    formData.append('jumlah_update', currentVal);

    fetch('cart.php', { method: 'POST', body: formData })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            qtyInput.value = data.new_qty;
            document.getElementById('subtotal-' + productId).innerText = data.subtotal;
            document.getElementById('cart-grand-total').innerText = data.grand_total;
            
            if(data.new_qty === 0) {
                document.getElementById('row-' + productId).remove();
                if(data.cart_empty) {
                    document.getElementById('cart-table-body').innerHTML = '<tr><td colspan="5" class="text-center py-5 text-muted">Your cart is empty.</td></tr>';
                    document.getElementById('checkout-area').style.display = 'none';
                }
            }
        }
    }).catch(error => console.error('Fetch error:', error));
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>