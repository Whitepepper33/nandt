<?php
/**
 * Template for displaying Page post type.
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
		<div div class="content">
			<div class="content-wrapper">
				<div id="leftcol" class="posts">
					<?php
						while ( have_posts() ) {
							the_post();
							the_content();
							wp_link_pages( array( 'before' => '<p class="page-links"><span class="page-links-title">' . __( 'Pages:', 'qaween' ) . '</span>', 'after' => '</p>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
						}
					?>
					<?php get_template_part( 'includes/share-buttons' ); // load share buttons ?>
					<?php comments_template( '', true ); ?>
				</div>
			
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>