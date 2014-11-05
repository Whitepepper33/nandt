<?php
/**
 * Function to register widget areas
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'warrior_register_sidebars' ) ) {
	function warrior_register_sidebars(){
		if ( function_exists('register_sidebar') ) {

			// Sidebar Widget
			register_sidebar(array(
				'name' 			=> __('Sidebar', 'qaween'),
				'description'	=> __('Widgets will be displayed in homepage.', 'qaween'),
				'before_widget'	=> '<div id="widget-%1$s" class="widget %2$s">',
				'after_widget' 	=> '</div>',
				'before_title' 	=> '<div class="sidebar-title"><h3><label>',
				'after_title' 	=> '</label></h3></div>',
			));

			// Homepage Widget
			register_sidebar(array(
				'name' 			=> __('Homepage', 'qaween'),
				'description'	=> __('Widgets will be displayed in post &amp; pages that have sidebar.', 'qaween'),
				'before_widget' => '<section id="widget-%1$s" class="container main %2$s">',
				'after_widget' 	=> '</section>',
				'before_title' 	=> '<div class="section-heading animate"><h2>',
				'after_title' 	=> '</h2></div>',
			));

		}
	}
}


/**
 * Function to remove default widgets after theme switch
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'warrior_removed_default_widgets' ) ) {
	function warrior_removed_default_widgets(){
		global $wp_registered_sidebars;
		$widgets = get_option('sidebars_widgets');
		foreach ($wp_registered_sidebars as $sidebar=>$value) {
			unset($widgets[$sidebar]);
		}
		update_option('sidebars_widgets', $widgets);
	}
}

if ( is_admin() && $pagenow == 'themes.php' && isset($_GET['activated'] ) )
	add_action( 'admin_init', 'warrior_removed_default_widgets' );

// Load Custom Widgets
include_once( get_template_directory() . '/includes/widgets/warrior-twitter.php' );
include_once( get_template_directory() . '/includes/widgets/warrior-about-couple.php' );
include_once( get_template_directory() . '/includes/widgets/warrior-blog.php' );
include_once( get_template_directory() . '/includes/widgets/warrior-countdown.php' );
include_once( get_template_directory() . '/includes/widgets/warrior-slideshow.php' );
include_once( get_template_directory() . '/includes/widgets/warrior-gallery.php' );
include_once( get_template_directory() . '/includes/widgets/warrior-rsvp.php' );
include_once( get_template_directory() . '/includes/widgets/warrior-couple-tweets.php' );
include_once( get_template_directory() . '/includes/widgets/warrior-map.php' );
?>