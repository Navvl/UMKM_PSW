```php
<?php
session_start();
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Banana Go</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Your CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/home.css">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

<?php include "components/navbar.php"; ?>

<!-- HERO ABOUT -->
<section class="hero-section">
    <div class="hero-bg-text">ABOUT</div>

    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center min-vh-80">

            <!-- LEFT TEXT -->
            <div class="col-lg-6 hero-text-content">
                <div class="stagger-wrapper">
                    <div class="stagger-line"><span>WHO WE</span></div>
                    <div class="stagger-line"><span>ARE ?</span></div>
                </div>

                <p class="mt-4" style="color: var(--text-secondary); font-weight:500; ">
                    Banana Go hadir untuk menghadirkan pengalaman baru dalam menikmati
                    <strong>pisang cokelat kekinian</strong>. Kami menggabungkan bahan
                    berkualitas, inovasi rasa, dan pelayanan cepat untuk menciptakan
                    street food yang tidak hanya enak, tapi juga memorable.
                </p>

                <a href="index.php" class="btn-piscok-lg mt-3">Back to Home</a>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="col-lg-6 text-center">
                <div style="
                    background: white;
                    border-radius: 25px;
                    padding: 10px;
                    display: inline-block;
                    box-shadow: 0 15px 35px rgba(0,0,0,0.15);
                ">
                    <img src="assets/img/home/model3.webp"
                         style="width:300px; border-radius:20px;">
                </div>
            </div>

        </div>
    </div>

    <!-- WAVE -->
    <div class="hero-wave">
        <svg class="waves" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 24 150 28" preserveAspectRatio="none">
            <defs>
                <path id="wave" d="M-160 44c30 0 58-18 88-18s58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"/>
            </defs>
            <g class="parallax">
                <use href="#wave" x="48" y="0" fill="rgba(255,255,255,0.7)"/>
                <use href="#wave" x="48" y="3" fill="rgba(255,255,255,0.5)"/>
                <use href="#wave" x="48" y="7" fill="#fff"/>
            </g>
        </svg>
    </div>
</section>

<!-- OUR HISTORY -->
<section class="about-section">
    <div class="container text-center">
        <h2 class="brand-heading">Our History</h2>

        <p class="brand-description" style="text-align: justify;">
            Banana Go lahir dari kecintaan terhadap jajanan tradisional Indonesia,
            khususnya pisang cokelat yang telah lama menjadi camilan favorit masyarakat.
            Berawal dari sebuah ide sederhana untuk menghadirkan camilan yang akrab di
            lidah masyarakat dengan tampilan dan cita rasa yang lebih modern, Banana Go
            mulai dikembangkan sebagai brand yang mengutamakan kualitas, kreativitas,
            dan kepuasan pelanggan.
        </p>

        <p class="brand-description mt-3" style="text-align: justify;">
            Perjalanan Banana Go dimulai di Batam dengan visi untuk menghadirkan
            street food yang tidak hanya lezat, tetapi juga mampu memberikan pengalaman
            yang menyenangkan bagi setiap pelanggan. Berbagai percobaan resep,
            pemilihan bahan baku terbaik, hingga pengembangan varian topping dilakukan
            untuk menciptakan produk yang memiliki karakter unik dan berbeda dari
            pisang cokelat pada umumnya.
        </p>

        <p class="brand-description mt-3" style="text-align: justify;">
            Seiring berjalannya waktu, Banana Go terus berkembang dengan menghadirkan
            inovasi rasa, peningkatan kualitas pelayanan, dan pengalaman pelanggan
            yang lebih baik. Nama Banana Go sendiri melambangkan semangat untuk terus
            bergerak maju, berinovasi, dan berkembang mengikuti kebutuhan masyarakat
            modern tanpa melupakan cita rasa khas yang menjadi identitas utama produk.
        </p>
    </div>
</section>

<!-- OUR STORY -->
<section class="about-section mt-5 pt-4">
    <div class="container text-center">
        <h2 class="brand-heading">Our Story</h2>

        <p class="brand-description" style="text-align: justify;">
            Berawal dari kecintaan terhadap jajanan tradisional,
            <span class="highlight">Banana Go</span> berkembang menjadi brand
            yang menghadirkan inovasi pisang cokelat dengan berbagai topping modern.
            Kami percaya bahwa makanan sederhana bisa menjadi luar biasa jika dibuat
            dengan passion dan kualitas terbaik.
        </p>

        <p class="brand-description mt-3" style="text-align: justify;">
            Dari Batam untuk semua pecinta street food Indonesia, kami terus berkembang
            dengan menghadirkan rasa baru, pelayanan terbaik, dan pengalaman yang
            menyenangkan di setiap gigitan.
        </p>
    </div>
</section>

<!-- VALUES -->
<section class="py-5" style="background:#fff;">
    <div class="container text-center">
        <h2 class="brand-heading">Our Values</h2>

        <div class="row mt-5">
            <div class="col-md-4">
                <i class="bi bi-star-fill" style="font-size:40px; color:var(--bg-primary);"></i>
                <h5 class="mt-3">Quality</h5>
                <p>Kami hanya menggunakan bahan terbaik untuk menjaga rasa premium.</p>
            </div>

            <div class="col-md-4">
                <i class="bi bi-lightning-fill" style="font-size:40px; color:var(--bg-primary);"></i>
                <h5 class="mt-3">Fast Service</h5>
                <p>Pelayanan cepat tanpa mengorbankan kualitas produk.</p>
            </div>

            <div class="col-md-4">
                <i class="bi bi-emoji-smile-fill" style="font-size:40px; color:var(--bg-primary);"></i>
                <h5 class="mt-3">Customer Happiness</h5>
                <p>Kepuasan pelanggan adalah prioritas utama kami.</p>
            </div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<?php include "components/footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>