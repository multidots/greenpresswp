<?php
/**
 * Bootstraps the Theme.
 *
 * @package GreenPressWP
 */

declare( strict_types = 1 );

namespace GreenPressWP\Includes;

use GreenPressWP\Includes\Blocks;
use GreenPressWP\Includes\Traits\Singleton;

/**
 * Class GreenPressWP
 */
class GreenPressWP {
	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		/**
		 * Load classes.
		 */
		Assets::get_instance();
		Menus::get_instance();
		Blocks::get_instance();
		GreenPressWP_Customize::get_instance();
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
		add_action( 'after_setup_theme', array( $this, 'setup_theme' ) );
		add_action( 'wp_head', array( $this, 'pingback_header' ) );
		add_action( 'admin_init', array( $this, 'custom_editor_switch_setting' ) );
		add_action( 'template_redirect', array( $this, 'start_html_minify' ) );
		add_action( 'init', array( $this, 'gpwp_nav_rewrite_rule' ) );

		/**
		 * Filters.
		 */
		add_filter( 'use_block_editor_for_post', array( $this, 'custom_set_default_editor' ), 10, 2 );
		add_filter( 'query_vars', array( $this, 'gpwp_register_query_var' ) );
		add_filter( 'template_include', array( $this, 'gpwp_template_include' ) );
	}

	/**
	 * Setup theme.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function setup_theme(): void {

		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
		add_theme_support( 'title-tag' );

		/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
		add_theme_support( 'post-thumbnails' );

		/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		/**
		 * Add theme support for selective refresh for widgets.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		// Gutenberg theme support.

		/**
		 * Some blocks in Gutenberg like tables, quotes, separator benefit from structural styles (margin, padding, border etc…)
		 * They are applied visually only in the editor (back-end) but not on the front-end to avoid the risk of conflicts with the styles wanted in the theme.
		 * If you want to display them on front to have a base to work with, in this case, you can add support for wp-block-styles, as done below.
		 *
		 * @see Theme Styles.
		 * @link https://make.wordpress.org/core/2018/06/05/whats-new-in-gutenberg-5th-june/, https://developer.wordpress.org/block-editor/developers/themes/theme-support/#default-block-styles
		 */
		add_theme_support( 'wp-block-styles' );

		/**
		 * Some blocks such as the image block have the possibility to define
		 * a “wide” or “full” alignment by adding the corresponding classname
		 * to the block’s wrapper ( alignwide or alignfull ). A theme can opt-in for this feature by calling
		 * add_theme_support( 'align-wide' ), like we have done below.
		 *
		 * @see Wide Alignment
		 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#wide-alignment
		 */
		add_theme_support( 'align-wide' );

		/**
		 * Loads the editor styles in the Gutenberg editor.
		 *
		 * Editor Styles allow you to provide the CSS used by WordPress’ Visual Editor so that it can match the frontend styling.
		 * If we don't add this, the editor styles will only load in the classic editor ( tiny mice )
		 *
		 * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/#editor-styles
		 */
		add_theme_support( 'editor-styles' );
		/**
		 *
		 * Path to our custom editor style.
		 * It allows you to link a custom stylesheet file to the TinyMCE editor within the post edit screen.
		 *
		 * Since we are not passing any parameter to the function,
		 * it will by default, link the editor-style.css file located directly under the current theme directory.
		 * In our case since we are passing 'assets/build/css/editor.css' path it will use that.
		 * You can change the name of the file or path and replace the path here.
		 *
		 * @see add_editor_style(
		 * @link https://developer.wordpress.org/reference/functions/add_editor_style/
		 */
		add_editor_style( 'assets/build/css/editor.css' );

		/**
		 * Set the maximum allowed width for any content in the theme,
		 * like oEmbeds and images added to posts
		 *
		 * @see Content Width
		 * @link https://codex.wordpress.org/Content_Width
		 */
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 1240;
		}
	}

	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function pingback_header(): void {
		if ( is_singular() && pings_open() ) {
			printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
		}
	}

	/**
	 * Add the setting to Writing Settings.
	 *
	 * @return void
	 */
	public function custom_editor_switch_setting() {
		add_settings_field(
			'default_editor', // Field ID.
			'Default Editor', // Title of the field.
			array( $this, 'custom_editor_switch_field_html' ), // Callback function to render field.
			'writing', // Settings page slug (writing settings page).
		);
		register_setting( 'writing', 'default_editor' );
	}

	/**
	 * Render the HTML for the setting field.
	 *
	 * @return void
	 */
	public function custom_editor_switch_field_html() {
		$current_editor = get_option( 'default_editor', 'gutenberg' );  // Default to Gutenberg if not set.
		?>
		<select name="default_editor">
			<option value="gutenberg" <?php selected( $current_editor, 'gutenberg' ); ?>>Gutenberg</option>
			<option value="classic" <?php selected( $current_editor, 'classic' ); ?>>Classic Editor</option>
		</select>
		<?php
	}

	/**
	 * Set the default editor based on the setting.
	 *
	 * @return bool
	 */
	public function custom_set_default_editor() {
		$default_editor = get_option( 'default_editor', 'gutenberg' );

		if ( 'classic' === $default_editor ) {
			return false;
		}

		return true;
	}

	/**
	 * Start output buffering with minification.
	 *
	 * @return void
	 */
	public function start_html_minify(): void {
		ob_start( array( $this, 'minify_output' ) );
	}

	/**
	 * Minify the buffered HTML output.
	 *
	 * @param string $buffer Full HTML output buffer.
	 * @return string Minified HTML.
	 */
	public function minify_output( string $buffer ): string {
		return preg_replace( '/>\s+</', '><', $buffer );
	}

	/**
	 * Register custom query variable for menu.
	 *
	 * @param array $vars Existing query variables.
	 *
	 * @return array Modified query variables.
	 */
	public function gpwp_register_query_var( array $vars ): array {
		$vars[] = 'menu';

		return $vars;
	}

	/**
	 * Include the custom template for the menu.
	 *
	 * @param string $template Current template path.
	 *
	 * @return string Modified template path.
	 */
	public function gpwp_template_include( string $template ): string {
		if ( get_query_var( 'menu' ) ) {
			return get_template_directory() . '/menu.php';
		}
		return $template;
	}

	/**
	 * Add rewrite rule for the custom menu URL.
	 *
	 * This allows us to access the menu via /menu/ URL.
	 *
	 * @return void
	 */
	public function gpwp_nav_rewrite_rule(): void {
		add_rewrite_rule( 'menu', 'index.php?menu=true', 'top' );
	}
}
