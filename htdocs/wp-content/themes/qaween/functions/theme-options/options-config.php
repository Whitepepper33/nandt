<?php

/**
	ReduxFramework Sample Config File
	For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
**/

if ( !class_exists( "ReduxFramework" ) ) {
	return;
} 

if ( !class_exists( "Redux_Framework_sample_config" ) ) {
	class Redux_Framework_sample_config {

		public $args = array();
		public $sections = array();
		public $theme;
		public $ReduxFramework;

		public function __construct( ) {

			// Just for demo purposes. Not needed per say.
			$this->theme = wp_get_theme();

			// Set the default arguments
			$this->setArguments();

			// Create the sections and fields
			$this->setSections();
			
			if ( !isset( $this->args['opt_name'] ) ) { // No errors please
				return;
			}
			
			$this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
			

			// If Redux is running as a plugin, this will remove the demo notice and links
			//add_action( 'redux/plugin/hooks', array( $this, 'remove_demo' ) );
			
			// Function to test the compiler hook and demo CSS output.
			//add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2); 
			// Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.

			// Change the arguments after they've been declared, but before the panel is created
			//add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
			
			// Change the default value of a field after it's been set, but before it's been used
			//add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );

			// Dynamically add a section. Can be also used to modify sections/fields
			add_filter('redux/options/'.$this->args['opt_name'].'/sections', array( $this, 'dynamic_section' ) );

		}


		/**

			This is a test function that will let you see when the compiler hook occurs. 
			It only runs if a field	set with compiler=>true is changed.

		**/

		function compiler_action($options, $css) {
			//echo "<h1>The compiler hook has run!";
			//print_r($options); //Option values
			
			//print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

			/*
			// Demo of how to use the dynamic CSS and write your own static CSS file
		    $filename = dirname(__FILE__) . '/style' . '.css';
		    global $wp_filesystem;
		    if( empty( $wp_filesystem ) ) {
		        require_once( ABSPATH .'/wp-admin/includes/file.php' );
		        WP_Filesystem();
		    }

		    if( $wp_filesystem ) {
		        $wp_filesystem->put_contents(
		            $filename,
		            $css,
		            FS_CHMOD_FILE // predefined mode settings for WP files
		        );
		    }
			*/
		}



		/**
		 
		 	Custom function for filtering the sections array. Good for child themes to override or add to the sections.
		 	Simply include this function in the child themes functions.php file.
		 
		 	NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
		 	so you must use get_template_directory_uri() if you want to use any of the built in icons
		 
		 **/

		function dynamic_section($sections){
		    //$sections = array();
		    $sections[] = array(
		        'title' => __('Section via hook', 'qaween'),
		        'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'qaween'),
				'icon' => 'el-icon-paper-clip',
				    // Leave this as a blank section, no options just some intro text set above.
		        'fields' => array()
		    );

		    return $sections;
		}
		
		
		/**

			Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

		**/
		
		function change_arguments($args){
		    //$args['dev_mode'] = true;
		    
		    return $args;
		}
			
		
		/**

			Filter hook for filtering the default value of any given field. Very useful in development mode.

		**/

		function change_defaults($defaults){
		    $defaults['str_replace'] = "Testing filter hook!";
		    
		    return $defaults;
		}


		// Remove the demo link and the notice of integrated demo from the redux-framework plugin
		function remove_demo() {
			
			// Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
			if ( class_exists('ReduxFrameworkPlugin') ) {
				remove_filter( 'plugin_row_meta', array( ReduxFrameworkPlugin::get_instance(), 'plugin_meta_demo_mode_link'), null, 2 );
			}

			// Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
			remove_action('admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );	

		}


		public function setSections() {

			/**
			 	Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
			 **/


			// Background Patterns Reader
			$sample_patterns_path = ReduxFramework::$_dir . '../theme-options/patterns/';
			$sample_patterns_url  = ReduxFramework::$_url . '../theme-options/patterns/';
			$sample_patterns      = array();

			if ( is_dir( $sample_patterns_path ) ) :
				
			  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
			  	$sample_patterns = array();

			    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

			      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
			      	$name = explode(".", $sample_patterns_file);
			      	$name = str_replace('.'.end($name), '', $sample_patterns_file);
			      	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
			      }
			    }
			  endif;
			endif;

			ob_start();

			$ct = wp_get_theme();
			$this->theme = $ct;
			$item_name = $this->theme->get('Name'); 
			$tags = $this->theme->Tags;
			$screenshot = $this->theme->get_screenshot();
			$class = $screenshot ? 'has-screenshot' : '';

			$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','qaween' ), $this->theme->display('Name') );

			?>
			<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
				<?php if ( $screenshot ) : ?>
					<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
					<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
						<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
					</a>
					<?php endif; ?>
					<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
				<?php endif; ?>

				<h4>
					<?php echo $this->theme->display('Name'); ?>
				</h4>

				<div>
					<ul class="theme-info">
						<li><?php printf( __('By %s','qaween'), $this->theme->display('Author') ); ?></li>
						<li><?php printf( __('Version %s','qaween'), $this->theme->display('Version') ); ?></li>
						<li><?php echo '<strong>'.__('Tags', 'qaween').':</strong> '; ?><?php printf( $this->theme->display('Tags') ); ?></li>
					</ul>
					<p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
					<?php if ( $this->theme->parent() ) {
						printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
							__( 'http://codex.wordpress.org/Child_Themes','qaween' ),
							$this->theme->parent()->display( 'Name' ) );
					} ?>
					
				</div>

			</div>

			<?php
			$item_info = ob_get_contents();
			    
			ob_end_clean();

			$sampleHTML = '';
			if( file_exists( dirname(__FILE__).'/info-html.html' )) {
				/** @global WP_Filesystem_Direct $wp_filesystem  */
				global $wp_filesystem;
				if (empty($wp_filesystem)) {
					require_once(ABSPATH .'/wp-admin/includes/file.php');
					WP_Filesystem();
				}  		
				$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
			}


			// ACTUAL DECLARATION OF SECTIONS
			
			// General Setings
			$this->sections[] = array(
				'icon' => 'el-icon-cogs',
				'title' => __('General Settings', 'qaween'),
				'fields' => array(						
					array(
						'id'				=> 'enable_rtl',
						'type' 				=> 'button_set',
						'title' 			=> __('RTL Support', 'qaween'), 
						'desc'				=> __('Enable right to left text support.', 'qaween'),
						'options' 			=> array('1' => 'Yes', '2' => 'No'),
						'default' 			=> '2'
					),

					array(
						'id'				=> 'tracking_code',
						'type' 				=> 'textarea',
						'title' 			=> __('Tracking Code', 'qaween'), 
						'desc' 				=> __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'qaween')
					),

                    array(
						'id'				=> 'fade_effect',
						'type' 				=> 'button_set',
                        'title'				=> __('Fade Effect', 'qaween'),
						'desc' 				=> __('Enable / disable fade effect when scrolling the page.', 'qaween'),
						'options' 			=> array('1' => 'Yes', '2' => 'No'),
						'default' 			=> '1'
                    ),

					array(
						'id'				=> 'admin_email',
						'type' 				=> 'text',
						'title' 			=> __('Admin Email', 'qaween'), 
						'desc' 				=> __('Will be use to send the RSVP form submission.', 'qaween'),
						'placeholder'		=> 'yourname@domain.com',
						'validate' 			=> 'email',
						'default'			=> get_option('admin_email'),
					),
				)
			);

			// The Wedding Setings
			$this->sections[] = array(
				'icon' => ' el-icon-calendar',
				'title' => __('The Wedding', 'qaween'),
				'fields' => array(
					// Time & Location
					array(
				        'id'   					=> 'divider_couple_bride',
				        'type' 					=> 'info',
				        'desc'					=> 'Wedding Date & Location',
			    	),

					array(
						'id'				=> 'wedding_date',
						'type' 				=> 'date',
				        'title'				=> __('Wedding date', 'qaween'),
				        'desc' 				=> __('Wedding date. Format: <code>MM/DD/YYYY.', 'qaween'),
				        'placeholder' 		=> __('Click to enter a date', 'qaween'),
					),

					array(
						'id'				=> 'wedding_time',
						'type' 				=> 'text',
				        'title'				=> __('Wedding time', 'qaween'),
				        'desc' 				=> __('Wedding time. Format: <code>HH:MM</code> (24 hour format).', 'qaween'),
				        'placeholder' 		=> __('For example 14:00', 'qaween')
					),

					array(
						'id'				=> 'wedding_location',
						'type' 				=> 'text',
						'title' 			=> __('Wedding Location', 'qaween'), 
					),


					array(
				        'id'					=> 'wedding_events',
				        'type' 					=> 'multi_text',
				        'title' 				=> __('Wedding Events', 'qaween'),
				        'desc' 					=> __('The events will be displayed in the RSVP form widget', 'qaween'),
				        'default'				=> array('Wedding Ceremony', 'Wedding Party'),
				    ),
				)
			);

			
			// The Couple Setings
			$this->sections[] = array(
				'icon' 			=> 'el-icon-heart',
				'title' 		=> __('The Couple', 'qaween'),
				'fields' => array(
					// Groom
					array(
				        'id'   				=> 'divider_couple_groom',
				        'desc' 				=> __('Groom Info', 'qaween'),
				        'type' 				=> 'info'
				    ),

					array(
						'id'				=> 'name_groom',
						'type' 				=> 'text',
						'title' 			=> __('Groom Full Name', 'qaween'), 
					),

					array(
						'id'				=> 'about_groom',
						'type' 				=> 'textarea',
						'title' 			=> __('Groom short description', 'qaween'),
					),

					array(
						'id'				=> 'photo_groom',
						'type' 				=> 'media', 
						'url'				=> true,
						'title' 			=> __('Groom Photo', 'qaween'),
						'desc'				=> __('Please upload 150x150 image.', 'qaween'),
						'compiler' 			=> 'true',
						'default'			=> array('url' => 'http://placehold.it/200x200/f5f5f5/666666/&text=Groom'),
					),

					array(
						'id'				=> 'url_facebook_groom',
						'type' 				=> 'text',
						'title' 			=> __('Groom Facebook Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_twitter_groom',
						'type' 				=> 'text',
						'title' 			=> __('Groom Twitter Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_gplus_groom',
						'type' 				=> 'text',
						'title' 			=> __('Groom Google+ Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_pinterest_groom',
						'type' 				=> 'text',
						'title' 			=> __('Groom Pinterest Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_youtube_groom',
						'type' 				=> 'text',
						'title' 			=> __('Groom Youtube Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_flickr_groom',
						'type' 				=> 'text',
						'title' 			=> __('Groom Flickr Profile URL', 'qaween'), 
					),

					// Bride
					array(
				        'id'   					=> 'divider_couple_bride',
				        'type' 					=> 'info',
				        'desc'					=> 'The Bride',
			    	),

					array(
						'id'				=> 'name_bride',
						'type' 				=> 'text',
						'title' 			=> __('Bride Full Name', 'qaween'), 
					),

					array(
						'id'				=> 'about_bride',
						'type' 				=> 'textarea',
						'title' 			=> __('Bride short description', 'qaween'),
					),

					array(
						'id'				=> 'photo_bride',
						'type' 				=> 'media', 
						'url'				=> true,
						'title' 			=> __('Bride Photo', 'qaween'),
						'desc'				=> __('Please upload 150x150 image.', 'qaween'),
						'compiler' 			=> 'true',
						'default'			=> array('url' => 'http://placehold.it/200x200/f5f5f5/666666/&text=Bride'),
					),

					array(
						'id'				=> 'url_facebook_bride',
						'type' 				=> 'text',
						'title' 			=> __('Bride Facebook Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_twitter_bride',
						'type' 				=> 'text',
						'title' 			=> __('Bride Twitter Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_gplus_bride',
						'type' 				=> 'text',
						'title' 			=> __('Bride Google+ Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_pinterest_bride',
						'type' 				=> 'text',
						'title' 			=> __('Bride Pinterest Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_youtube_bride',
						'type' 				=> 'text',
						'title' 			=> __('Bride Youtube Profile URL', 'qaween'), 
					),

					array(
						'id'				=> 'url_flickr_bride',
						'type' 				=> 'text',
						'title' 			=> __('Bride Flickr Profile URL', 'qaween'), 
					),
				)
			);


			// Appearance Settings
			$this->sections[] = array(
				'icon' => 'el-icon-website',
				'title' => __('Appearance', 'qaween'),
				'fields' => array(						
					array(
						'id'				=> 'logo_type',
						'type' 				=> 'button_set',
						'title' 			=> __('Logo Type', 'qaween'), 
						'subtitle' 			=> __('No validation can be done on this field type', 'qaween'),
						'desc'				=> __('Select logo type.', 'qaween'),
						'options' 			=> array('1' => 'Text', '2' => 'Image'),
						'default' 			=> '1'
					),

					array(
						'id'				=> 'logo_text',
						'type' 				=> 'text',
						'required' 			=> array('logo_type', 'equals', '1'),
						'title' 			=> __('Text Logo', 'qaween'), 
						'desc' 				=> __('Bride & Groom names separated by <code>*</code>. Line break using <code>|</code>.', 'qaween'),
						'placeholder'		=> 'Groom | Name * Bride | Name',
						'default'			=> 'Groom | Name * Bride | Name'
					),

					array(
						'id'				=> 'logo_image',
						'type' 				=> 'media', 
						'url'				=> true,
						'required' 			=> array('logo_type', 'equals', '2'),
						'title' 			=> __('Image Logo', 'qaween'),
						'compiler' 			=> 'true',
						'desc'				=> __('Upload your logo or type the URL on the text box.', 'qaween'),
						'default'			=> array('url'=>'http://s.wordpress.org/style/images/codeispoetry.png'),
					),

					array(
						'id'				=> 'favicon',
						'type' 				=> 'media', 
						'url'				=> true,
						'title' 			=> __('Favicon', 'qaween'),
						'compiler' 			=> 'true',
						'desc'				=> __('Upload your logo or type the URL on the text box.', 'qaween'),
						'default'			=> array('url' => get_stylesheet_directory_uri() .'/images/favicon.png'),
					),

					array(
				        'id'       			=> 'custom_css',
				        'type'     			=> 'ace_editor',
				        'title'    			=> __('Custom CSS Code', 'qaween'), 
				        'desc' 			=> __('Paste your custom CSS code here.', 'qaween'),
				        'mode'     			=> 'css',
				        'theme'    			=> 'monokai',
				    ),
				)
			);

			// Color Settings
			$this->sections[] = array(
				'icon'    => 'el-icon-brush',
				'title'   => __('Colors', 'qaween'),
				'fields'  => array(
					array(
				        'id'       				=> 'body_background',
				        'type'     				=> 'background',
				        'title'    				=> __('Body Background', 'qaween'),
				        'output'				=> array('body'),
				        'preview_media'			=> true,
				        'background-repeat'     => true,
		                'background-attachment' => true,
		                'background-position'   => true,
		                'background-image'      => true,
		                'background-gradient'   => false,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => true,
						'default'				=> array(
													'background-color'		=> '#ffffff',
												)
					),

					array(
				        'id'       				=> 'countdown_background',
				        'type'     				=> 'background',
				        'title'    				=> __('Countdown Background', 'qaween'),
				        'output'				=> array('#countdown'),
				        'preview_media'			=> true,
				        'background-repeat'     => true,
		                'background-attachment' => true,
		                'background-position'   => true,
		                'background-image'      => true,
		                'background-gradient'   => true,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => true,
						'default'				=> array(
													'background-color'		=> '#eeeeee',
												)
					),

					array(
				        'id'       				=> 'page_title_background',
				        'type'     				=> 'background',
				        'title'    				=> __('Page Title Background', 'qaween'),
				        'output'				=> array('.page-title'),
				        'preview_media'			=> true,
				        'background-repeat'     => true,
		                'background-attachment' => true,
		                'background-position'   => true,
		                'background-image'      => true,
		                'background-gradient'   => true,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => true,
						'default'				=> array(
													'background-color'		=> '#eeeeee',
												)
					),

					array(
				        'id'       				=> 'rsvp_background',
				        'type'     				=> 'background',
				        'title'    				=> __('RSVP Background', 'qaween'),
				        'output'				=> array('#rsvp'),
				        'preview_media'			=> true,
				        'background-repeat'     => true,
		                'background-attachment' => true,
		                'background-position'   => true,
		                'background-image'      => true,
		                'background-gradient'   => true,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => true,
						'default'				=> array(
													'background-color'		=> '#eeeeee',
												)
					),

					array(
				        'id'       			=> 'rsvp_text_color',
				        'type'     			=> 'color',
				        'title'    			=> __('RSVP Text Color', 'qaween'),
				        'output'   			=> array('#rsvp .widget-title p'),
				        'default'  			=> '#555555',
				        'validate' 			=> 'color'
					),

					array(
				        'id'       				=> 'rsvp_form_background',
				        'type'     				=> 'background',
				        'title'    				=> __('RSVP Form Background', 'qaween'),
				        'output'				=> array('#rsvp form'),
				        'preview'				=> false,
				        'preview_media'			=> false,
				        'background-repeat'     => false,
		                'background-attachment' => false,
		                'background-position'   => false,
		                'background-image'      => false,
		                'background-gradient'   => false,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => false,
						'default'				=> array(
													'background-color'		=> '#fff',
												)
					),

					array(
				        'id'       			=> 'link_color',
				        'type'     			=> 'link_color',
				        'title'    			=> __('Main Link Color', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('a'),
				        'default'  => array(
				            'regular'  => '#1952a9',
				            'hover'    => '#e36060',
				        )
					),

					array(
				        'id'       			=> 'menu_link_color',
				        'type'     			=> 'link_color',
				        'title'    			=> __('Menu Link Color', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('.nav li a', '.nav li.current-menu-item a', '.nav li.current_page_item a'),
				        'default'  			=> array(
				            'regular'  		=> '#555555',
				            'hover'    		=> '#838383',
				        )
					),

					array(
				        'id'       				=> 'menu_background',
				        'type'     				=> 'background',
				        'title'    				=> __('Menu Background', 'qaween'),
				        'output'				=> array('nav.main', 'nav.main ul.sub-menu'),
				        'preview'				=> false,
				        'preview_media'			=> false,
				        'background-repeat'     => false,
		                'background-attachment' => false,
		                'background-position'   => false,
		                'background-image'      => false,
		                'background-gradient'   => true,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => false,
						'default'				=> array(
							'background-color'	=> '#ffffff',
						)
					),

					array(
				        'id'       			=> 'menu_border',
				        'type'     			=> 'border',
				        'title'    			=> __('Menu Border Option', 'qaween'),
				        'output'   			=> array('nav.main'),
				        'all'				=> false,
				        'left'				=> false,
				        'right'				=> false,
				        'default' 			=> array(
				            'border-color'  => '#eeeeee',
				            'border-style'  => 'solid',
				            'border-top'    => '1px',
				            'border-bottom' => '1px', 
				        )
					),

					array(
				        'id'       			=> 'menu_separator',
				        'type'     			=> 'border',
				        'title'    			=> __('Menu Separator', 'qaween'),
				        'output'   			=> array('.nav li a'),
				        'all'				=> false,
				        'top'				=> false,
				        'bottom'			=> false,
				        'left'				=> false,
				        'default' 			=> array(
				            'border-color'  => '#eee',
				            'border-style'  => 'solid',
				            'border-right'    => '1px',
				        )
					),

					array(
				        'id'       			=> 'menu_sub_menu_border',
				        'type'     			=> 'border',
				        'title'    			=> __('Sub Menu Border', 'qaween'),
				        'output'   			=> array('.nav li ul'),
				        'all'				=> true,
				        'default' 			=> array(
				            'border-color'  => '#dedede',
				            'border-style'  => 'solid',
				            'border-width'  => '1',
				        )
					),

					array(
				        'id'       			=> 'menu_sub_menu_sepator',
				        'type'     			=> 'border',
				        'title'    			=> __('Sub Menu Separator', 'qaween'),
				        'output'   			=> array('.nav li ul li a'),
				        'all'				=> false,
				        'top'				=> false,
				        'right'				=> false,
				        'left'				=> false,
				        'default' 			=> array(
				            'border-color'  	=> '#dedede',
				            'border-style'  	=> 'solid',
				            'border-bottom'    	=> '1px',
				        )
					),

					array(
				        'id'       			=> 'slideshow_button_text',
				        'type'     			=> 'color',
				        'title'    			=> __('Slideshow Button Text', 'qaween'),
				        'output'   			=> array('#slideshow .wedding-date'),
				        'default'  			=> '#ffffff',
				        'validate' 			=> 'color'
					),

					array(
				        'id'       			=> 'slideshow_button_border',
				        'type'     			=> 'border',
				        'title'    			=> __('Slideshow Button Border', 'qaween'),
				        'output'   			=> array('#slideshow .wedding-date'),
				        'all'				=> true,
				        'default' 			=> array(
				            'border-color'  => '#ffffff', 
				            'border-style'  => 'solid', 
				            'border-width'    => '1',
				        )
					),

					array(
				        'id'       			=> 'couple_icon_link_color',
				        'type'     			=> 'link_color',
				        'title'    			=> __('Couple Social Icon Link Color', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('.social a'),
				        'default'  => array(
				            'regular'  => '#c7c7c7',
				            'hover'    => '#6a6a6a',
				            'active'   => '#c7c7c7'
				        )
					),

					array(
				        'id'       			=> 'countdown_love_icon',
				        'type'     			=> 'color',
				        'title'    			=> __('Countdown Love Icon', 'qaween'),
				        'output'   			=> array('#countdown .fa-heart'),
				        'default'  			=> '#ffffff',
				        'validate' 			=> 'color'
					),

					array(
				        'id'       			=> 'countdown_border',
				        'type'     			=> 'border',
				        'title'    			=> __('Countdown Border', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('#countdown .countdown-body'),
				        'all'				=> false,
				        'left'				=> false,
				        'right'				=> false,
				        'default' 			=> array(
				            'border-color'  => '#ffffff',
				            'border-style'  => 'solid',
				            'border-top'    => '1px',
				            'border-bottom' => '1px',
				        )
					),

					array(
				        'id'       			=> 'couple_tweets_follow_button_border',
				        'type'     			=> 'border',
				        'title'    			=> __('Couple Tweets Follow Button Border', 'qaween'),
				        'output'   			=> array('#tweets-updates div.tweets-content a.tweets-button-follow'),
				        'all'				=> true,
				        'default' 			=> array(
				            'border-color'  => '#000',
				            'border-style'  => 'solid',
				            'border-width'  => '2',
				        )
					),

					array(
				        'id'       			=> 'couple_tweets_follow_button_border_hover',
				        'type'     			=> 'border',
				        'title'    			=> __('Couple Tweets Follow Button Border Hover Color', 'qaween'),
				        'output'   			=> array('#tweets-updates div.tweets-content a.tweets-button-follow:hover'),
				        'all'				=> true,
				        'default' 			=> array(
				            'border-color'  => '#f66767',
				            'border-style'  => 'solid',
				            'border-width'  => '2',
				        )
					),

					array(
				        'id'       			=> 'couple_tweets_follow_button_text_color',
				        'type'     			=> 'link_color',
				        'title'    			=> __('Couple Tweets Follow Button Text Color', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('#tweets-updates div.tweets-content a.tweets-button-follow'),
				        'default'  => array(
				            'regular'  => '#555555',
				            'hover'    => '#f66767',
				        )
					),

					array(
				        'id'       			=> 'footer_border',
				        'type'     			=> 'border',
				        'title'    			=> __('Footer Border', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('#footer'),
				        'all'				=> false,
				        'left'				=> false,
				        'right'				=> false,
				        'bottom'			=> false,
				        'default' 			=> array(
				            'border-color'  => '#eeeeee',
				            'border-style'  => 'solid',
				            'border-top'    => '1px',
				        )
					),

					array(
				        'id'       			=> 'footer_love_icon',
				        'type'     			=> 'color',
				        'title'    			=> __('Footer Love Icon', 'qaween'),
				        'output'   			=> array('#footer .fa-heart'),
				        'default'  			=> '#eeeeee',
				        'validate' 			=> 'color'
					),

					array(
				        'id'       			=> 'divider_color_post',
				        'type'     			=> 'info',
				        'title'    			=> __('Post Settings', 'qaween'),
					),

					array(
				        'id'       			=> 'post_title_link_color',
				        'type'     			=> 'link_color',
				        'title'    			=> __('Post Title Link Color', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('.blog-title h2 a'),
				        'default'  => array(
				            'regular'  => '#000000',
				            'hover'    => '#e36060',
				        )
					),

					array(
				        'id'       			=> 'breadcrumb_text_shadow',
				        'type'     			=> 'color',
				        'title'    			=> __('Breadcrumb Text Shadow', 'qaween'),
				        'default'  			=> '#ffffff',
				        'validate' 			=> 'color'
					),

					array(
				        'id'       			=> 'breadcrumb_link_color',
				        'type'     			=> 'link_color',
				        'title'    			=> __('Breadcrumb Link Color', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('#breadcrumb a'),
				        'default'  => array(
				            'regular'  => '#555555',
				            'hover'    => '#e36060',
				        )
					),

					array(
				        'id'       			=> 'share_icon_link_color',
				        'type'     			=> 'link_color',
				        'title'    			=> __('Share Icon Color', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('.addthis_toolbox a'),
				        'default'  => array(
				            'regular'  => '#555555',
				            'hover'    => '#e36060',
				        )
					),

					array(
				        'id'       			=> 'feat_thumb_hover_button_border',
				        'type'     			=> 'border',
				        'title'    			=> __('Featured Thumbnail Hover Button Border', 'qaween'),
				        'output'   			=> array('.overlay .read-more'),
				        'all'				=> true,
				        'default' 			=> array(
				            'border-color'  	=> '#ffffff',
				            'border-style'  	=> 'solid',
				            'border-with'    	=> '1',
				        )
					),

					array(
				        'id'       			=> 'feat_thumb_hover_text_color',
				        'type'     			=> 'link_color',
				        'title'    			=> __('Featured Thumbnail Read More Color', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('.overlay .read-more'),
				        'default'  => array(
				            'regular'  => '#ffffff',
				            'hover'    => '#ffffff',
				        )
					),

					array(
				        'id'       				=> 'post_tags_background',
				        'type'     				=> 'background',
				        'title'    				=> __('Post Tags Background', 'qaween'),
				        'output'   				=> array('.tags a'),
				        'preview'				=> false,
				        'background-repeat'     => false,
		                'background-attachment' => false,
		                'background-position'   => false,
		                'background-image'      => false,
		                'background-gradient'   => false,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => false,
						'default'				=> array(
													'background-color'		=> '#f0f0f0',
												)
					),

					array(
				        'id'       			=> 'post_tags_link_color',
				        'type'     			=> 'link_color',
				        'title'    			=> __('Post Tags Link Color', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('.tags a', '.tagcloud a'),
				        'default'  => array(
				            'regular'  => '#666666',
				            'hover'    => '#999999',
				        )
					),

					array(
				        'id'       			=> 'divider_color_sidebar',
				        'type'     			=> 'info',
				        'title'    			=> __('Sidebar Settings', 'qaween'),
					),

					array(
				        'id'       			=> 'sidebar_title_border',
				        'type'     			=> 'border',
				        'title'    			=> __('Sidebar Title Border', 'qaween'),
				        'active'			=> false,
				        'output'   			=> array('.sidebar-title h3'),
				        'all'				=> false,
				        'left'				=> false,
				        'right'				=> false,
				        'top'				=> false,
				        'default' 			=> array(
				            'border-color'  => '#eeeeee',
				            'border-style'  => 'solid',
				            'border-bottom'    => '1px',
				        )
					),

					array(
				        'id'       			=> 'sidebar_title_background',
				        'type'     			=> 'background',
				        'title'    			=> __('Sidebar Title Background', 'qaween'),
				        'output'   			=> array('.sidebar-title h3 label'),
				        'preview'			=> false,
				        'background-repeat'     => false,
		                'background-attachment' => false,
		                'background-position'   => false,
		                'background-image'      => false,
		                'background-gradient'   => false,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => false,
						'default'				=> array(
													'background-color'		=> '#eeeeee',
												)
					),

					array(
				        'id'       			=> 'divider_color_form',
				        'type'     			=> 'info',
				        'title'    			=> __('Form Settings', 'qaween'),
					),

					array(
				        'id'       			=> 'text_field_bg_color',
				        'type'     			=> 'background',
				        'title'    			=> __('Input Form Background', 'qaween'),
				        'output'   			=> array('form div.text input', 'form div.textarea textarea', 'form select'),
				        'preview'			=> false,
				        'background-repeat'     => false,
		                'background-attachment' => false,
		                'background-position'   => false,
		                'background-image'      => false,
		                'background-gradient'   => false,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => false,
						'default'				=> array(
													'background-color'		=> '#f3f3f3',
												)
					),

					array(
				        'id'       			=> 'text_field_text_color',
				        'type'     			=> 'color',
				        'title'    			=> __('Text Field & Textarea Text Color', 'qaween'),
				        'output'   			=> array('form div.text input', 'form textarea', 'form select'),
				        'default'  			=> '#555555',
				        'validate' 			=> 'color'
					),

					array(
				        'id'       			=> 'text_field_placeholder_color',
				        'type'     			=> 'color',
				        'title'    			=> __('Text Field & Textarea Placeholder Color', 'qaween'),
				        'output'   			=> array('::-webkit-input-placeholder', ':-moz-placeholder', '::-moz-placeholder', ':-ms-input-placeholder'),
				        'default'  			=> '#cccccc',
				        'validate' 			=> 'color'
					),

					array(
				        'id'       			=> 'submit_button_bg_color',
				        'type'     			=> 'background',
				        'title'    			=> __('Button Background Color', 'qaween'),
				        'output'   			=> array('form div.submit input', '.form-submit input', 'form button'),
				        'preview'			=> false,
				        'background-repeat'     => false,
		                'background-attachment' => false,
		                'background-position'   => false,
		                'background-image'      => false,
		                'background-gradient'   => false,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => false,
						'default'				=> array(
													'background-color'		=> '#e36060',
												)
					),

					array(
				        'id'       			=> 'submit_button_bg_hover_color',
				        'type'     			=> 'background',
				        'title'    			=> __('Button Background Hover Color', 'qaween'),
				        'output'   			=> array('form div.submit input:hover', '.form-submit input:hover', 'form button:hover'),
				        'preview'			=> false,
				        'background-repeat'     => false,
		                'background-attachment' => false,
		                'background-position'   => false,
		                'background-image'      => false,
		                'background-gradient'   => false,
		                'background-clip'       => false,
		                'background-origin'     => false,
		                'background-size'       => false,
						'default'				=> array(
													'background-color'		=> '#555555',
												)
					),
			    )
		    );


			// Typography Settings
			$this->sections[] = array(
				'icon'    => 'el-icon-text-width',
				'title'   => __('Typography', 'qaween'),
				'fields'  => array(
					array(
				        'id'   				=> 'divider_typography_overall',
				        'desc' 				=> __('Overall Typography', 'qaween'),
				        'type' 				=> 'info'
				    ),

					array(
						'id'				=> 'paragraph_text',
						'type'				=> 'typography',
						'title' 			=> __('Paragraph Text', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> true,
						'output'      		=> array('body', 'body p'),
						'default'			=> array(
							'font-family'		=> 'Arimo',
							'font-size'			=> '14px',
							'font-weight'		=> '400',
							'color'				=> '#555555',
							'line-height'		=> '24px'
						)
					),

					array(
						'id'				=> 'text_logo',
						'type'				=> 'typography',
						'title' 			=> __('Text Logo', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#logo .name'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '48px',
							'font-weight'		=> '700',
							'color'				=> '#555555'
						)
					),

					array(
						'id'				=> 'text_logo_and',
						'type'				=> 'typography',
						'title' 			=> __('Text Logo "&" Font', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#logo .and'),
						'default'			=> array(
							'font-family'		=> "'Times New Roman', Times, serif",
							'font-size'			=> '100px',
							'font-weight'		=> '400',
							'color'				=> '#555555'
						)
					),

					array(
						'id'				=> 'main_menu',
						'type'				=> 'typography',
						'title' 			=> __('Main Menu', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('nav.main'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '15px',
							'font-weight'		=> '400',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'post_meta',
						'type'				=> 'typography',
						'title' 			=> __('Post Meta', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.blog-item .meta', '.post .meta', '.hentry .meta'),
						'default'			=> array(
							'font-family'		=> 'Arimo',
							'font-size'			=> '12px',
							'font-weight'		=> '400',
							'color'				=> '#c8c8c8'
						)
					),

					array(
						'id'				=> 'footer_text',
						'type'				=> 'typography',
						'title' 			=> __('Footer Text', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#footer .container div'),
						'default'			=> array(
							'font-family'		=> 'Arimo',
							'font-size'			=> '13px',
							'font-weight'		=> '400',
							'color'				=> '#555555'
						)
					),

					array(
						'id'				=> 'sidebar_widget_title',
						'type'				=> 'typography',
						'title' 			=> __('Sidebar Widget Title', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.sidebar-title h3'),
						'default'			=> array(
							'font-family'		=> 'Arimo',
							'font-size'			=> '11px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
				        'id'   				=> 'divider_typography_homepage',
				        'desc' 				=> __('Homepage Typography', 'qaween'),
				        'type' 				=> 'info'
				    ),

					array(
						'id'				=> 'homepage_widget_title',
						'type'				=> 'typography',
						'title' 			=> __('Homepage Widget Title', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.section-heading h2'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '30px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'happy_couple_heading',
						'type'				=> 'typography',
						'title' 			=> __('The Couple Heading', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.couples .title h2'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '14px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'couple_tweets_heading',
						'type'				=> 'typography',
						'title' 			=> __('Couple Tweets Heading', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('ul#tweets-updates li .heading h3'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '30px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'couple_tweets_username',
						'type'				=> 'typography',
						'title' 			=> __('Couple Tweets Twitter Username', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('ul#tweets-updates li .heading span'),
						'default'			=> array(
							'font-family'		=> 'Arimo',
							'font-size'			=> '16px',
						)
					),

					array(
						'id'				=> 'countdown_timer',
						'type'				=> 'typography',
						'title' 			=> __('Countdown Timer', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#countdown .number'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '60px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'countdown_wedding_location',
						'type'				=> 'typography',
						'title' 			=> __('Countdown Wedding Location', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#countdown h2'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '15px',
							'font-weight'		=> '700',
							'color'				=> '#ffffff'
						)
					),

					array(
						'id'				=> 'countdown_timer_text',
						'type'				=> 'typography',
						'title' 			=> __('Countdown Timer Text', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#timer .text'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '11px',
							'font-weight'		=> '400',
							'color'				=> '#ffffff'
						)
					),

					array(
						'id'				=> 'homepage_blog_title',
						'type'				=> 'typography',
						'title' 			=> __('Homepage Blog Widget Post Title', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.blog-title h2'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '24px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
				        'id'   				=> 'divider_typography_post_detail',
				        'desc' 				=> __('Post Detail Typography', 'qaween'),
				        'type' 				=> 'info'
				    ),

					array(
						'id'				=> 'post_title',
						'type'				=> 'typography',
						'title' 			=> __('Post Title', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.page-title h1'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '50px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'archive_post_title',
						'type'				=> 'typography',
						'title' 			=> __('Archive Post Title', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.post .blog-title h2'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '30px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'breadcrumb',
						'type'				=> 'typography',
						'title' 			=> __('Breadcrumb', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#breadcrumb'),
						'default'			=> array(
							'font-family'		=> 'Arimo',
							'font-size'			=> '12px',
							'font-weight'		=> '400',
							'color'				=> '#555555'
						)
					),

					array(
						'id'				=> 'post-h1',
						'type'				=> 'typography',
						'title' 			=> __('H1 Heading', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.blog-title h1', '#leftcol h1', '.content.full h1'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '40px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'post-h2',
						'type'				=> 'typography',
						'title' 			=> __('H2 Heading', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#leftcol h2', '.content.full h2'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '30px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'post-h3',
						'type'				=> 'typography',
						'title' 			=> __('H3 Heading', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#leftcol h3', '.content.full h3'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '25px',
							'font-weight'		=> '400',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'post-h4',
						'type'				=> 'typography',
						'title' 			=> __('H4 Heading', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#leftcol h4', '.content.full h4'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '20px',
							'font-weight'		=> '400',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'post-h5',
						'type'				=> 'typography',
						'title' 			=> __('H5 Heading', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#leftcol h5', '.content.full h5'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '16px',
							'font-weight'		=> '400',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'post-h6',
						'type'				=> 'typography',
						'title' 			=> __('H6 Heading', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('#leftcol h6', '.content.full h6'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '12px',
							'font-weight'		=> '400',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'comment_headings',
						'type'				=> 'typography',
						'title' 			=> __('Archive Post Title', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.post-heading h3', '.comment-reply-title'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '24px',
							'font-weight'		=> '700',
							'color'				=> '#000000'
						)
					),

					array(
						'id'				=> 'submit_button',
						'type'				=> 'typography',
						'title' 			=> __('Submit Button', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('form div.submit input', '.form-submit input', 'input[type="submit"]', 'form button'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '14px',
							'font-weight'		=> '700',
							'color'				=> '#ffffff'
						)
					),

					array(
						'id'				=> 'comment_meta',
						'type'				=> 'typography',
						'title' 			=> __('Comment Meta', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.comment-head .meta a'),
						'default'			=> array(
							'font-family'		=> 'Helvetica',
							'font-size'			=> '12px',
							'font-weight'		=> '700',
							'color'				=> '#c9c9c9'
						)
					),

					array(
						'id'				=> 'comment_moderation_text',
						'type'				=> 'typography',
						'title' 			=> __('Comment Moderation Text', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.comment-waiting p'),
						'default'			=> array(
							'font-family'		=> 'Arimo',
							'font-size'			=> '15px',
							'font-weight'		=> '400',
							'color'				=> '#ff0000'
						)
					),

					array(
				        'id'   				=> 'divider_typography_gallery',
				        'desc' 				=> __('Gallery Typography', 'qaween'),
				        'type' 				=> 'info'
				    ),

					array(
						'id'				=> 'gallery_filter',
						'type'				=> 'typography',
						'title' 			=> __('Gallery Filter', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.filters'),
						'default'			=> array(
							'font-family'		=> 'Arimo',
							'font-size'			=> '14px',
							'font-weight'		=> '400',
							'color'				=> '#555555'
						)
					),

					array(
						'id'				=> 'gallery_hover_title',
						'type'				=> 'typography',
						'title' 			=> __('Gallery Hover Title', 'qaween'),
						'google'			=> true,
						'subsets'			=> true,
						'preview'			=> true,
						'line-height' 		=> false,
						'output'      		=> array('.overlay .read-more'),
						'default'			=> array(
							'font-family'		=> 'Montserrat',
							'font-size'			=> '12px',
							'font-weight'		=> '400',
							'color'				=> '#ffffff'
						)
					),
				)
			);

			if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
			    $tabs['docs'] = array(
					'icon' => 'el-icon-book',
					    'title' => __('Documentation', 'qaween'),
			        'content' => nl2br(file_get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
			    );
			}

		}


		/**
			
			All the possible arguments for Redux.
			For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

		 **/
		public function setArguments() {
			
			$theme = wp_get_theme(); // For use with some settings. Not necessary.

			$this->args = array(
	            
	            // TYPICAL -> Change these values as you need/desire
				'opt_name'          	=> 'qaween_option', // This is where your data is stored in the database and also becomes your global variable name.
				'display_name'			=> $theme->get('Name'), // Name that appears at the top of your panel
				'display_version'		=> $theme->get('Version'), // Version that appears at the top of your panel
				'menu_type'          	=> 'menu', //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'     	=> true, // Show the sections below the admin menu item or not
				'menu_title'			=> __( 'Theme Options', 'redux-framework' ),
	            'page'		 	 		=> __( 'Theme Options', 'redux-framework' ),
	            'google_api_key'   	 	=> 'AIzaSyDM81TyGQY8jEQykIWxXp1EnuKHOGe3ULA', // Must be defined to add google fonts to the typography module
	            'global_variable'    	=> '', // Set a different name for your global variable other than the opt_name
	            'dev_mode'           	=> false, // Show the time the page took to load, etc
	            'customizer'         	=> true, // Enable basic customizer support

	            // OPTIONAL -> Give you extra features
	            'page_priority'      	=> 61, // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
	            'page_parent'        	=> 'themes.php', // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
	            'page_permissions'   	=> 'manage_options', // Permissions needed to access the options panel.
	            'menu_icon'          	=> get_template_directory_uri() .'/images/warrior-icon.png', // Specify a custom URL to an icon
	            'last_tab'           	=> '', // Force your panel to always open to a specific tab (by id)
	            'page_icon'          	=> 'icon-themes', // Icon displayed in the admin panel next to your menu_title
	            'page_slug'          	=> 'warriorpanel', // Page slug used to denote the panel
	            'save_defaults'      	=> true, // On load save the defaults to DB before user clicks save or not
	            'default_show'       	=> false, // If true, shows the default value next to each field that is not the default value.
	            'default_mark'       	=> '', // What to print by the field's title if the value shown is default. Suggested: *


	            // CAREFUL -> These options are for advanced use only
	            'transient_time' 	 	=> 60 * MINUTE_IN_SECONDS,
	            'output'            	=> true, // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
	            'output_tag'            => true, // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
	            'domain'             	=> 'redux-framework', // Translation domain key. Don't change this unless you want to retranslate all of Redux.
	            //'footer_credit'      	=> '', // Disable the footer credit of Redux. Please leave if you can help it.
	            

	            // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
	            'database'           	=> '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
	            
	        
	            'show_import_export' 	=> true, // REMOVE
	            'system_info'        	=> false, // REMOVE
	            
	            'help_tabs'          	=> array(),
	            'help_sidebar'       	=> '', // __( '', $this->args['domain'] );            
				);


			// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.	
			$this->args['share_icons'][] = array(
			    'url' => 'https://www.facebook.com/themewarrior',
			    'title' => 'Like us on Facebook', 
			    'icon' => 'el-icon-facebook'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://twitter.com/themewarrior',
			    'title' => 'Follow us on Twitter', 
			    'icon' => 'el-icon-twitter'
			);
			$this->args['share_icons'][] = array(
			    'url' => 'http://themeforest.net/user/ThemeWarriors',
			    'title' => 'Follow us on Twitter', 
			    'icon' => 'el-icon-flag-alt'
			);

		}
	}
	new Redux_Framework_sample_config();

}


/** 

	Custom function for the callback referenced above

 */
if ( !function_exists( 'redux_my_custom_field' ) ):
	function redux_my_custom_field($field, $value) {
	    print_r($field);
	    print_r($value);
	}
endif;

/**
 
	Custom function for the callback validation referenced above

**/
if ( !function_exists( 'redux_validate_callback_function' ) ):
	function redux_validate_callback_function($field, $value, $existing_value) {
	    $error = false;
	    $value =  'just testing';
	    /*
	    do your validation
	    
	    if(something) {
	        $value = $value;
	    } elseif(something else) {
	        $error = true;
	        $value = $existing_value;
	        $field['msg'] = 'your custom error message';
	    }
	    */
	    
	    $return['value'] = $value;
	    if($error == true) {
	        $return['error'] = $field;
	    }
	    return $return;
	}
endif;
