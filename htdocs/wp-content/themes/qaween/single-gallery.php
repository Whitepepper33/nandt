<?php
/**
 * Template for displaying single posts in the Gallery post type.
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
					while ( have_posts() ) {
						the_post();
					?>
					<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="post-content">
							<?php
								$images = array();
								if ( has_post_thumbnail() ) :
									$feat_thumb_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'gallery-thumb');
									$feat_large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
									$images[] = array( 'thumb' => $feat_thumb_image_url[0], 'large' => $feat_large_image_url[0], 'title' => get_the_title() );

									$args = array( 'numberposts' => null, 'order' => 'ASC', 'post_type' => 'attachment', 'post_status' => null, 'post_mime_type' => 'image', 'post_parent' => get_the_ID(), 'showposts' => -1 );
									$attachments = get_posts($args);
									if ($attachments) {
										foreach ($attachments as $attachment) {
											$other_thumb_image_url = wp_get_attachment_image_src( $attachment->ID, 'gallery-thumb' );
											$other_large_image_url = wp_get_attachment_image_src( $attachment->ID, 'large' );
											if ( $other_large_image_url[0] != $feat_large_image_url[0] )
												$images[] = array( 'thumb' => $other_thumb_image_url[0], 'large' => $other_large_image_url[0], 'title' => $attachment->post_title );
										}
									}
								endif;
								
								if ( $images ) :
							?>
							<ul class="galleries gallery-photos">
								<?php foreach ( $images as $image ) : ?>
									<li class="gallery-item">
										<div class="overlay">
											<a href="<?php echo $image['large']; ?>" class="center" rel="prettyPhoto<?php echo ( count($images) ? '['.get_the_ID().']' : '' ); ?>" title="<?php echo $image['title']; ?>"><i class="fa fa-expand"></i></a>
										</div>
										<a href="<?php echo $image['large']; ?>"><img src="<?php echo $image['thumb']; ?>" alt="" class="gallery-thumb" /></a>
									</li>
								<?php endforeach; ?>
							</ul>
							<?php endif; ?>

							<?php the_content(); ?>

							<?php get_template_part( 'includes/share-buttons' ); // load share buttons ?>
						</div>
					</div>
					<?php
					}
				?>
			</div>
		</div>
	</div>

<?php get_footer(); ?>