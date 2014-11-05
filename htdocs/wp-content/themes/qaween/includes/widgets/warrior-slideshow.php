<?php
/**
 * Slideshow widget
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

// Widgets
if ( function_exists( 'slideshows_register' ) ) {
	add_action( 'widgets_init', 'warrior_slideshow_widget' );
}

// Register our widget
function warrior_slideshow_widget() {
	register_widget( 'Warrior_Slideshow' );
}

// Warrior Slideshow Widget
class Warrior_Slideshow extends WP_Widget {


	//  Setting up the widget
	function Warrior_Slideshow() {
		$widget_ops  = array( 'classname' => 'slideshow', 'description' => __('Warrior Slideshow Widget', 'qaween') );
		$control_ops = array( 'id_base' => 'warrior_slideshow' );

		$this->WP_Widget( 'warrior_slideshow', __('Home: Warrior Slideshow', 'qaween'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $shortname, $qaween_option;

		extract( $args );

		$warrior_slideshow_count 	= !empty($instance['warrior_slideshow_count']) ? absint( $instance['warrior_slideshow_count'] ) : 3;
		$warrior_slideshow_duration = !empty($instance['warrior_slideshow_duration']) ? absint( $instance['warrior_slideshow_duration'] ) : 3000;
		
		$args = array(
			'post_type' => 'slideshow',
			'post_status' => 'publish',
			'posts_per_page' => $warrior_slideshow_count
		);
		$slideshow_query = new WP_Query();
		$slideshow_query->query($args);
		if ( $slideshow_query->have_posts() ) :

		echo $before_widget;
?>
		<div id="slideshow" class="full-width" data-duration="<?php echo $warrior_slideshow_duration; ?>">
			<?php if( $qaween_option['wedding_date'] || $qaween_option['wedding_location'] ) : // only display if date or location is not empty ?>
				<span class="wedding-date">
					<?php echo qaween_date() . ( $qaween_option['wedding_date'] && $qaween_option['wedding_location'] ? ', ' : '' ) . $qaween_option['wedding_location']; ?>
				</span>
			<?php endif; ?>

			<ul class="slideshow-images">
				<?php while( $slideshow_query->have_posts() ) : $slideshow_query->the_post(); ?>
				<li><?php the_post_thumbnail('full'); ?></li>
				<?php endwhile; ?>
			</ul>
		</div>
<?php
	echo $after_widget;
	
	endif;
	wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {
		global $shortname;

		$instance = $old_instance;

		$instance['warrior_slideshow_count']	= (int) $new_instance['warrior_slideshow_count'];
		$instance['warrior_slideshow_duration']	= (int) $new_instance['warrior_slideshow_duration'];

		return $instance;
	}

	function form( $instance ) {
		global $shortname;

		$instance = wp_parse_args( (array) $instance, array('warrior_slideshow_count' => 3, 'warrior_slideshow_duration' => 3000 ) );
	?>
 		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_slideshow_count' ); ?>"><?php _e('Slideshow Count:', 'qaween'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'warrior_slideshow_count' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_slideshow_count' ); ?>" value="<?php echo $instance['warrior_slideshow_count']; ?>" />
		</p>
 		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_slideshow_duration' ); ?>"><?php _e('Slideshow Duration:', 'qaween'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'warrior_slideshow_duration' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_slideshow_duration' ); ?>" value="<?php echo $instance['warrior_slideshow_duration']; ?>" />
		</p>
		<p><small><?php printf( __('You can add slideshows from <a href="%s">here</a>.', 'qaween'), admin_url('edit.php?post_type=slideshow') ); ?></small></p>
	<?php
	}
}

?>