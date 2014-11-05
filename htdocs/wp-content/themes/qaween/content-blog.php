<?php
/**
 * Template for displaying posts in the post, blog style.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="gallery-item">
		<div class="overlay">
			<a class="read-more" href="<?php the_permalink(); ?>" class="left"><?php _e( 'Read More', 'qaween' ); ?></a>
		</div>
		<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('blog-thumb', array('class' => 'gallery-thumb')); ?></a>
		<i class="post-icon icon-image2"></i>
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
		<div class="text">
			<?php the_excerpt(); ?>
		</div>
	</div>
</div>