<?php defined( 'ABSPATH' ) || exit; get_header(); ?>
<main id="main" class="site-main un-wrap">
    <section class="un-hero">
        <?php if ( has_post_thumbnail( 2138 ) ) { echo get_the_post_thumbnail( 2138, 'full', array( 'class' => 'un-hero-image', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high' ) ); } ?>
        <div class="un-hero-content">
        <p class="un-kicker">Chamber + popular music</p>
        <h1><?php bloginfo( 'name' ); ?></h1>
        <?php
        $intro = new WP_Query( array( 'post_type' => 'slide', 'posts_per_page' => 1, 'meta_query' => array( 'relation' => 'OR', array( 'key' => 't_one_hide', 'compare' => 'NOT EXISTS' ), array( 'key' => 't_one_hide', 'value' => '0' ) ) ) );
        $description = $intro->have_posts() ? get_post_meta( $intro->posts[0]->ID, 't_one_description', true ) : '';
        ?>
        <p><?php echo esc_html( $description ?: "Unthunk is an identifier for Trevor Tunnacliffe's musical endeavours." ); ?></p>
        </div>
    </section>
    <section id="portfolio" class="un-section" aria-labelledby="releases-heading">
        <h2 id="releases-heading"><?php echo esc_html( unthunk_option( 'portfolio_title', 'Releases' ) ); ?></h2>
        <div class="un-grid">
        <?php $releases = new WP_Query( array( 'post_type' => 'project', 'posts_per_page' => -1, 'orderby' => 'date', 'order' => 'DESC', 'meta_query' => array( 'relation' => 'OR', array( 'key' => '_unthunk_include_in_menu', 'compare' => 'NOT EXISTS' ), array( 'key' => '_unthunk_include_in_menu', 'value' => '0', 'compare' => '!=' ) ) ) );
        while ( $releases->have_posts() ) : $releases->the_post(); ?>
            <article class="un-release">
                <a href="<?php the_permalink(); ?>">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail( 'large' ); } else { ?><div class="un-card-placeholder"><?php the_title(); ?></div><?php } ?>
                    <h3><?php the_title(); ?></h3>
                </a>
                <?php echo get_the_term_list( get_the_ID(), 'filter', '<p>', ', ', '</p>' ); ?>
            </article>
        <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </section>
    <?php if ( unthunk_option( 'about_content' ) || post_type_exists( 'musician' ) ) : ?>
    <section id="about" class="un-section">
        <div class="un-copy"><h2><?php echo esc_html( unthunk_option( 'about_title', 'About Unthunk' ) ); ?></h2>
        <?php echo wp_kses_post( wpautop( unthunk_option( 'about_content' ) ) ); ?></div>
        <?php $members = new WP_Query( array( 'post_type' => 'musician', 'posts_per_page' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ), 'meta_query' => array( 'relation' => 'OR', array( 'key' => '_unthunk_musician_homepage', 'compare' => 'NOT EXISTS' ), array( 'key' => '_unthunk_musician_homepage', 'value' => '0', 'compare' => '!=' ) ) ) ); ?>
        <?php if ( $members->have_posts() ) : ?><div class="un-members">
        <?php while ( $members->have_posts() ) : $members->the_post(); ?>
            <article class="un-member"><a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'medium' ); ?><h3><?php the_title(); ?></h3></a><?php the_content(); ?></article>
        <?php endwhile; wp_reset_postdata(); ?></div><?php endif; ?>
    </section><?php endif; ?>
    <section id="news" class="un-section">
        <h2>News</h2><div class="un-grid">
        <?php $news = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 3, 'ignore_sticky_posts' => true ) );
        while ( $news->have_posts() ) : $news->the_post(); ?>
            <article class="un-news"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3><?php the_excerpt(); ?></article>
        <?php endwhile; wp_reset_postdata(); ?></div>
        <?php $posts_page = absint( get_option( 'page_for_posts' ) ); if ( $posts_page ) : ?><p><a href="<?php echo esc_url( get_permalink( $posts_page ) ); ?>">All posts &rarr;</a></p><?php endif; ?>
    </section>
    <section id="contact" class="un-section un-copy"><span id="cta-contact"></span>
        <h2><?php echo esc_html( unthunk_option( 'contact_title', 'Get in touch' ) ); ?></h2>
        <p>To hear, record or perform Unthunk material, get in touch. We're happy to provide scores and high resolution audio files.</p>
        <?php if ( shortcode_exists( 'unthunk_contact' ) ) { echo do_shortcode( '[unthunk_contact]' ); } ?>
    </section>
</main>
<?php get_footer(); ?>
