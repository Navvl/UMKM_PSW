// BUAT MUNCULIN NAVBAR DAN FOOTER
async function loadComponent(elementId, filePath) {
    try {
        const response = await fetch(filePath);
        if (!response.ok) {
            throw new Error(`Failed to load component from ${filePath}. Status: ${response.status}`);
        }
        const html = await response.text();
        document.getElementById(elementId).innerHTML = html;
    } catch (error) {
        console.error('Component loading error:', error.message);
        document.getElementById(elementId).innerHTML = `<div class="alert alert-danger">Error: Failed to load UI component.</div>`;
    }
}

// Jalankan saat struktur DOM sudah siap
document.addEventListener('DOMContentLoaded', () => {
    loadComponent('navbar-placeholder', 'components/navbar.html');
    loadComponent('footer-placeholder', 'components/footer.html');
});





// BAGIAN CARD DI HOME
document.addEventListener("DOMContentLoaded", () => {
    const container = document.getElementById('productPreviewStack');
    const titleEl = document.getElementById('activeProductTitle');
    if (!container || !titleEl) return;

    const cards = container.querySelectorAll('.floating-card');
    const dots = container.querySelectorAll('.btn-page');
    
    // Daftar Nama Produk blay (sesuaikan urutannya dengan data-index)
    const productNames = ["Cheese", "White Glaze", "Matcha", "Chocolate", "Mix Variant"];

    let currentIndex = 0;
    let isHovered = false;
    let autoPlay;

    const updateCards = (newIndex) => {
        // 1. Animasi Fade pada Judul blay
        titleEl.classList.add('title-fade');
        
        setTimeout(() => {
            titleEl.innerText = productNames[newIndex];
            titleEl.classList.remove('title-fade');
        }, 300); // Match dengan durasi CSS transition

        // 2. Update Card State blay
        currentIndex = newIndex;
        cards.forEach((card, i) => {
            card.classList.remove('active-center', 'active-left', 'active-right', 'shuffle-anim');
            
            const total = cards.length;
            const leftIndex = (currentIndex - 1 + total) % total;
            const rightIndex = (currentIndex + 1) % total;

            if (i === currentIndex) {
                card.classList.add('active-center', 'shuffle-anim');
            } else if (i === leftIndex) {
                card.classList.add('active-left');
            } else if (i === rightIndex) {
                card.classList.add('active-right');
            }
        });

        // 3. Update dots blay
        dots.forEach((dot, i) => {
            dot.classList.toggle('active', i === currentIndex);
        });
    };

    const startAutoPlay = () => {
        autoPlay = setInterval(() => {
            if (!isHovered) {
                let next = (currentIndex + 1) % cards.length;
                updateCards(next);
            }
        }, 4000); // 4 detik blay biar sempet baca judul
    };

    // Hover logic
    container.addEventListener('mouseenter', () => {
        isHovered = true;
        clearInterval(autoPlay);
    });

    container.addEventListener('mouseleave', () => {
        isHovered = false;
        startAutoPlay();
    });

    // Klik nomor navigasi
    dots.forEach((dot, i) => {
        dot.addEventListener('click', () => {
            if(i !== currentIndex) updateCards(i);
        });
    });

    updateCards(0);
    startAutoPlay();
});



// NAVBAR
const initStickyNavbar = () => {
    const nav = document.querySelector(".navbar-bananago");
    const threshold = 100;

    // 1. Jika navbar BELUM ADA di DOM blay
    if (!nav) {
        // Cek lagi tiap 0.1 detik blay, jangan dimatiin scriptnya
        setTimeout(initStickyNavbar, 100);
        return; 
    }

    window.addEventListener("scroll", () => {
        if (window.scrollY > threshold) {
            if (!nav.classList.contains("is-sticky")) {
                nav.classList.add("is-sticky");
            }
        } else {
            if (nav.classList.contains("is-sticky")) {
                nav.classList.remove("is-sticky");
            }
        }
    });
};

// Panggil fungsinya langsung blay, dia bakal nyari sendiri sampe dapet
initStickyNavbar();