<?php
/**
 * Gallery album widget
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

// Widgets
if ( function_exists( 'gallery_register' ) ) {
	add_action( 'widgets_init', 'warrior_gallery_widget' );
}

// Register our widget
function warrior_gallery_widget() {
	register_widget( 'Warrior_Gallery' );
}

// Warrior Gallery Widget
class Warrior_Gallery extends WP_Widget {


	//  Setting up the widget
	function Warrior_Gallery() {
		$widget_ops  = array( 'classname' => 'gallery', 'description' => __('Warrior Gallery ALbum Widget', 'qaween') );
		$control_ops = array( 'id_base' => 'warrior_gallery' );

		$this->WP_Widget( 'warrior_gallery', __('Home: Warrior Gallery Album', 'qaween'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		global $shortname;

		extract( $args );

		$warrior_gallery_title = apply_filters('widget_title', $instance['warrior_gallery_title']);
		$warrior_gallery_count = !empty($instance['warrior_gallery_count']) ? absint( $instance['warrior_gallery_count'] ) : 8;
		
		$args = array(
			'post_type' => 'gallery',
			'post_status' => 'publish',
			'posts_per_page' => $warrior_gallery_count
		);
		$gallery_query = new WP_Query();
		$gallery_query->query($args);
		if ( $gallery_query->have_posts() ) :

		echo $before_widget;
?>
		<div class="content full">
			<?php echo $before_title . $warrior_gallery_title . $after_title; ?>
			<ul class="galleries animate">
			<?php while( $gallery_query->have_posts() ) : $gallery_query->the_post(); ?>
				<li class="gallery-item">
					<?php
					if ( has_post_thumbnail() ) :
						$large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
						$args = array( 'numberposts' => null, 'order' => 'ASC', 'post_type' => 'attachment', 'post_status' => null, 'post_mime_type' => 'image', 'post_parent' => get_the_ID(), 'showposts' => -1 );
						$attachments = get_posts($args);
						$others = array();
						if ($attachments) {
							echo '<div class="hidden">';
							foreach ($attachments as $attachment) {
								$other_image = wp_get_attachment_image_src( $attachment->ID, 'large' );
								if ( $other_image[0] != $large_image_url[0] ) {
									echo '<a rel="prettyPhoto['.get_the_ID().']" href="'. $other_image[0] .'" title="'. $attachment->post_title .'"></a>';
									$others[] = $attachment->ID;
								}
							}
							echo '</div>';
						}
						?>
						<div class="overlay">
							<a href="<?php the_permalink(); ?>" class="left"><i class="fa fa-file-text-o"></i></a>
							<a href="<?php echo $large_image_url[0]; ?>" class="right" rel="prettyPhoto<?php echo ( count($others) ? '['.get_the_ID().']' : '' ); ?>" title="<?php the_title(); ?>"><i class="fa fa-expand"></i></a>
						</div>
						<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('medium-thumb', array('class' => 'gallery-thumb')); ?></a>
					<?php else : ?>
						<div class="overlay">
							<a href="<?php the_permalink(); ?>" class="left"><i class="fa fa-file-text-o"></i></a>
						</div>
						<a href="<?php the_permalink(); ?>"><img src="http://placehold.it/270x180/f5f5f5/666666/&amp;text=&nbsp;" alt="" class="" /></a>
					<?php endif; ?>
				</li>
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

		$instance['warrior_gallery_title']	= strip_tags( $new_instance['warrior_gallery_title'] );
		$instance['warrior_gallery_count']	= (int) $new_instance['warrior_gallery_count'];

		return $instance;
	}

	function form( $instance ) {
		global $shortname;

		$instance = wp_parse_args( (array) $instance, array('warrior_gallery_title' => __('Photo Gallery', 'qaween'), 'warrior_gallery_count' => 6 ) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_gallery_title' ); ?>"><?php _e('Widget Title:', 'qaween'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_gallery_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_gallery_title' ); ?>" value="<?php echo $instance['warrior_gallery_title']; ?>" />
        </p>
 		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_gallery_count' ); ?>"><?php _e('Number of Album to be Displayed:', 'qaween'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'warrior_gallery_count' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_gallery_count' ); ?>" value="<?php echo $instance['warrior_gallery_count']; ?>" />
		</p>
	<?php
	}
}

?>