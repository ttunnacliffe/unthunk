<?php
defined( 'ABSPATH' ) || exit;

function unthunk_navigation_fallback() {
    echo '<div class="main-nav"><ul>';
    foreach ( array( '' => 'Home', '#portfolio' => 'Releases', '#about' => 'About', '#news' => 'News', '#contact' => 'Contact' ) as $anchor => $label ) {
        echo '<li><a href="' . esc_url( home_url( '/' ) . $anchor ) . '">' . esc_html( $label ) . '</a></li>';
    }
    echo '</ul></div>';
}
add_filter( 'wp_nav_menu_args', function ( $args ) {
    if ( isset( $args['theme_location'] ) && $args['theme_location'] === 'primary' ) { $args['fallback_cb'] = 'unthunk_navigation_fallback'; }
    return $args;
} );

function unthunk_option( $key, $fallback = '' ) {
    $options = get_option( 't_one_options', array() );
    return is_array( $options ) && isset( $options[ $key ] ) ? $options[ $key ] : $fallback;
}
add_filter( 'generate_sidebar_layout', function ( $layout ) {
    return is_front_page() || is_page( array( 'about-us', 'musicians' ) ) || is_singular( array( 'project', 'tracks', 'musician' ) ) ? 'no-sidebar' : $layout;
} );
add_filter( 'body_class', function ( $classes ) {
    if ( is_front_page() ) { $classes[] = 'un-home'; }
    return $classes;
} );
add_filter( 'generate_copyright', function ( $copyright ) {
    $saved = unthunk_option( 'footer_text' );
    return $saved ? wp_kses_post( do_shortcode( $saved ) ) : '&copy; ' . esc_html( wp_date( 'Y' ) ) . ' Trevor Tunnacliffe';
} );
// GeneratePress loads this child's style.css; do not enqueue it a second time.
add_action( 'after_switch_theme', function () {
    $locations = get_theme_mod( 'nav_menu_locations', array() );
    if ( empty( $locations['primary'] ) ) {
        $old = get_option( 'theme_mods_t-one', array() );
        $menus = isset( $old['nav_menu_locations'] ) ? $old['nav_menu_locations'] : array();
        foreach ( array( 'main-menu-left', 'main-menu-right' ) as $location ) {
            if ( ! empty( $menus[ $location ] ) ) {
                $locations['primary'] = absint( $menus[ $location ] );
                set_theme_mod( 'nav_menu_locations', $locations );
                break;
            }
        }
    }
} );
