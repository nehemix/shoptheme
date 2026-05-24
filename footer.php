<footer class="urban-footer">
    <p>&copy; <?php echo date('Y'); ?> <strong>47CMSHOP</strong>. Todos los derechos reservados. | By <strong>PixelSite</strong></p>
    <p style="font-size:0.8rem; color: #555; font-family: 'Permanent Marker', cursive;">STREETWEAR & BTS CULTURE</p>
</footer>

<!-- Arquitectura Desacoplada: Vanilla JS IntersectionObserver -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Programación declarativa de configuración del Observer
    const observerOptions = {
        root: null,
        rootMargin: "0px",
        threshold: 0.15
    };
    
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target); // Libera recursos una vez animado
            }
        });
    }, observerOptions);
    
    // Selecciona los componentes modulares y los observa
    document.querySelectorAll('.urban-fade-in').forEach(el => observer.observe(el));
});
</script>

<?php wp_footer(); ?>
</body>
</html>