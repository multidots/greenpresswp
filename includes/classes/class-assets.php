<?php
/**
 * Enqueue theme assets.
 *
 * @package GreenPressWP
 */

declare( strict_types = 1 );

namespace GreenPressWP\Includes;

use GreenPressWP\Includes\Traits\Singleton;

/**
 * Class Assets
 */
class Assets {
	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// load class.
		$this->setup_hooks();
	}

	/**
	 * To register action/filter.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	protected function setup_hooks(): void {

		/**
		 * Actions.
		 */
		add_action( 'get_header', array( $this, 'remove_actions' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		add_action( 'enqueue_block_assets', array( $this, 'enqueue_editor_assets' ) );
		add_action( 'upload_mimes', array( $this, 'add_file_types_to_uploads' ) ); //phpcs:ignore WordPressVIPMinimum.Hooks.RestrictedHooks.upload_mimes
		add_action( 'wp_check_filetype_and_ext', array( $this, 'gpwp_theme_check_filetype' ), 10, 3 );
	}

	/**
	 * Remove actions.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function remove_actions(): void {

		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'wp_resource_hints', 2 );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'rest_output_link_wp_head' );
		remove_action( 'wp_head', 'wp_shortlink_wp_head' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'template_redirect', 'rest_output_link_header', 11 );
	}

	/**
	 * Load critical CSS.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function hook_critical_css(): void {

		$css = file_get_contents( GREEN_PRESS_WP_BUILD_URI . '/inline.css' ); // phpcs:ignore
		wp_add_inline_style( 'main-style-handle', $css );
	}

	/**
	 * Register and Enqueue styles.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function register_styles(): void {

		$this->hook_critical_css();

		// // Register styles.
		wp_register_style( 'main-css', GREEN_PRESS_WP_BUILD_URI . '/main.css', array(), GREEN_PRESS_WP_VERSION, 'all' );

		// // Enqueue Styles.
		wp_enqueue_style( 'main-css' );

		$body_bg                = get_theme_mod( 'body_bg', '#ffffff' );
		$text_color             = get_theme_mod( 'text_color', '#636363' );
		$heading_color          = get_theme_mod( 'heading_color', '#222222' );
		$link_color             = get_theme_mod( 'link_color', '#277a4b' );
		$link_hover_color       = get_theme_mod( 'link_hover_color', '#222222' );
		$block_quote_color      = get_theme_mod( 'block_quote_color', '#277a4b' );
		$site_title_color       = get_theme_mod( 'site_title_color', '#222222' );
		$site_tagline_color     = get_theme_mod( 'site_tagline_color', '#909090' );
		$header_bg_color        = get_theme_mod( 'header_bg_color', '#ffffff' );
		$header_nav_link_color  = get_theme_mod( 'header_nav_link_color', '#277a4b' );
		$footer_bg_color        = get_theme_mod( 'footer_bg_color', '#222222' );
		$footer_text_link_color = get_theme_mod( 'footer_text_link_color', '#ffffff' );

		$inline_css = sprintf(
			':root {
			--body-bg-color: %s;
			--text-color: %s;
			--heading-color: %s;
			--link-color: %s;
			--link-hover-color: %s;
			--block-quote-color: %s;
			--site-title-color: %s;
			--site-tagline-color: %s;
			--header-bg-color: %s;
			--header-nav-link-color: %s;
			--footer-bg-color: %s;
			--footer-text-link-color: %s;
		}',
			esc_attr( $body_bg ),
			esc_attr( $text_color ),
			esc_attr( $heading_color ),
			esc_attr( $link_color ),
			esc_attr( $link_hover_color ),
			esc_attr( $block_quote_color ),
			esc_attr( $site_title_color ),
			esc_attr( $site_tagline_color ),
			esc_attr( $header_bg_color ),
			esc_attr( $header_nav_link_color ),
			esc_attr( $footer_bg_color ),
			esc_attr( $footer_text_link_color ),
		);

		$inline_css = preg_replace( '/\s*([{}:;,])\s*/', '$1', $inline_css ); // Smart trim.
		$inline_css = preg_replace( '/\s+/', ' ', $inline_css ); // Collapse multiple spaces.

		wp_add_inline_style( 'main-css', $inline_css );
	}

	/**
	 * Register and Enqueue Scripts.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function register_scripts(): void {
		// Register scripts.
		wp_register_script( 'main-js', GREEN_PRESS_WP_BUILD_URI . '/main.js', array(), GREEN_PRESS_WP_VERSION, true );

		// Enqueue Scripts.
		wp_enqueue_script( 'main-js' );

		wp_deregister_script( 'wp-embed' );

		// Remove dashicons in frontend for unauthenticated users.
		if ( ! is_user_logged_in() ) {
			wp_deregister_style( 'dashicons' );
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	/**
	 * Action Function to add SVG support in file uploads.
	 *
	 * @param array $file_types Supported file types.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function add_file_types_to_uploads( array $file_types ): array {
		if ( is_user_logged_in() && current_user_can( 'manage_options' ) ) {
			$new_filetypes          = array();
			$new_filetypes['svg']   = 'image/svg+xml';
			$new_filetypes['woff']  = 'application/font-woff';
			$new_filetypes['woff2'] = 'application/font-woff2';
			$new_filetypes['woff']  = 'font/woff';
			$new_filetypes['woff2'] = 'font/woff2';
			$file_types             = array_merge( $file_types, $new_filetypes );
		}

		return $file_types;
	}


	/**
	 * Enqueue editor assets.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function enqueue_editor_assets() {

		// Enqueue interactivity API for blocks.
		wp_enqueue_script( 'wp_interactivity' );

		// Change block Priority to head.
		$blocks = \WP_Block_Type_Registry::get_instance()->get_all_registered();
		foreach ( $blocks as $block ) {
			if ( has_block( $block->name ) ) {
				wp_enqueue_style( $block->style );
			}
		}
	}

	/**
	 * Check file type for woff and woff2.
	 *
	 * @param array  $data     File data.
	 * @param string $file     File path.
	 * @param string $filename File name.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function gpwp_theme_check_filetype( array $data, string $file, string $filename ): array {
		$ext = pathinfo( $filename, PATHINFO_EXTENSION );
		if ( 'woff2' === $ext ) {
			$data['ext']  = 'woff2';
			$data['type'] = 'font/woff2';
		} elseif ( 'woff' === $ext ) {
			$data['ext']  = 'woff';
			$data['type'] = 'font/woff';
		}
		return $data;
	}
}
