<?php
/** Public submission policy and server-verified reCAPTCHA v2. */
defined( 'ABSPATH' ) || exit;
add_filter( 'pre_option_users_can_register', '__return_zero' );
add_filter( 'pre_option_default_comment_status', function () { return 'closed'; } );
add_filter( 'pre_option_default_ping_status', function () { return 'closed'; } );
add_filter( 'pre_option_default_pingback_flag', '__return_zero' );
add_action( 'pre_comment_on_post', function () { wp_die( 'Comments are disabled.', 'Comments disabled', array( 'response' => 403 ) ); } );
add_filter( 'rest_pre_dispatch', function ( $result, $server, $request ) {
    if ( ! is_user_logged_in() && ! in_array( $request->get_method(), array( 'GET', 'HEAD', 'OPTIONS' ), true ) ) {
        return new WP_Error( 'unthunk_authentication_required', 'Authentication is required for changes.', array( 'status' => 401 ) );
    }
    return $result;
}, 5, 3 );
add_filter( 'xmlrpc_methods', function ( $methods ) {
    unset( $methods['pingback.ping'], $methods['pingback.extensions.getPingbacks'] );
    return $methods;
} );

function unthunk_recaptcha_key( $kind ) {
    $constant = $kind === 'site' ? 'UNTHUNK_RECAPTCHA_SITE_KEY' : 'UNTHUNK_RECAPTCHA_SECRET_KEY';
    return defined( $constant ) ? constant( $constant ) : get_option( 'unthunk_recaptcha_' . $kind, '' );
}
function unthunk_recaptcha_ready() { return unthunk_recaptcha_key( 'site' ) && unthunk_recaptcha_key( 'secret' ); }
function unthunk_recaptcha_verify() {
    if ( ! unthunk_recaptcha_ready() || ( $_SERVER['REQUEST_METHOD'] ?? '' ) !== 'POST' ) { return false; }
    $token = isset( $_POST['g-recaptcha-response'] ) && is_string( $_POST['g-recaptcha-response'] ) ? sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ) : '';
    if ( ! $token || strlen( $token ) > 4096 ) { return false; }
    $response = wp_remote_post( 'https://www.google.com/recaptcha/api/siteverify', array(
        'timeout' => 10,
        'body' => array( 'secret' => unthunk_recaptcha_key( 'secret' ), 'response' => $token ),
    ) );
    if ( is_wp_error( $response ) || wp_remote_retrieve_response_code( $response ) !== 200 ) { return false; }
    $data = json_decode( wp_remote_retrieve_body( $response ), true );
    $host = strtolower( (string) wp_parse_url( home_url(), PHP_URL_HOST ) );
    return is_array( $data ) && ! empty( $data['success'] ) && isset( $data['hostname'] ) && hash_equals( $host, strtolower( $data['hostname'] ) );
}
add_action( 'admin_menu', function () {
    add_options_page( 'Unthunk Security', 'Unthunk Security', 'manage_options', 'unthunk-security', 'unthunk_security_settings' );
} );
function unthunk_security_settings() {
    if ( ! current_user_can( 'manage_options' ) ) { return; }
    if ( isset( $_POST['unthunk_security_save'] ) ) {
        check_admin_referer( 'unthunk_security_settings' );
        update_option( 'unthunk_recaptcha_site', sanitize_text_field( wp_unslash( $_POST['unthunk_recaptcha_site'] ?? '' ) ), false );
        $secret = sanitize_text_field( wp_unslash( $_POST['unthunk_recaptcha_secret'] ?? '' ) );
        // Never redisplay a stored secret. Blank keeps the existing key.
        if ( $secret ) { update_option( 'unthunk_recaptcha_secret', $secret, false ); }
        echo '<div class="notice notice-success"><p>Security settings saved.</p></div>';
    }
    echo '<div class="wrap"><h1>Unthunk Security</h1><p>Public registration, comments and pingbacks are disabled. Changes through the REST API require authentication and WordPress permissions.</p>';
    echo '<h2>Contact form reCAPTCHA</h2><p>Use Google reCAPTCHA v2 (I’m not a robot checkbox), with this site’s domain allowed. The form accepts messages only after Google verification succeeds for this domain. Missing keys or failed verification block submission.</p>';
    echo '<p><strong>Status: ' . ( unthunk_recaptcha_ready() ? 'Keys configured' : 'Keys required — contact submissions blocked' ) . '</strong></p>';
    echo '<form method="post">'; wp_nonce_field( 'unthunk_security_settings' );
    echo '<table class="form-table"><tr><th><label for="unthunk-recaptcha-site">Site key</label></th><td><input class="regular-text" id="unthunk-recaptcha-site" name="unthunk_recaptcha_site" value="' . esc_attr( get_option( 'unthunk_recaptcha_site', '' ) ) . '" autocomplete="off"></td></tr>';
    echo '<tr><th><label for="unthunk-recaptcha-secret">Secret key</label></th><td><input class="regular-text" id="unthunk-recaptcha-secret" name="unthunk_recaptcha_secret" type="password" value="" autocomplete="new-password"><p class="description">Enter directly here. Leave blank to retain the stored key. Never put this key in GitHub.</p></td></tr></table>';
    submit_button( 'Save security settings', 'primary', 'unthunk_security_save' );
    echo '</form></div>';
}
