<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}

// Logic untuk menghitung total item di keranjang (khusus user)
$cart_count = 0;
if(isset($_SESSION['role']) && $_SESSION['role'] == 'user' && isset($_SESSION['cart'])) {
    $cart_count = array_sum($_SESSION['cart']);
}
?>

<nav class="navbar navbar-bananago">
  <div class="container">
    
    <div class="nav-col-left">
      <button class="navbar-toggler border-0 p-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
        <div class="burger-icon">
          <span></span>
          <span></span>
          <span></span>
        </div>
      </button>
    </div>

    <div class="nav-col-center">
      <a class="navbar-brand m-0" href="index.php">
        <img src="assets/img/logo.jpg" alt="Banana_Go Logo" class="navbar-logo">
      </a>
    </div>

    <div class="nav-col-right d-flex align-items-center gap-3">

<?php if(isset($_SESSION['login']) && $_SESSION['login'] === true): ?>

    <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'user'): ?>
        <!-- ICON CART KHUSUS USER -->
        <a href="cart.php" class="nav-icon-btn position-relative" title="View Cart">
            <i class="bi bi-bag-fill"></i>
            <?php if($cart_count > 0): ?>
                <span class="cart-badge"><?= $cart_count ?></span>
            <?php endif; ?>
        </a>
    <?php endif; ?>

    <!-- REVISI: BUTTON PROFIL DIUBAH JADI ICON MURNI COY -->
    <a href="profil.php" class="nav-icon-btn" title="My Profile">
        <i class="bi bi-person-circle"></i>
    </a>

    <a href="logout.php" class="btn-nav-order">
        Logout
    </a>

<?php else: ?>

    <a href="register.php" class="btn-nav-order">
        Register
    </a>

    <a href="login.php" class="btn-nav-order">
        Login
    </a>

<?php endif; ?>

</div>

  </div>
</nav>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" style="background-color: var(--bg-primary); border-right: none;">
  <div class="offcanvas-header justify-content-end">
    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" style="filter: brightness(0) saturate(100%) invert(13%) sepia(43%) saturate(1048%) hue-rotate(331deg) brightness(91%) contrast(90%);"></button>
  </div>
  <div class="offcanvas-body">
    <ul class="nav flex-column align-items-center mt-5">
      <li class="nav-item mb-4"><a class="nav-link-menu" href="index.php">Home</a></li>
      <li class="nav-item mb-4"><a class="nav-link-menu" href="produk.php">Order Now</a></li>
      <li class="nav-item mb-4"><a class="nav-link-menu" href="Pesanan.php">Your Order</a></li>
      <li class="nav-item mb-4"><a class="nav-link-menu" href="#contact">Contact</a></li>
      <li class="nav-item mb-4"><a class="nav-link-menu" href="about_us.php">About Us</a></li>
    </ul>
  </div>
</div>