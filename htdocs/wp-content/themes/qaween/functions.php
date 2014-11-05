<?php
/**
 * List of files inclusion and functions
 *
 * Define global variables:
 * $themename : theme name information
 * $shortname : short name information
 * $version : current theme version
 * 
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

global $themename, $shortname, $version;
	
$themename = 'Qaween';
$shortname = 'qaween';
$version = wp_get_theme()->Version;


/**
 * Loads the ReduxFramework
 * 
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/functions/redux/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/functions/redux/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/functions/theme-options/options-config.php' ) ) {
    require_once( dirname( __FILE__ ) . '/functions/theme-options/options-config.php' );
}

// Include theme functions
require_once( get_template_directory() . '/functions/theme-functions/theme-widgets.php' ); // Load widgets
require_once( get_template_directory() . '/functions/theme-functions/theme-support.php' ); // Load theme support
require_once( get_template_directory() . '/functions/theme-functions/theme-functions.php' ); // Load custom functions
require_once( get_template_directory() . '/functions/theme-functions/theme-styles.php' ); // Load JavaScript, CSS & comment list layout
require_once( get_template_directory() . '/functions/class-tgm-plugin-activation.php' ); // Load TGM-Plugin-Activation


/**
 * After setup theme
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
function warrior_theme_init(){
	add_action( 'widgets_init', 'warrior_register_sidebars' );
}
add_action( 'after_setup_theme', 'warrior_theme_init' );


/**
 * Required & recommended plugins
 * *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
function warrior_required_plugins() {
	$plugins = array(
		array(
			'name'			=> 'Qaween Plugin',
			'version' 		=> '1.0.0',
			'slug'			=> 'qaween-plugin',
			'source'		=> get_template_directory() . '/plugins/qaween-plugin.zip',
			'external_url'	=> '',
			'required'		=> true,
		),
		array(
			'name'			=> 'Advanced Custom Fields',
			'slug'			=> 'advanced-custom-fields',
			'required'		=> true,
		),
		array(
			'name'			=> 'Shortcodes Ultimate',
			'slug'			=> 'shortcodes-ultimate',
			'required'		=> true,
		),
		array(
			'name'			=> 'WordPress SEO by Yoast',
			'slug'			=> 'wordpress-seo',
			'required'		=> false,
		),
	);

	$string = array(
		'page_title' => __( 'Install Required Plugins', 'qaween' ),
		'menu_title' => __( 'Install Plugins', 'qaween' ),
		'installing' => __( 'Installing Plugin: %s', 'qaween' ),
		'oops' => __( 'Something went wrong with the plugin API.', 'qaween' ),
		'notice_can_install_required' => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ),
		'notice_can_install_recommended' => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ),
		'notice_cannot_install' => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ),
		'notice_can_activate_required' => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ),
		'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ),
		'notice_cannot_activate' => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ),
		'notice_ask_to_update' => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ),
		'notice_cannot_update' => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ),
		'install_link' => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
		'activate_link' => _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
		'return' => __( 'Return to Required Plugins Installer', 'qaween' ),
		'plugin_activated' => __( 'Plugin activated successfully.', 'qaween' ),
		'complete' => __( 'All plugins installed and activated successfully. %s', 'qaween' ),
		'nag_type' => 'updated'
	);

	$theme_text_domain = 'qaween';

	$config = array(
		'domain' => 'qaween',
		'default_path' => '',
		'parent_menu_slug' => 'themes.php',
		'parent_url_slug' => 'themes.php',
		'menu' => 'install-plugins',
		'has_notices' => true,
		'is_automatic' => true,
		'message' => '',
		'strings' => $string
	);

	tgmpa($plugins, $config);
}
add_action('tgmpa_register', 'warrior_required_plugins');
