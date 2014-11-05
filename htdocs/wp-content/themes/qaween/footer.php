<?php
/**
 * Template for displaying footer section.
 *
 * @package WordPress
 * @subpackage Qaween
 * @since Qaween 1.0.0
 */
?>

<?php global $qaween_option; // load theme option global variable ?>

    </section>
    <!-- End: Content -->

    <!-- Start: Footer -->
    <footer id="footer">
        <div class="container main"> 
            <div class="copyright"><?php printf( __( '%1$s. Copyright %2$s. Made goo yoves.', 'qaween' ), get_bloginfo('name'), date_i18n('Y') ); ?></div>
        </div>
    </footer>
    <!-- End: Footer -->

<?php
// Load tracking code from theme options
if( isset($qaween_option['tracking_code']) ) {
    echo $qaween_option['tracking_code'];
}

// Load custom CSS from theme options
if( isset( $qaween_option['custom_css'] ) ) {
    echo '<style type="text/css">';
    echo $qaween_option['custom_css'];
    echo '</style>';
}
?>

<?php wp_footer(); ?>
</body>
</html>