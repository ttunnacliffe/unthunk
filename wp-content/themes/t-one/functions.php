<?php
/*-----------------------------------------------------
 * Includes
 * -------------------------------------------------------------------------- */
if ( file_exists( get_template_directory() . '/inc/Metabox/meta-box.php' ) ) {
	require_once get_template_directory() . '/inc/Metabox/meta-box.php';
}
if ( file_exists( get_template_directory() . '/inc/metabox.php' ) ) {
	require_once get_template_directory() . '/inc/metabox.php';
}
if ( !class_exists( 'ReduxFramework' ) && file_exists( get_template_directory() . '/inc/ReduxFramework/ReduxCore/framework.php' ) ) {
    require_once( get_template_directory() . '/inc/ReduxFramework/ReduxCore/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( get_template_directory() . '/inc/theme-options.php' ) ) {
    require_once( get_template_directory() . '/inc/theme-options.php' );
}
if ( file_exists( get_template_directory() . '/inc/post-types.php' ) ) {
	require_once get_template_directory() . '/inc/post-types.php';
}
if ( file_exists( get_template_directory() . '/inc/widgets.php' ) ) {
	require_once get_template_directory() . '/inc/widgets.php';
}
if ( file_exists( get_template_directory() . '/inc/author.php' ) ) {
	require_once get_template_directory() . '/inc/author.php';
}
if ( file_exists( get_template_directory() . '/inc/breadcrumbs.php' ) ) {
	require_once get_template_directory() . '/inc/breadcrumbs.php';
}
if ( file_exists( get_template_directory() . '/inc/comments.php' ) ) {
	require_once get_template_directory() . '/inc/comments.php';
}
if ( file_exists( get_template_directory() . '/inc/custom-post-lists.php' ) ) {
	require_once get_template_directory() . '/inc/custom-post-lists.php';
}
if ( file_exists( get_template_directory() . '/inc/pagination.php' ) ) {
	require_once get_template_directory() . '/inc/pagination.php';
}
if ( file_exists( get_template_directory() . '/inc/post-views.php' ) ) {
	require_once get_template_directory() . '/inc/post-views.php';
}
if ( file_exists( get_template_directory() . '/inc/ajax-contact-form.php' ) ) {
	require_once get_template_directory() . '/inc/ajax-contact-form.php';
}
if ( file_exists( get_template_directory() . '/inc/recaptchalib.php' ) ) {
	require_once get_template_directory() . '/inc/recaptchalib.php';
}

/* -----------------------------------------------------------------------------
 * Setup theme
 * -------------------------------------------------------------------------- */
if ( !function_exists('t_one_theme_setup') ) {
	
	function t_one_theme_setup(){
		
		/*CONTENT WIDTH*/
		if ( ! isset( $content_width ) ) {
			$content_width = 700;
		}
		
		load_theme_textdomain('t_one', get_template_directory_uri() . '/languages');
		
		/* HTML5 */
		add_theme_support( 'html5', array( 'comment-form' ) );
		
		
		/* == AUTOMATICS FEED == */
		add_theme_support( 'automatic-feed-links' );
		
		/* THUMBNAILS SUPPORT AND SIZES */
		add_theme_support( 'post-thumbnails' );
		add_image_size ('t_one-100','100','9999',false);
		add_image_size ('t_one-500','500','9999',false);
		add_image_size ('t_one-1000','1000','9999',false);
		add_image_size ('t_one-1400','1400','9999',false);
		
		/* == MENUS == */
		register_nav_menus( array('main-menu-left' => __('Main menu left', 't_one'), 'main-menu-right' => __('Main menu right', 't_one') ));
		
		/* == SIDEBARS == */
		register_sidebar(array(
			'name' => __( 'Default Sidebar', 't_one'),
			'before_widget' => '<div class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="heading">',
			'after_title' => '</h4>',
		));
		
		register_sidebar(array(
			'name' => __( 'Footer Sidebar', 't_one'),
			'id' => 'sidebar-footer',
			'class'  => 'list-unstyled',
			'before_widget' => '<div class="col-sm-2"><div id="%1$s" class="footer-inner %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h4 class="heading">',
			'after_title' => '</h4>',
		));
		
	}
	
}
add_action('after_setup_theme', 't_one_theme_setup');


/* -----------------------------------------------------------------------------
 * Styles
 * -------------------------------------------------------------------------- */
add_action('wp_enqueue_scripts', 't_one_add_styles');
function t_one_add_styles () {
	global $t_one_opt;
	
	//bootstrap
	wp_register_style( 'bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
	wp_enqueue_style( 'bootstrap' );
	
	//animate
	wp_register_style( 'animate', get_template_directory_uri() . '/assets/css/animate.css');
	wp_enqueue_style( 'animate' );
	
	//font awesome
	wp_register_style( 'font_awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css');
	wp_enqueue_style( 'font_awesome' );
	
	//owl carousel
	wp_register_style( 'owl_carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css');
	wp_enqueue_style( 'owl_carousel' );

	//owl theme
	wp_register_style( 'owl_theme', get_template_directory_uri() . '/assets/css/owl.theme.css');
	wp_enqueue_style( 'owl_theme' );
	
	//flexslider
	wp_register_style( 'flexslider', get_template_directory_uri() . '/assets/css/flexslider.css');
	wp_enqueue_style( 'flexslider' );
	
	//magnific-popup
	wp_register_style( 'magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css');
	wp_enqueue_style( 'magnific-popup' );
	
	//t_one style
	wp_register_style( 'style', get_template_directory_uri() . '/style.css');
	wp_enqueue_style( 'style' );
		
}

add_action('wp_enqueue_scripts', 't_one_add_inline_styles');
function t_one_add_inline_styles () {
	global $t_one_opt;
		
	$color = $t_one_opt['primary'];
	$color_rgb = t_one_hex2RGB($color, true);
	
	$custom_css = '#extra-info .overlay { background-color: rgba(' . $color_rgb . ', 0.96)}';
	
	if ( is_admin_bar_showing() ) { 
	$custom_css .= '.navbar{ top:32px; }';
	} 
	
	wp_add_inline_style( 'style', $custom_css );
	
}


/* -----------------------------------------------------------------------------
 * Scripts
 * -------------------------------------------------------------------------- */
add_action('wp_enqueue_scripts', 't_one_add_scripts');
function t_one_add_scripts(){ 
	
	// comments reply script
	if ( is_singular() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply', '', array( 'jquery' ), '', true ); 
	}

	//bootstrap
	wp_register_script('bootstrap', get_template_directory_uri(). '/assets/js/bootstrap.min.js', array( 'jquery' ), '', true);
	wp_enqueue_script('bootstrap');

	//pace
	wp_register_script('pace', get_template_directory_uri(). '/assets/js/pace.min.js', array( 'jquery' ), '', true);
	wp_enqueue_script('pace');
	
	//owl-carousel
	wp_register_script('owl-carousel', get_template_directory_uri(). '/assets/js/owl.carousel.min.js', array( 'jquery' ), '', true);
	wp_enqueue_script('owl-carousel');
	
	//smoothscroll
	wp_register_script('smoothscroll', get_template_directory_uri(). '/assets/js/smoothscroll.js', array( 'jquery' ), '', true);
	wp_enqueue_script('smoothscroll');

	//easing
	wp_register_script('easing', get_template_directory_uri(). '/assets/js/jquery.easing-1.3.pack.js', array( 'jquery' ), '', true);
	wp_enqueue_script('easing');

	//isotope
	wp_register_script('isotope', get_template_directory_uri(). '/assets/js/isotope.min.js', array( 'jquery' ), '', true);
	wp_enqueue_script('isotope');
	
	//sticky
	wp_register_script('sticky', get_template_directory_uri(). '/assets/js/jquery.sticky.js', array( 'jquery' ), '', true);
	wp_enqueue_script('sticky');
	
	//flexslider
	wp_register_script('flexslider', get_template_directory_uri(). '/assets/js/jquery.flexslider.js', array( 'jquery' ), '', true);
	wp_enqueue_script('flexslider');
	
	//magnific-popup
	wp_register_script('magnific-popup', get_template_directory_uri(). '/assets/js/jquery.magnific-popup.min.js', array( 'jquery' ), '', true);
	wp_enqueue_script('magnific-popup');
	
	//t-one
	wp_register_script('t-one', get_template_directory_uri(). '/assets/js/t-one.js', array( 'jquery' ), '', true);
	wp_enqueue_script('t-one');
	
}

/* -----------------------------------------------------------------------------
 * Filters
 * -------------------------------------------------------------------------- */
add_filter( 'nav_menu_link_attributes', 'filter_function_name', 10, 3 );
function filter_function_name( $atts, $item, $args ) {
	if ( !is_page_template('templates/home-page.php')  )
    $atts = str_replace('#', home_url() . '#' , $atts);
    return $atts;
}

add_filter( 'get_avatar', 't_one_get_avatar' );
function t_one_get_avatar( $avatar ) {
    $avatar = str_replace('avatar-100', 'avatar-100 img-circle', $avatar);
    return $avatar;
}

add_filter( 'wp_nav_menu', 'add_menuclass_dropdown' );
function add_menuclass_dropdown( $class ) {
  return preg_replace( '/menu-item-has-children/', 'menu-item-has-children dropdown', $class, 1 );
}

add_filter( 'wp_nav_menu', 'add_menuclass_dropdown_menu' );
function add_menuclass_dropdown_menu( $class ) {
   return preg_replace( '/sub-menu/', 'sub-menu dropdown-menu', $class, 1 );
}

add_filter('wp_list_categories', 't_one_add_count_span');
function t_one_add_count_span($links) {
  $links = str_replace('</a> (', '</a> <span class="count">(', $links);
  $links = str_replace(')', ')</span>', $links);
  return $links;
}

add_filter('wp_dropdown_cats', 't_one_add_bootstrap_categories');
function t_one_add_bootstrap_categories($args) {
  $args = str_replace('postform', 'postform form-control', $args);
  return $args;
}

add_filter('get_archives_link', 't_one_archive_count_span');
function t_one_archive_count_span($links) {
$links = str_replace('</a>&nbsp;(', '</a> <span class="count">(', $links);
$links = str_replace(')', ')</span>', $links);
return $links;
}

add_filter('get_image_tag_class','t_one_add_image_class');
function t_one_add_image_class($class){
	$class .= ' img-responsive';
	return $class;
}

add_filter( 'avatar_defaults', 'custom_avatar' );
function custom_avatar($avatar_defaults){
	$custom_avatar = get_stylesheet_directory_uri() . '/images/team-2.jpg';
	$avatar_defaults[$custom_avatar] = "T-one Avatar";
	return $avatar_defaults;
}

/* == CUSTOM EXCERPT == */
add_filter('excerpt_more', 't_one_excerpt_more');
function t_one_excerpt_more( $more ) {
	return '...';
}

add_filter( 'excerpt_length', 't_one_excerpt_length', 999 );
function t_one_excerpt_length( $length ) {
	global $t_one_opt;
	return $t_one_opt['excerpt_lenght'];
}

add_filter( 'wp_title', 't_one_wp_title_for_home' );
function t_one_wp_title_for_home( $title ) {
  if( empty( $title ) && ( is_home() || is_front_page() ) ) {
    return get_bloginfo( 'name' ) ;
  }
  return $title;
}

/* -----------------------------------------------------------------------------
 * Helper functions
 * -------------------------------------------------------------------------- */
//get date link in aproppiate format
function t_one_display_date_link () {

	$archive_year  = get_the_time('Y'); 
	$archive_month = get_the_time('m'); 
	$archive_day   = get_the_time('d'); 
	
	$output = '<a href="' . get_day_link( $archive_year, $archive_month, $archive_day) . '">' .  get_the_date() . '</a>';
	
	return $output;

}
//Convert hexadecimal color to rgb color
function t_one_hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
    $hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
    $rgbArray = array();
    if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
        $colorVal = hexdec($hexStr);
        $rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
        $rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
        $rgbArray['blue'] = 0xFF & $colorVal;
    } elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
        $rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
        $rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
        $rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
    } else {
        return false; //Invalid hex color code
    }
    return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}


/* -----------------------------------------------------------------------------
 *Some other actions
 * -------------------------------------------------------------------------- */
//Tracking code
add_action('wp_enqueue_scripts', 't_one_tracking_code');
function t_one_tracking_code() { 
	global $t_one_opt;
	if (!empty($t_one_opt['tracking-code'])) {
		echo $t_one_opt['tracking-code'];
	}
}

//Custom css
add_action('wp_enqueue_scripts', 't_one_custom_css');
function t_one_custom_css() { 
	global $t_one_opt;
	if (!empty($t_one_opt['css-code'])) {
		$custom_css = $t_one_opt['css-code'];
	}
	
	wp_add_inline_style( 'style', $custom_css );
}

//Custom js
add_action('wp_enqueue_scripts', 't_one_custom_js');
function t_one_custom_js() { 
	global $t_one_opt;
	if (!empty($t_one_opt['js-code'])) {
		echo '<script type="text/javascript">' . $t_one_opt['js-code'] . '</script>';
	}
}

/* -----------------------------------------------------------------------------
 * Custom functions
 * -------------------------------------------------------------------------- */
//Custom thumbnail image get
function t_one_image_remove_size() {
	global $post;
	$thumb = get_the_post_thumbnail($post->ID, 't_one-1000', array( 'class' => "parallax-bg" ));
	$thumb = preg_replace( '/(width|height)=\"\d*\"\s/', "", $thumb );
	return $thumb;
}

// Register Custom Post Type
function tracks_post_type() {

	$labels = array(
		'name'                => _x( 'Tracks', 'Post Type General Name', 'text_domain' ),
		'singular_name'       => _x( 'Track', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'           => __( 'Tracks', 'text_domain' ),
		'parent_item_colon'   => __( 'Parent Track:', 'text_domain' ),
		'all_items'           => __( 'All Tracks', 'text_domain' ),
		'view_item'           => __( 'View Track', 'text_domain' ),
		'add_new_item'        => __( 'Add New Track', 'text_domain' ),
		'add_new'             => __( 'Add New Track', 'text_domain' ),
		'edit_item'           => __( 'Edit Track', 'text_domain' ),
		'update_item'         => __( 'Update Track', 'text_domain' ),
		'search_items'        => __( 'Search Track', 'text_domain' ),
		'not_found'           => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
	);
	$args = array(
		'label'               => __( 'tracks', 'text_domain' ),
		'description'         => __( 'Music tracks pages', 'text_domain' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'trackbacks', 'revisions', 'custom-fields', 'page-attributes', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'tracks', $args );

}

// Hook into the 'init' action
add_action( 'init', 'tracks_post_type', 0 );

function load_fonts() {
            wp_register_style('prostoOne', 'http://fonts.googleapis.com/css?family=Prosto+One');
            wp_enqueue_style( 'prostoOne');
            wp_register_style('lora', 'http://fonts.googleapis.com/css?family=Lora');
            wp_enqueue_style( 'lora');
        }
    
    add_action('wp_print_styles', 'load_fonts');


 //Allow shortcodes in widgets
add_filter ('footer_text', 'do_shortcode');

function year_shortcode () {
$year = date_i18n ('Y');
return $year;
}
add_shortcode ('year', 'year_shortcode');

// Fix theme problem
add_action( 'admin_enqueue_scripts', function() {

    wp_add_inline_script(
        'jquery-core',
        'window.jQuery = window.jQuery || {};
         jQuery.browser = jQuery.browser || {};
         jQuery.browser.msie = false;'
    );

});

add_action( 'admin_enqueue_scripts', function() {

    wp_add_inline_script(
        'jquery-core',
        '  
        // Polyfill for deprecated jQuery.live()
        if (typeof jQuery.fn.live === "undefined") {
            jQuery.fn.live = function(event, callback) {
                jQuery(document).on(event, this.selector, callback);
            };
        }

        // Polyfill for deprecated $.browser.msie
        jQuery.browser = jQuery.browser || {};
        jQuery.browser.msie = false;
        '
    );

});