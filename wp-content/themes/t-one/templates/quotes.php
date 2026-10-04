<?php global $t_one_opt; ?>
<section class="quote space">
	<div class="container text-center">
    	<div id="quote" class="owl-carousel owl-theme">
        	<?php if (!empty($t_one_opt['quote_pages'] )) { ?>
            	<?php $qn_quote_query = new WP_Query(array( 'post_type' => 'page', 'posts_per_page' => -1, 'post__in' =>$t_one_opt['quote_pages'] ) );
				while ( $qn_quote_query->have_posts() ) : $qn_quote_query->the_post(); ?>
                	<div class="item">
                        <blockquote>
                            <span class="icon-quote" data-icon="\e016"></span>
                            <?php the_content() ?>
                            <small><?php the_title() ?></small>
                        </blockquote>
                    </div>
				<?php endwhile; wp_reset_postdata(); ?>
			<?php } ?>
        </div>
        <!-- end: Carousel -->
    </div>
    <!-- container -->
</section>
<!-- START WORKS SECTION -->