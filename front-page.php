<?php
get_header(); 

$banner_url   = get_theme_mod( 'urban_master_banner_url' );
$hero_text    = get_theme_mod( 'urban_master_hero_text', '' );
$bundle_title = get_theme_mod( 'urban_master_bundle_title', 'PACK DUO: 2 REMERAS URBANAS' );
$bundle_desc  = get_theme_mod( 'urban_master_bundle_desc', 'Llevate dos remeras de la tienda combinándolas como quieras con un precio especial de pack.' );
?>

<div class="urban-hero-container">
    <div class="urban-banner-169">
        <?php if ( ! empty( $banner_url ) ) : ?>
            <img src="<?php echo esc_url( $banner_url ); ?>" alt="Banner 47 CMSHOP" class="urban-banner-img">
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
</div>

<div class="urban-bundle-section">
    <div class="urban-bundle-card">
        <div class="urban-bundle-badge">PACK EXCLUSIVO</div>
        <h3 class="urban-bundle-title"><?php echo esc_html( $bundle_title ); ?></h3>
        <p class="urban-bundle-desc"><?php echo esc_html( $bundle_desc ); ?></p>
        
        <div class="urban-bundle-container-slot">
            <span>[Espacio reservado para mapear tu publicación Bundle / Pack]</span>
        </div>
    </div>
</div>

<div class="urban-shop-container">
    <h2 style="font-family: var(--font-graffiti); color: var(--white); font-size: 2.5rem; text-align: center; margin-bottom: 40px; text-shadow: 2px 2px 0px var(--accent-2); text-transform: uppercase;">Últimos Drops</h2>
    <?php
    // Consulta personalizada para traer las remeras a la home (excluyendo el bundle)
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 6, // Muestra las 6 remeras más nuevas
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => array( 'bundle', 'pack' ), // Sigue ocultando el bundle de aquí
                'operator' => 'NOT IN'
            )
        )
    );
    $home_products = new WP_Query( $args );

    if ( $home_products->have_posts() ) {
        woocommerce_product_loop_start();
        while ( $home_products->have_posts() ) {
            $home_products->the_post();
            wc_get_template_part( 'content', 'product' );
        }
        woocommerce_product_loop_end();
    } else {
        echo '<p style="text-align:center; color: var(--gray-text); font-size: 1.2rem;">Próximos drops muy pronto...</p>';
    }
    wp_reset_postdata();
    ?>
</div>

<?php get_footer(); ?>