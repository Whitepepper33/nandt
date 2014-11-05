<?php
/**
 * Template for displaying 404 pages (Not Found)
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<?php get_header(); ?>

	<!-- Start: Page Title -->
	<div class="page-title" data-stellar-ratio="2">
		<h1 class="title"><?php echo qaween_archive_title(); ?></h1>

		<?php get_template_part( 'includes/breadcrumb' ); ?>
	</div>
	<!-- End: Page Title -->
        
	<div class="container main">
		<div div class="content full">
			<div class="content-wrapper">
				<div class="post-content">
					<p><?php _e('The page you\'re looking for is not available. The page may have been deleted or unpublished.', 'qaween');?></p>
				</div>
			</div>
		</div>
	</div>

<?php get_footer(); ?>