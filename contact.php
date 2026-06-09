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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

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

                <form action="Config/proses_contact.php" method="POST" novalidate>
                    
                    <input type="text" name="nama" placeholder="Nama kamu" required>

                    <input type="email" id="email" name="email" placeholder="Email kamu" required>
                    
                    <div id="emailError" style="display: none; background-color: #dc3545; color: white; padding: 14px 16px; border: 3px solid #4c2013; border-radius: 18px; font-size: 14px; font-weight: 700; margin-top: -5px; margin-bottom: 5px; text-align: left; font-family: 'Poppins', sans-serif;">
                        <i class="bi bi-exclamation-triangle-fill" style="margin-right: 8px;"></i><span id="errorText"></span>
                    </div>

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
        // --- 1. Fitur Pencatat Sisa Karakter Teks ---
        const pesanInput = document.getElementById('pesan');
        const charCount = document.getElementById('charCount');

        pesanInput.addEventListener('input', function () {
            const maxLength = pesanInput.getAttribute('maxlength');
            const currentLength = pesanInput.value.length;
            const remaining = maxLength - currentLength; 

            charCount.innerText = remaining + ' characters remaining';
        });


        // --- 2. Fitur Logika Validasi Email Menggunakan JavaScript ---
        const contactForm = document.querySelector('form');
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const errorText = document.getElementById('errorText');
        const btnSubmit = document.getElementById('btnSubmit');

        contactForm.addEventListener('submit', function (event) {
            const emailValue = emailInput.value.trim();

            // Cek kondisi: jika teks kosong atau tidak ada lambang '@'
            if (emailValue === "" || !emailValue.includes('@')) {
                // Tahan form agar tidak pindah halaman ke proses_contact.php
                event.preventDefault(); 
                
                // Masukkan teks pesan error secara dinamis lewat JS
                errorText.innerText = "Sertakan '@' pada alamat email. '" + (emailValue || " ") + "' tidak memiliki '@'.";
                
                // Perintahkan kotak merah untuk tampil di layar
                emailError.style.display = 'block';
                
                // Ubah border input email menjadi merah cerah dan berikan background soft-red
                emailInput.style.borderColor = '#dc3545';
                emailInput.style.backgroundColor = '#fff5f5';
                
                // Kembalikan fokus kursor ketikan ke kolom email
                emailInput.focus();
                return false;
            }

            // Jika email sudah benar (ada '@'), jalankan loading submit kamu
            emailError.style.display = 'none';
            emailInput.style.borderColor = '';
            emailInput.style.backgroundColor = '';
            
            btnSubmit.innerHTML = 'Sending...';
            btnSubmit.disabled = true;
        });

        // Event listener pasif: hilangkan efek error seketika saat user mulai mengetik ulang
        emailInput.addEventListener('input', function() {
            emailError.style.display = 'none';
            emailInput.style.borderColor = '';
            emailInput.style.backgroundColor = '';
        });
    </script>
    
    <?php include 'components/footer.php'; ?>
</body>
</html>