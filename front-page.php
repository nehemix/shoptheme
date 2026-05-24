<?php
get_header(); 

$banner_url   = get_theme_mod( 'urban_master_banner_url' );
$hero_text    = get_theme_mod( 'urban_master_hero_text', '' );
$bundle_title = get_theme_mod( 'urban_master_bundle_title', 'PACK DUO: 2 REMERAS ARIRANG' );
$bundle_desc  = get_theme_mod( 'urban_master_bundle_desc', 'Llevate dos remeras de la tienda combinándolas como quieras con un precio especial de pack.' );
?>

<div class="urban-hero-container urban-fade-in">
    <div class="urban-banner-169">
        <?php if ( ! empty( $banner_url ) ) : ?>
            <!-- LCP Image Opt: Eager loading con alta prioridad para mejorar Web Vitals -->
            <img src="<?php echo esc_url( $banner_url ); ?>" alt="Banner 47 CMSHOP" class="urban-banner-img" fetchpriority="high" decoding="sync">
            <?php if ( ! empty( $hero_text ) ) : ?>
                <div class="urban-banner-overlay">
                    <h1 class="urban-hero-dynamic-title"><?php echo wp_kses_post( $hero_text ); ?></h1>
                </div>
            <?php endif; ?>
        <?php else : ?>
            <div class="urban-banner-placeholder-text">
                <span>47 CMSHOP PORTADA MASTER<br>
                <small>Ve a Apariencia > Personalizar > 47 CMSHOP - Portada Maestra para subir tu banner (.png o .jpg) de forma dinámica.</small></span>
            </div>
        <?php endif; ?>
    </div>
    <div class="urban-hero-cta-wrapper">
        <a href="#promo-bundle" class="urban-hero-cta">Ver Promo</a>
    </div>
</div>

<div class="urban-bundle-section urban-fade-in" id="promo-bundle">
    <div class="urban-bundle-card">
        <div class="urban-bundle-badge">PACK EXCLUSIVO</div>
        <h3 class="urban-bundle-title"><?php echo esc_html( $bundle_title ); ?></h3>
        <p class="urban-bundle-desc"><?php echo esc_html( $bundle_desc ); ?></p>
        
        <div class="urban-bundle-container-slot">
            <?php
            // Consulta para traer específicamente el producto Bundle / Pack a la Home
            $bundle_args = array(
                'post_type'      => 'product',
                'posts_per_page' => 1,
                'tax_query'      => array(
                    array(
                        'taxonomy' => 'product_cat',
                        'field'    => 'slug',
                        'terms'    => array( 'bundle', 'pack' ), // Utiliza cualquiera de estas categorías en WooCommerce
                        'operator' => 'IN'
                    )
                )
            );
            $bundle_product = new WP_Query( $bundle_args );

            if ( $bundle_product->have_posts() ) {
                woocommerce_product_loop_start();
                while ( $bundle_product->have_posts() ) {
                    $bundle_product->the_post();
                    wc_get_template_part( 'content', 'product' );
                }
                woocommerce_product_loop_end();
            } else {
                echo '<span>[Crea un producto en WooCommerce y asígnale la categoría "bundle" o "pack" para verlo aquí]</span>';
            }
            wp_reset_postdata();
            ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>