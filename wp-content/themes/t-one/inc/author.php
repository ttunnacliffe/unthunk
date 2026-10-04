<?php

/* == AUTHOR BIO == */ 
function t_one_author_info() {  
	if (is_single()) {  
	 
		$output = '<div class="author-box well"><div class="media-well">'; 
		 
		//show author avatar 
		
			$output .= '<div class="pull-left">'. get_avatar( get_the_author_meta('ID'), 100 ). '</div>'; 
	
			 
		$output .= '<div class="media-body">'; 
			 
		//show title for the box  
		
			$name =  sprintf('%s', get_the_author_meta( 'display_name' )); 
			$output .= '<div class="media-heading"><strong>' . $name . '</strong></div>'; 

		 
		//show author biography 
       
			$output .= '<p>' . get_the_author_meta( 'description' ) . '</p>'; 

		 
		$output .= '</div></div></div>'; 
		 
		return $output; 
	} 
}
?>