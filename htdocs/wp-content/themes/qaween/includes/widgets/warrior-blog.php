<?php
/**
 * Blog widget
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
 
// Widgets
add_action( 'widgets_init', 'warrior_blog_widget' );

// Register our widget
function warrior_blog_widget() {
	register_widget( 'Warrior_Blog' );
}

// Warrior Blog Widget
class Warrior_Blog extends WP_Widget {


	//  Setting up the widget
	function Warrior_Blog() {
		$widget_ops  = array( 'classname' => 'blog', 'description' => __('Warrior Blog Widget', 'qaween') );
		$control_ops = array( 'id_base' => 'warrior_blog' );

		$this->WP_Widget( 'warrior_blog', __('Home: Warrior Blog', 'qaween'), $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {

		extract( $args );

		$warrior_blog_title	= apply_filters('widget_title', $instance['warrior_blog_title']);
		$warrior_blog_count = !empty($instance['warrior_blog_count']) ? absint( $instance['warrior_blog_count'] ) : 4;
		
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'posts_per_page' => $warrior_blog_count
		);
		$blog_query = new WP_Query();
		$blog_query->query($args);
		if ( $blog_query->have_posts() ) :

		echo $before_widget;
?>
		<div class="content">
			<?php echo $before_title . $warrior_blog_title . $after_title; ?>
			<ul class="blog">
			<?php $i=1; while( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
				<li class="blog-item animate<?php if ( $i==1 ) echo ' first'; ?>">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="thumbnail">
						<?php the_post_thumbnail('small-thumb'); ?>
					</div>
					<?php endif; ?>
					<div class="blog-title">
						<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					</div>
					<div class="meta">
						<span><i class="fa fa-clock-o"></i> <abbr title="<?php echo get_the_date() .' '. get_the_time(); ?>"><?php printf( __('%s ago', 'qaween'), human_time_diff( get_the_time('U'), current_time('timestamp') ) ); ?></abbr></span>
						<span><i class="fa fa-user"></i> <?php the_author(); ?></span>
						<span><i class="fa fa-comments-o"></i> <?php comments_popup_link( 0, 1, '%' ); ?></span>
					</div>
					<div class="post-content">
						<?php
						if ( $i==1 )
							echo wp_trim_words(get_the_excerpt(), 45);
						else
							echo wp_trim_words(get_the_excerpt(), 19);
						?>
					</div>
				</li>
			<?php $i=$i+1; endwhile; ?>
			</ul>
		</div>
<?php
	echo $after_widget;
	
	endif;
	wp_reset_postdata();
	}

	function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['warrior_blog_title']	= strip_tags( $new_instance['warrior_blog_title'] );
		$instance['warrior_blog_count']	= (int) $new_instance['warrior_blog_count'];

		return $instance;
	}

	function form( $instance ) {

		$instance = wp_parse_args( (array) $instance, array('warrior_blog_title' => __('Our Wedding Blog', 'qaween'), 'warrior_blog_count' => 4 ) );
	?>
        <p>
            <label for="<?php echo $this->get_field_id( 'warrior_blog_title' ); ?>"><?php _e('Widget Title:', 'qaween'); ?></label>
            <input type="text" id="<?php echo $this->get_field_id( 'warrior_blog_title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_blog_title' ); ?>" value="<?php echo $instance['warrior_blog_title']; ?>" />
        </p>
 		<p>
			<label for="<?php echo $this->get_field_id( 'warrior_blog_count' ); ?>"><?php _e('Number of Post to be Displayed:', 'qaween'); ?></label>
			<input type="text" id="<?php echo $this->get_field_id( 'warrior_blog_count' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'warrior_blog_count' ); ?>" value="<?php echo $instance['warrior_blog_count']; ?>" />
		</p>
	<?php
	}
}

?>