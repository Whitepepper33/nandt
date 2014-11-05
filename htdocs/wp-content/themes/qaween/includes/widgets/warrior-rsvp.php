<?php
/**
 * RSVP widget
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

// Widgets
if ( function_exists( 'rsvp_register' ) ) {
	add_action( 'widgets_init', 'warrior_rsvp_widget' );
}

// Register our widget
function warrior_rsvp_widget() {
	register_widget( 'Warrior_RSVP' );
}

// Warrior RSVP Widget
class Warrior_RSVP extends WP_Widget {
	//  Setting up the widget
	function Warrior_RSVP() {
		$widget_ops  = array( 'classname' => 'rsvp', 'description' => __('RSVP form Widget', 'qaween') );
		$control_ops = array( 'id_base' => 'warrior_rsvp' );

		$this->WP_Widget( 'warrior_rsvp', __('Home: Warrior RSVP', 'qaween'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $qaween_option;

		extract( $args );
		
		$warrior_rsvp_title = apply_filters('widget_title', $instance['warrior_rsvp_title']);
		$warrior_rsvp_text  = $instance['warrior_rsvp_text'];

		echo $before_widget;
?>
        <div id="rsvp" class="full-width">
            <div class="container main">
				<div class="contact-form">
					<form id="rsvp-form" class="animate" action="#" method="post">
						<div class="alert hidden"></div>
						<div class="input text">
							<input id="rsvp-name" class="input" placeholder="<?php _e('Full Name', 'qaween'); ?>" />
						</div>

						<div class="input text">
							<input id="rsvp-email" class="input" placeholder="<?php _e('Email', 'qaween'); ?>" />
						</div>

						<div class="input select">
							<select id="rsvp-persons">
								<option value="" disabled selected><?php _e('Number of Persons Attending', 'qaween'); ?></option>
								<?php for( $i = 1; $i <=10; $i++ ) { ?>
									<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="input select">
							<select name="rsvp-event" id="rsvp-event">
							<?php
							foreach( $qaween_option['wedding_events'] as $id => $name) {
								echo '<option value="'. $id .'">'. $name .'</option>';
							} 
							?>
							</select>
						</div>

						<div class="input-wrapper submit">
							<button type="submit"><?php _e('I\'m Attending', 'qaween'); ?></button>
							<img src="<?php echo get_template_directory_uri() . '/images/ajax-loader.gif'; ?>" alt="" class="loader hidden" />
							<input type="hidden" id="rsvp-action" value="new_rsvp" />
							<input type="hidden" id="rsvp-nonce" value="<?php echo wp_create_nonce( 'rsvp_nonce' ); ?>" />
						</div>
					</form>

					<div class="widget-title">
						<?php echo $before_title . $warrior_rsvp_title . $after_title; ?>
						<p class="animate"><?php echo $warrior_rsvp_text; ?></p>
					</div>
				</div>
			</div>
		</div>
<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['warrior_rsvp_title']	= strip_tags( $new_instance['warrior_rsvp_title'] );
		$instance['warrior_rsvp_text']	= $new_instance['warrior_rsvp_text'];

		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array('warrior_rsvp_title' => __('Are You Attending?', 'qaween'), 'warrior_rsvp_text' => __('You can change this text from the widget setting.', 'qaween') ) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_rsvp_title' ); ?>"><?php _e('Widget Title:', 'qaween'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_rsvp_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_rsvp_title' ); ?>" value="<?php echo $instance['warrior_rsvp_title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_rsvp_text' ); ?>"><?php _e('Description Text:', 'qaween'); ?></label>
            <textarea id="<?php echo $this->get_field_id( 'warrior_rsvp_text' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_rsvp_text' ); ?>"><?php echo $instance['warrior_rsvp_text']; ?></textarea>
        </p>
		<p><small><?php printf( __('All submission will be sent to the email address set on the <a href="%s">theme options page</a>.', 'qaween'), admin_url('admin.php?page=warriorpanel&tab=0') ); ?></small></p>
	<?php
	}
}
?>