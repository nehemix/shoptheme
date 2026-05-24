<?php
/**
 * Configuración principal del tema.
 * Habilita el soporte para WooCommerce, logos, y estructura base.
 * @return void
 */
function urban_theme_master_setup() {
    add_theme_support( 'woocommerce' );
    add_theme_support( 'wc-product-gallery-zoom' );
    add_theme_support( 'wc-product-gallery-lightbox' );
    add_theme_support( 'wc-product-gallery-slider' );
    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );

    add_theme_support( 'custom-logo', array(
        'height'      => 95,
        'width'       => 350,
        'flex-width'  => true,
        'flex-height' => true,
    ) );

    register_nav_menus( array(
        'main-menu' => 'Menú Principal Urban',
    ) );
}
add_action( 'after_setup_theme', 'urban_theme_master_setup' );

/**
 * Inyección de scripts y estilos principales.
 * Se mantiene desacoplado para no inflar el <head>.
 * @return void
 */
function urban_theme_master_scripts() {
    wp_enqueue_style( 'urban-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;800&family=Permanent+Marker&display=swap', array(), null );
    wp_enqueue_style( 'urban-style', get_stylesheet_uri(), array(), '6.0.0' );
}
add_action( 'wp_enqueue_scripts', 'urban_theme_master_scripts' );

/**
 * Menú de fallback automático con Home y Productos.
 * @return void
 */
function urban_default_menu() {
    echo '<li class="menu-item"><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
    if ( class_exists( 'WooCommerce' ) ) {
        echo '<li class="menu-item"><a href="' . esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ) . '">Productos</a></li>';
    }
}

// Excluir categoría "bundle" o "pack" de la página principal de Productos
add_action( 'woocommerce_product_query', 'urban_exclude_bundle_category' );
function urban_exclude_bundle_category( $q ) {
    if ( ! is_admin() && $q->is_main_query() && ( is_shop() || is_product_category() || is_product_tag() ) ) {
        $tax_query = (array) $q->get( 'tax_query' );
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => array( 'bundle', 'pack' ), // Crea esta categoría en WooCommerce para tu Bundle
            'operator' => 'NOT IN'
        );
        $q->set( 'tax_query', $tax_query );
    }
}

// Elimina los widgets sueltos (Buscar, Páginas, etc.) de las páginas de productos
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

// Elimina los metadatos (SKU, Categorías y Etiquetas) de la página de producto individual
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );

add_filter( 'loop_shop_columns', 'urban_master_columns', 999 );
function urban_master_columns() {
    return 4;
}

function urban_master_customize_register( $wp_customize ) {
    $wp_customize->add_section( 'urban_master_settings', array(
        'title'    => __( '47 CMSHOP - Portada Maestra', '47cmshop' ),
        'priority' => 25,
    ) );

    $wp_customize->add_setting( 'urban_master_banner_url', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ) );
    $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'urban_master_banner_url', array(
        'label'    => __( 'Subir Banner de Portada (Formato PNG/JPG 16:9)', '47cmshop' ),
        'section'  => 'urban_master_settings',
        'settings' => 'urban_master_banner_url',
    ) ) );

    $wp_customize->add_setting( 'urban_master_hero_text', array(
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ) );
    $wp_customize->add_control( 'urban_master_hero_text', array(
        'label'       => __( 'Texto sobre el Banner (Opcional)', '47cmshop' ),
        'section'     => 'urban_master_settings',
        'type'        => 'textarea',
    ) );

    $wp_customize->add_setting( 'urban_master_bundle_title', array(
        'default'           => 'PACK DUO: 2 REMERAS URBANAS',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'urban_master_bundle_title', array(
        'label'    => __( 'Título de la Publicación Bundle', '47cmshop' ),
        'section'  => 'urban_master_settings',
        'type'     => 'text',
    ) );

    $wp_customize->add_setting( 'urban_master_bundle_desc', array(
        'default'           => 'Llevate dos remeras de la tienda combinándolas como quieras con un precio especial de pack.',
        'sanitize_callback' => 'sanitize_text_field',
    ) );
    $wp_customize->add_control( 'urban_master_bundle_desc', array(
        'label'    => __( 'Descripción del Pack', '47cmshop' ),
        'section'  => 'urban_master_settings',
        'type'     => 'textarea',
    ) );
}
add_action( 'customize_register', 'urban_master_customize_register' );

// Eliminar la pestaña de Valoraciones (Reviews) de la página de producto individual
add_filter( 'woocommerce_product_tabs', 'urban_remove_reviews_tab', 98 );
function urban_remove_reviews_tab( $tabs ) {
    unset( $tabs['reviews'] );
    return $tabs;
}