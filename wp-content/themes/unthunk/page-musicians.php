<?php defined( 'ABSPATH' ) || exit; get_header(); ?>
<div id="primary" class="content-area"><main id="main" class="site-main">
<?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class(); ?>><div class="inside-article">
    <h1><?php the_title(); ?></h1>
    <div class="entry-content">
        <?php the_content(); ?>
        <?php
        $locations = get_nav_menu_locations();
        $items = ! empty( $locations['primary'] ) ? wp_get_nav_menu_items( $locations['primary'] ) : array();
        $parent = 0;
        foreach ( (array) $items as $item ) {
            if ( absint( $item->object_id ) === get_the_ID() || untrailingslashit( $item->url ) === untrailingslashit( get_permalink() ) ) {
                $parent = $item->ID;
                break;
            }
        }
        $musicians = array();
        if ( $parent ) {
            foreach ( (array) $items as $item ) {
                if ( absint( $item->menu_item_parent ) === $parent ) { $musicians[] = $item; }
            }
        }
        if ( $musicians ) : ?>
        <ul class="un-musician-list" aria-label="Musicians">
            <?php foreach ( $musicians as $musician ) : ?>
            <li><a href="<?php echo esc_url( $musician->url ); ?>"><?php echo esc_html( $musician->title ); ?></a></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
    </div>
</div></article>
<?php endwhile; ?></main></div>
<?php get_footer(); ?>
