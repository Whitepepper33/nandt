<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<!-- Start: Right Column -->
<div id="rightcol">
<?php
if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Sidebar') ) { 
	echo '<div class="container"><p class="no-widget">';
	_e('There\'s no widget assigned. You can start assigning widgets to "Sidebar" widget area from the <a href="'. admin_url('/widgets.php') .'">Widgets</a> page.', 'qaween');
	echo '</p></div>';
}
?>
</div>
<!-- End: Right Column -->