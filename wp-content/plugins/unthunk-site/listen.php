<?php
defined( 'ABSPATH' ) || exit;
add_action( 'init', function () {
    register_post_type( 'un_stream', array( 'labels' => array( 'name' => 'Streaming Services', 'singular_name' => 'Streaming Service', 'add_new_item' => 'Add Streaming Service', 'edit_item' => 'Edit Streaming Service' ), 'public' => false, 'show_ui' => true, 'show_in_menu' => true, 'menu_icon' => 'dashicons-format-audio', 'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'revisions' ) ) );
} );
add_action( 'add_meta_boxes_un_stream', function () {
    add_meta_box( 'un-stream-settings', 'Listening link and visibility', function ( $post ) {
        wp_nonce_field( 'un_stream_save', 'un_stream_nonce' );
        echo '<p><label>Artist profile URL<br><input type="url" style="width:100%" name="un_stream_url" value="' . esc_attr( get_post_meta( $post->ID, '_un_stream_url', true ) ) . '"></label></p>';
        echo '<p><label><input type="checkbox" name="un_stream_available" value="1" ' . checked( get_post_meta( $post->ID, '_un_stream_available', true ), '1', false ) . '> Available — show on Listen page</label></p>';
        echo '<p><label><input type="checkbox" name="un_stream_featured" value="1" ' . checked( absint( get_option( 'un_stream_featured' ) ), $post->ID, false ) . '> Featured service</label></p><p class="description">Selecting Featured replaces the previous featured service. Publish and mark Available to display it.</p>';
        echo '<p><label>Last checked<br><input type="date" name="un_stream_checked" value="' . esc_attr( get_post_meta( $post->ID, '_un_stream_checked', true ) ) . '"></label></p><p>Use the description for a short introduction and the featured image for optional artwork.</p>';
    }, 'un_stream', 'normal', 'high' );
} );
add_action( 'save_post_un_stream', function ( $id ) {
    if ( wp_is_post_revision( $id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $id ) || empty( $_POST['un_stream_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['un_stream_nonce'] ) ), 'un_stream_save' ) ) { return; }
    update_post_meta( $id, '_un_stream_url', esc_url_raw( wp_unslash( $_POST['un_stream_url'] ?? '' ), array( 'https', 'http' ) ) );
    update_post_meta( $id, '_un_stream_available', isset( $_POST['un_stream_available'] ) ? '1' : '0' );
    $date = sanitize_text_field( wp_unslash( $_POST['un_stream_checked'] ?? '' ) );
    update_post_meta( $id, '_un_stream_checked', preg_match( '/^\d{4}-\d{2}-\d{2}$/', $date ) ? $date : '' );
    if ( isset( $_POST['un_stream_featured'] ) ) { update_option( 'un_stream_featured', $id ); }
    elseif ( absint( get_option( 'un_stream_featured' ) ) === $id ) { delete_option( 'un_stream_featured' ); }
} );
add_filter( 'manage_un_stream_posts_columns', function ( $columns ) { $columns['un_available'] = 'Available'; $columns['un_featured'] = 'Featured'; $columns['un_checked'] = 'Last checked'; return $columns; } );
add_action( 'manage_un_stream_posts_custom_column', function ( $column, $id ) {
    if ( $column === 'un_available' ) { echo get_post_meta( $id, '_un_stream_available', true ) === '1' ? 'Yes' : 'No'; }
    if ( $column === 'un_featured' ) { echo absint( get_option( 'un_stream_featured' ) ) === $id ? 'Yes' : '—'; }
    if ( $column === 'un_checked' ) { echo esc_html( get_post_meta( $id, '_un_stream_checked', true ) ?: 'Not checked' ); }
}, 10, 2 );
add_action( 'admin_menu', function () {
    add_submenu_page( 'edit.php?post_type=un_stream', 'Check streaming services', 'Check services', 'edit_posts', 'un-stream-check', function () {
        echo '<div class="wrap"><h1>Check streaming services</h1><p>Open each profile to confirm that it contains Unthunk releases. Edit the service to update its URL, Available checkbox and Last checked date. These are manual checks; a working URL alone does not confirm music availability.</p><table class="widefat striped"><thead><tr><th>Service</th><th>Profile</th><th>Last checked</th><th>Manage</th></tr></thead><tbody>';
        foreach ( get_posts( array( 'post_type' => 'un_stream', 'post_status' => array( 'publish', 'draft', 'private' ), 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ) as $post ) {
            $url = get_post_meta( $post->ID, '_un_stream_url', true );
            echo '<tr><td>' . esc_html( $post->post_title ) . '</td><td>' . ( $url ? '<a target="_blank" rel="noopener noreferrer" href="' . esc_url( $url ) . '">Check profile ↗</a>' : 'No URL set' ) . '</td><td>' . esc_html( get_post_meta( $post->ID, '_un_stream_checked', true ) ?: 'Not checked' ) . '</td><td><a href="' . esc_url( get_edit_post_link( $post->ID ) ) . '">Edit service</a></td></tr>';
        }
        echo '</tbody></table><h2>Check additional services</h2><p>Search for Unthunk and compare the results with releases such as Oblong, Elliptic and Return to the sea. Add a service only after confirming the correct artist profile.</p>';
        foreach ( array( 'Deezer' => 'https://www.deezer.com/search/Unthunk', 'YouTube Music' => 'https://music.youtube.com/search?q=Unthunk', 'Qobuz' => 'https://www.qobuz.com/search?q=Unthunk' ) as $name => $url ) { echo '<p><a target="_blank" rel="noopener noreferrer" href="' . esc_url( $url ) . '">Search ' . esc_html( $name ) . ' ↗</a></p>'; }
        echo '<p><a class="button" href="' . esc_url( admin_url( 'post-new.php?post_type=un_stream' ) ) . '">Add Streaming Service</a></p></div>';
    } );
} );
add_shortcode( 'unthunk_listen', function () {
    $posts = get_posts( array( 'post_type' => 'un_stream', 'numberposts' => -1, 'orderby' => array( 'menu_order' => 'ASC', 'title' => 'ASC' ), 'meta_key' => '_un_stream_available', 'meta_value' => '1' ) );
    $featured = absint( get_option( 'un_stream_featured' ) );
    $render = function ( $post, $large ) {
        $url = get_post_meta( $post->ID, '_un_stream_url', true );
        if ( ! $url ) { return ''; }
        $html = '<article class="' . ( $large ? 'un-listen-featured' : 'un-listen-service' ) . '">';
        if ( $large && has_post_thumbnail( $post ) ) { $html .= get_the_post_thumbnail( $post, 'large' ); }
        $html .= '<div>' . ( $large ? '<p class="un-kicker">Featured service</p>' : '' ) . '<h' . ( $large ? '2' : '3' ) . '>' . esc_html( $post->post_title ) . '</h' . ( $large ? '2' : '3' ) . '>';
        $html .= wpautop( wp_kses_post( $post->post_content ) );
        $html .= '<a class="' . ( $large ? 'un-button' : 'un-listen-link' ) . '" href="' . esc_url( $url ) . '">Listen on ' . esc_html( $post->post_title ) . ' ↗</a></div></article>';
        return $html;
    };
    $html = '<div class="un-listen">'; $other = '';
    foreach ( $posts as $post ) { if ( $post->ID === $featured ) { $html .= $render( $post, true ); } else { $other .= $render( $post, false ); } }
    if ( $other ) { $html .= '<section class="un-listen-others"><h2>Also listen on</h2><div class="un-listen-grid">' . $other . '</div></section>'; }
    return $html . '</div>';
} );
add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) || get_option( 'un_listen_initialized_v1' ) ) { return; }
    if ( ! add_option( 'un_listen_seed_lock', 1, '', false ) ) { return; }
    $services = array(
        'Bandcamp' => array( 'https://unthunk.bandcamp.com/music', 'Explore Unthunk’s music on Bandcamp. Listen to releases and purchase downloads directly.', 0 ),
        'Spotify' => array( 'https://open.spotify.com/artist/6DIuOBKraX9jYEtpcOKfTy', '', 10 ),
        'Apple Music' => array( 'https://music.apple.com/us/artist/unthunk/1420305654', '', 20 ),
        'Amazon Music' => array( 'https://music.amazon.com/artists/B07G35RBWL/unthunk', '', 30 ),
        'Tidal' => array( 'https://tidal.com/artist/10165973', '', 40 )
    );
    foreach ( $services as $name => $data ) {
        $id = wp_insert_post( array( 'post_type' => 'un_stream', 'post_status' => 'publish', 'post_title' => $name, 'post_content' => $data[1], 'menu_order' => $data[2] ), true );
        if ( is_wp_error( $id ) ) { return; }
        update_post_meta( $id, '_un_stream_url', $data[0] ); update_post_meta( $id, '_un_stream_available', '1' ); update_post_meta( $id, '_un_stream_checked', '2026-10-06' );
        if ( $name === 'Bandcamp' ) { update_option( 'un_stream_featured', $id ); }
    }
    $page = get_page_by_path( 'listen' );
    $id = $page ? $page->ID : wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Listen', 'post_name' => 'listen', 'post_content' => '[unthunk_listen]' ), true );
    if ( is_wp_error( $id ) ) { return; }
    $locations = get_nav_menu_locations();
    if ( ! empty( $locations['primary'] ) ) {
        $exists = false; foreach ( (array) wp_get_nav_menu_items( $locations['primary'] ) as $item ) { if ( absint( $item->object_id ) === $id && $item->object === 'page' ) { $exists = true; } }
        if ( ! $exists ) { wp_update_nav_menu_item( $locations['primary'], 0, array( 'menu-item-object-id' => $id, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-title' => 'Listen', 'menu-item-parent-id' => 0, 'menu-item-status' => 'publish' ) ); }
    }
    update_option( 'un_listen_initialized_v1', 1 );
} );
