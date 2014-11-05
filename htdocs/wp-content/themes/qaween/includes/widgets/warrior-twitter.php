<?php
/**
 * Twitter widget
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
 
// Widgets
add_action( 'widgets_init', 'warrior_twitter_widget' );

// Register our widget
function warrior_twitter_widget() {
	register_widget( 'Warrior_Twitter' );
}

// Warrior Twitter Widget
class Warrior_Twitter extends WP_Widget {


	//  Setting up the widget
	function Warrior_Twitter() {
		$widget_ops  = array( 'classname' => 'twitter', 'description' => __('Warrior Twitter Widget', 'qaween') );
		$control_ops = array( 'id_base' => 'warrior_twitter' );

		$this->WP_Widget( 'warrior_twitter', __('Warrior Twitter', 'qaween'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $shortname;

		extract( $args );

		$warrior_twitter_title        = apply_filters('widget_title', $instance['warrior_twitter_title']);
		$warrior_twitter_username     = $instance['warrior_twitter_username'];
		$warrior_twitter_tweets_count = !empty($instance['warrior_twitter_tweets_count']) ? $instance['warrior_twitter_tweets_count'] : 1;
		$warrior_twitter_button_text  = $instance['warrior_twitter_button_text'];
		$twitter_consumer_key		  = $instance['twitter_consumer_key'];
		$twitter_consumer_secret	  = $instance['twitter_consumer_secret'];
		
		$tweets = warrior_get_recent_tweets( $warrior_twitter_username, $twitter_consumer_key, $twitter_consumer_secret, $warrior_twitter_tweets_count );

		echo $before_widget;
?>

		<?php echo $before_title . $warrior_twitter_title . $after_title; ?>

		<ul>
		<?php if ( $tweets ) : ?>
			<?php foreach ( $tweets as $tweet ) : ?>
				<li>
					<p><span class="fa fa-twitter-square"></span>  <?php echo twitter_links($tweet['text']); ?></p>
					<div class="meta">
						<?php $tweet_time = date('U', strtotime( $tweet['created_at'] )); ?>
						<a href="http://twitter.com/<?php echo $warrior_twitter_username; ?>/status/<?php echo $tweet['status_id']; ?>"><span class="fa fa-clock-o"></span> <?php echo human_time_diff( $tweet_time, current_time('timestamp') ) . __(' ago', 'qaween'); ?></a>

					</div>
				</li>
			<?php endforeach; ?>
		<?php endif; ?>
			<li><span class="fa fa-twitter"></span> <a href="http://twitter.com/<?php echo $warrior_twitter_username;?>"><?php echo $warrior_twitter_button_text; ?></a></li>
        </ul>

<?php
	echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		global $shortname;

		$instance = $old_instance;

		$instance['warrior_twitter_title']			= strip_tags( $new_instance['warrior_twitter_title'] );
		$instance['warrior_twitter_username']		= strip_tags( $new_instance['warrior_twitter_username'] );
		$instance['warrior_twitter_tweets_count']	= strip_tags( $new_instance['warrior_twitter_tweets_count'] );
		$instance['warrior_twitter_button_text']	= strip_tags( $new_instance['warrior_twitter_button_text'] );
		$instance['twitter_consumer_key']			= strip_tags( $new_instance['twitter_consumer_key'] );
		$instance['twitter_consumer_secret']		= strip_tags( $new_instance['twitter_consumer_secret'] );

		return $instance;
	}

	function form( $instance ) {
		global $shortname;

		$instance = wp_parse_args( (array) $instance, array('warrior_twitter_title' => __('Latest Tweets', 'qaween'), 'warrior_twitter_username' => 'themewarrior', 'warrior_twitter_tweets_count' => '5', 'warrior_twitter_button_text' => __('Follow me on Twitter', 'qaween'), 'twitter_consumer_key' => '', 'twitter_consumer_secret' => '' ) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_twitter_title' ); ?>"><?php _e('Widget Title:', 'qaween'); ?></label>
            <input id="<?php echo $this->get_field_id( 'warrior_twitter_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_twitter_title' ); ?>" value="<?php echo $instance['warrior_twitter_title']; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_twitter_username' ); ?>"><?php _e('Twitter Username (this will also change the username in the WarriorPanel):', 'qaween'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'warrior_twitter_username' ); ?>" name="<?php echo $this->get_field_name( 'warrior_twitter_username' ); ?>" value="<?php echo $instance['warrior_twitter_username']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_twitter_tweets_count' ); ?>"><?php _e('Tweets Count:', 'qaween'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'warrior_twitter_tweets_count' ); ?>" name="<?php echo $this->get_field_name( 'warrior_twitter_tweets_count' ); ?>" value="<?php echo $instance['warrior_twitter_tweets_count']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_twitter_button_text' ); ?>"><?php _e('Button Text:', 'qaween'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'warrior_twitter_button_text' ); ?>" name="<?php echo $this->get_field_name( 'warrior_twitter_button_text' ); ?>" value="<?php echo $instance['warrior_twitter_button_text']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_consumer_key' ); ?>"><?php _e('Twitter Consumer key:', 'qaween'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_consumer_key' ); ?>" name="<?php echo $this->get_field_name( 'twitter_consumer_key' ); ?>" value="<?php echo $instance['twitter_consumer_key']; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'twitter_consumer_secret' ); ?>"><?php _e('Twitter Consumer secret:', 'qaween'); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'twitter_consumer_secret' ); ?>" name="<?php echo $this->get_field_name( 'twitter_consumer_secret' ); ?>" value="<?php echo $instance['twitter_consumer_secret']; ?>" />
		</p>
		<p><small><?php _e('You can get Twitter consumer key & consumer secret by <a href="http://dev.twitter.com" target="_blank">creating an app</a> on Twitter.', 'qaween'); ?></small></p>
	<?php
	}
}
?>