<?php
/*
Plugin Name: Qaween Plugin
Plugin URI: http://www.themewarrior.com
Description: Plugin for Qaween WordPress theme
Version: 1.0.0
Author: ThemeWarrior
Author URI: http://www.themewarrior.com
License: GPL
*/


// Theme Localization
load_plugin_textdomain( 'qaween', false, dirname( plugin_basename( __FILE__ ) ) . '/lang' );

// Slideshow Custom Post Type
add_action('init', 'slideshows_register');
 
function slideshows_register() {
	$labels = array(
		'name' => __('Slideshows', 'qaween'),
		'singular_name' => __('Slideshow', 'qaween'),
		'add_new' => __('Add New', 'qaween'),
		'add_new_item' => __('Add New Slideshow', 'qaween'),
		'edit_item' => __('Edit Slideshow', 'qaween'),
		'new_item' => __('New Slideshow', 'qaween'),
		'view_item' => __('View Slideshow', 'qaween'),
		'search_items' => __('Search Slideshow', 'qaween'),
		'not_found' =>  __('Nothing found', 'qaween'),
		'not_found_in_trash' => __('Nothing found in Trash', 'qaween'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'slideshow', 'with_front' => true ),
		'capability_type' => 'page',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title','author','thumbnail')
	  ); 
 
	register_post_type( 'slideshow' , $args );
}


// Gallery Custom Post Type
add_action('init', 'gallery_register');
 
function gallery_register() {
	$labels = array(
		'name' => __('Gallery', 'qaween'),
		'singular_name' => __('Gallery', 'qaween'),
		'add_new' => __('Add New', 'qaween'),
		'add_new_item' => __('Add New Gallery', 'qaween'),
		'edit_item' => __('Edit Gallery', 'qaween'),
		'new_item' => __('New Gallery', 'qaween'),
		'view_item' => __('View Gallery', 'qaween'),
		'search_items' => __('Search Gallery', 'qaween'),
		'not_found' =>  __('Nothing found', 'qaween'),
		'not_found_in_trash' => __('Nothing found in Trash', 'qaween'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'gallery', 'with_front' => false ),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'taxonomies' => array('gallery_type'),
		'supports' => array('title','editor','author','thumbnail')
	  ); 
 
	register_post_type( 'gallery' , $args );
}

// Custom Taxonomy
add_action( 'init', 'gallery_taxonomies', 0 );

function gallery_taxonomies() {	
	register_taxonomy('gallery_type', 'gallery', array( 'hierarchical' => true, 'label' => __('Gallery Categories', 'qaween'), 'show_ui' => true, 'query_var' => true, 'rewrite' => array('slug' => 'gallery-type'), 'singular_label' => __('Gallery Category', 'qaween')) );
}


// Event Custom Post Type
add_action('init', 'event_register');
 
function event_register() {
	$labels = array(
		'name' => __('Events', 'qaween'),
		'singular_name' => __('Event', 'qaween'),
		'add_new' => __('Add New', 'qaween'),
		'add_new_item' => __('Add New Event', 'qaween'),
		'edit_item' => __('Edit Event', 'qaween'),
		'new_item' => __('New Event', 'qaween'),
		'view_item' => __('View Event', 'qaween'),
		'search_items' => __('Search Event', 'qaween'),
		'not_found' =>  __('Nothing found', 'qaween'),
		'not_found_in_trash' => __('Nothing found in Trash', 'qaween'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'event', 'with_front' => true ),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title','author','thumbnail')
	  ); 
 
	register_post_type( 'event' , $args );
}



// RSVP Custom Post Type
add_action('init', 'rsvp_register');
 
function rsvp_register() {
	$labels = array(
		'name' => __('RSVP', 'qaween'),
		'singular_name' => __('RSVP', 'qaween'),
		'add_new' => __('Add New', 'qaween'),
		'add_new_item' => __('Add New RSVP', 'qaween'),
		'edit_item' => __('Edit RSVP', 'qaween'),
		'new_item' => __('New RSVP', 'qaween'),
		'view_item' => __('View RSVP', 'qaween'),
		'search_items' => __('Search RSVP', 'qaween'),
		'not_found' =>  __('Nothing found', 'qaween'),
		'not_found_in_trash' => __('Nothing found in Trash', 'qaween'),
		'parent_item_colon' => ''
	);
 
	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'rsvp', 'with_front' => true ),
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => 20,
		'supports' => array('title')
	  ); 
 
	register_post_type( 'rsvp' , $args );
}


// Change Default Post Title
add_filter( 'enter_title_here', 'warrior_change_post_title' );
function warrior_change_post_title( $title ){
	$screen = get_current_screen();
	if  ( 'rsvp' == $screen->post_type ) {
		$title = __('Name', 'qaween');
	}
	if  ( 'event' == $screen->post_type ) {
		$title = __('Event Name', 'qaween');
	}
	return $title;
}



// RSVP Form
add_action( 'wp_ajax_new_rsvp', 'warrior_rsvp_form' );
add_action( 'wp_ajax_nopriv_new_rsvp', 'warrior_rsvp_form' );

function warrior_rsvp_form() {
	global $qaween_option;

	$nonce		= isset( $_REQUEST['nonce'] ) ? $_REQUEST['nonce'] : '';
	$name		= isset( $_REQUEST['name'] ) ? esc_attr( $_REQUEST['name'] ) : '';
	$email		= isset( $_REQUEST['email'] ) ? esc_attr( $_REQUEST['email'] ) : '';
	$persons	= isset( $_REQUEST['persons'] ) ? absint( $_REQUEST['persons'] ) : '';
	$event		= isset( $_REQUEST['rsvp_event'] ) ? esc_attr( $_REQUEST['rsvp_event'] ) : '';
	
	if ( ! wp_verify_nonce( $nonce, 'rsvp_nonce' ) )
		die( __('Silence is golden.', 'qaween') );
	
	$result = array();

	if ( ! $name || ! $email ) {
		if ( ! $name )
			$info[] = __('Name field is required.', 'qaween');
		if ( ! $email )
			$info[] = __('Email field is required.', 'qaween');
		if ( ! $persons )
			$info[] = __('Number of persons attending is required.', 'qaween');
	
		$result['error'] = true;
		$result['info'] = join('<br />', $info);
	} elseif ( ! is_email( $email ) ) {
		$result['error'] = true;
		$result['info'] = __('Invalid email address.', 'qaween');
	} else {
		$result['error'] = false;
		$result['info'] = __('Your RSVP has been sent.', 'qaween');
		warrior_rsvp_insert( $name, $email, $persons, $event );
		wp_mail(
			$qaween_option['admin_email'],
			sprintf( '[RSVP %2$s] %1$s', $name, get_bloginfo( 'name' ) ),
			__('Someone just RSVP\'d your wedding event.', 'qaween') ."\n \n". __('Name: ', 'qaween') . $name ."\n". __('Email: ', 'qaween') . $email ."\n". __('Number of Persons Attending: ', 'qaween') . $persons ."\n". __('Event: ', 'qaween') . $event,
			sprintf( 'From: "%1$s" <%2$s>', $name, $email )
		);
	}
	
	if( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' )
		echo json_encode($result);
	else
		header( "Location: " . ( isset( $_SERVER["HTTP_REFERER"] ) ? $_SERVER["HTTP_REFERER"] : '' ) );

	die();
}


function warrior_rsvp_insert( $name = '', $email = '', $persons, $event ) {
	if ( !$name || !$email )
		return;
		
	$add_new_rsvp = array(
		'post_title'		=> $name,
		'post_status'		=> 'draft',
		'post_type'			=> 'rsvp'
	);
	$new_rsvp_id = wp_insert_post($add_new_rsvp);

	update_post_meta($new_rsvp_id, 'rsvp_email', $email);
	update_post_meta($new_rsvp_id, 'rsvp_persons_attending', $persons);
	update_post_meta($new_rsvp_id, 'rsvp_event', $event);

	do_action('wp_insert_post', 'wp_insert_post');
}


// Change RSVP Edit Columns
add_filter('manage_edit-rsvp_columns', 'warrior_edit_rsvp_columns');	
function warrior_edit_rsvp_columns( $columns ) {
	$columns = array(
		"cb" => "<input type=\"checkbox\" />",
		"title" => __('Name', 'qaween'),
		"email" => __('Email', 'qaween'),
		"persons" => __('Person(s) Attending', 'qaween'),
		"event" => __('Event', 'qaween'),
		"date" => __('Submit', 'qaween'),
	);
	return $columns;
}

add_action('manage_rsvp_posts_custom_column', 'warrior_rsvp_columns');
function warrior_rsvp_columns( $columns ) {
	global $post;
	$post_id = $post->ID;
	switch ( $columns ) {
		case 'email':
			echo get_post_meta($post->ID, 'rsvp_email', true);
		break;
		case 'persons':
			echo get_post_meta($post->ID, 'rsvp_persons_attending', true);
		break;
		case 'event':
			echo get_post_meta($post->ID, 'rsvp_event', true);
		break;
	}
}


// Dashboard - At a Glance
// http://wordpress.org/support/topic/dashboard-at-a-glance-custom-post-types
function warrior_right_now_content_table_end() {
    $args = array(
        'public' => true ,
        '_builtin' => false
    );
    $output = 'object';
    $operator = 'and';
	
	// Custom Post Type
    $post_types = get_post_types( $args , $output , $operator );
    foreach( $post_types as $post_type ) {
        $num_posts = wp_count_posts( $post_type->name );
        $num = number_format_i18n( $num_posts->publish );
        $text = _n( $post_type->labels->name, $post_type->labels->name , intval( $num_posts->publish ) );
        if ( current_user_can( 'edit_posts' ) ) {
            $cpt_name = $post_type->name;
        }
        echo '<li class="post-count"><tr><a href="edit.php?post_type='.$cpt_name.'"><td class="first b b-' . $post_type->name . '"></td>' . $num . '&nbsp;<td class="t ' . $post_type->name . '">' . $text . '</td></a></tr></li>';
    }

	// Custom Taxonomy
    $taxonomies = get_taxonomies( $args , $output , $operator );
    foreach( $taxonomies as $taxonomy ) {
        $num_terms  = wp_count_terms( $taxonomy->name );
        $num = number_format_i18n( $num_terms );
        $text = _n( $taxonomy->labels->name, $taxonomy->labels->name , intval( $num_terms ));
        if ( current_user_can( 'manage_categories' ) ) {
            $cpt_tax = $taxonomy->name;
        }
        echo '<li class="post-count"><tr><a href="edit-tags.php?taxonomy='.$cpt_tax.'"><td class="first b b-' . $taxonomy->name . '"></td>' . $num . '&nbsp;<td class="t ' . $taxonomy->name . '">' . $text . '</td></a></tr></li>';
    }

	// RSVP in draft
    $num_posts_rvsp_draft = wp_count_posts( 'rvsp' );
	$num_rvsp_draft = number_format_i18n( $num_posts->draft );
    echo '<li class="post-count"><tr><a href="edit.php?post_type=rsvp&post_status=draft"><td class="first b b-rsvp"></td>'. $num_rvsp_draft .'&nbsp;<td class="t rsvp">' . __('RSVP in draft', 'qaween') . '</td></a></tr></li>';

	// RSVP attending persons
	global $wpdb;
	$find_rsvp_attending_yes = new WP_Query( array( 'post_type' => 'rsvp', 'meta_key' => 'rsvp_persons_attending' ) );
	
	$persons_rsvp_attending_yes = array();
	if ( isset($find_rsvp_attending_yes->posts) ) {
		foreach ( $find_rsvp_attending_yes->posts as $post) {
			$persons_rsvp_attending_yes[] = get_post_meta($post->ID, 'rsvp_persons_attending', true);
		}
	} else {
		$persons_rsvp_attending_yes[] = 0;
	}
    echo '</ul><h4 class="sub">'. __('RSVP Info', 'warrior') .'</h4><ul>';
    echo '<li class="person-count"><tr><a href="edit.php?post_type=rsvp&attend=yes"><td class="first b b-rsvp"></td>'. array_sum($persons_rsvp_attending_yes) .'&nbsp;<td class="t rsvp">' . __('People Will be Attending', 'qaween') . '</td></a></tr></li>';
	
}
add_action( 'dashboard_glance_items' , 'warrior_right_now_content_table_end' );
