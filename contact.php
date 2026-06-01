<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - BananaGo</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"rel="stylesheet"/>

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/home.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>

      .contact-section {
    min-height: 100vh;
    background:
        radial-gradient(circle at top left, #ffe873 0%, transparent 32%),
        radial-gradient(circle at bottom right, #f7cb3d 0%, transparent 30%),
        #f8dc3d;
    padding: 120px 8% 80px;
    color: #4c2013;
    font-family: 'Poppins', sans-serif;
}

.contact-title {
    text-align: center;
    margin-bottom: 45px;
}

.contact-title span {
    display: inline-block;
    background: #4c2013;
    color: #f8dc3d;
    padding: 8px 20px;
    border-radius: 999px;
    font-weight: 900;
    font-size: 13px;
    letter-spacing: 2px;
    margin-bottom: 14px;
}

.contact-title h1 {
    font-size: 56px;
    font-weight: 900;
    margin-bottom: 10px;
}

.contact-title p {
    font-size: 17px;
    font-weight: 600;
}

.contact-wrapper {
    display: grid;
    grid-template-columns: 0.9fr 1.1fr;
    gap: 35px;
    max-width: 1250px;
    margin: 0 auto;
}

.contact-card,
.map-card {
    background: #fffaf0;
    border-radius: 28px;
    padding: 35px;
    box-shadow: 10px 10px 0 #4c2013;
}

.contact-card h2,
.map-title h2 {
    font-size: 30px;
    font-weight: 900;
    margin-bottom: 12px;
}

.info-desc,
.map-title p {
    font-weight: 600;
    line-height: 1.7;
    margin-bottom: 25px;
}

.info-list {
    display: grid;
    gap: 18px;
    margin-bottom: 30px;
}

.info-list div {
    background: white;
    border: 2px solid #4c2013;
    border-radius: 18px;
    padding: 14px 16px;
    font-weight: 800;
}

.wa-btn {
    display: inline-block;
    width: 100%;
    text-align: center;
    background: #25d366;
    color: white;
    text-decoration: none;
    padding: 15px;
    border-radius: 999px;
    font-weight: 900;
}

.form-card form {
    display: flex;
    flex-direction: column;
    gap: 18px;
}

.form-card input,
.form-card textarea {
    width: 100%;
    padding: 16px 18px;
    border: 3px solid #4c2013;
    border-radius: 18px;
    font-size: 15px;
    outline: none;
    font-family: 'Poppins', sans-serif;
}

.form-card textarea {
    height: 150px;
    resize: none;
}

.form-card button {
    background: #4c2013;
    color: #f8dc3d;
    border: none;
    padding: 16px;
    border-radius: 999px;
    font-weight: 900;
    cursor: pointer;
}

.map-card {
    max-width: 1250px;
    margin: 45px auto 0;
    padding: 25px;
}

.map-title {
    margin-bottom: 18px;
}

.map-card iframe {
    border-radius: 22px;
}

@media (max-width: 900px) {
    .contact-wrapper {
        grid-template-columns: 1fr;
    }

    .contact-title h1 {
        font-size: 40px;
    }
}

    </style>
</head>
<body>

    <?php include 'components/navbar.php'; ?>
   <section class="contact-section">
    <div class="contact-title">
        <span>GET IN TOUCH</span>
        <h1>CONTACT US</h1>
        <p>Hubungi kami untuk pemesanan, kerja sama, atau pertanyaan.</p>
    </div>

    <div class="contact-wrapper">

        <div class="contact-card info-card">
            <h2>Informasi detail</h2>
            <p class="info-desc">
                Pisang cokelat lumer favorit kamu. Kami siap melayani pesanan setiap hari.
            </p>

            <div class="info-list">
                <div>📍 <span>Batam, Indonesia</span></div>
                <div>📞 <span>0812-3456-7890</span></div>
                <div>✉️ <span>bananago@gmail.com</span></div>
                <div>⏰ <span>09.00 - 21.00</span></div>
            </div>

            <a href="kirimwa.id/bananago.batam" class="wa-btn">
                Chat WhatsApp
            </a>
        </div>

        <div class="contact-card form-card">
            <h2>Kirim Pesan</h2>

            <form>
                <input type="text" placeholder="Nama kamu">
                <input type="email" placeholder="Email kamu">
                <textarea placeholder="Tulis pesan kamu..."></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>

    </div>

    <div class="map-card">
        <div class="map-title">
            <h2>Lokasi Kami</h2>
            <p>Kunjungi BananaGo langsung di Batam.</p>
        </div>

        <iframe 
            src="https://www.google.com/maps?q=Banana%20Go%20Kembang%20Sari%20Batam&output=embed"
            width="100%" 
            height="380" 
            style="border:0;" 
            allowfullscreen="" 
            loading="lazy">
        </iframe>
    </div>
</section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="assets/js/main.js"></script>
         <?php include 'components/footer.php'; ?>
</body>
</html>