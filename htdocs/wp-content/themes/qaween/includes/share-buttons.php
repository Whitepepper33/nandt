<?php
/**
 * Template to display sharing buttons
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<?php if( function_exists('the_field') ) : ?>
	<?php if( get_field('qaween_share_buttons') ): ?>
		<!-- AddThis Button BEGIN -->
		<div class="share-buttons">
			<div class="addthis_toolbox addthis_default_style">
				<span class="text"><?php _e('Share this post', 'qaween'); ?></span>
				<a class="addthis_button_facebook" fb:like:layout="button_count"><span class="fa fa-facebook"></span> <label><?php _e('Facebook', 'qaween'); ?></label></a>
				<a class="addthis_button_twitter"><span class="fa fa-twitter"></span> <label><?php _e('Twitter', 'qaween'); ?></label></a>
				<a class="addthis_button_google_plusone_share" g:plusone:size="medium"><span class="fa fa-google-plus"></span> <label><?php _e('Google Plus', 'qaween'); ?></label></a>
				<a class="addthis_button_pinterest_share" pi:pinit:layout="horizontal" pi:pinit:url="<?php echo get_permalink( $post->ID ); ?>"><span class="fa fa-pinterest"></span> <label><?php _e('Pinterest', 'qaween'); ?></label></a>
				<a class="addthis_button_email"><span class="fa fa-envelope"></span> <label><?php _e('Email to a Friend', 'qaween'); ?></label></a>
			</div>
		</div>
		<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>
		<!-- AddThis Button END -->
	<?php endif; ?>
<?php endif; ?>