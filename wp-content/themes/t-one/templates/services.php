<?php
global $t_one_opt;
$title = esc_html( $t_one_opt['services_title'] );
$content = esc_html( $t_one_opt['services_content'] );
?>
<section id="services">
	<div class="container space">
    	<div class="row">
            <div class="col-sm-8 col-sm-offset-2 text-center">
                <h1 class="heading-style"><?php echo $title ?></h1>
                <p class="divide-arrow">
                    <img src="<?php echo get_template_directory_uri() . '/images/wave1.png' ?>" alt="">
                </p>
                <p class="lead"><?php echo $content ?></p>
            </div>
        </div>
        <div class="row text-center">
         	<?php if(!empty($t_one_opt['services_pages'] ) ) {
				$box = 0;
				$qn_services_query = new WP_Query(array( 'post_type' => 'page', 'posts_per_page' => -1,  'post__in' => $t_one_opt['services_pages'] ) );
				while ( $qn_services_query->have_posts() ) : $qn_services_query->the_post();
				$box++?>
				   <div class="col-sm-3">
						<div class="service-wrap">
                            <div class="icon-wrap">
                                <?php the_post_thumbnail('t_one-500', array( 'class' => "img-responsive icon" )); ?>
                            </div>
                            <div class="service-content data<?php echo $box ?> collapse">
                                <?php the_content() ?>
                            </div>
                            <div class="service-btm">
                                <a data-toggle="collapse" data-target=".data<?php echo $box ?>"><?php the_title() ?></a>
                            </div>
                        </div>
                        <!-- /.service wrap -->
				   </div>
				   <!-- .col3 -->
        		<?php endwhile; wp_reset_postdata(); ?>
             <?php } ?>
    	</div>
	</div>
</section>