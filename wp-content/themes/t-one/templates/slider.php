<?php global $t_one_opt;
$title = $t_one_opt['slider_title'];
$speed = $t_one_opt['slider_speed'];
$direction = ( $t_one_opt['slider_direction_nav'] == 1 ? true : false );
$caption = $t_one_opt['slider_mobile_caption'];
 ?>
<!-- Slider -->
<section id="slider">
    <div class="flexslider" data-speed="<?php echo $speed ?>" data-direction-nav="<?php echo $direction ?>">
         <ul class="slides">
         <?php 
		   $args = array(
			  'posts_per_page' => -1,
			  'orderby' => 'post_date',
			  'order' => 'DESC',
			  'post_type' => 'slide',
			  'meta_query' => array(
				  array(
						'key' => 't_one_hide',
						'value' => '0',
				  ),
			)
		);
		$qn_slider_query = new WP_Query($args);
		while ($qn_slider_query->have_posts()): $qn_slider_query->the_post(); ?>
        	<li>
            	<?php if(has_post_thumbnail()) {
					 	echo t_one_image_remove_size();
				 }?>
                <div class="overlay"></div>
                <div class="container <?php if ( $caption == 0 ) { echo 'hidden-xs'; } ?>">
                    <div class="caption-wrap">
                    	<?php 
							$intro = esc_html ( rwmb_meta( 't_one_intro_text' ) );
							$desc = esc_html ( rwmb_meta( 't_one_description' ) );
							$tag1 = esc_html( rwmb_meta( 't_one_tag1' ) );
							$tag2 = esc_html( rwmb_meta( 't_one_tag2' ) );
							$tag3 = esc_html( rwmb_meta( 't_one_tag3' ) );
						?>
                    	<?php if ( !empty( $intro ) ) { ?>
                        	<p class="line-1"><?php echo $intro ?></p>
                        <?php } ?>
                        <?php if ( $title == 1 ) { ?>
                        <h1 class="line-2"><?php the_title() ?></h1>
                        <?php } ?>
                        <?php if ( !empty( $desc )  ) { ?>
                            <h4 class="line-3"><?php echo $desc ?></h4>
                        <?php } ?>
                        <?php if ( !empty( $tag1 ) || !empty( $tag2 ) ) { ?>
                            <p class="line-5">
                                <a href="#"><?php echo $tag1 ?></a>
                                <a href="#"><?php echo $tag2 ?></a>
                            </p>
                        <?php } ?>
                        <?php if ( !empty( $tag3 ) ) { ?>
                            <p class="line-6"><?php echo $tag3 ?></p>
                        <?php } ?>
                    </div>
                </div>
            </li>
		<?php endwhile; wp_reset_query(); ?>
		</ul>
	</div>
</section>