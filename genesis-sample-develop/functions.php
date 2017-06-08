<?php
/**
 * Genesis Sample.
 *
 * This file adds functions to the Genesis Sample Theme.
 *
 * @package Genesis Sample
 * @author  StudioPress & Christoph Herr
 * @license GPL-2.0+
 * @link	http://www.studiopress.com/
 */

// Start the engine.
include_once( get_template_directory() . '/lib/init.php' );

// Setup Theme.
include_once( get_stylesheet_directory() . '/lib/theme-defaults.php' );

add_action( 'after_setup_theme', 'genesis_sample_localization_setup' );
/**
 * Set Localization (do not remove).
 *
 * @return void
 */
function genesis_sample_localization_setup(){
	load_child_theme_textdomain( 'genesis-sample', get_stylesheet_directory() . '/languages' );
}

// Add the helper functions.
include_once( get_stylesheet_directory() . '/lib/helper-functions.php' );

// Add User Profile additions.
include_once( get_stylesheet_directory() . '/lib/user-profile-extension.php' );

// Add changes to posts.
include_once( get_stylesheet_directory() . '/lib/changes-to-posts.php' );

// Add Image upload and Color select to WordPress Theme Customizer.
require_once( get_stylesheet_directory() . '/lib/customize.php' );

// Include Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/output.php' );

// Add WooCommerce support.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php' );

// Add the required WooCommerce styles and Customizer CSS.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php' );

// Add the Genesis Connect WooCommerce notice.
include_once( get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php' );

// Child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Genesis Sample' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );
define( 'CHILD_THEME_VERSION', '2.3.0' );

add_action( 'wp_enqueue_scripts', 'genesis_sample_enqueue_scripts_styles' );
/**
 * Enqueue Scripts and Styles.
 *
 * @return void
 */
function genesis_sample_enqueue_scripts_styles() {

	wp_enqueue_style( 'genesis-sample-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );
	wp_enqueue_style( 'dashicons' );

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	wp_enqueue_script( 'genesis-sample-responsive-menu', get_stylesheet_directory_uri() . "/js/responsive-menus{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_localize_script(
		'genesis-sample-responsive-menu',
		'genesis_responsive_menu',
		genesis_sample_responsive_menu_settings()
	);

}

/**
 * Define our responsive menu settings.
 *
 * @return array $settings
 */
function genesis_sample_responsive_menu_settings() {

	$settings = array(
		'mainMenu'		  => __( 'Menu', 'genesis-sample' ),
		'menuIconClass'	 => 'dashicons-before dashicons-menu',
		'subMenu'		   => __( 'Submenu', 'genesis-sample' ),
		'subMenuIconsClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'	   => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

// Add HTML5 markup structure.
add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list', 'gallery', 'search-form' ) );

// Add Accessibility support.
add_theme_support( 'genesis-accessibility', array( '404-page', 'drop-down-menu', 'headings', 'rems', 'search-form', 'skip-links' ) );

// Add viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Add support for custom header.
add_theme_support( 'custom-header', array(
	'width'		   => 600,
	'height'		  => 160,
	'header-selector' => '.site-title a',
	'header-text'	 => false,
	'flex-height'	 => true,
) );

// Add support for custom background.
add_theme_support( 'custom-background' );

// Add support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Add support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Add Image Sizes.
add_image_size( 'featured-image', 720, 400, true );
// Register a custom image size for images on Posts page.
add_image_size( 'posts-page', 500, 0, true );

// Rename primary and secondary navigation menus.
add_theme_support( 'genesis-menus', array( 'primary' => __( 'After Header Menu', 'genesis-sample' ), 'secondary' => __( 'Footer Menu', 'genesis-sample' ) ) );

add_shortcode( 'add_upload_form', 'ch_add_upload_form_shortcode' );
/**
 * Checks if user is logged in and displays upload form
 *
 * @return string
 */
function ch_add_upload_form_shortcode() {
	if ( ! is_user_logged_in() ) {
		$output = '<div class="not-logged-in">You have to be logged in to upload images.</div>';
	} else {
		 $output = Caldera_Forms::render_form( 'CF5932e93b85f2c' );
	}
	return $output;
}

add_filter( 'wp_nav_menu_items', 'my_nav_menu_author_link' );
/**
 * Add current author archive to menu
 * https://wordpress.stackexchange.com/a/204375
 *
 * @param string $menu Menu items.
 * @return string
 */
function my_nav_menu_author_link( $menu ) {
	if ( ! is_user_logged_in() ) {
		return $menu;
	} else {

		$link = get_author_posts_url( get_current_user_id() );

		$class = is_author() ? ' class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item"' : ' class="menu-item menu-item-type-custom menu-item-object-custom"';

		$author_archive_link =
		'<li' . $class . '>' .
			 '<a href="' . $link . '" >' .
				 __( 'My Books' ) .
			 '</a>' .
		 '</li>';

		$menu = $menu . $author_archive_link;

		return $menu;

	}
}

add_filter( 'genesis_sitemap_output', 'ch_sitemap' );
/**
 * Only show authors on archive page.
 *
 * @return string $sitemap
 */
function ch_sitemap() {
	$sitemap = sprintf( '<ul>%s</ul>', wp_list_authors( 'exclude_admin=0&optioncount=1&echo=0' ) );
	return $sitemap;
}

