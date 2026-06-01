// =====================================================
// ================= LOAD FOOTER ========================
// =====================================================

async function loadComponent(elementId, filePath) {
    try {
        const response = await fetch(filePath);

        if (!response.ok) {
            throw new Error(`Failed to load component from ${filePath}`);
        }

        const html = await response.text();

        const element = document.getElementById(elementId);

        if (element) {
            element.innerHTML = html;
        }

    } catch (error) {
        console.error('Component loading error:', error.message);

        const element = document.getElementById(elementId);

        if (element) {
            element.innerHTML = `
                <div class="alert alert-danger">
                    Error: Failed to load UI component.
                </div>
            `;
        }
    }
}

// Footer only
document.addEventListener('DOMContentLoaded', () => {
    loadComponent('footer-placeholder', 'components/footer.html');
});





// =====================================================
// ================= HOME PRODUCT CARD =================
// =====================================================

document.addEventListener("DOMContentLoaded", () => {

    const container = document.getElementById('productPreviewStack');
    const titleEl = document.getElementById('activeProductTitle');

    if (!container || !titleEl) return;

    const cards = container.querySelectorAll('.floating-card');
    const dots = container.querySelectorAll('.btn-page');

    const productNames = [
        "Cheese",
        "White Glaze",
        "Matcha",
        "Chocolate",
        "Mix Variant"
    ];

    let currentIndex = 0;
    let isHovered = false;
    let autoPlay;

    const updateCards = (newIndex) => {

        titleEl.classList.add('title-fade');

        setTimeout(() => {
            titleEl.innerText = productNames[newIndex];
            titleEl.classList.remove('title-fade');
        }, 300);

        currentIndex = newIndex;

        cards.forEach((card, i) => {

            card.classList.remove(
                'active-center',
                'active-left',
                'active-right',
                'shuffle-anim'
            );

            const total = cards.length;

            const leftIndex = (currentIndex - 1 + total) % total;
            const rightIndex = (currentIndex + 1) % total;

            if (i === currentIndex) {

                card.classList.add(
                    'active-center',
                    'shuffle-anim'
                );

            } else if (i === leftIndex) {

                card.classList.add('active-left');

            } else if (i === rightIndex) {

                card.classList.add('active-right');
            }
        });

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

        }, 4000);
    };

    container.addEventListener('mouseenter', () => {

        isHovered = true;

        clearInterval(autoPlay);
    });

    container.addEventListener('mouseleave', () => {

        isHovered = false;

        startAutoPlay();
    });

    dots.forEach((dot, i) => {

        dot.addEventListener('click', () => {

            if (i !== currentIndex) {
                updateCards(i);
            }
        });
    });

    updateCards(0);

    startAutoPlay();
});






// =====================================================
// ================= STICKY NAVBAR =====================
// =====================================================

const initStickyNavbar = () => {

    const nav = document.querySelector(".navbar-bananago");

    const threshold = 100;

    if (!nav) {

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

initStickyNavbar();