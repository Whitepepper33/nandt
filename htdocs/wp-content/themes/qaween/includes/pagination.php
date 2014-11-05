<?php
/**
 * Template for displaying pagination
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<?php global $wp_query; if($wp_query->max_num_pages > 1) : ?>
<div class="clear"></div>

<!-- Start: Pagination -->
<div id="pagination">
<?php
	previous_posts_link( __('Previous', 'qaween') );
	next_posts_link( __('Next', 'qaween') );
?>
</div>
<!-- End: Pagination -->
<?php endif; ?>