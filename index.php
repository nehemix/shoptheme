<?php
get_header(); ?>
<div class="urban-shop-container">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <div style="color:var(--white); line-height:1.8; margin-bottom:40px;"><?php the_content(); ?></div>
    <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>