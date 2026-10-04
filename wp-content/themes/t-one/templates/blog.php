<?php global $t_one_opt; ?>
<section id="news" class="space">
	<div class="overlay"></div>
    <div class="container">
		<?php $args = array(
            'orderby' => 'post_date',
            'order' => 'DESC',
            'post_type' => 'post',
	    'posts_per_page' => 3
        );
        $the_query = new WP_Query($args); while ($the_query->have_posts()): $the_query->the_post(); ?>
        <div class="row post-row">
            <div class="col-sm-2">
                <aside class="post-date"><?php echo get_the_date() ?></aside>
            </div>
            <div class="excerpt col-sm-9">
                <h3 class="post-title">
                    <a href="<?php the_permalink() ?>" title="#"><?php the_title(); ?></a>
                </h3>
                <?php the_excerpt(); ?>
            </div>
        </div>
        <!-- .post row -->
        <?php endwhile; wp_reset_query(); ?>
<a style="color: #26292A;" href="<?php echo get_permalink( get_option('page_for_posts' ) ); ?>">All Posts &raquo;</a>
	</div>
</section>
<!-- end: News -->