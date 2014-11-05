<?php
/**
 * Template Name: Homepage
 * 
 * Template for displaying homepage widget area.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<?php get_header(); ?>

<?php 
if ( ! function_exists('dynamic_sidebar') || ! dynamic_sidebar('Homepage') ) {
	echo '<div class="container"><p class="no-widget">';
	_e('There\'s no widget assigned. You can start assigning widgets to "Homepage" widget area from the <a href="'. admin_url('/widgets.php') .'">Widgets</a> page.', 'qaween');
	echo '</p></div>';
}
?>

<?php get_footer(); ?>