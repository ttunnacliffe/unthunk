<?php defined( 'ABSPATH' ) || exit; get_header(); ?>
<div id="primary" class="content-area"><main id="main" class="site-main">
<?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class(); ?>><div class="inside-article">
<h1><?php the_title(); ?></h1><div class="entry-content"><?php the_content(); ?>
<?php $musicians = new WP_Query( array( 'post_type' => 'musician', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ) ) ); ?>
<ul class="un-musician-list" aria-label="Musicians">
<?php while ( $musicians->have_posts() ) : $musicians->the_post(); ?>
<li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a><?php $instrument = get_post_meta( get_the_ID(), '_unthunk_instrument', true ); if ( $instrument ) : ?><p><?php echo esc_html( $instrument ); ?></p><?php endif; ?></li>
<?php endwhile; wp_reset_postdata(); ?></ul>
</div></div></article><?php endwhile; ?></main></div>
<?php get_footer(); ?>
