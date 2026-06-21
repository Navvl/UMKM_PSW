<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Banana Go</title>
    <link rel="icon" type="image/jpeg" href="assets/img/icon.png">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700;900&display=swap">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/> 

    <!-- css yang dipakai di bagian contact -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/contact.css">

</head>
<body>

<!-- ini yg dipakai berulang x di halaman mn pun -->
    <?php include 'components/navbar.php'; ?>
    
    <section class="contact-section">
        <div class="contact-title">
            <span>GET IN TOUCH</span>
            <h1>CONTACT US</h1>
            <p>Hubungi kami untuk pemesanan, kerja sama, atau pertanyaan.</p>
        </div>

        <!-- grid sytem antara info card dan form pesan -->
         <!-- info card -->
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

                <!-- form pesan  -->
            <div class="contact-card form-card">
                <h2>Kirim Pesan</h2>

                <form action="Config/proses_contact.php" method="POST" novalidate>
                    
                    <input type="text" name="nama" placeholder="Nama kamu" required>

                    <input type="email" id="email" name="email" placeholder="Email kamu" required>
                    
                    <textarea id="pesan" name="pesan" placeholder="Tulis pesan kamu..." maxlength="200" required></textarea>
                    
                    <div id="charCount" style="text-align: right; font-size: 0.85rem; font-weight: 600; color: #4c2013; opacity: 0.7; margin-bottom: 10px;">
                        200 characters remaining
                    </div>

                     <div id="emailError" style="display: none; background-color: #dc3545; color: white; padding: 14px 16px; border: 3px solid #4c2013; border-radius: 18px; font-size: 14px; font-weight: 700; margin-top: -5px; margin-bottom: 5px; text-align: left; font-family: 'Poppins', sans-serif;">
                        <i class="bi bi-exclamation-triangle-fill" style="margin-right: 8px;"></i><span id="errorText"></span>
                    </div>

                    <button type="submit" id="btnSubmit">
                        Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- BAGIAN MAPS UNTUK MEMPERMUDAH CUSTOMER CARI LOKASI KITA "MAPS" -->
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

    <script>
        //  1. Fitur Pencatat Sisa Karakter Teks ---=
        const pesanInput = document.getElementById('pesan');
        const charCount = document.getElementById('charCount');

        pesanInput.addEventListener('input', function () {
            const maxLength = pesanInput.getAttribute('maxlength');
            const currentLength = pesanInput.value.length;
            const remaining = maxLength - currentLength; 

            charCount.innerText = remaining + ' characters remaining';
        });

        //  2. Validasi Form Menyeluruh Menggunakan JS
        const contactForm = document.querySelector('form');
        // Ambil elemen nama menggunakan querySelector karena tidak memiliki ID
        const namaInput = document.querySelector('input[name="nama"]'); 
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const errorText = document.getElementById('errorText');
        const btnSubmit = document.getElementById('btnSubmit');

        contactForm.addEventListener('submit', function (event) {
            // Ambil semua nilai (value) dan buang spasi kosong di awal/akhir teks
            const namaValue = namaInput.value.trim();
            const emailValue = emailInput.value.trim();
            const pesanValue = pesanInput.value.trim();

            // Reset tampilan error setiap kali tombol submit ditekan ulang
            emailError.style.display = 'none';
            namaInput.style.borderColor = '';
            emailInput.style.borderColor = '';
            emailInput.style.backgroundColor = '';
            pesanInput.style.borderColor = '';

            // CEK KONDISI 1: Apakah ada kolom yang dibiarkan kosong?
            if (namaValue === "" || emailValue === "" || pesanValue === "") {
                event.preventDefault(); // Tahan pengiriman data
                
                // Ini bagian peringatan kalau kosong
                errorText.innerText = "Mohon isi semua kolom (Nama, Email, dan Pesan) sebelum mengirim.";
                emailError.style.display = 'block';

                // Beri garis merah pada kolom yang masih kosong agar user tahu
                if (namaValue === "") namaInput.style.borderColor = '#dc3545';
                if (emailValue === "") emailInput.style.borderColor = '#dc3545';
                if (pesanValue === "") pesanInput.style.borderColor = '#dc3545';
                
                return false;
            }

            // CEK KONDISI 2: Jika semua terisi, apakah format emailnya sudah benar?
            if (!emailValue.includes('@')) {
                event.preventDefault(); // Tahan pengiriman data
                
                errorText.innerText = "Sertakan '@' pada alamat email. '" + emailValue + "' tidak memiliki '@'.";
                emailError.style.display = 'block';
                
                emailInput.style.borderColor = '#dc3545';
                emailInput.style.backgroundColor = '#fff5f5';
                emailInput.focus();
                
                return false;
            }

            // Jika semua kondisi di atas aman, jalankan proses loading
            btnSubmit.innerHTML = 'Sending...';
            btnSubmit.disabled = true;
        });

        // Event listener tambahan: hilangkan efek error seketika saat user mulai mengetik di kolom manapun
        const resetErrorStyle = function() {
            emailError.style.display = 'none';
            this.style.borderColor = '';
            this.style.backgroundColor = '';
        };

        namaInput.addEventListener('input', resetErrorStyle);
        emailInput.addEventListener('input', resetErrorStyle);
        pesanInput.addEventListener('input', resetErrorStyle);
    </script>

<!-- ini yg dipakai berulang x di halaman mn pun -->
    <?php include 'components/footer.php'; ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</html>