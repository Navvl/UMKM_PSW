<?php
session_start();
?>
<!doctype html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Banana Go</title>
    <link rel="icon" type="image/jpeg" href="assets/img/icon.png">
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="assets/css/home.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
    <?php include 'components/navbar.php'; ?>
<body class="home-page"></body>
    <section class="hero-section">
        <div class="hero-bg-text">BANANAGO</div>

        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center min-vh-80">
                
                <div class="col-lg-5 hero-text-content">
                    <div class="stagger-wrapper">
                        <div class="stagger-line"><span>HEY,</span></div>
                        <div class="stagger-line"><span>BANANA GO</span></div>
                        <div class="stagger-line"><span>RIGHT</span></div>
                        <div class="stagger-line"><span>HERE!</span></div>
                    </div>

                </div>

                <div class="col-lg-7">
                    <div class="product-title-wrapper text-center mb-3">
                        <h3 id="activeProductTitle" class="active-product-title">Cheese</h3>
                    </div>

                    <div class="modern-stack-container" id="productPreviewStack">
                        <div class="floating-card" data-index="0"><img src="assets/img/home/cheese.webp"></div>
                        <div class="floating-card" data-index="1"><img src="assets/img/home/white_glaze.webp"></div>
                        <div class="floating-card" data-index="2"><img src="assets/img/home/matcha.webp"></div>
                        <div class="floating-card" data-index="3"><img src="assets/img/home/chocolate.webp"></div>
                        <div class="floating-card" data-index="4"><img src="assets/img/home/mix.webp"></div>

                        <div class="stack-pagination">
                            <button class="btn-page active" data-index="0">1</button>
                            <button class="btn-page" data-index="1">2</button>
                            <button class="btn-page" data-index="2">3</button>
                            <button class="btn-page" data-index="3">4</button>
                            <button class="btn-page" data-index="4">5</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="hero-wave">
            <svg class="waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
            viewBox="0 24 150 28" preserveAspectRatio="none" shape-rendering="auto">
                <defs>
                    <path id="gentle-wave" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z" />
                </defs>
                <g class="parallax">
                    <use xlink:href="#gentle-wave" x="48" y="0" fill="rgba(255,255,255,0.7)" />
                    <use xlink:href="#gentle-wave" x="48" y="3" fill="rgba(255,255,255,0.5)" />
                    <use xlink:href="#gentle-wave" x="48" y="7" fill="#fff" />
                </g>
            </svg>
        </div>
    </section>

    <section id="about-banana" class="about-section-premium py-5">
        <div class="container my-4">
            <div class="row align-items-center justify-content-between g-5">
                
                <div class="col-lg-5">
                    <div class="about-img-box">
                        <img src="assets/img/home/about-piscok.webp" alt="Banana Go Quality">
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="about-content">
                        <h4 class="about-subtitle">About Us</h4>
                        <h2 class="brand-heading-premium">More Than Just<br>a <span class="about-highlight-clean">Banana</span></h2>
                        
                        <p class="brand-description-premium">
                            Di Banana Go, kami percaya bahwa jajanan bukan sekadar pengganjal perut ini adalah sebuah pengalaman. Setiap gigitan yang kami sajikan adalah perpaduan dari semangat, kualitas bahan premium, dan kesempurnaan rasa jalanan.
                        </p>

                        <ul class="about-feature-list list-unstyled">
                            <li>
                                <i class="bi bi-check-circle-fill"></i>
                                <span>Pisang Manis Pilihan (Sustainably Sourced)</span>
                            </li>
                            <li>
                                <i class="bi bi-star-fill"></i>
                                <span>Cokelat Lumer Premium (Ethically Traded)</span>
                            </li>
                            <li>
                                <i class="bi bi-fire"></i>
                                <span>Digoreng Dadakan (Freshly Made)</span>
                            </li>
                            <li>
                                <i class="bi bi-award-fill"></i>
                                <span>Kualitas Terjamin (Quality Crafted)</span>
                            </li>
                        </ul>

                        <div class="mt-4 pt-2">
                            <a href="produk.php" class="btn-about-order">Order Now <i class="bi bi-arrow-right ms-2"></i></a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- TESTIMONIAL SECTION -->
    <section id="testimonials" class="testimonials-section-wavy">
        
        <!-- Gelombang Atas -->
        <div class="wave-divider wave-top">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#FFFFFF" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,0L1392,0C1344,0,1248,0,1152,0C1056,0,960,0,864,0C768,0,672,0,576,0C480,0,384,0,288,0C192,0,96,0,48,0L0,0Z"></path>
            </svg>
        </div>

        <div class="container testi-container-wavy position-relative z-2">
            
            <div class="text-center mb-5 pb-3">
                <h4 class="about-subtitle text-secondary-brand">Testimonials</h4>
                <h2 class="brand-heading-premium">What Our <span class="highlight-white-clean">Customers</span> Say</h2>
            </div>

            <div class="text-center mb-5 pb-3">
                <div class="trusted-badge mx-auto mb-3">
                    <div class="stars-gold me-2">
                        <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                    </div>
                    <span class="fw-bold text-dark">5.0 Rating • 100+ Happy Customers</span>
                </div>
            </div>

            <!-- Testimonial Cards -->
            <div class="row g-4 justify-content-center">
                
                <!-- Card 1 -->
                <div class="col-lg-4 col-md-6">
                    <div class="testi-card-modern">
                        <div class="quote-icon"><i class="bi bi-quote"></i></div>
                        <div class="stars-gold mb-3">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testi-text">"Cokelatnya beneran lumer parah dan kulitnya tetep renyah walau udah dibawa pulang. Gak ada obat! Bakal jadi langganan tetap sih ini."</p>
                        
                        <div class="testi-user-profile mt-4 pt-3 border-top">
                            <img src="assets/img/home/pp1.webp" alt="Kyle Lukeman" class="user-avatar">
                            <div class="user-info">
                                <h5 class="user-name">Kyle Lukeman</h5>
                                <span class="user-role">Verified Buyer</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-lg-4 col-md-6">
                    <div class="testi-card-modern">
                        <div class="quote-icon"><i class="bi bi-quote"></i></div>
                        <div class="stars-gold mb-3">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testi-text">"Varian Matcha-nya juara sih. Gak terlalu manis tapi berasa banget premiumnya. Anak-anak di rumah pada rebutan pas dibawain pulang!"</p>
                        
                        <div class="testi-user-profile mt-4 pt-3 border-top">
                            <img src="assets/img/home/pp2.webp" alt="Budi Santoso" class="user-avatar">
                            <div class="user-info">
                                <h5 class="user-name">Budi Santoso</h5>
                                <span class="user-role">Verified Buyer</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-lg-4 col-md-6">
                    <div class="testi-card-modern">
                        <div class="quote-icon"><i class="bi bi-quote"></i></div>
                        <div class="stars-gold mb-3">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testi-text">"Pelayanannya cepet dan packingnya aman banget. Padahal ordernya banyak buat acara kantor. Sukses terus Banana Go!"</p>
                        
                        <div class="testi-user-profile mt-4 pt-3 border-top">
                            <img src="assets/img/home/pp3.webp" alt="Reja Novakovic" class="user-avatar">
                            <div class="user-info">
                                <h5 class="user-name">Reja Novakovic</h5>
                                <span class="user-role">Corporate Client</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Gelombang Bawah -->
        <div class="wave-divider wave-bottom">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#FAFAFA" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- WHY BANANA GO? -->
    <section id="why-banana" class="why-section-clean py-4">
        <div class="container">
            <div class="text-center mb-4">
                <h4 class="about-subtitle">The Experience</h4>
                <h2 class="brand-heading-premium">Why <span class="about-highlight-clean">Banana Go?</span></h2>
            </div>

            <!-- Block 1 -->
            <div class="row align-items-center mb-4 why-row justify-content-center gap-lg-4">
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="why-img-wrapper">
                        <img src="assets/img/home/model2.webp" alt="Enjoying Cheese Variant">
                    </div>
                </div>
                <div class="col-lg-5">
                    <h4 class="why-title fw-bold mb-2">Teman Nongkrong Paling Pas</h4>
                    <p class="brand-description-premium text-muted mb-0" style="font-size: 0.95rem;">
                        Keju parut melimpah yang gurih ketemu pisang manis hangat. Kombinasi klasik yang gak pernah salah buat dijadiin temen ngopi lu di sore hari. Dijamin nagih dari gigitan pertama.
                    </p>
                </div>
            </div>

            <!-- Block 2 -->
            <div class="row align-items-center why-row flex-lg-row-reverse justify-content-center gap-lg-4">
                <div class="col-lg-4 mb-3 mb-lg-0">
                    <div class="why-img-wrapper">
                        <img src="assets/img/home/model1.webp" alt="Enjoying Matcha Variant">
                    </div>
                </div>
                <div class="col-lg-5 text-lg-end">
                    <h4 class="why-title fw-bold mb-2">Mood Booster Instan</h4>
                    <p class="brand-description-premium text-muted mb-0" style="font-size: 0.95rem;">
                        Tekstur kulit yang super renyah berpadu dengan lumeran saus matcha premium. Gak kemanisan, gak bikin eneg. Didesain khusus buat nemenin me-time atau nugas lu biar makin produktif.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <?php include 'components/footer.php'; ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>
