<?php
/**
 * Template for displaying header part.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>
<?php global $post, $qaween_option; ?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?> <?php if( $qaween_option['enable_rtl'] == '1' ) { echo 'dir="rtl"'; } ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php wp_title('|',true,''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable = yes" >
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <!-- Start: Header -->
    <header id="header">
        <div class="container header">
            <div id="logo">
                <a href="<?php echo home_url('/'); ?>">
					<?php qaween_logo(); ?>
                </a>
            </div>
        </div>
        
        <!-- Start: Navigation -->
        <nav class="main">
			<?php
			if ( has_nav_menu( 'main-menu' ) )
				wp_nav_menu( array ( 'theme_location' => 'main-menu', 'container' => null, 'menu_class' => 'nav', 'depth' => 2, 'walker' => new qaween_walker_nav_menu ) );
			else
				wp_nav_menu( array ( 'theme_location' => 'main-menu', 'container' => null, 'menu_class' => 'nav', 'depth' => 1 ) );
			?>
        </nav>
        <!-- End: Navigation -->
    </header>
    <!-- End: Header -->

    <!-- Start: Content -->
    <section id="main">