<article class="blog-item" <?php post_class(); ?>>
    <?php if (has_post_thumbnail()) { ?>
        <div class="post-media">
            <a href="<?php the_permalink() ?>"><?php the_post_thumbnail('t_one-1000', array( 'class' => "img-responsive" )); ?></a>
        </div>
    <?php } ?>
    <div class="post-date p-top-40">
        <ul>
            <li class="date">
                <?php echo t_one_display_date_link () ?>
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
<!-- hide post meta
    <div class="post-meta">
        <ul>
            <li>
                <span><?php _e('Posted by ', 't_one' ) ;  the_author_posts_link() ?></span>
            </li>
            <li>
                <span><?php _e( 'In ', 't_one' ) ; the_category(' ') ?></span>
            </li>
        </ul>
    </div>
-->

    <!-- end:Post Meta -->

    <div class="post-entry">
        <?php the_excerpt(); ?>
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

<div>
<hr/>
</div>
    <!-- end:Post Entry -->

</article>