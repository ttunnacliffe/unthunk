<?php

//POPULAR POSTS
function t_one_popular_posts($num) {

global $post;

$args = array(

	'posts_per_page' => $num,

	'meta_key' => 'post_views_count',

	'orderby' => 'meta_value_num',

	'order'=> 'DESC',

	'suppress_filters' => true,

	'ignore_sticky_posts' => 1,

);

$the_query = new WP_Query($args);

$output = '<div class="side-post"><ul>';

while ($the_query->have_posts()): $the_query->the_post();

$output .= '<li class="posts-list">';

		if ( has_post_thumbnail() ) {

			$output .= get_the_post_thumbnail( $post->ID, 'small', array( 'class' => "img-responsive" ) );

		}

		$output .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a><span class="side-date">' . get_the_date() . '</span></li>';

endwhile;

wp_reset_query();

$output .= '</ul></div>';

return $output;

}

//RECENT POSTS
function t_one_recent_posts($num) {

global $post;

$args = array(

	'posts_per_page' => $num,

	'orderby' => 'post_date',

	'order' => 'DESC',

	'ignore_sticky_posts' => 1,

);

$the_query = new WP_Query($args);

$output = '<div class="side-post"><ul>';

while ($the_query->have_posts()): $the_query->the_post();

$output .= '<li class="posts-list">';

		if ( has_post_thumbnail() ) {

			$output .= get_the_post_thumbnail( $post->ID, 'small', array( 'class' => "img-responsive" ) );

		}

		$output .= '<a href="' . get_permalink() . '" title="' . get_the_title() . '">' . get_the_title() . '</a><span class="side-date">' . get_the_date() . '</span></li>';

endwhile;

wp_reset_query();

$output .= '</ul></div>';

return $output;

}

?>