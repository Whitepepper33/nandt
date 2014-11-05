<?php
/**
 * Template for displaying posts in the post, default style.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( ! is_single() && has_post_thumbnail() ) : ?>
		<div class="gallery-item">
			<div class="overlay">
				<a class="read-more" href="<?php the_permalink(); ?>" class="left"><?php _e( 'Read More', 'qaween' ); ?></a>
			</div>
			<a href="<?php the_permalink(); ?>"><?php the_post_thumbnail('large-thumb', array('class' => 'gallery-thumb')); ?></a>
		</div>
	<?php endif; ?>

	<?php if ( ! is_single() ) : ?>
		<div class="blog-title">
			<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
		</div>
	<?php endif; ?>

	<?php if( ! is_single() ) : ?>
	<div class="meta">
		<span><i class="fa fa-clock-o"></i> <abbr title="<?php echo get_the_date() .' '. get_the_time(); ?>"><?php printf( __('%s ago', 'qaween'), human_time_diff( get_the_time('U'), current_time('timestamp') ) ); ?></abbr></span>
		<span><i class="fa fa-user"></i> <?php the_author(); ?></span>
		<span><i class="fa fa-comments-o"></i> <?php comments_popup_link( 0, 1, '%' ); ?></span>
	</div>
	<?php endif; ?>

	<div class="post-content">
	<?php if ( is_single() ) : ?>
		<?php
		the_content();
		wp_link_pages( array( 'before' => '<p class="page-links"><span class="page-links-title">' . __( 'Pages:', 'qaween' ) . '</span>', 'after' => '</p>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
		the_tags('<p class="tags">', ' ', '</p>');
		?>
		<?php get_template_part( 'includes/share-buttons' ); // load share buttons ?>
		<div class="clear"></div>
	<?php else : ?>
		<div class="text">
			<?php the_excerpt(); ?>
		</div>
	<?php endif; // is_single() ?>
	</div>

	<?php if( is_single() ) : ?>
	<div class="meta">
		<span><i class="fa fa-clock-o"></i> <abbr title="<?php echo get_the_date() .' '. get_the_time(); ?>"><?php printf( __('%s ago', 'qaween'), human_time_diff( get_the_time('U'), current_time('timestamp') ) ); ?></abbr></span>
		<span><i class="fa fa-user"></i> <?php the_author(); ?></span>
		<span><i class="fa fa-comments-o"></i> <?php comments_popup_link( 0, 1, '%' ); ?></span>
	</div>
	<?php endif; ?>
	<?php comments_template( '', true ); ?>
</div>