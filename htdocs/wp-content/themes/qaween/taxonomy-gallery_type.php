<?php
/**
 * Template for displaying taxonomy from gallery_type taxonomy
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
		<?php $term =	$wp_query->queried_object; ?>
		<h1 class="title"><?php echo $term->name; ?></h1>

		<?php get_template_part( 'includes/breadcrumb' ); ?>
	</div>
	<!-- End: Page Title -->
        
	<div class="container main">
		<div div class="content full">
			<div class="content-wrapper">
				<ul id="grid" class="posts gallery-post">
					<?php
					if ( get_query_var('paged') ) {
						$paged = get_query_var('paged');
					} elseif ( get_query_var('page') ) {
						$paged = get_query_var('page');
					} else {
						$paged = 1;
					}

					if ( have_posts() ) {
						while( have_posts() ) {
							the_post();
							get_template_part( 'content', 'gallery' );
						}

						get_template_part( 'includes/pagination' );
					}
					?>
				</ul>
			
			</div>
		</div>
	</div>

<?php get_footer(); ?>