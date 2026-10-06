<?php
/**
 * Plugin Name: Unthunk Site
 * Description: Preserves Unthunk releases, tracks, legacy URLs and the contact form independently of the theme.
 * Version: 1.2.1
 * License: GPL-2.0-or-later
 */
defined( 'ABSPATH' ) || exit;
// Disable new comments and pingbacks everywhere, including existing content.
add_filter( 'comments_open', '__return_false', PHP_INT_MAX, 2 );
add_filter( 'pings_open', '__return_false', PHP_INT_MAX, 2 );
add_filter( 'comments_array', '__return_empty_array', PHP_INT_MAX, 2 );
add_filter( 'get_comments_number', '__return_zero', PHP_INT_MAX, 2 );
add_action( 'init', function () {
    foreach ( get_post_types() as $type ) {
        remove_post_type_support( $type, 'comments' );
        remove_post_type_support( $type, 'trackbacks' );
    }
}, 100 );
function unthunk_register_content() {
    $shared = array( 'public' => true, 'has_archive' => true, 'show_in_rest' => true, 'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields', 'revisions' ) );
    if ( ! post_type_exists( 'project' ) ) { register_post_type( 'project', array_merge( $shared, array( 'label' => 'Releases', 'rewrite' => array( 'slug' => 'item' ) ) ) ); }
    if ( ! post_type_exists( 'tracks' ) ) { register_post_type( 'tracks', array_merge( $shared, array( 'label' => 'Tracks', 'capability_type' => 'page', 'taxonomies' => array( 'category', 'post_tag' ), 'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes' ) ) ) ); }
    if ( ! post_type_exists( 'slide' ) ) { register_post_type( 'slide', array_merge( $shared, array( 'label' => 'Slides', 'rewrite' => array( 'slug' => 'slide' ) ) ) ); }
    if ( ! taxonomy_exists( 'filter' ) ) { register_taxonomy( 'filter', array( 'project' ), array( 'label' => 'Filters', 'show_ui' => true, 'show_admin_column' => true, 'show_in_rest' => true, 'rewrite' => array( 'slug' => 'filter' ) ) ); }
    add_shortcode( 'year', function () { return wp_date( 'Y' ); } );
}
add_action( 'init', 'unthunk_register_content', 20 );
register_activation_hook( __FILE__, function () { unthunk_register_content(); flush_rewrite_rules(); } );
add_action( 'after_switch_theme', function () { unthunk_register_content(); flush_rewrite_rules(); } );

// Missing metadata keeps existing and new releases included by default.
add_action( 'add_meta_boxes_project', function () {
    add_meta_box( 'unthunk-homepage', 'Homepage visibility', function ( $post ) {
        wp_nonce_field( 'unthunk_homepage', 'unthunk_homepage_nonce' );
        echo '<label><input type="checkbox" name="unthunk_include_in_menu" value="1" ' . checked( get_post_meta( $post->ID, '_unthunk_include_in_menu', true ) !== '0', true, false ) . '> Include in menu</label>';
        echo '<p class="description">Show this project on the home page. Uncheck to hide it from the home page while keeping its own page available.</p>';
    }, 'project', 'side', 'high' );
} );
add_action( 'save_post_project', function ( $id ) {
    if ( wp_is_post_revision( $id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $id ) || empty( $_POST['unthunk_homepage_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['unthunk_homepage_nonce'] ) ), 'unthunk_homepage' ) ) { return; }
    update_post_meta( $id, '_unthunk_include_in_menu', isset( $_POST['unthunk_include_in_menu'] ) ? '1' : '0' );
} );

// Retain editing of release-to-track relationships without the old theme's Meta Box library.
add_action( 'add_meta_boxes_project', function () {
    add_meta_box( 'unthunk-tracks', 'Release tracks', function ( $post ) {
        wp_nonce_field( 'unthunk_tracks', 'unthunk_tracks_nonce' );
        $selected = array();
        foreach ( get_post_meta( $post->ID, 't_one_track', false ) as $value ) { $selected = array_merge( $selected, array_map( 'absint', (array) $value ) ); }
        echo '<p>Select tracks belonging to this release. Existing track order is preserved.</p><input type="hidden" name="unthunk_tracks_present" value="1">';
        foreach ( get_posts( array( 'post_type' => 'tracks', 'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC' ) ) as $track ) {
            echo '<label style="display:block"><input type="checkbox" name="unthunk_tracks[]" value="' . absint( $track->ID ) . '" ' . checked( in_array( $track->ID, $selected, true ), true, false ) . '> ' . esc_html( $track->post_title ) . '</label>';
        }
    }, 'project', 'side' );
} );
add_action( 'save_post_project', function ( $id ) {
    if ( wp_is_post_revision( $id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $id ) || empty( $_POST['unthunk_tracks_present'] ) || empty( $_POST['unthunk_tracks_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['unthunk_tracks_nonce'] ) ), 'unthunk_tracks' ) ) { return; }
    $new = array_values( array_unique( array_filter( array_map( 'absint', isset( $_POST['unthunk_tracks'] ) ? (array) $_POST['unthunk_tracks'] : array() ), function ( $track ) { return get_post_type( $track ) === 'tracks'; } ) ) );
    $old = array(); foreach ( get_post_meta( $id, 't_one_track', false ) as $value ) { $old = array_merge( $old, array_map( 'absint', (array) $value ) ); }
    $ordered = array_values( array_unique( array_merge( array_intersect( $old, $new ), $new ) ) );
    delete_post_meta( $id, 't_one_track' ); foreach ( $ordered as $track ) { add_post_meta( $id, 't_one_track', $track ); }
} );

add_shortcode( 'unthunk_contact', function () {
    ob_start();
    $state = isset( $_GET['unthunk_contact'] ) ? sanitize_key( wp_unslash( $_GET['unthunk_contact'] ) ) : '';
    if ( $state ) { echo '<p class="un-notice" role="status">' . esc_html( $state === 'sent' ? 'Thank you. Your message has been sent.' : 'Your message could not be sent. Please try again shortly.' ) . '</p>'; }
    ?>
    <form class="un-contact" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
        <input type="hidden" name="action" value="unthunk_contact">
        <?php wp_nonce_field( 'unthunk_contact', 'unthunk_nonce' ); ?>
        <label for="un-name">Name</label><input id="un-name" name="name" autocomplete="name" maxlength="120" required>
        <label for="un-email">Email</label><input id="un-email" name="email" type="email" autocomplete="email" maxlength="254" required>
        <label for="un-phone">Phone (optional)</label><input id="un-phone" name="phone" type="tel" autocomplete="tel" maxlength="60">
        <label for="un-message">Message</label><textarea id="un-message" name="message" rows="6" maxlength="10000" required></textarea>
        <div class="un-trap" aria-hidden="true"><label for="un-website">Leave this field empty</label><input id="un-website" name="website" tabindex="-1" autocomplete="off"></div>
        <button type="submit">Send message</button>
    </form>
    <?php return ob_get_clean();
} );
function unthunk_contact_submit() {
    $status = 'error';
    $nonce = isset( $_POST['unthunk_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['unthunk_nonce'] ) ) : '';
    $name = isset( $_POST['name'] ) ? sanitize_text_field( wp_unslash( $_POST['name'] ) ) : '';
    $email = isset( $_POST['email'] ) ? sanitize_email( wp_unslash( $_POST['email'] ) ) : '';
    $message = isset( $_POST['message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['message'] ) ) : '';
    $phone = isset( $_POST['phone'] ) ? sanitize_text_field( wp_unslash( $_POST['phone'] ) ) : '';
    $rate_key = 'unthunk_contact_' . hash_hmac( 'sha256', isset( $_SERVER['REMOTE_ADDR'] ) ? $_SERVER['REMOTE_ADDR'] : '', wp_salt() );
    if ( wp_verify_nonce( $nonce, 'unthunk_contact' ) && empty( $_POST['website'] ) && $name && is_email( $email ) && $message && strlen( $message ) <= 10000 && ! get_transient( $rate_key ) ) {
        set_transient( $rate_key, 1, MINUTE_IN_SECONDS );
        $options = get_option( 't_one_options', array() );
        $recipient = is_array( $options ) && ! empty( $options['contact_email'] ) ? sanitize_email( $options['contact_email'] ) : get_option( 'admin_email' );
        if ( is_email( $recipient ) && wp_mail( $recipient, 'Unthunk website message', "Name: $name\nEmail: $email\nPhone: $phone\n\n$message", array( 'Reply-To: ' . $email ) ) ) { $status = 'sent'; }
    }
    wp_safe_redirect( home_url( '/?unthunk_contact=' . $status . '#contact' ) ); exit;
}
add_action( 'admin_post_unthunk_contact', 'unthunk_contact_submit' );
add_action( 'admin_post_nopriv_unthunk_contact', 'unthunk_contact_submit' );

// Musicians are independent of the theme; title, featured image and editor hold
// the name, image and optional description.
add_action( 'init', function () {
    register_post_type( 'musician', array(
        'labels' => array( 'name' => 'Musicians', 'singular_name' => 'Musician', 'add_new_item' => 'Add Musician', 'edit_item' => 'Edit Musician' ),
        'public' => true, 'show_in_rest' => true, 'menu_icon' => 'dashicons-groups',
        'rewrite' => array( 'slug' => 'musicians', 'with_front' => false ),
        'supports' => array( 'title', 'editor', 'thumbnail', 'revisions', 'page-attributes' ),
    ) );
}, 20 );
add_filter( 'enter_title_here', function ( $text, $post ) { return $post->post_type === 'musician' ? 'Name' : $text; }, 10, 2 );
add_action( 'add_meta_boxes_musician', function () {
    add_meta_box( 'unthunk-musician-details', 'Musician details', function ( $post ) {
        wp_nonce_field( 'unthunk_musician', 'unthunk_musician_nonce' );
        echo '<p><label for="unthunk-instrument">Instrument</label><br><input class="widefat" id="unthunk-instrument" name="unthunk_instrument" value="' . esc_attr( get_post_meta( $post->ID, '_unthunk_instrument', true ) ) . '"></p>';
        echo '<p><label><input type="checkbox" name="unthunk_musician_active" value="1" ' . checked( get_post_meta( $post->ID, '_unthunk_musician_active', true ), '1', false ) . '> Active</label></p>';
        echo '<p><label><input type="checkbox" name="unthunk_musician_homepage" value="1" ' . checked( get_post_meta( $post->ID, '_unthunk_musician_homepage', true ) !== '0', true, false ) . '> Include on homepage</label></p>';
        echo '<p class="description">Use the title for Name, the featured image for Image, and the main editor for an optional description. This checkbox only controls the homepage.</p>';
    }, 'musician', 'side', 'high' );
} );
add_action( 'save_post_musician', function ( $id ) {
    if ( wp_is_post_revision( $id ) || ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $id ) || empty( $_POST['unthunk_musician_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['unthunk_musician_nonce'] ) ), 'unthunk_musician' ) ) { return; }
    update_post_meta( $id, '_unthunk_instrument', sanitize_text_field( wp_unslash( $_POST['unthunk_instrument'] ?? '' ) ) );
    update_post_meta( $id, '_unthunk_musician_active', isset( $_POST['unthunk_musician_active'] ) ? '1' : '0' );
    update_post_meta( $id, '_unthunk_musician_homepage', isset( $_POST['unthunk_musician_homepage'] ) ? '1' : '0' );
} );
add_filter( 'manage_musician_posts_columns', function ( $columns ) { $columns['unthunk_instrument'] = 'Instrument'; $columns['unthunk_active'] = 'Active'; $columns['unthunk_homepage'] = 'Homepage'; return $columns; } );
add_action( 'manage_musician_posts_custom_column', function ( $column, $id ) {
    if ( $column === 'unthunk_instrument' ) { echo esc_html( get_post_meta( $id, '_unthunk_instrument', true ) ); }
    if ( $column === 'unthunk_active' ) { echo get_post_meta( $id, '_unthunk_musician_active', true ) === '1' ? 'Yes' : 'No'; }
    if ( $column === 'unthunk_homepage' ) { echo get_post_meta( $id, '_unthunk_musician_homepage', true ) === '0' ? 'No' : 'Yes'; }
}, 10, 2 );
// One-time migration includes every child profile, even those absent from the menu.
// IDs, slugs, publication status and full original content are retained.
add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) || get_option( 'unthunk_musicians_migrated_v1' ) ) { return; }
    $parent = get_page_by_path( 'musicians' );
    if ( ! $parent ) { return; }
    $profiles = get_posts( array( 'post_type' => 'page', 'post_parent' => $parent->ID, 'post_status' => array( 'publish', 'draft', 'private', 'pending', 'future' ), 'numberposts' => -1, 'orderby' => 'menu_order', 'order' => 'ASC' ) );
    $locations = get_nav_menu_locations();
    $items = ! empty( $locations['primary'] ) ? wp_get_nav_menu_items( $locations['primary'] ) : array();
    $rank = array(); foreach ( (array) $items as $item ) { $rank[absint( $item->object_id )] = $item->menu_order; }
    foreach ( $profiles as $profile ) {
        $original = $profile->post_content;
        add_post_meta( $profile->ID, '_unthunk_original_profile_content', $original, true );
        $image = get_post_thumbnail_id( $profile->ID );
        if ( ! $image && preg_match( '/<img[^>]+src=["\x27]([^"\x27]+)/i', $original, $match ) ) {
            $url = preg_replace( '/-\d+x\d+(?=\.[^.]+$)/', '', html_entity_decode( $match[1] ) );
            $url = preg_replace( '#https?://(?:stg\.)?unthunk\.ca#', home_url(), $url );
            $image = attachment_url_to_postid( $url );
        }
        if ( ! $image && preg_match( '/wp-image-(\d+)/', $original, $match ) ) { $image = absint( $match[1] ); }
        if ( $image ) { set_post_thumbnail( $profile->ID, $image ); }
        $text = preg_replace( '#<a\b[^>]*>\s*<img\b[^>]*>\s*</a>|<img\b[^>]*>#is', '', $original );
        $text = trim( preg_replace( '#<!--.*?-->|<hr\b[^>]*>|<figure\b[^>]*>\s*</figure>#is', '', $text ) );
        $plain = trim( wp_strip_all_tags( $text ) );
        // Short legacy bios contain just an instrument; longer prose stays editable.
        $instrument = strlen( $plain ) <= 90 ? $plain : '';
        if ( $profile->post_name === 'trevor-tunnacliffe' ) { $instrument = 'Bass guitar, guitar, baritone guitar'; }
        update_post_meta( $profile->ID, '_unthunk_instrument', $instrument );
        update_post_meta( $profile->ID, '_unthunk_musician_homepage', '1' );
        wp_update_post( array( 'ID' => $profile->ID, 'post_type' => 'musician', 'post_parent' => 0, 'post_content' => $instrument === $plain ? '' : $text, 'menu_order' => $rank[$profile->ID] ?? ( 100 + $profile->menu_order ) ) );
        foreach ( (array) $items as $item ) {
            if ( absint( $item->object_id ) === $profile->ID && $item->type === 'post_type' ) { update_post_meta( $item->ID, '_menu_item_object', 'musician' ); }
        }
    }
    update_option( 'unthunk_musicians_migrated_v1', 1 );
    flush_rewrite_rules();
} );

// Initialize the requested flags once from the existing Musicians submenu.
// Later checkbox edits remain independent of navigation membership.
add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) || get_option( 'unthunk_musician_active_initialized_v2' ) ) { return; }
    $locations = get_nav_menu_locations();
    if ( empty( $locations['primary'] ) ) { return; }
    $items = wp_get_nav_menu_items( $locations['primary'] );
    $page = get_page_by_path( 'musicians' );
    if ( ! $page ) { return; }
    $parent = 0;
    foreach ( (array) $items as $item ) { if ( absint( $item->object_id ) === $page->ID ) { $parent = $item->ID; break; } }
    if ( ! $parent ) { return; }
    foreach ( get_posts( array( 'post_type' => 'musician', 'post_status' => array( 'publish', 'draft', 'private', 'pending', 'future' ), 'numberposts' => -1, 'fields' => 'ids' ) ) as $id ) {
        update_post_meta( $id, '_unthunk_musician_active', '0' );
        update_post_meta( $id, '_unthunk_musician_homepage', '0' );
    }
    // Snapshot of the seven submenu profiles selected by the administrator.
    foreach ( array( 1026, 288, 1024, 997, 34, 2131, 25 ) as $id ) {
        if ( get_post_type( $id ) === 'musician' ) {
            update_post_meta( $id, '_unthunk_musician_active', '1' );
            update_post_meta( $id, '_unthunk_musician_homepage', '1' );
        }
    }
    update_option( 'unthunk_musician_active_initialized_v2', 1 );
} );

// Move the existing posts page and insert an editable News navigation item once.
add_action( 'admin_init', function () {
    if ( ! current_user_can( 'manage_options' ) || get_option( 'unthunk_blog_menu_migrated_v1' ) ) { return; }
    $blog = absint( get_option( 'page_for_posts' ) );
    $locations = get_nav_menu_locations();
    if ( ! $blog || empty( $locations['primary'] ) ) { return; }
    $result = wp_update_post( array( 'ID' => $blog, 'post_parent' => 0, 'post_name' => 'blog' ), true );
    if ( is_wp_error( $result ) ) { return; }
    $menu = $locations['primary'];
    $items = wp_get_nav_menu_items( $menu );
    $about = get_page_by_path( 'about-us' );
    $news = 0;
    foreach ( (array) $items as $item ) { if ( absint( $item->object_id ) === $blog && $item->type === 'post_type' ) { $news = $item->ID; break; } }
    $news = wp_update_nav_menu_item( $menu, $news, array( 'menu-item-object-id' => $blog, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-title' => 'News', 'menu-item-parent-id' => 0, 'menu-item-status' => 'publish' ) );
    if ( is_wp_error( $news ) ) { return; }
    $position = 1;
    foreach ( (array) $items as $item ) {
        if ( $item->ID === $news ) { continue; }
        wp_update_post( array( 'ID' => $item->ID, 'menu_order' => $position++ ) );
        if ( $about && absint( $item->object_id ) === $about->ID ) { wp_update_post( array( 'ID' => $news, 'menu_order' => $position++ ) ); }
    }
    update_option( 'unthunk_blog_menu_migrated_v1', 1 );
    flush_rewrite_rules();
} );
// Keep bookmarks and paginated links to the former blog address working.
add_action( 'template_redirect', function () {
    $path = wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH );
    if ( preg_match( '#^/about-us/blog(/.*)?$#', $path, $match ) ) {
        wp_safe_redirect( home_url( '/blog' . ( $match[1] ?? '/' ) ), 301 );
        exit;
    }
}, 1 );

require_once __DIR__ . '/listen.php';
