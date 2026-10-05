<?php defined( 'ABSPATH' ) || exit; get_header(); ?>
<div id="primary" class="content-area"><main id="main" class="site-main">
<?php while ( have_posts() ) : the_post(); ?><article <?php post_class(); ?>><div class="inside-article">
<h1><?php the_title(); ?></h1><div class="un-musician-image"><?php the_post_thumbnail( 'large' ); ?></div>
<p><?php echo esc_html( get_post_meta( get_the_ID(), '_unthunk_instrument', true ) ); ?></p>
<div class="entry-content"><?php the_content(); ?></div>
</div></article><?php endwhile; ?></main></div><?php get_footer(); ?>
