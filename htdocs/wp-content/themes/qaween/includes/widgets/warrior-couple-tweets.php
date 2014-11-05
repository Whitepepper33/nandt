<?php
/**
 * Couple Tweet widget
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
 
// Widgets
add_action( 'widgets_init', 'warrior_couple_tweet_widget' );

// Register our widget
function warrior_couple_tweet_widget() {
	register_widget( 'Warrior_Couple_Tweet' );
}

// Warrior Twitter Widget
class Warrior_Couple_Tweet extends WP_Widget {


	//  Setting up the widget
	function Warrior_Couple_Tweet() {
		$widget_ops  = array( 'classname' => 'twitter', 'description' => __('Warrior Couple Tweet Widget', 'qaween') );
		$control_ops = array( 'id_base' => 'widget_warrior_twitter' );

		$this->WP_Widget( 'widget_warrior_twitter', __('Home: Warrior Couple Tweet', 'qaween'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $shortname;

		extract( $args );

		$warrior_twitter_title        = apply_filters('widget_title', $instance['warrior_twitter_title']);
		$warrior_twitter_tweets_count = !empty($instance['warrior_twitter_tweets_count']) ? $instance['warrior_twitter_tweets_count'] : 4;
		$warrior_twitter_button_text  = $instance['warrior_twitter_button_text'];

		$warrior_twitter_name_groom		= $instance['warrior_twitter_name_groom'];
		$warrior_twitter_photo_groom	= $instance['warrior_twitter_photo_groom'];
		$warrior_twitter_username_groom	= $instance['warrior_twitter_username_groom'];
		$twitter_consumer_key_groom		= $instance['twitter_consumer_key_groom'];
		$twitter_consumer_secret_groom  = $instance['twitter_consumer_secret_groom'];
		
		$warrior_twitter_name_bride		= $instance['warrior_twitter_name_bride'];
		$warrior_twitter_photo_bride	= $instance['warrior_twitter_photo_bride'];
		$warrior_twitter_username_bride	= $instance['warrior_twitter_username_bride'];
		$twitter_consumer_key_bride		= $instance['twitter_consumer_key_bride'];
		$twitter_consumer_secret_bride  = $instance['twitter_consumer_secret_bride'];

		if ( empty($warrior_twitter_username_groom) && empty($warrior_twitter_username_bride) )
			return;

		$tweets_groom = warrior_get_recent_tweets( $warrior_twitter_username_groom, $twitter_consumer_key_groom, $twitter_consumer_secret_groom, $warrior_twitter_tweets_count );
		$tweets_bride = warrior_get_recent_tweets( $warrior_twitter_username_bride, $twitter_consumer_key_bride, $twitter_consumer_secret_bride, $warrior_twitter_tweets_count );
		
		echo $before_widget;
?>
	<div class="content">
		<?php echo $before_title . $warrior_twitter_title . $after_title; ?>
		<ul id="tweets-updates">
		
			<li class="grooms-tweets">
			<?php if ( $tweets_groom ) : ?>
				<div class="thumbnail">
					<?php $twitter_photo_groom_url = $warrior_twitter_photo_groom ? $warrior_twitter_photo_groom : 'http://placehold.it/120x120/f5f5f5/666666/&text=Groom' ?>
					<img src="<?php echo $twitter_photo_groom_url; ?>" />
				</div>
				<div class="tweets-content">
					<div class="heading">
						<h3><?php echo $warrior_twitter_name_groom; ?></h3>
						<span><?php echo '@'.$warrior_twitter_username_groom; ?></span>
					</div>

					<ul class="tweets-lists">
					<?php foreach ( $tweets_groom as $tweet_groom ) : ?>
						<?php $tweet_time = date('U', strtotime( $tweet_groom['created_at'] )); ?>
						<li>
							<p><?php echo twitter_links($tweet_groom['text']); ?></p>
							<span class="meta"><?php echo human_time_diff( $tweet_time, current_time('timestamp') ) . __(' ago', 'qaween'); ?></span>
						</li>
					<?php endforeach; ?>
					</ul>

					<a class="tweets-button-follow" href="http://twitter.com/<?php echo $warrior_twitter_username_groom; ?>" target="_blank"><?php echo str_replace('%name%', $warrior_twitter_name_groom, $warrior_twitter_button_text ); ?></a>

				</div>

			<?php endif; ?>
			</li>

			<li class="right">
			<?php if ( $tweets_bride ) : ?>
				<div class="thumbnail">
					<?php $twitter_photo_bride_url = $warrior_twitter_photo_bride ? $warrior_twitter_photo_bride : 'http://placehold.it/120x120/f5f5f5/666666/&text=Bride' ?>
					<img src="<?php echo $twitter_photo_bride_url; ?>" />
				</div>
				<div class="tweets-content">
					<div class="heading">
						<h3><?php echo $warrior_twitter_name_bride; ?></h3>
						<span><?php echo '@'.$warrior_twitter_username_bride; ?></span>
					</div>

					<ul class="tweets-lists">
					<?php foreach ( $tweets_bride as $tweet_bride ) : ?>
						<?php $tweet_time = date('U', strtotime( $tweet_bride['created_at'] )); ?>
						<li>
							<p><?php echo twitter_links($tweet_bride['text']); ?></p>
							<span class="meta"><?php echo human_time_diff( $tweet_time, current_time('timestamp') ) . __(' ago', 'qaween'); ?></span>
						</li>
					<?php endforeach; ?>
					</ul>

					<a class="tweets-button-follow" href="http://twitter.com/<?php echo $warrior_twitter_username_bride; ?>" target="_blank"><?php echo str_replace('%name%', $warrior_twitter_name_bride, $warrior_twitter_button_text ); ?></a>

				</div>

			<?php endif; ?>
			</li>

		</ul>

	</div>
<?php
	echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		global $shortname;

		$instance = $old_instance;

		$instance['warrior_twitter_title']			= strip_tags( $new_instance['warrior_twitter_title'] );
		$instance['warrior_twitter_tweets_count']	= strip_tags( $new_instance['warrior_twitter_tweets_count'] );
		$instance['warrior_twitter_button_text']	= strip_tags( $new_instance['warrior_twitter_button_text'] );
		$instance['warrior_twitter_name_groom']		= strip_tags( $new_instance['warrior_twitter_name_groom'] );
		$instance['warrior_twitter_photo_groom']	= strip_tags( $new_instance['warrior_twitter_photo_groom'] );
		$instance['warrior_twitter_username_groom']	= strip_tags( $new_instance['warrior_twitter_username_groom'] );
		$instance['twitter_consumer_key_groom']		= strip_tags( $new_instance['twitter_consumer_key_groom'] );
		$instance['twitter_consumer_secret_groom']	= strip_tags( $new_instance['twitter_consumer_secret_groom'] );
		$instance['warrior_twitter_name_bride']		= strip_tags( $new_instance['warrior_twitter_name_bride'] );
		$instance['warrior_twitter_photo_bride']	= strip_tags( $new_instance['warrior_twitter_photo_bride'] );
		$instance['warrior_twitter_username_bride']	= strip_tags( $new_instance['warrior_twitter_username_bride'] );
		$instance['twitter_consumer_key_bride']		= strip_tags( $new_instance['twitter_consumer_key_bride'] );
		$instance['twitter_consumer_secret_bride']	= strip_tags( $new_instance['twitter_consumer_secret_bride'] );

		return $instance;
	}

	function form( $instance ) {
		global $shortname;

		$instance = wp_parse_args( (array) $instance, array('warrior_twitter_title' => __("The couples's tweets", 'qaween'), 'warrior_twitter_tweets_count' => '4', 'warrior_twitter_button_text' => __('Follow %name% on twitter', 'qaween'), 'warrior_twitter_name_groom' => '', 'warrior_twitter_photo_groom' => 'http://placehold.it/120x120/f5f5f5/666666/&text=Groom', 'warrior_twitter_username_groom' => '', 'twitter_consumer_key_groom' => '', 'twitter_consumer_secret_groom' => '', 'warrior_twitter_name_bride' => '', 'warrior_twitter_photo_bride' => 'http://placehold.it/120x120/f5f5f5/666666/&text=Bride', 'warrior_twitter_username_bride' => '', 'twitter_consumer_key_bride' => '', 'twitter_consumer_secret_bride' => '' ) );
		$warrior_twitter_photo_groom = $instance[ 'warrior_twitter_photo_groom' ] ? esc_url( $instance[ 'warrior_twitter_photo_groom' ] ) : '';
		$warrior_twitter_photo_bride = $instance[ 'warrior_twitter_photo_bride' ] ? esc_url( $instance[ 'warrior_twitter_photo_bride' ] ) : '';

	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_twitter_title' ); ?>"><?php _e('Widget Title:', 'qaween'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_twitter_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_twitter_title' ); ?>" value="<?php echo $instance['warrior_twitter_title']; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_twitter_tweets_count' ); ?>"><?php _e('Tweets Count:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'warrior_twitter_tweets_count' ); ?>" name="<?php echo $this->get_field_name( 'warrior_twitter_tweets_count' ); ?>" value="<?php echo $instance['warrior_twitter_tweets_count']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_twitter_button_text' ); ?>"><?php _e('Button Text:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'warrior_twitter_button_text' ); ?>" name="<?php echo $this->get_field_name( 'warrior_twitter_button_text' ); ?>" value="<?php echo $instance['warrior_twitter_button_text']; ?>" />
			<br />
			<small><?php printf( __('Notes: %s will be replace with the name', 'qaween'), '<code>%name%</code>'); ?></small>
		</p>
		<p>
			<small><?php _e('You can get Twitter consumer key & consumer secret by <a href="http://dev.twitter.com" target="_blank">creating an app</a> on Twitter.', 'qaween'); ?></small>
		</p>

		<h3><?php _e('The Groom', 'qaween'); ?></h3>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_twitter_name_groom' ); ?>"><?php _e('Twitter Name:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'warrior_twitter_name_groom' ); ?>" name="<?php echo $this->get_field_name( 'warrior_twitter_name_groom' ); ?>" value="<?php echo $instance['warrior_twitter_name_groom']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('warrior_twitter_photo_groom'); ?>"><?php _e('Twitter Photo:', 'qaween'); ?></label>
			<br />
			<img src="<?php echo $warrior_twitter_photo_groom; ?>" alt="" id="<?php echo $this->get_field_id('warrior_twitter_photo_groom'); ?>_preview" style="max-width: 100%; height: auto; <?php echo ( $warrior_twitter_photo_groom ? '' : 'display:none;' ) ; ?>" />
	        <input type="text" class="widefat" name="<?php echo $this->get_field_name('warrior_twitter_photo_groom'); ?>" id="<?php echo $this->get_field_id('warrior_twitter_photo_groom'); ?>" value="<?php echo $warrior_twitter_photo_groom; ?>">
		</p>
		<p>
	        <input type="button" value="<?php _e( 'Upload', 'qaween' ); ?>" class="button widget_media_upload" id="<?php echo $this->get_field_id('warrior_twitter_photo_groom'); ?>_button_upload" />
	        <input type="button" value="<?php _e( 'Remove', 'qaween' ); ?>" class="button widget_media_remove" id="<?php echo $this->get_field_id('warrior_twitter_photo_groom'); ?>_button_remove" style="color: red; <?php echo ( $warrior_twitter_photo_groom ? '' : 'display:none;' ) ; ?>" />
	    </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_twitter_username_groom' ); ?>"><?php _e('Twitter Username:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'warrior_twitter_username_groom' ); ?>" name="<?php echo $this->get_field_name( 'warrior_twitter_username_groom' ); ?>" value="<?php echo $instance['warrior_twitter_username_groom']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_consumer_key_groom' ); ?>"><?php _e('Twitter Consumer key:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter_consumer_key_groom' ); ?>" name="<?php echo $this->get_field_name( 'twitter_consumer_key_groom' ); ?>" value="<?php echo $instance['twitter_consumer_key_groom']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_consumer_secret_groom' ); ?>"><?php _e('Twitter Consumer secret:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter_consumer_secret_groom' ); ?>" name="<?php echo $this->get_field_name( 'twitter_consumer_secret_groom' ); ?>" value="<?php echo $instance['twitter_consumer_secret_groom']; ?>" />
		</p>

		<h3><?php _e('The Bride', 'qaween'); ?></h3>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_twitter_name_bride' ); ?>"><?php _e('Twitter Name:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'warrior_twitter_name_bride' ); ?>" name="<?php echo $this->get_field_name( 'warrior_twitter_name_bride' ); ?>" value="<?php echo $instance['warrior_twitter_name_bride']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('warrior_twitter_photo_bride'); ?>"><?php _e('Twitter Photo:', 'qaween'); ?></label>
			<br />
			<img src="<?php echo $warrior_twitter_photo_bride; ?>" alt="" id="<?php echo $this->get_field_id('warrior_twitter_photo_bride'); ?>_preview" style="max-width: 100%; height: auto; <?php echo ( $warrior_twitter_photo_bride ? '' : 'display:none;' ) ; ?>" />
	        <input type="text" class="widefat" name="<?php echo $this->get_field_name('warrior_twitter_photo_bride'); ?>" id="<?php echo $this->get_field_id('warrior_twitter_photo_bride'); ?>" value="<?php echo $warrior_twitter_photo_bride; ?>">
		</p>
		<p>
	        <input type="button" value="<?php _e( 'Upload', 'qaween' ); ?>" class="button widget_media_upload" id="<?php echo $this->get_field_id('warrior_twitter_photo_bride'); ?>_button_upload" />
	        <input type="button" value="<?php _e( 'Remove', 'qaween' ); ?>" class="button widget_media_remove" id="<?php echo $this->get_field_id('warrior_twitter_photo_bride'); ?>_button_remove" style="color: red; <?php echo ( $warrior_twitter_photo_bride ? '' : 'display:none;' ) ; ?>" />
	    </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_twitter_username_bride' ); ?>"><?php _e('Twitter Username:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'warrior_twitter_username_bride' ); ?>" name="<?php echo $this->get_field_name( 'warrior_twitter_username_bride' ); ?>" value="<?php echo $instance['warrior_twitter_username_bride']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_consumer_key_bride' ); ?>"><?php _e('Twitter Consumer key:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter_consumer_key_bride' ); ?>" name="<?php echo $this->get_field_name( 'twitter_consumer_key_bride' ); ?>" value="<?php echo $instance['twitter_consumer_key_bride']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_consumer_secret_bride' ); ?>"><?php _e('Twitter Consumer secret:', 'qaween'); ?></label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'twitter_consumer_secret_bride' ); ?>" name="<?php echo $this->get_field_name( 'twitter_consumer_secret_bride' ); ?>" value="<?php echo $instance['twitter_consumer_secret_bride']; ?>" />
		</p>
	<?php
	}
}
?>