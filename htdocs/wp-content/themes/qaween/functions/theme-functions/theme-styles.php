<?php
/**
 * Function to load JS & CSS files
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

if ( ! function_exists( 'warrior_enqueue_scripts' ) ) {
	function warrior_enqueue_scripts() {
		global $qaween_option;

		// Load all Javascript files
		wp_enqueue_script('jquery');

		if ( is_singular() ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_script('superfish', get_template_directory_uri() .'/js/superfish.js', '', '1.4.8', true);
		wp_enqueue_script('stellar', get_template_directory_uri() .'/js/jquery.stellar.min.js', '', '0.6.2', true);
		wp_enqueue_script('widget_map', 'http://maps.google.com/maps/api/js?sensor=false', '', '0.6.2', true);

		// Only load in homepage
		if( is_home() || is_front_page() ) {
			wp_enqueue_script('backstretch', get_template_directory_uri() .'/js/jquery.backstretch.min.js', '', '2.0.4', true);
			wp_enqueue_script('countdown', get_template_directory_uri() .'/js/jquery.countdown.min.js', '', '2.0.1', true);
		}

		// Only load page-gallery.php page template
		if( is_page_template('page-gallery.php') || is_tax('gallery_type') || is_home() || is_front_page() ) { 
			wp_enqueue_script('mixitup', get_template_directory_uri() .'/js/jquery.mixitup.min.js', '', '1.5.4', true);
		}
		
		wp_enqueue_script('prettyPhoto', get_template_directory_uri() .'/js/jquery.prettyPhoto.js', '', '3.1.5', true);
		wp_enqueue_script('mobilemenu', get_template_directory_uri() .'/js/jquery.mobilemenu.js', '', '3.1.5', true);
		wp_enqueue_script('flexverticalcenter', get_template_directory_uri() .'/js/jquery.flexverticalcenter.js', '', '1.0', true);
		wp_enqueue_script('functions', get_template_directory_uri() .'/js/functions.js', '', null, true);
			
		// Localize script
		if( isset($qaween_option['wedding_date']) && isset($qaween_option['wedding_time']) ) {
			$wedding_date_time = $qaween_option['wedding_date'] . $qaween_option['wedding_time'];
		} else {
			$wedding_date_time = '';
		}

		wp_localize_script('functions', '_warrior', array(
			'ajaxurl' => admin_url('admin-ajax.php'),
			'countdown_time' => date('F, d Y H:i', strtotime( $wedding_date_time ) ),
			'countup_title' => __("We've Been Married For:", 'qaween'),
			'map_market_icon' => get_template_directory_uri() . '/images/map-marker.png',
			'map_market_shadow' => get_template_directory_uri() . '/images/map-marker-shadow.png'
		));

		// Load all CSS files		
		wp_enqueue_style('style', get_stylesheet_directory_uri() .'/style.css', array(), null, 'all');
		wp_enqueue_style('prettyPhoto', get_template_directory_uri() . '/css/prettyPhoto.css', array(), '3.1.5', 'all' );

		wp_enqueue_style('responsive', get_template_directory_uri() .'/css/responsive.css', array(), null, 'all');
		
		// RTL Support
		if( $qaween_option['enable_rtl'] == '1' ) {
			wp_enqueue_style('rtl', get_template_directory_uri() . '/css/rtl.css', array(), '1.0.0', 'all' );
		}
			
		// Load custom CSS file
		wp_enqueue_style('custom', get_template_directory_uri() .'/custom.css', array(), null, 'screen');
	}
}
add_action( 'wp_enqueue_scripts', 'warrior_enqueue_scripts' );


/**
 * Function to load JS & CSS files on wp-admin
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'warrior_enqueue_scripts_admin' ) ) {
	function warrior_enqueue_scripts_admin() {
		global $qaween_option, $pagenow;

		wp_enqueue_style( 'jquery-ui', get_template_directory_uri() .'/css/jquery-ui.css', array(), '1.10.3', 'screen' );
		wp_enqueue_style( 'jquery-ui-timepicker-addon', get_template_directory_uri() .'/css/jquery-ui-timepicker-addon.css', array(), '1.4.3', 'screen' );

		if( $pagenow == 'admin.php' ) {
			wp_enqueue_style( 'redux-custom-css', get_template_directory_uri() .'/css/redux-custom.css', array(), time(), 'screen' );
		}

		if( $pagenow == 'widgets.php' ) {
			wp_enqueue_media();
			wp_enqueue_script('widget-script', get_template_directory_uri() . '/js/widget-script.js', null, null, true);
		}

		// RTL Support
		if( $qaween_option['enable_rtl'] == '1' ) {
			add_editor_style( array( 'css/editor-style-rtl.css') );
		}

		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'timepicker', get_template_directory_uri() . '/js/jquery-ui-timepicker-addon.js', '', '1.4.3', true );
	}
}
add_action( 'admin_enqueue_scripts', 'warrior_enqueue_scripts_admin' );

function my_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );


/**
 * Function to generate the several styles from theme options
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'warrior_add_styles_theme_options' ) ) {
	function warrior_add_styles_theme_options() {
		global $qaween_option;
		?>
		<style type="text/css">
			#breadcrumb {
				text-shadow: 1px 1px <?php echo $qaween_option['breadcrumb_text_shadow']; ?>;
			}

			<?php if( $qaween_option['fade_effect'] == '2' ) : ?>
			.animate {
			    opacity: 1 !important;
			    filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100) !important;
			    -ms-filter:'progid:DXImageTransform.Microsoft.Alpha(Opacity=100)' !important;
			}
			<?php endif; ?>
		</style>
		<?php
	}
}
add_action( 'wp_enqueue_scripts', 'warrior_add_styles_theme_options' );


/**
 * Function to add style & script code on wp-admin
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'warrior_add_scripts_admin' ) ) {
	function warrior_add_scripts_admin() {
		?>
		<style type="text/css">
			.ui-datepicker { font-family: inherit; font-size: 1em; }
			#dashboard_right_now .person-count a:before { content: '\f110'; }
			#dashboard_right_now h4.sub { margin: 0 -12px 10px; padding-top: 6px; font-weight: 600; }
		</style>
		<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#acf-field-event_date').datetimepicker({ dateFormat: "yy/mm/dd", timeFormat: "HH:mm" });
		});
		</script>
		<?php
	}
}
add_action( 'admin_footer', 'warrior_add_scripts_admin' );