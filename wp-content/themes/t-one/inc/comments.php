<?php 
//Custom comments list
function t_one_comments_list( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' : ?>
		<li <?php comment_class(); ?> id="comment<?php comment_ID(); ?>">
			<div class="back-link"><?php comment_author_link(); ?></div>
	<?php
			break;
		default :
	?>
</li>
   <div <?php comment_class('media-well'); ?> id="comment-<?php comment_ID(); ?>">
   		<?php if ($comment->comment_approved == '0') : ?>
			<p><?php _e('Your comment is awaiting moderation.', 't_one') ?></p>
		<?php endif; ?>
       		<div class="pull-left">
          		<?php echo get_avatar( $comment, 100 ); ?>
            </div>
            <div class="media-body">
          		<div class="well">
             		<div class="media-heading">
                		<strong><?php comment_author(); ?></strong>&nbsp; <small><?php printf( __('%1$s', 't_one'), get_comment_date()) ?></small>
						<?php edit_comment_link(__('<i class="fa fa-pencil"></i>Edit', 't_one'), ' ', '' ); ?>
                        <?php comment_reply_link( array_merge( $args, array( 
								'reply_text' => __( '<i class="fa fa-repeat"></i>Reply', 't_one' ),
								'depth' => $depth,
								'max_depth' => $args['max_depth'] 
								) ) ); ?>
             		</div>
             		<p><?php comment_text() ?></p>
            </div>
          
            </div>
    
	<?php // End the default styling of comment
		break;
	endswitch;
}

//Custom comments form
function t_one_comments_form($user_identity) {

	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
	$args = array(
	
	'title_reply'       => '<h3>' . __( 'Leave a Reply', 't_one' ) . '</h3><hr>',
  	'title_reply_to'    => '<h3>' .__( 'Leave a Reply to %s', 't_one' ) . '</h3>',
  	'cancel_reply_link' => '<h3>' .__( 'Cancel Reply', 't_one' ) . '</h3>',
  	'label_submit'      => __( 'Comment', 't_one' ),
	'id_form'			=> 'request',
	
	'comment_field' =>  '<div class="form-group"><textarea name="comment" placeholder="' . __( 'Add your text here', 't_one' ) .
	'" rows="3" class="form-control"></textarea></div>',
	
	'logged_in_as' => '<div class="col-sm-12"><p class="logged-in-as">' .
    sprintf(
    __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ),
      admin_url( 'profile.php' ),
      $user_identity,
      wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) )
    ) . '</p></div>',
	
	'must_log_in' => '<div class="col-sm-12"><p class="must-log-in">' .
    sprintf(
      __( 'You must be <a href="%s">logged in</a> to post a comment.' ),
      wp_login_url( apply_filters( 'the_permalink', get_permalink() ) )
    ) . '</p></div>',

  	'comment_notes_before' => '',

  	'comment_notes_after' => '',
	
	'fields' => apply_filters( 'comment_form_default_fields', array(
			
		'author' =>
		  '<div class="form-group"><input type="text" name="name" placeholder="' . __( 'Name', 't_one' ) . '" id="exampleInputPassword1" class="form-control" value="' . esc_attr( $commenter['comment_author'] ) .  '" size="30"' . $aria_req . '></div>',
		  
		'email' =>
		 '<div class="form-group"><input type="email" name="email" placeholder="' . __( 'Email', 't_one' ) . '" id="exampleInputPassword1" class="form-control" value="' . esc_attr( $commenter['comment_author_email'] ) .  '" size="30"' . $aria_req . '></div>',
		  
	
		'url' =>
		  '<div class="form-group"><input type="text" name="subject" placeholder="' . __( 'Subject', 't_onee' ) . '" id="exampleInputPassword1" class="form-control" value="' . esc_attr( $commenter['comment_author_url'] ) .  '" size="30"' . $aria_req . '></div>',
		  
		)),
	);
 	
	return comment_form($args);
}

?>