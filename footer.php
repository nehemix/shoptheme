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

    // Ocultar mensaje de depuración de envío de WooCommerce (Incluso tras actualizar por AJAX)
    const hideWooShippingNotices = () => {
        document.querySelectorAll('.woocommerce-info, .woocommerce-message, ul.woocommerce-error li').forEach(notice => {
            if(notice.innerText.includes('Zona de coincidencia') || notice.innerText.includes('Customer matched zone')) {
                notice.style.display = 'none';
            }
        });
    };
    hideWooShippingNotices();

    if (typeof jQuery !== 'undefined') {
        jQuery(document.body).on('updated_checkout updated_shipping_method updated_cart_totals', hideWooShippingNotices);
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>