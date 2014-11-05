<?php
/**
 * Template for displaying posts in the Event post type.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="gallery-item">
		<?php the_post_thumbnail('event-thumb', array('class' => 'gallery-thumb')); ?>
	</div>
	<?php endif; ?>
	<div class="blog-title">
		<h2><?php the_title(); ?></h2>
	</div>
	<div class="meta">
		<span><i class="fa fa-calendar"></i> <?php _e('Time:', 'qaween'); ?> <?php echo ( get_field('event_date') ? date_i18n( 'M j, Y h:i a', strtotime( get_field('event_date') ) ) : '&ndash;' ); ?></span>
		<span><i class="fa fa-map-marker"></i> <?php _e('Location:', 'qaween'); ?> <?php echo ( get_field('event_locaton') ? esc_attr( get_field('event_locaton') ) : '&ndash;' ); ?></span>
	</div>
	<div class="post-content">
		<div class="text">
			<?php echo wpautop( get_field('event_info') ); ?>
		</div>
	</div>
</div>