<?php
get_header(); 

?>

<div class="urban-shop-container">
    <h1 style="font-family: var(--font-bts); color: var(--white); font-size: 3rem; text-shadow: 3px 3px 0px var(--accent-2); text-transform: uppercase; text-align: center; margin-bottom: 40px;">
        <?php woocommerce_page_title(); ?>
    </h1>

    <?php
    if ( woocommerce_product_loop() ) {
        woocommerce_product_loop_start();
        if ( wc_get_loop_prop( 'total' ) ) {
            while ( have_posts() ) {
                the_post();
                wc_get_template_part( 'content', 'product' );
            }
        }
        woocommerce_product_loop_end();
        the_posts_navigation();
    } else {
        do_action( 'woocommerce_no_products_found' );
    }
    ?>
</div>

<?php get_footer(); ?>