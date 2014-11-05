<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
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
				<div id="leftcol" class="posts">
					<?php
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							get_template_part( 'content' );
						}
						get_template_part( 'includes/pagination' );
					} else {
						_e('The page you\'re looking for is not available. The page may have been deleted or unpublished.', 'qaween');
					}
					?>
				</div>
			
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>