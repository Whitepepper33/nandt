<?php
/**
 * Template Name: Gallery
 * 
 * Template for displaying Gallery post format.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<?php get_header(); ?>

	<!-- Start: Page Title -->
	<div class="page-title">
		<h1 class="title"><?php the_title(); ?></h1>

		<?php get_template_part( 'includes/breadcrumb' ); ?>
	</div>
	<!-- End: Page Title -->
        
	<div class="container main">
		<div div class="content full">
			<div class="content-wrapper">
				<?php
				$terms = get_terms('gallery_type', 'hide_empty=0');
				if ( $terms ) :
				?>
				<div id="filter" class="filters">
					<span class="label"><?php _e('Select album:', 'qaween'); ?></span>
					<a class="filter" data-filter="all"><?php _e('All', 'qaween'); ?></a>
					<?php foreach ( $terms as $term ) : ?>
					<a class="filter" data-filter="<?php echo $term->slug; ?>"><?php echo $term->name; ?></a>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
				<ul id="grid" class="posts gallery-post">
					<?php
					$args=array(
						'post_type' 	=> 'gallery',
						'post_status' 	=> 'publish',
						'showposts'		=> -1
					);
					$wp_query = new WP_Query();
					$wp_query->query($args);
					if ( $wp_query->have_posts() ):
						while( $wp_query->have_posts() ) :
							$wp_query->the_post();
							get_template_part( 'content', 'gallery' );
						endwhile;
						get_template_part( 'includes/pagination' );
					endif;
					?>
				</ul>
			
			</div>
		</div>
	</div>

<?php get_footer(); ?>