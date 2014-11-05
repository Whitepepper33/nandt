<?php
/**
 * About Couple widget
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

// Widgets
add_action( 'widgets_init', 'warrior_about_couple_widget' );

// Register our widget
function warrior_about_couple_widget() {
	register_widget( 'Warrior_About_Couple' );
}

// Warrior Abou the Couple Widget
class Warrior_About_Couple extends WP_Widget {


	//  Setting up the widget
	function Warrior_About_Couple() {
		$widget_ops  = array( 'classname' => 'about_couple', 'description' => __('Warrior About Couple Widget', 'qaween') );
		$control_ops = array( 'id_base' => 'warrior_about_couple' );

		$this->WP_Widget( 'warrior_about_couple', __('Home: Warrior About Couple', 'qaween'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $shortname, $qaween_option;

		extract( $args );

		$warrior_about_couple_title	= apply_filters('widget_title', $instance['warrior_about_couple_title']);
		
		echo $before_widget;
?>
		<div class="content">
			<div class="content-wrapper home couple">
				<?php echo $before_title . $warrior_about_couple_title . $after_title; ?>
				<div class="couples half left animate">
					<div class="thumb">
						<div class="thumbnail">
							<img src="<?php echo ( $qaween_option['photo_groom']['url'] ? esc_url( $qaween_option['photo_groom']['url'] ) : 'http://placehold.it/200x200/f5f5f5/666666/&text=Groom&' ); ?>" alt="" />
						</div>

						<div class="social">
						<?php
							if ( $qaween_option['url_facebook_groom'] ) echo '<a href="'.esc_url( $qaween_option['url_facebook_groom'] ).'"><i class="fa fa-facebook"></i></a>';
							if ( $qaween_option['url_twitter_groom'] ) echo '<a href="'.esc_url( $qaween_option['url_twitter_groom'] ).'"><i class="fa fa-twitter"></i></a>';
							if ( $qaween_option['url_gplus_groom'] ) echo '<a href="'.esc_url( $qaween_option['url_gplus_groom'] ).'"><i class="fa fa-google-plus"></i></a>';
							if ( $qaween_option['url_pinterest_groom'] ) echo '<a href="'.esc_url( $qaween_option['url_pinterest_groom'] ).'"><i class="fa fa-pinterest"></i></a>';
							if ( $qaween_option['url_youtube_groom'] ) echo '<a href="'.esc_url( $qaween_option['url_youtube_groom'] ).'"><i class="fa fa-youtube"></i></a>';
							if ( $qaween_option['url_flickr_groom'] ) echo '<a href="'.esc_url( $qaween_option['url_flickr_groom'] ).'"><i class="fa fa-flickr"></i></a>';
						?>
						</div>
					</div>
					<?php if ( $qaween_option['name_groom'] ) : ?>
						<div class="title"><h2><?php echo $qaween_option['name_groom']; ?></h2></div>
					<?php endif; ?>
					<div class="excerpt">
						<?php echo wpautop( $qaween_option['about_groom'] ); ?>
					</div>
				</div>
				<div class="couples half right animate">
					<div class="thumb">
						<div class="thumbnail">
							<img src="<?php echo ( $qaween_option['photo_bride']['url'] ? esc_url( $qaween_option['photo_bride']['url'] ) : 'http://placehold.it/200x200/f5f5f5/666666&text=Bride' ); ?>" alt="" />
						</div>
						
						<div class="social">
						<?php
							if ( $qaween_option['url_facebook_bride'] ) echo '<a href="'.esc_url( $qaween_option['url_facebook_bride'] ).'"><i class="fa fa-facebook"></i></a>';
							if ( $qaween_option['url_twitter_bride'] ) echo '<a href="'.esc_url( $qaween_option['url_twitter_bride'] ).'"><i class="fa fa-twitter"></i></a>';
							if ( $qaween_option['url_gplus_bride'] ) echo '<a href="'.esc_url( $qaween_option['url_gplus_bride'] ).'"><i class="fa fa-google-plus"></i></a>';
							if ( $qaween_option['url_pinterest_bride'] ) echo '<a href="'.esc_url( $qaween_option['url_pinterest_bride'] ).'"><i class="fa fa-pinterest"></i></a>';
							if ( $qaween_option['url_youtube_bride'] ) echo '<a href="'.esc_url( $qaween_option['url_youtube_bride'] ).'"><i class="fa fa-youtube"></i></a>';
							if ( $qaween_option['url_flickr_bride'] ) echo '<a href="'.esc_url( $qaween_option['url_flickr_bride'] ).'"><i class="fa fa-flickr"></i></a>';
						?>
						</div>
					</div>
					<?php if ( $qaween_option['name_bride'] ) : ?>
						<div class="title"><h2><?php echo $qaween_option['name_bride']; ?></h2></div>
					<?php endif; ?>
					<div class="excerpt">
						<?php echo wpautop( $qaween_option['about_bride'] ); ?>
					</div>
				</div>
			</div>
		</div>
<?php
	echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		global $shortname;

		$instance = $old_instance;

		$instance['warrior_about_couple_title']	= strip_tags( $new_instance['warrior_about_couple_title'] );

		return $instance;
	}

	function form( $instance ) {
		global $shortname;

		$instance = wp_parse_args( (array) $instance, array('warrior_about_couple_title' => __('The Happy Couple', 'qaween') ) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_about_couple_title' ); ?>"><?php _e('Widget Title:', 'qaween'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_about_couple_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_about_couple_title' ); ?>" value="<?php echo $instance['warrior_about_couple_title']; ?>" />
        </p>
		<p><small><?php printf( __('This data taken from <a href="%s">Theme Options</a>.', 'qaween'), admin_url('admin.php?page=warriorpanel') ); ?></small></p>
	<?php
	}
}

?>