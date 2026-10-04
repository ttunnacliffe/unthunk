<?php
/* -----------------------------------------------------------------------------
 * Custom post types
 * -------------------------------------------------------------------------- */
function t_one_slider_custom_post_type() {
  $labels = array(
    'name'               => 'Slides',
    'singular_name'      => 'Slide',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Slide',
    'edit_item'          => 'Edit Slide',
    'new_item'           => 'New Slide',
    'all_items'          => 'All Slides',
    'view_item'          => 'View Slide',
    'search_items'       => 'Search Slides',
    'not_found'          => 'No slides found',
    'not_found_in_trash' => 'No slides found in Trash',
    'parent_item_colon'  => '',
    'menu_name'          => 'Slider'
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'slide' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
  );

  register_post_type( 'slide', $args );
}
add_action( 'init', 't_one_slider_custom_post_type' );

function t_one_portfolio_custom_post_type() {
  $labels = array(
    'name'               => 'Projects',
    'singular_name'      => 'Project',
    'add_new'            => 'Add New',
    'add_new_item'       => 'Add New Project',
    'edit_item'          => 'Edit Project',
    'new_item'           => 'New Project',
    'all_items'          => 'All Projects',
    'view_item'          => 'View Project',
    'search_items'       => 'Search Projects',
    'not_found'          => 'No projects found',
    'not_found_in_trash' => 'No projects found in Trash',
    'parent_item_colon'  => '',
    'menu_name'          => 'Portfolio'
  );

  $args = array(
    'labels'             => $labels,
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'item' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'custom-fields' )
  );

  register_post_type( 'project', $args );
}
add_action( 'init', 't_one_portfolio_custom_post_type' );

// hook into the init action and call create_book_taxonomies when it fires
add_action( 'init', 'create_filter_taxonomies', 0 );
function create_filter_taxonomies() {
	
	$labels = array(
		'name'              => _x( 'filters', 'taxonomy general name', 't_one' ),
		'singular_name'     => _x( 'filter', 'taxonomy singular name', 't_one' ),
		'search_items'      => __( 'Search filters', 't_one' ),
		'all_items'         => __( 'All filters', 't_one' ),
		'parent_item'       => __( 'Parent filter', 't_one' ),
		'parent_item_colon' => __( 'Parent filter:', 't_one' ),
		'edit_item'         => __( 'Edit filter', 't_one' ),
		'update_item'       => __( 'Update filter', 't_one' ),
		'add_new_item'      => __( 'Add New filter', 't_one' ),
		'new_item_name'     => __( 'New Genre filter', 't_one' ),
		'menu_name'         => __( 'Filters', 't_one' ),
	);

	$args = array(
		'hierarchical'      => false,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'filter' ),
	);

	register_taxonomy( 'filter', array( 'project' ), $args );
	
}