<?php
/**
 * Function to gather analytics from our users using PressTrends.
 * You can disable this from the Theme Options.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

if ( ! function_exists( 'presstrends_qaween' ) ) {
	function presstrends_qaween() {
	    // PressTrends Account API Key
	    $api_key = 'szhthn8js6okr76o3925r8m6ea5z25fbfhqb';
	    $auth = 'f5osfhkvalrr1sawz5p9wrtvirkvjy8pm';
	    // Start of Metrics
	    global $wpdb;
	    $data = get_transient( 'presstrends_theme_cache_data' );
	    if ( !$data || $data == '' ) {
	        $api_base = 'http://api.presstrends.io/index.php/api/sites/add?auth=';
	        $url      = $api_base . $auth . '&api=' . $api_key . '';
	        $count_posts    = wp_count_posts();
	        $count_pages    = wp_count_posts( 'page' );
	        $comments_count = wp_count_comments();
	        if ( function_exists( 'wp_get_theme' ) ) {
	            $theme_data    = wp_get_theme();
	            $theme_name    = urlencode( $theme_data->Name );
	            $theme_version = $theme_data->Version;
	        } else {
	            $theme_data    = wp_get_theme();
	            $theme_name    = urlencode( $theme_data->Name );
	            $theme_version = $theme_data->Version;
	        }
	        $all_plugins = get_plugins();
	        $plugin_name = '';
	        foreach ( $all_plugins as $plugin_file => $plugin_data ) {
	            $plugin_name .= $plugin_data['Name'];
	            $plugin_name .= '&';
	        }
	        $posts_with_comments = $wpdb->get_var( "SELECT COUNT(*) FROM $wpdb->posts WHERE post_type='post' AND comment_count > 0" );
	        $avg_time_btw_posts = $wpdb->get_var("SELECT TIMESTAMPDIFF(SECOND, MIN(post_date), MAX(post_date)) / (COUNT(*)-1) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'post'");
	        $avg_time_btw_comments = $wpdb->get_var("SELECT TIMESTAMPDIFF(SECOND, MIN(comment_date), MAX(comment_date)) / (COUNT(*)-1) FROM $wpdb->comments WHERE comment_approved = '1'");
	        $data                	= array(
	            'url'             	=> base64_encode(site_url()),
	            'posts'           	=> $count_posts->publish,
	            'pages'           	=> $count_pages->publish,
	            'comments'        	=> $comments_count->total_comments,
	            'approved'        	=> $comments_count->approved,
	            'spam'            	=> $comments_count->spam,
	            'between_posts'   	=> $avg_time_btw_posts,
	            'between_comments'	=> $avg_time_btw_comments,
	            'pingbacks'       	=> $wpdb->get_var( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_type = 'pingback'" ),
	            'post_conversion' 	=> ( $count_posts->publish > 0 && $posts_with_comments > 0 ) ? number_format( ( $posts_with_comments / $count_posts->publish ) * 100, 0, '.', '' ) : 0,
	            'theme_version'   	=> $theme_version,
	            'theme_name'      	=> $theme_name,
	            'site_name'       	=> str_replace( ' ', '', get_bloginfo( 'name' ) ),
	            'plugins'         	=> count( get_option( 'active_plugins' ) ),
	            'plugin'          	=> urlencode( $plugin_name ),
	            'wpversion'       	=> get_bloginfo( 'version' ),
	            'api_version'	  	=> '2.4',
	        );
	        foreach ( $data as $k => $v ) {
	            $url .= '&' . $k . '=' . $v . '';
	        }
	        wp_remote_get( $url );
	        set_transient( 'presstrends_theme_cache_data', $data, 60 * 60 * 24 );
	    }
	}
}
add_action('admin_init', 'presstrends_qaween');

/**
 * Function to load comment list
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'warrior_comment_list' ) ) {
	function warrior_comment_list($comment, $args, $depth) {
		global $post;
		$author_post_id = $post->post_author;
		$GLOBALS['comment'] = $comment;

		// Allowed html tags will be display
		$allowed_html = array(
			'a' => array( 'href' => array(), 'title' => array() ),
			'abbr' => array( 'title' => array() ),
			'acronym' => array( 'title' => array() ),
			'strong' => array(),
			'b' => array(),
			'blockquote' => array( 'cite' => array() ),
			'cite' => array(),
			'code' => array(),
			'del' => array( 'datetime' => array() ),
			'em' => array(),
			'i' => array(),
			'q' => array( 'cite' => array() ),
			'strike' => array(),
			'ul' => array(),
			'ol' => array(),
			'li' => array()
		);
		
		$add_comment_class = $comment->comment_approved == '0' ? 'waiting' : '';

		switch ( $comment->comment_type ) :
			case '' :
	?>
	<li id="comment-<?php comment_ID() ?>" <?php comment_class($add_comment_class); ?>>
		<div class="comment-thumbnail">
			<?php echo get_avatar( $comment, 80 ); ?>
		</div>
		<div class="comment-info">
			<div class="comment-head">
				<?php printf( __('<strong class="name">%s</strong> <span>says</span>', 'qaween'), get_comment_author_link()); ?>
				<div class="meta">
					<a href="<?php echo get_comment_link(); ?>"><?php echo get_comment_date() .' '. get_comment_time(); ?></a>
					<?php edit_comment_link(__('Edit Comment', 'qaween'), ' - ', ''); ?>
				</div>
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
			<div class="comment-waiting">
				<p><?php _e('Your comment is now awaiting moderation.', 'qaween'); ?></p>
			</div>
			<?php endif; ?>
			<div class="comment-content">
				<?php echo apply_filters('comment_text', wp_kses( get_comment_text(), $allowed_html ) );  ?>
				<?php echo comment_reply_link(array('depth' => $depth, 'max_depth' => $args['max_depth']));  ?>			
			</div>
		</div>
	</li>
	<?php
			break;
			case 'pingback'  :
			case 'trackback' :
	?>
	<li id="comment-<?php comment_ID() ?>" <?php comment_class($add_comment_class); ?>>
		<div class="comment-head">
			<?php printf( __('<strong class="name">%s</strong> <span>says</span>', 'qaween'), get_comment_author_link()); ?>
			<div class="meta">
				<a href="<?php echo get_comment_link(); ?>"><?php echo get_comment_date() .' '. get_comment_time(); ?></a>
				<?php edit_comment_link(__('Edit Comment', 'qaween'), ' - ', ''); ?>
			</div>
		</div>
		<?php if ($comment->comment_approved == '0') : ?>
		<div class="comment-waiting">
			<p><?php _e('Your comment is now awaiting moderation.', 'qaween'); ?></p>
		</div>
		<?php endif; ?>
		<div class="comment-content">
			<?php echo apply_filters('comment_text', wp_kses( get_comment_text(), $allowed_html ) );  ?>
		</div>
	</li>
	<?php
			break;
		endswitch;
	}
}

/**
 * Add class on posts prev & next
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'next_posts_link_class' ) ) {
	function next_posts_link_class() {
	    return 'class="next"';
	}
}
add_filter('next_posts_link_attributes', 'next_posts_link_class');

if ( ! function_exists( 'previous_posts_link_class' ) ) {
	function previous_posts_link_class() {
	    return 'class="prev"';
	}
}
add_filter('previous_posts_link_attributes', 'previous_posts_link_class');


/**
 * Function to get the first link from a post. Based on the codes from WP Recipes 
 * http://www.wprecipes.com/wordpress-tip-how-to-get-the-first-link-in-post
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'get_link_url' ) ) {
	function get_link_url() {
	    $content = get_the_content();
	    $has_url = get_url_in_content( $content );

	    return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}
}


/**
 * Function to add site favicon
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'warrior_add_favicon' ) ) {
	function warrior_add_favicon() {
		global $qaween_option;

		if ( ! $qaween_option['favicon'] )
			return false;
	?>
	<link rel="shortcut icon" href="<?php echo esc_url( $qaween_option['favicon']['url'] ); ?>" />
	<?php
	}
}
add_action( 'wp_head', 'warrior_add_favicon', 5 );


/**
 * Function to build site logo
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'qaween_logo' ) ) {
	function qaween_logo() {
		global $qaween_option;

		if ( $qaween_option['logo_type'] == '2' ) :
			echo '<img src="' . esc_url( $qaween_option['logo_image']['url'] ) . '" alt="' . get_bloginfo('name') . '" />';
		elseif ( $qaween_option['logo_text'] != '' ) :
			$couples = explode("*", $qaween_option['logo_text']);
			if ( count($couples) == 1 ) {
				$couples = explode("|", $qaween_option['logo_text']);
				echo '<div class="name">' . ( count($couples) == 1 ? $couples[0] : $couples[0] . '<span>' . $couples[1] . '</span>' ) .'</div>';
			} else {
				$couple1_names = explode("|", $couples[0]);
				$couple1_name = count($couple1_names) == 1 ? $couples[0] : $couple1_names[0] . '<span>' . $couple1_names[1] . '</span>';
				$couple2_names = explode("|", $couples[1]);
				$couple2_name = count($couple2_names) == 1 ? $couples[1] : $couple2_names[0] . '<span>' . $couple2_names[1] . '</span>';
				echo '<div class="name left">' . $couple1_name . '</div><div class="and">&amp;</div><div class="name right">' . $couple2_name . '</div>';
			}
		else :
			echo '<div class="name">' . get_bloginfo('name') . ' <span>' . get_bloginfo('description') . '</span></div>';
		endif;
	}
}


/**
 * Function to convert wedding date from theme options
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'qaween_date' ) ) {
	function qaween_date() {
		global $qaween_option;

		if ( ! $qaween_option['wedding_date'] ) 
			return false;

		return date_i18n('F jS, Y', strtotime( $qaween_option['wedding_date'] ) );
	}
}



/**
 * Main menu walker
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
class qaween_walker_nav_menu extends Walker_Nav_Menu {
	  
	// add classes to ul sub-menus
	function start_lvl( &$output, $depth = 0, $args = array() ) {
		// depth dependent classes
		$indent = ( $depth > 0  ? str_repeat( "\t", $depth ) : '' ); // code indent
	  
		// build html
		$output .= "\n" . $indent . '<ul class="dropdown">' . "\n";
	}
	
	// add main/sub classes to li's and links
	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query, $wpdb;
		$indent = ( $depth > 0 ? str_repeat( "\t", $depth ) : '' ); // code indent
	  
		// menu item has children?
		$has_children = $wpdb->get_var("SELECT COUNT(meta_id) FROM wp_postmeta WHERE meta_key='_menu_item_menu_item_parent' AND meta_value='".$item->ID."'");
		
		// passed classes
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$class_names = esc_attr( implode( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) ) );
	  
		// build html
		$output .= $indent . '<li id="nav-menu-item-'. $item->ID . '" class="menu ' . $class_names . '">';
	  
		// link attributes
		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . ( $has_children > 0 ? 'javascript:void(0);' : esc_attr( $item->url ) ) .'"' : '';
	  
		$item_output = sprintf( '%1$s<a%2$s>%3$s%4$s%5$s</a>%6$s',
			$args->before,
			$attributes,
			$args->link_before,
			apply_filters( 'the_title', $item->title, $item->ID ),
			$args->link_after,
			$args->after
		);
	  
		// build html
		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}



/**
 * Function to collect the title of the current page
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if ( ! function_exists( 'qaween_archive_title' ) ) {
	function qaween_archive_title() {
		global $wp_query;

		$title = '';
		if ( is_category() ) :
			$title = sprintf( __( 'Category Archives: %s', 'qaween' ), single_cat_title( '', false ) );
		elseif ( is_tag() ) :
			$title = sprintf( __( 'Tag Archives: %s', 'qaween' ), single_tag_title( '', false ) );
		elseif ( is_tax() ) :
			$title = sprintf( __( '%s Archives', 'qaween' ), get_post_format_string( get_post_format() ) );
		elseif ( is_day() ) :
			$title = sprintf( __( 'Daily Archives: %s', 'qaween' ), get_the_date() );
		elseif ( is_month() ) :
			$title = sprintf( __( 'Monthly Archives: %s', 'qaween' ), get_the_date( 'F Y' ) );
		elseif ( is_year() ) :
			$title = sprintf( __( 'Yearly Archives: %s', 'qaween' ), get_the_date( 'Y' ) );
		elseif ( is_author() ) :
			$author = get_user_by( 'slug', get_query_var( 'author_name' ) );
			$title = sprintf( __( 'Author Archives: %s', 'qaween' ), get_the_author_meta( 'display_name', $author->ID ) );
		elseif ( is_search() ) :
			if ( $wp_query->found_posts ) {
				$title = sprintf( __( 'Search Results for: %s', 'qaween' ), esc_attr( get_search_query() ) );
			} else {
				$title = sprintf( __( 'No Results for: %s', 'qaween' ), esc_attr( get_search_query() ) );
			}
		elseif ( is_404() ) :
			$title = __( 'Not Found', 'qaween' );
		else :
			$title = __( 'Blog', 'qaween' );
		endif;
		
		return $title;
	}
}

/**
 * Function to move meta bix position
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if( ! function_exists('meta_box_position') ) {
	function meta_box_position() {
		remove_meta_box( 'postimagediv', 'gallery', 'side' );
		remove_meta_box( 'postimagediv', 'slideshow', 'side' );
		add_meta_box('postimagediv', __('Gallery Cover'), 'post_thumbnail_meta_box', 'gallery', 'normal', 'high');
		add_meta_box('postimagediv', __('Set Slideshow Image'), 'post_thumbnail_meta_box', 'slideshow', 'normal', 'high');

	}
}
add_action('do_meta_boxes', 'meta_box_position');


/**
 * Function to get twitter update
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
if( ! function_exists('warrior_get_recent_tweets') ) {
	function warrior_get_recent_tweets( $screen_name = '', $consumer_key = '', $consumer_secret = '', $tweets_count = 5 ) {

		if ( !$screen_name)
			return false;
		
		// some variables
		$token = get_option('warriorTwitterToken'.$screen_name);

		// get recent tweets from cache
		$recent_tweets = get_transient('warriorRecentTweets'.$screen_name);

		// cache version does not exist or expired
		if (false === $recent_tweets) {

			// getting new auth bearer only if we don't have one
			if(!$token) {

				// preparing credentials
				$credentials = $consumer_key . ':' . $consumer_secret;
				$toSend = base64_encode($credentials);
	 
				// http post arguments
				$args = array(
					'method' => 'POST',
					'httpversion' => '1.1',
					'blocking' => true,
					'headers' => array(
						'Authorization' => 'Basic ' . $toSend,
						'Content-Type' => 'application/x-www-form-urlencoded;charset=UTF-8'
					),
					'body' => array( 'grant_type' => 'client_credentials' )
				);
	 
				add_filter('https_ssl_verify', '__return_false');
				$response = wp_remote_post('https://api.twitter.com/oauth2/token', $args);

				$keys = json_decode(wp_remote_retrieve_body($response));

				if($keys) {
					// saving token to wp_options table
					update_option('warriorTwitterToken'.$screen_name, $keys->access_token);
					$token = $keys->access_token;
				}
			}

			// we have bearer token wether we obtained it from API or from options
			$args = array(
				'httpversion' => '1.1',
				'blocking' => true,
				'headers' => array(
					'Authorization' => "Bearer $token"
				)
			);

			add_filter('https_ssl_verify', '__return_false');
			$api_url = "https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=$screen_name&count=$tweets_count";
			$response = wp_remote_get($api_url, $args);
	 
			if (!is_wp_error($response)) {
				$tweets = json_decode(wp_remote_retrieve_body($response));

				if(!empty($tweets)){
					for($i=0; $i<count($tweets); $i++){
						$recent_tweets[] = array(
							'text' 						=> $tweets[$i]->text, 
							'created_at' 				=> $tweets[$i]->created_at, 
							'status_id' 				=> $tweets[$i]->id_str
						);
					}
				}			
			}
			
			// cache for an hour
			set_transient('warriorRecentTweets'.$screen_name, $recent_tweets, 1*60*60);
		}

		return $recent_tweets;

	}
}

/**
 * Function to replace replace permalink on tweet
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */

if( ! function_exists('twitter_links') ) {
	function twitter_links($tweet_text) {
		$tweet_text = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2</a>", $tweet_text);
		$tweet_text = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>", $tweet_text);
		$tweet_text = preg_replace("/@(\w+)/", "<a href=\"http://twitter.com/\\1\" target=\"_blank\">@\\1</a>", $tweet_text);
		$tweet_text = preg_replace("/#(\w+)/", "<a href=\"http://twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $tweet_text);
		return $tweet_text;
	}
}
