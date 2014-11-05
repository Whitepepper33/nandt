<?php
/**
 * Map widget
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
 
// Widgets
add_action( 'widgets_init', 'warrior_map_widget' );

// Register our widget
function warrior_map_widget() {
	register_widget( 'Warrior_Map' );
}

// Warrior Blog Widget
class Warrior_Map extends WP_Widget {


	//  Setting up the widget
	function Warrior_Map() {
		$widget_ops  = array( 'classname' => 'map', 'description' => __('Warrior Map Widget', 'qaween') );
		$control_ops = array( 'id_base' => 'widget_warrior_map' );

		$this->WP_Widget( 'widget_warrior_map', __('Home: Warrior Map', 'qaween'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args );

		$warrior_map_title	 = apply_filters('widget_title', $instance['warrior_map_title']);
		$warrior_map_name 	 = $instance['warrior_map_name'];
		$warrior_map_address = $instance['warrior_map_address'];
		$warrior_map_image	 = !empty($instance['warrior_map_image']) ? $instance['warrior_map_image'] : '';
		$warrior_map_lat	 = !empty($instance['warrior_map_lat']) ? $instance['warrior_map_lat'] : '';
		$warrior_map_lng	 = !empty($instance['warrior_map_lng']) ? $instance['warrior_map_lng'] : '';
		$warrior_map_zoom 	 = $instance['warrior_map_zoom'];

		if ( !$warrior_map_address && ( !$warrior_map_lat || !$warrior_map_lng ) )
			return;

		echo $before_widget;
		echo $before_title . $warrior_map_title . $after_title;
?>
	<div id="map-wrapper" data-map-name="<?php echo $warrior_map_name; ?>" data-map-address="<?php echo $warrior_map_address; ?>" data-map-image="<?php echo $warrior_map_image; ?>" data-map-lat="<?php echo $warrior_map_lat; ?>" data-map-lng="<?php echo $warrior_map_lng; ?>" data-map-zoom="<?php echo $warrior_map_zoom; ?>"></div>
<?php
	echo $after_widget;
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['warrior_map_title']		= strip_tags( $new_instance['warrior_map_title'] );
		$instance['warrior_map_name']		= strip_tags( $new_instance['warrior_map_name'] );
		$instance['warrior_map_address']	= strip_tags( $new_instance['warrior_map_address'] );
		$instance['warrior_map_image']		= esc_url( $new_instance['warrior_map_image'] );
		$instance['warrior_map_lat']		= strip_tags( $new_instance['warrior_map_lat'] );
		$instance['warrior_map_lng']		= strip_tags( $new_instance['warrior_map_lng'] );
		$instance['warrior_map_zoom']		= (int) $new_instance['warrior_map_zoom'];

		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array('warrior_map_title' => __('Our Wedding Location', 'qaween'), 'warrior_map_name' => '', 'warrior_map_address' => '', 'warrior_map_image' => '', 'warrior_map_lat' => '', 'warrior_map_lng' => '', 'warrior_map_zoom' => 14 ) );
		
		$warrior_map_image = $instance[ 'warrior_map_image' ] ? esc_url( $instance[ 'warrior_map_image' ] ) : '';
	?>
		<p><small><?php _e('You can either specify an address or latitude longitude coordinate to specify the precise map target location.', 'qaween'); ?></small></p>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_map_title' ); ?>"><?php _e('Widget Title:', 'qaween'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_map_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_map_title' ); ?>" value="<?php echo $instance['warrior_map_title']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_map_name' ); ?>"><?php _e('Map Name:', 'qaween'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_map_name' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_map_name' ); ?>" value="<?php echo $instance['warrior_map_name']; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_map_address' ); ?>"><?php _e('Map Address:', 'qaween'); ?></label>
			<textarea id="<?php echo $this->get_field_id( 'warrior_map_address' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_map_address' ); ?>" rows="3"><?php echo $instance['warrior_map_address']; ?></textarea>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('warrior_map_image'); ?>"><?php _e('Map Image:', 'qaween'); ?></label>
			<br />
			<img src="<?php echo $warrior_map_image; ?>" alt="" id="<?php echo $this->get_field_id('warrior_map_image'); ?>_preview" style="max-width: 100%; height: auto; <?php echo ( $warrior_map_image ? '' : 'display:none;' ) ; ?>" />
	        <input type="text" class="widefat" name="<?php echo $this->get_field_name('warrior_map_image'); ?>" id="<?php echo $this->get_field_id('warrior_map_image'); ?>" value="<?php echo $warrior_map_image; ?>">
		</p>
		<p>
	        <input type="button" value="<?php _e( 'Upload', 'qaween' ); ?>" class="button widget_media_upload" id="<?php echo $this->get_field_id('warrior_map_image'); ?>_button_upload" />
	        <input type="button" value="<?php _e( 'Remove', 'qaween' ); ?>" class="button widget_media_remove" id="<?php echo $this->get_field_id('warrior_map_image'); ?>_button_remove" style="color: red; <?php echo ( $warrior_map_image ? '' : 'display:none;' ) ; ?>" />
	    </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_map_lat' ); ?>"><?php _e('Map Latitude:', 'qaween'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_map_lat' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_map_lat' ); ?>" value="<?php echo $instance['warrior_map_lat']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_map_lng' ); ?>"><?php _e('Map Longitude:', 'qaween'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_map_lng' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_map_lng' ); ?>" value="<?php echo $instance['warrior_map_lng']; ?>" />
        </p>
		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_map_zoom' ); ?>"><?php _e('Map Zoom Level:', 'qaween'); ?></label>
			<select id="<?php echo $this->get_field_id( 'warrior_map_zoom' ); ?>" name="<?php echo $this->get_field_name( 'warrior_map_zoom' ); ?>">
			<?php $zoom_opts = range(1, 20); ?>
			<?php foreach ($zoom_opts as $zoom_opt) { ?>
				<option value="<?php echo $zoom_opt; ?>" <?php echo selected( $instance['warrior_map_zoom'], $zoom_opt, false ); ?>><?php echo $zoom_opt; ?></option>
			<?php } ?>
			</select>
		</p>
	<?php
	}
}

?>