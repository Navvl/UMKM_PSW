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
    <link rel="stylesheet" href="assets/css/contact.css">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                <div>📞 <span>0813-6136-7657</span></div>
                <div>✉️ <span>bananago@gmail.com</span></div>
                <div>⏰ <span>09.00 - 21.00</span></div>
            </div>

            <a href="https://kirimwa.id/bananago.batam" class="wa-btn">
                Chat WhatsApp
            </a>
        </div>

        <div class="contact-card form-card">
            <h2>Kirim Pesan</h2>

            <form action="Config/proses_contact.php" method="POST">

    <input type="text" name="nama" placeholder="Nama kamu" required>

    <input type="email" name="email" placeholder="Email kamu" required>

    <textarea id="pesan" name="pesan" placeholder="Tulis pesan kamu..." maxlength="200" required></textarea>
    
    <div id="charCount" style="text-align: right; font-size: 0.85rem; font-weight: 600; color: #4c2013; opacity: 0.7; margin-bottom: 10px;">
        200 characters remaining
    </div>

    <button type="submit" id="btnSubmit">
        Send Message
    </button>

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
        
        <script src="assets/js/main.js"></script>
        <script>
            const pesanInput = document.getElementById('pesan');
            const charCount = document.getElementById('charCount');
            const btnSubmit = document.getElementById('btnSubmit');

            pesanInput.addEventListener('input', function () {
                const maxLength = pesanInput.getAttribute('maxlength');
                const currentLength = pesanInput.value.length;
                const remaining = maxLength - currentLength; 

                charCount.innerText = remaining + ' characters remaining';
            });

            const contactForm = document.querySelector('form');
            contactForm.addEventListener('submit', function () {
                btnSubmit.innerHTML = 'Sending...';
                btnSubmit.disabled = true;
            });
        </script>
         <?php include 'components/footer.php'; ?>
</body>
</html>s