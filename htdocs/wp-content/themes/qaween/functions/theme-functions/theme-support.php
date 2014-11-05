<?php
/**
* List of theme support functions
*/


// Check if the function exist
if ( function_exists( 'add_theme_support' ) ) {
	// Add post thumbnail feature
	add_theme_support( 'post-thumbnails' );
	add_image_size('small-thumb', 460, 300, true); // small thumb
	add_image_size('medium-thumb', 500, 330, true); // medium thumb
	add_image_size('large-thumb', 630, 410, true); // large thumb
	add_image_size('gallery-thumb', 330, 220, true); // gallery thumb
	add_image_size('blog-thumb', 520, 520, true); // blog thumb
	add_image_size('event-thumb', 520, 300, true); // event thumb
	
	// Add WordPress navigation menus
	add_theme_support('nav-menus');
	register_nav_menus( array(
		'main-menu' => __( 'Main Menu', 'qaween' ),
	) );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Add custom background feature 
	add_theme_support( 'custom-background' );
}

/**
 * Function to enable localization
 * Text domain is set to to theme name in lower case
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.2
 */
if( ! function_exists('warrior_localization') ) {
	function warrior_localization(){
	    load_theme_textdomain('qaween', get_template_directory() . '/lang');
	}
}
add_action('after_setup_theme', 'warrior_localization');

// Set maximum image width displayed in a single post or page
if ( ! isset( $content_width ) ) {
	$content_width = 705;
}