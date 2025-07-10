<?php
/**
 * Theme Functions.
 *
 * @package GreenPressWP
 */

declare( strict_types = 1 );

if ( ! defined( 'GREEN_PRESS_WP_VERSION' ) ) {
	define( 'GREEN_PRESS_WP_VERSION', '1.0' );
}

if ( ! defined( 'GREEN_PRESS_WP_PATH' ) ) {
	define( 'GREEN_PRESS_WP_PATH', __DIR__ );
}

if ( ! defined( 'GREEN_PRESS_WP_URL' ) ) {
	define( 'GREEN_PRESS_WP_URL', get_template_directory_uri() );
}

if ( ! defined( 'GREEN_PRESS_WP_BUILD_URI' ) ) {
	define( 'GREEN_PRESS_WP_BUILD_URI', untrailingslashit( get_template_directory_uri() ) . '/assets/build' );
}

if ( ! defined( 'GREEN_PRESS_WP_BUILD_PATH' ) ) {
	define( 'GREEN_PRESS_WP_BUILD_PATH', untrailingslashit( get_template_directory() ) . '/assets/build' );
}

if ( ! defined( 'GREEN_PRESS_WP_SRC_BLOCK_DIR_PATH' ) ) {
	define( 'GREEN_PRESS_WP_SRC_BLOCK_DIR_PATH', get_template_directory() . '/assets/build/blocks' );
}

if ( ! defined( 'GREEN_PRESS_WP_NETWORK_SITE_URL' ) ) {
	define( 'GREEN_PRESS_WP_NETWORK_SITE_URL', network_site_url() );
}
/**
 * Load up the class autoloader.
 */
require_once GREEN_PRESS_WP_PATH . '/includes/helpers/autoloader.php';

/**
 * Theme Init
 *
 * Sets up the theme.
 *
 * @return void
 * @since 1.0.0
 */
function gpwp_main_get_theme_instance(): void {
	\GreenPressWP\Includes\Echo_Main::get_instance();
}
gpwp_main_get_theme_instance();

// Add theme support for post thumbnails.
add_theme_support( 'post-thumbnails' );
