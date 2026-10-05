<?php
/**
 * Plugin Name: Unthunk Site
 * Description: Preserves Unthunk releases, tracks, legacy URLs and the contact form independently of the theme.
 * Version: 1.0.0
 * License: GPL-2.0-or-later
 */
defined( 'ABSPATH' ) || exit;
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
