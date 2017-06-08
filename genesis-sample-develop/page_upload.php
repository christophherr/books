<?php
/**
 * Genesis Sample.
 *
 * This file adds the upload page template to the Genesis Sample Theme.
 *
 * Template Name: Upload
 *
 * @package Genesis Sample
 * @author  Christoph Herr
 * @license GPL-2.0+
 * @link    http://www.studiopress.com/
 */

add_filter( 'body_class', 'genesis_sample_add_body_class' );
/**
 * Adds body class
 *
 * @param array $classes CSS classes.
 * @return array Adjusted CSS classes
 */
function genesis_sample_add_body_class( $classes ) {

	$classes[] = 'upload-page';

	return $classes;

}

add_action( 'genesis_entry_content', 'ch_add_upload_form' );
/**
 * Checks if user is logged in and displays upload form.
 *
 * @return void
 */
function ch_add_upload_form() {
	if ( ! is_user_logged_in() ) {
		?>
		<div class="not-logged-in">You have to be logged in to upload images.</div>
		<div class="login"><a href="<?php echo wp_login_url( get_permalink() ); ?>" title="Login">Click here to Login</a>
		<a href="<?php echo wp_registration_url( get_permalink() ); ?>" title="Login">Click here to Sign Up</a>
		</div>
		<?php return;
	}
		echo Caldera_Forms::render_form( 'CF5932e93b85f2c' );
}

// Remove footer widgets.
remove_action( 'genesis_before_footer', 'genesis_footer_widget_areas' );

// Remove site footer elements.
remove_action( 'genesis_footer', 'genesis_footer_markup_open', 5 );
remove_action( 'genesis_footer', 'genesis_do_footer' );
remove_action( 'genesis_footer', 'genesis_footer_markup_close', 15 );

// Run the Genesis loop.
genesis();
