<?php defined( 'ABSPATH' ) || exit; get_header(); ?>
<div id="primary" class="content-area"><main id="main" class="site-main">
<?php while ( have_posts() ) : the_post(); ?>
<article <?php post_class(); ?>><div class="inside-article">
    <p class="un-kicker">Release</p><h1><?php the_title(); ?></h1>
    <?php $gallery = get_post_meta( get_the_ID(), 't_one_project_gallery', false );
    if ( $gallery ) : ?><div class="un-gallery"><?php foreach ( $gallery as $id ) { echo wp_get_attachment_image( absint( $id ), 'large' ); } ?></div>
    <?php elseif ( has_post_thumbnail() ) : ?><div class="un-gallery"><?php the_post_thumbnail( 'large' ); ?></div><?php endif; ?>
    <div class="un-release-layout"><div class="entry-content"><?php the_content(); wp_link_pages(); ?>
    <?php $url = get_post_meta( get_the_ID(), 't_one_project_button_url', true ); $text = get_post_meta( get_the_ID(), 't_one_project_button_text', true );
    if ( $url && $text ) : ?><p><a class="un-button" href="<?php echo esc_url( $url ); ?>"><?php echo esc_html( $text ); ?></a></p><?php endif; ?></div>
    <?php $tracks = get_post_meta( get_the_ID(), 't_one_track', false ); $ids = array();
    foreach ( $tracks as $value ) { foreach ( (array) $value as $id ) { if ( absint( $id ) ) { $ids[] = absint( $id ); } } }
    if ( $ids ) : ?><aside aria-label="Release tracks"><h2>Tracks</h2><ol class="un-track-list">
        <?php foreach ( $ids as $id ) { if ( get_post_status( $id ) === 'publish' ) : ?><li><a href="<?php echo esc_url( get_permalink( $id ) ); ?>"><?php echo esc_html( get_the_title( $id ) ); ?></a></li><?php endif; } ?>
    </ol></aside><?php endif; ?></div>
</div></article>
<?php endwhile; ?></main></div>
<?php get_footer(); ?>
