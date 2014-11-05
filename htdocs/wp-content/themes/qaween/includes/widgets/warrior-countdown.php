<?php
/**
 * Countdown widget
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

// Widgets
add_action( 'widgets_init', 'warrior_countdown_widget' );

// Register our widget
function warrior_countdown_widget() {
	register_widget( 'Warrior_Countdown' );
}

// Warrior Countdown Widget
class Warrior_Countdown extends WP_Widget {


	//  Setting up the widget
	function Warrior_Countdown() {
		$widget_ops  = array( 'classname' => 'countdown', 'description' => __('Warrior Countdown Widget', 'qaween') );
		$control_ops = array( 'id_base' => 'warrior_countdown' );

		$this->WP_Widget( 'warrior_countdown', __('Home: Warrior Countdown', 'qaween'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $shortname, $qaween_option;

		extract( $args );
		
		echo $before_widget;
?>
        <div id="countdown" class="full-width">
            <div class="container main">
            	<?php if ( $qaween_option['wedding_date'] ) : ?>
	                <div class="full title">
						<h2><?php echo qaween_date() . ( $qaween_option['wedding_location'] ? ', ' . $qaween_option['wedding_location'] : '' ); ?></h2>
	                </div>
	                <div class="countdown-body">
	                    <div class="fa fa-heart"></div>
	                    <div id="timer">
							<div class="number-container"><div class="number">{yn}</div><div class="text">{yl}</div></div>
							<div class="number-container"><div class="number">{on}</div> <div class="text">{ol}</div></div>
							<div class="number-container"><div class="number">{dn}</div> <div class="text">{dl}</div></div>
							<div class="number-container"><div class="number">{hnn}</div> <div class="text">{hl}</div></div>
							<div class="number-container"><div class="number">{mnn}</div> <div class="text">{ml}</div></div>
							<div class="number-container"><div class="number">{snn}</div> <div class="text">{sl}</div></div>
						</div>
	                </div>
	        	<?php else: ?>
					<p><?php _e('Error: You need to set the wedding date & time from the theme options.', 'qaween'); ?></p>
				<?php endif; ?>
            </div>
        </div>

<?php
		echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {
		global $shortname;

		$instance = $old_instance;

		return $instance;
	}

	function form( $instance ) {
		global $shortname;

		$instance = wp_parse_args( (array) $instance, array() );
	?>
		<p><small><?php printf( __('This data taken from <a href="%s">Theme Options</a>.', 'qaween'), admin_url('admin.php?page=warriorpanel') ); ?></small></p>
	<?php
	}
}

?>