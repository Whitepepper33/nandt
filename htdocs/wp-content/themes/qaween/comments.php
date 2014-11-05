<?php
/**
 * Template for displaying comments
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

// Do not delete these lines
if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die (_e('Please do not load this page directly. Thanks!', 'qaween'));

	if (!empty($post->post_password)) { // if there's a password
		if ($_COOKIE['wp-postpass_' . COOKIEHASH] != $post->post_password) {  // and it doesn't match the cookie
?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.','qaween') ; ?></p>
<?php
		return;
		}
	}
?>

<?php if ( have_comments() ) : ?>

    <!-- START: COMMENT LIST -->
    <div id="comments" class="comments-area">
		<div class="post-heading">
			<h3><?php comments_number( __('No Comments', 'qaween'), __('1 Comment', 'qaween'), __('% Comments', 'qaween') ); ?></h3>
		</div>
		<h2 class="comments-title"></h2>
    
        <ul class="comments">
            <?php wp_list_comments('callback=warrior_comment_list'); ?>
        </ul>
        
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
			<div class="navigation clearfix">
				<span class="prev"><?php previous_comments_link(__('&larr; Previous', 'qaween'), 0); ?></span>
				<span class="next"><?php next_comments_link(__('Next &rarr;', 'qaween'), 0); ?></span>
			</div>	
		<?php endif; ?>
			
    </div>
    <!-- END: COMMENT LIST -->
    
<?php else : // or, if we don't have comments:
	if ( ! comments_open() ) :
?>
	<?php endif; // end ! comments_open() ?>
		
<?php endif; // end have_comments() ?> 

	<!-- START: RESPOND -->
    <?php if ( comments_open() ) : ?>
	<div class="submit-comment">
		<?php
		$comment_fields = array(
			'author'	=> '<div class="input text"><input type="text" class="text-input" name="author" id="author" value="" placeholder="'. __('Name*', 'qaween') .'" /></div>',
			'email'		=> '<div class="input text"><input type="text" class="text-input" name="email" id="email" value="" placeholder="'. __('Email*', 'qaween') .'" /></div>',
			'url'		=> '<div class="input text"><input type="text" class="text-input" name="url" id="url" value="" placeholder="'. __('Website URL', 'qaween') .'" /></div>',
		);
		comment_form( array(
			'title_reply'			=>	__('Leave a Reply', 'qaween'),
			'comment_notes_before'	=>	'',
			'comment_notes_after'	=>	'',
			'label_submit'			=>	__( 'Submit', 'qaween' ),
			'cancel_reply_link'		=>  __( 'Cancel Reply', 'qaween' ),
			'logged_in_as'			=>  '<p class="logged-user">' . sprintf( __( 'You are logged in as <a href="%1$s">%2$s</a> &#8212; <a href="%3$s">Logout &raquo;</a>', 'qaween' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
			'fields'				=> $comment_fields,
			'comment_field'			=>	'<div class="input textarea"><textarea name="comment" id="comment" placeholder="'. __('Message*', 'qaween') .'"></textarea></div>'
		) );
		?>
	</div>
	<?php endif; ?>
 	<!-- END: RESPOND -->