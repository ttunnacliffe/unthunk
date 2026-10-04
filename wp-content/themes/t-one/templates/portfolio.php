<?php global $t_one_opt; ?>
<section id="portfolio" class="space">
	<div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <h1><?php echo esc_html( $t_one_opt['portfolio_title'] ) ?></h1>
                <p class="divide-arrow">
                    <img src="<?php echo get_template_directory_uri() . '/images/wave1.png' ?>" alt="">
                </p>
            </div>
        </div>
        <!-- .row -->
        <div id="portfolio-shortcode">
            <div class="portfolio-categories text-center">
                <nav>
                    <ul>
                        <li class="active">
                            <a href="#" data-filter="*">All</a>
                        </li>
                        <?php $filter_tags = get_terms('filter'); 
					 	foreach ($filter_tags as $filter) {?>
                        <li>
                            <a href="#" data-filter=".<?php echo $filter->name ?>"><?php echo $filter->name ?></a>
                        </li>
                       <?php } ?>
                    </ul>
                </nav>
            </div>
            <div id="portfolio-container" class="row">
               
               <?php $args = array(
					'posts_per_page' => -1,
					'orderby' => 'post_date',
					'order' => 'DESC',
					'post_type' => 'project'
				);
				
				$the_query = new WP_Query($args);
       			while ($the_query->have_posts()): $the_query->the_post(); 
				
				$filter_tags = wp_get_post_terms($post->ID, 'filter');
				$tags = array();
				foreach($filter_tags as $tag){
					$tags[] = str_replace(' ', '-', $tag->name);
				}
				$class_tag = implode(' ', $tags);
				$tag = implode(', ', $tags); ?>
                
                <article class="<?php echo $class_tag ?> test isotope-item col-sm-4 col-xs-12">
                	<?php if (has_post_thumbnail()) { ?>
                    <figure>
                        <?php the_post_thumbnail('t_one-500', array( 'class'	=> "img-responsive" ) ) ?>
                        <figcaption>
                        	<?php $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'large');
							$popup =  get_post_meta( $post->ID, 't_one_popup', true );?>
                            <a <?php if($popup == '1') { echo 'class="popup item-hover" href="' . esc_url( $large_image_url[0] ) . '"'; } else { echo  'href="' . get_permalink() . '"'; } ?>>
                                <div class="layer"></div>
                            </a>
                        </figcaption>
                    </figure>
                    <?php } ?>
                    <div class="project-info">
                        <h4><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h4>
                        <p class="p-tags"><?php echo $tag ?></p>
                    </div>
                    <!-- .project info -->
                </article>
                  
                  <?php endwhile; wp_reset_query(); ?>
				</div>
			</div>
            <?php if($t_one_opt['portfolio_cta'] == 1) { ?>
     		<section class="cta">
            	<div class="row">
                	<div class="col-md-8">
                    	<p><?php esc_html_e( $t_one_opt['cta_content'] )?></p>
                    </div>
                    <div class="col-md-4 text-center">
                    	<div class="cta-btn">
                        	<a href="<?php echo esc_url( $t_one_opt['cta_button_url'] )?>" class="btn btn-white"><?php esc_html_e( $t_one_opt['cta_button_text'] )?></a>
                        </div>
                    </div>
                </div>
            </section>
            <?php } ?>
        </div>
	</section>