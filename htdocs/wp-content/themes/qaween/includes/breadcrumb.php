<?php
/**
 * Template for displaying Yoast breadcrumb
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<?php
if ( function_exists( 'yoast_breadcrumb' ) ) {
	yoast_breadcrumb('<div id="breadcrumb">','</div>');
}
?>