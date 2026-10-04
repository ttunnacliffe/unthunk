<?php get_header(); ?>
<div class="clearfix"></div>


<div class="subheader">
    <div class="overlay-1"></div>
    <div class="container">
       <?php if ( function_exists( 't_one_breadcrumbs' ) ) { echo t_one_breadcrumbs(); } ?>    </div>
</div>

<div class="container">
	<div class="row">
    	<div class="col-sm-8">
        	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<article class="blog-item">
                	<?php if (has_post_thumbnail()) { ?>
                    	<div class="post-media">
                        	<a href="<?php the_permalink() ?>"><?php the_post_thumbnail('t_one-1000', array( 'class' => "img-responsive" )); ?></a>
                      	</div>
                  	<?php } ?>
                  	<div class="post-title">
                      	<h2 class="title">
                          	<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                      	</h2>
                  	</div>
                  	<!-- end:Post Title -->
<!-- hide meta
                  	<div class="post-meta">
                      	<ul>
                          	<li>
                              	<span><?php _e('Posted by ', 't_one' ) ;  the_author_posts_link() ?></span>
                          	</li>
                            <li class="date">
                              	<?php echo get_the_date() ?>
                          	</li>
                      	</ul>
                  	</div>
-->
                  	<!-- end:Post Meta -->
                	<div class="post-entry">
						<?php the_content(); ?>
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
                </div>
                <!-- end:Post Tags -->
               <?php if ( function_exists( 'wpb_author_info' ) ) { echo wpb_author_info(); } ?>
			<?php endwhile; t_one_post_pagination(); ?>
        
       		<?php else:
        
				get_template_part('content', 'none');
            
        	endif; ?>
		</div>
    	<!-- col 8 -->
    	<?php get_sidebar(); ?>
	</div>
	<!-- row -->
</div>
<!-- container -->
<?php get_footer(); ?>