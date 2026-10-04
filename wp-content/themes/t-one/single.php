<?php get_header(); ?>
<div class="clearfix"></div>

<div class="subheader">
    <div class="overlay-1"></div>
    <div class="container">
     </div>
</div>

<div class="container">
	<div class="row">
    	<div class="col-sm-8">
        	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();  
            	//call to set post views inside the loop
				t_one_set_post_views($post->ID); ?>
				<article class="blog-item" <?php post_class(); ?>>
                	<?php if (has_post_thumbnail()) { ?>
                    	<div class="post-media">
                        	<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('t_one-1000', array( 'class' => "img-responsive" )); ?></a>
                      	</div>
                  	<?php } ?>
                  	<div class="post-date p-top-40">
                      	<ul>
                          	<li class="date">
                              	<?php echo get_the_date() ?>
                          	</li>
<!-- hide comment count
                          	<li class="comments">
                              	<a href="<?php comments_link(); ?>"><?php comments_number(  __('0 comments', 't_one' ), __( '1 comment', 't_one' ), __('% comments', 't_one')  ); ?></a>
                          	</li>
-->
                      	</ul>
                  	</div>
                  	<!-- end:Post date -->
                  	<div class="post-title">
                      	<h2 class="title">
                          	<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                      	</h2>
                  	</div>
                  	<!-- end:Post Title -->
<!-- hide author info
                  	<div class="post-meta">
                      	<ul>
                          	<li>
                              	<span><?php _e('Posted by ', 't_one' ) ;  the_author_posts_link() ?></span>
                          	</li>
                          	<li>
                             	<span><?php _e( 'In ', 't_one' ) ; the_category(', ') ?></span>
                          	</li>
                      	</ul>
                  	</div>
-->
                  	<!-- end:Post Meta -->
                	<div class="post-entry">
						<?php the_content('Read More'); ?>
                    	<?php wp_link_pages(
                            array(
                                'before' => '<div class="post-pager">',
                                'pagelink' => '<span>%</span>',
                                'after' => '</div>',
                                'next_or_number'   => 'next',
                                'nextpagelink'     => __( 'Next &rarr;', 't_one' ),
                                'previouspagelink' => __( '&larr; Previous', 't_one' ),
                            )
                    	); ?>
                	</div>
                	<!-- end:Post Entry -->
				</article>
                
				<div class="blog-tags">
                	<?php $tags = get_the_tags();
						if ($tags) {
						foreach($tags as $tag) {
							$tag_link = get_tag_link($tag->term_id);
							echo '<a href="' . $tag_link . '" class="btn btn-xs btn-default">' . $tag->name . '</a>';
						}
					}?>
		<div class="service-wrap">
<button class="btn btn-xs btn-default" onclick="goBack()">Go Back</button>
<!-- back button -->
		</div>
                </div>
                <!-- end:Post Tags -->
<!-- hide author
               <?php if ( function_exists( 't_one_author_info' ) ) { echo t_one_author_info(); } ?>
			<?php endwhile; t_one_post_pagination(); ?>
                
			<?php if ( comments_open() || get_comments_number()) {
          		comments_template();
        	} ?>
        
       		<?php else:
        
				get_template_part('content', 'none');
            
        	endif; ?>
-->
		</div>
    	<!-- col 8 don't show sidebar -->
    	<?php get_sidebar(); ?>

	</div>
	<!-- row -->
</div>

<!-- container -->
<?php get_footer(); ?>