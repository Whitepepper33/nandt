<?php
/**
 * Template for displaying posts in the Gallery post type.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<?php
	$add_class[] = 'mix';
	$gallery_categories = get_the_terms( get_the_ID(), 'gallery_type' );
	if ( $gallery_categories ) {
		foreach ( $gallery_categories as $gallery_category ) {
			$add_class[] = $gallery_category->slug;
		}
	}
?>
<li id="post-<?php the_ID(); ?>" <?php post_class( implode(' ', $add_class) ); ?>>
	<div class="gallery-item">
		<div class="overlay">
			<a class="read-more" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
		</div>
		<a href="<?php the_permalink(); ?>"><?php
			if ( has_post_thumbnail() )
				the_post_thumbnail('medium-thumb', array('class' => 'gallery-thumb'));
			else
				echo '<img src="http://placehold.it/500x330/f5f5f5/666666/&text=No+Thumbnail" alt="" class="gallery-thumb" />';
		?></a>
	</div>
</li>