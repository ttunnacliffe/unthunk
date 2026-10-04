<?php
/* -----------------------------------------------------------------------------
 * Pagination
 * -------------------------------------------------------------------------- */
//archives pagination
function t_one_pagination() {
	
	global $wp_query;    

	if ($wp_query->max_num_pages > 1){  
	
		$current_page = max(1, get_query_var('paged'));  
	
		echo '<ul class="pager">';  
		
		$args = array(  
		  'base' => @add_query_arg('paged','%#%'),  
		  'format' => '/paged/%#%',  
		  'current' => $current_page, 
		  'total' => $wp_query->max_num_pages, 
		  'show_all' => false, 
		  'type' => 'list',
		  'prev_text' => '&larr; Newer',  
		  'next_text' => 'Older &rarr;',
		  'paged' => 1 
		);
		echo paginate_links($args);  
	
	  	echo '</ul>';   
	
	}  

}

//post pagination
function t_one_post_pagination() {
	 		
			$in_same_cat = true;
			$previous = get_next_post( $in_same_cat );
			$next = get_previous_post( $in_same_cat );

			if ( ! $next && ! $previous ) {
				return;
			}
	
	 	 ?>
            <ul class="pager">
				<li class="previous"> <?php previous_post_link('%link', '&larr; %title', true) ?> </li>  
                <li class="next"> <?php next_post_link('%link', '%title &rarr;', true) ?> </li>
            </ul>
      <?php

} 
?>