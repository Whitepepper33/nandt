<?php
/**
 * Template Name: Blog Style
 * 
 * Template for displaying all posts, blog style.
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
					if ( get_query_var('paged') ) {
						$paged = get_query_var('paged');
					} elseif ( get_query_var('page') ) {
						$paged = get_query_var('page');
					} else {
						$paged = 1;
					}
					$args=array(
						'post_type' => 'post',
						'post_status' => 'publish',
						'paged' => $paged
					);
					$wp_query = new WP_Query();
					$wp_query->query($args);
					if ( $wp_query->have_posts() ):
						while( $wp_query->have_posts() ) :
							$wp_query->the_post();
							get_template_part( 'content' );
						endwhile;
						get_template_part( 'includes/pagination' );
					endif;
					?>
				</div>
			
				<?php get_sidebar(); ?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>