<?php

if ( post_password_required() )
	return;
?>
<?php if(comments_open() || (!comments_open() && get_comments_number() > 0)) : ?>
<div id="comments">
	<?php if ( have_comments() ) : ?>
        <div class="comment-list">
            <h3 class="comments-title">
                <?php comments_number( __('No Comment', 't_one'), __('<span>1</span> Comment', 't_one'), __('<span>%</span> Comments', 't_one') );?>
            </h3>
            <?php
                wp_list_comments( array(
                    'style'      => 'div',
                    'callback' => 't_one_comments_list',
                ) );
            ?>
        </div><!-- .comment-list -->
		
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) { ?>
            <nav class="navigation" role="navigation">
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 't_one' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 't_one' ) ); ?></div>
            </nav>
		<?php }  ?>
		
		<?php if ( !comments_open() && get_comments_number() ) { ?>
			<p class="no-comments"><?php _e( 'Comments are closed.' , 't_one' ); ?></p>
		<?php } ?>
	
	<?php endif; ?>
    
    </div><!-- #comments .comments-area -->
    <hr>
	<?php t_one_comments_form($user_identity) ?>

<?php endif; ?>