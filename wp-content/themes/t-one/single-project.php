<?php get_header(); ?>
 <div class="clearfix"></div>
    <!--Project Image Carousel-->
	<section class="project-slide-wrap">
       	<div class="container">
			<div class="row">
      		<?php if ( have_posts() ) : ?>
         	<div id="work" class="carousel slide">
         		<?php while ( have_posts() ) : the_post();
         
        			$attachments = get_post_meta( get_the_ID(), 't_one_project_gallery', false );
					if ( $attachments ) :
					$count = count($attachments); ?>
            		<!-- Indicators -->
            		<ol class="carousel-indicators">
            		<?php for ($i=0;$i<$count;$i++) { ?>
               			<li data-target="#work" data-slide-to="<?php echo $i ?>" class="active"></li>
            		<?php } ?>
            		</ol>
		
                	<!-- Wrapper for slides -->
                    <div class="carousel-inner">
                    <?php $count = 0;
                    foreach( $attachments as $attachment_ID ) :
                        $count++;
                        $full_image_url = wp_get_attachment_image_src( $attachment_ID, 'full' ); ?>
                       <div class="item <?php if ($count == 1) { echo 'active'; } ?>">
                          <!-- class of active since it's the first item -->
                          <img src="<?php echo esc_url( $full_image_url[0] ); ?>" class="img-responsive" alt="Title">    
                       </div>
                       <!--End Item-->
                    <?php endforeach; ?>
                    </div>
                    <!--End Carousel-Inner-->
                    <!-- Controls -->
                    <a class="left carousel-control" href="#work" data-slide="prev">
                    <span class="icon-prev"></span>
                    </a>
                    <a class="right carousel-control" href="#work" data-slide="next">
                    <span class="icon-next"></span>
                    </a>
                    <?php else : endif; ?>
                 </div>
              </div>
           </div>
        </section>
        <div class="container">
            <div class="project-desc-wrap">
                <div class="row">
         			<div class="col-sm-8">
            			<h2><?php the_title() ?></h2>
            			<p><?php the_content() ?></p>
            			<br />
         			</div>
         			<div class="col-sm-3 col-sm-offset-1">
                    	<div class="project-info affix-top" data-spy="affix" data-offset-top="400" data-offset-bottom="200">
                            <h4>Tracks</h4>
                            <?php 
                           $metas = rwmb_meta( 't_one_track' );
                           foreach ( $metas as $meta )
                              {
                              $track = get_post($meta);
                              echo '<p class="delimiter"><a href="' . get_permalink( $meta ) . '">' . $track->post_title . '</a></p>';
                              } ?>
            		</div>
           		</div>
        	</div>
     	</div>
     	<!-- .project description wrap -->
    </div>
    <!-- .container -->
      
<?php endwhile; else:
	
	get_template_part('content', 'none');
		
endif; ?>

<?php get_footer(); ?>