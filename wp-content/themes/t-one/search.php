<?php get_header(); ?>
<div class="clearfix"></div>
<div class="subheader">
    <div class="overlay-1"></div>
<!-- hide breadcrumbs
    <div class="container">
       <?php if ( function_exists( 't_one_breadcrumbs' ) ) { echo t_one_breadcrumbs(); } ?>    </div>
-->
</div>
<div class="container">
	<div class="row">
    	<div class="col-sm-8">                  
                  <?php if ( have_posts() ) : ?> 
                  
                  <h2 class="subtitle"><?php printf( __( 'Search Results for: %s', 'pukka' ), '<span>' . get_search_query() . '</span>' ) ?></h2>

					<?php while (have_posts()): the_post(); ?>
		
						<?php get_template_part ('content'); ?>
		
					<?php endwhile; ?>
			
						<?php echo t_one_pagination(); ?>
					
					<?php else : ?>
						
						<?php get_template_part('content', 'none'); ?>
					
					<?php endif; ?>
  
               </div>
               <!-- .col 9 -->
               
               <?php get_sidebar(); ?>
            </div>
	<!-- row -->
</div>
<!-- container -->
<?php get_footer(); ?>