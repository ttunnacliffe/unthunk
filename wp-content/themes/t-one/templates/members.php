<?php global $t_one_opt; ?>
<section id="members">
    <div class="container">
    	<div class="row space">
        
        <?php if (!empty($t_one_opt['members_pages'])) { ?>
           <?php $qn_members_query = new WP_Query(array( 'post_type' => 'page', 'posts_per_page' => -1, 'post__in' => $t_one_opt['members_pages'] ) );
			while ( $qn_members_query->have_posts() ) : $qn_members_query->the_post(); 
			$facebook = esc_url( get_post_meta( get_the_ID(), 't_one_facebook', true ) ); 
			$twitter = esc_url( get_post_meta( get_the_ID(), 't_one_twitter', true ) );
			$google =  esc_url( get_post_meta( get_the_ID(), 't_one_google', true ) );
			$linkedin = esc_url( get_post_meta( get_the_ID(), 't_one_linkedin', true ) );
			?> 
			
            <div class="col-sm-3">
                <div class="team-holder">
                	<?php the_post_thumbnail('t_one-500', array( 'class' => "img-responsive" )); ?>
                    	<div class="team-info">
                                <h4 class="name"><?php the_title() ?></h4>
                                <div class="title"><?php the_content() ?></div>
                                <?php if ( !empty( $facebook ) || !empty( $twitter ) || !empty( $google ) || !empty( $linkedin )) { ?>
                                <div class="social-icons socialIcons">
                                    <ul>
                                    	<?php if ( !empty( $facebook )) { ?>
                                        <li>
                                            <a href="<?php echo $facebook ; ?>" class="fb">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if ( !empty( $twitter )) { ?>
                                        <li>
                                            <a href="<?php echo $twitter ; ?>" class="twitter">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if ( !empty( $google )) { ?>
                                        <li>
                                            <a href="<?php echo $google ; ?>" class="google">
                                                <i class="fa fa-google-plus"></i>
                                            </a>
                                        </li>
                                        <?php } ?>
                                        <?php if ( !empty( $linkedin )) { ?>
                                        <li>
                                            <a href="<?php echo $linkedin ; ?>" class="linkedin">
                                                <i class="fa fa-linkedin"></i>
                                            </a>
                                        </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                 <!-- .social-icons -->
                                <?php } ?>
                            </div>
                            <!-- .team info -->
                        </div>
                        <!-- .team holder -->
                    </div>
                    <!-- .col 3 -->
				<?php endwhile; wp_reset_postdata(); ?>
			<?php } ?>
        </div>
        <!--.row-->
    </div>
    <!--.container-->
</section>