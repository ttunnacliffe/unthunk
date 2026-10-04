<?php 

/**
 * Register meta boxes
 */


add_filter( 'rwmb_meta_boxes', 't_one_register_meta_boxes' );

function t_one_register_meta_boxes( $meta_boxes ) {
	
	/**
	 * Prefix of meta keys (optional)
	 * Use underscore (_) at the beginning to make keys hidden
	 * Alt.: You also can make prefix empty to disable it
	 */
	// Better has an underscore as last sign
	$prefix = 't_one_';

	$meta_boxes[] = array(
		'id' => 'hide',
		'title' => __( 'Hide', 'rwmb' ),
		'pages' => array( 'slide', 'project'),
		'context' => 'side',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			array(
				'name' => __( 'Hide in home page', 'rwmb' ),
				'id'   => "{$prefix}hide",
				'type' => 'checkbox',
				'std'  => 0,
				'size' => '28'
			),		
		),
	);
	
	$meta_boxes[] = array(
		'id' => 'popup',
		'title' => __( 'Show Popup', 'rwmb' ),
		'pages' => array( 'project'),
		'context' => 'side',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			array(
				'name' => __( 'Show image on lightbox on click', 'rwmb' ),
				'id'   => "{$prefix}popup",
				'type' => 'checkbox',
				'std'  => 0,
				'size' => '28'
			),		
		),
	);
	
	$meta_boxes[] = array(
		'id' => 'extra_info',
		'title' => __( 'Extra info', 'rwmb' ),
		'pages' => array( 'slide'),
		'context' => 'side',
		'priority' => 'default',
		'autosave' => false,
		'fields' => array(
			array(
				'name' => __( 'Intro text', 'rwmb' ),
				'id'   => "{$prefix}intro_text",
				'type' => 'text',
				'size' => '28'
			),
			array(
				'name' => __( 'Description', 'rwmb' ),
				'id'   => "{$prefix}description",
				'type' => 'text',
				'size' => '28'
			),		
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'tags',
		'title'      => __( 'Tags', 'rwmb' ),
		'pages'      => array( 'slide', ),
		'context'    => 'side',
		'priority'   => 'default',
		'autosave' => false,
		'fields'     => array(
			array(
				'name' => __( 'Tag 1', 'rwmb' ),
				'id'   => "{$prefix}tag1",
				'type' => 'text',
				'size' => '28'
			),
			array(
				'name' => __( 'Tag 2', 'rwmb' ),
				'id'   => "{$prefix}tag2",
				'type' => 'text',
				'size' => '28'
			),
			array(
				'name' => __( 'Tag 3', 'rwmb' ),
				'id'   => "{$prefix}tag3",
				'type' => 'text',
				'size' => '28'
			),
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'project_details',
		'title'      => __( 'Project Details', 'rwmb' ),
		'pages'      => array( 'project', ),
		'context'    => 'side',
		'priority'   => 'default',
		'autosave' => false,
		'fields'     => array(
			 array(
'name' => 'Tracks',
'desc' => 'Tracks related to this project',
'id' => $prefix . 'track',
'type' => 'post',
'post_type'=> 'tracks',
'std' => '',
'class' => '',
'clone' => true,
),

		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'project_demo',
		'title'      => __( 'Project Demo', 'rwmb' ),
		'pages'      => array( 'project', ),
		'context'    => 'side',
		'priority'   => 'default', 
		'autosave' => false,
		'fields'     => array(
			array(
				'name' => __( 'Text', 'rwmb' ),
				'id'   => "{$prefix}project_button_text",
				'type' => 'text',
				'size' => '28'
			),
			array(
				'name' => __( 'URL', 'rwmb' ),
				'id'   => "{$prefix}project_button_url",
				'type' => 'text',
				'size' => '28'
			),
		),
	);
	
	$meta_boxes[] = array(
		'id'         => 'feature_text',
		'title'      => __( 'Text for home page', 'rwmb' ),
		'pages'      => array( 'feature', ),
		'context'    => 'side',
		'priority'   => 'default', 
		'autosave' => false,
		'fields'     => array(
			array(
				'name' => __( 'Text 1', 'rwmb' ),
				'id'   => "{$prefix}feature_text1",
				'type' => 'text',
				'size' => '28'
			),
			array(
				'name' => __( 'Text 2', 'rwmb' ),
				'id'   => "{$prefix}feature_text2",
				'type' => 'text',
				'size' => '28'
			),
		),
	);

	return $meta_boxes;
} ?>