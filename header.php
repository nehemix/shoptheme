<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="urban-header">
    <div class="header-container">
        <?php 
        if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
            the_custom_logo();
        } else {
            echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="urban-logo-text">47 CMSHOP</a>';
        }
        ?>

        <!-- Botón Hamburguesa -->
        <div class="urban-mobile-toggle" id="urban-menu-toggle" onclick="document.getElementById('urban-menu-wrapper').classList.toggle('active')">
            <span></span><span></span><span></span>
        </div>

        <nav class="urban-menu-wrapper" id="urban-menu-wrapper">
            <ul class="urban-menu">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'main-menu',
                    'container'      => false,
                    'items_wrap'     => '%3$s', // Muestra solo los li para inyectar el carrito al final
                    'fallback_cb'    => 'urban_default_menu'
                ) );
                ?>
                
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                <li class="urban-header-cart">
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="Ver tu carrito">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                        (<?php echo WC()->cart->get_cart_contents_count(); ?>)
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>