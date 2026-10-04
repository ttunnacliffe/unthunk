<?php 
/*
Template Name: Home Page
*/
?>

<?php get_header(); ?>

<?php
	global $t_one_opt;
	$sections = $t_one_opt['homepage_sections']['enabled'];
	
	foreach ($sections as $section) {
		switch ($section) {
			
			case 'Services':
				get_template_part( 'templates/services' );
			break;
			
			case 'Clients':
				get_template_part( 'templates/clients' );
			break;
			
			case 'Quotes':
				get_template_part( 'templates/quotes' );
			break;
			
			case 'Portfolio':
				get_template_part( 'templates/portfolio' );
			break;
			
			case 'Extra-info':
				get_template_part( 'templates/extra-info' );
			break;
			
			case 'About':
				get_template_part( 'templates/about' );
			break;
			
			case 'Blog':
				get_template_part( 'templates/blog' );
			break;
			
			case 'Contact':
				get_template_part( 'templates/contact-form' );
			break;
		}
	} 
	
	?>  
      
<?php get_footer(); ?>