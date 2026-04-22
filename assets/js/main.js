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