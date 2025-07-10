<?php
/**
 * Dynamic Blocks.
 *
 * @package GreenPressWP
 */

declare( strict_types = 1 );

namespace GreenPressWP\Includes;

use GreenPressWP\Includes\Traits\Singleton;

/**
 * Class Blocks
 */
class Blocks {
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
		 * Load blocks classes.
		 */
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_filter( 'block_categories_all', array( $this, 'custom_block_category' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'localize_gutenberg_blocks_config' ) );
	}

	/**
	 * Automatically registers all blocks that are located within the includes/blocks directory
	 *
	 * @return void
	 * @since 2.0.0
	 */
	public function register_blocks(): void {
		// Register all the blocks in the plugin.
		if ( file_exists( GREEN_PRESS_WP_SRC_BLOCK_DIR_PATH ) ) {
			$block_json_files = glob( GREEN_PRESS_WP_SRC_BLOCK_DIR_PATH . '/*/block.json' );

			// auto register all blocks that were found.
			foreach ( $block_json_files as $filename ) {
				// Retrieve block meta data.
				$metadata = wp_json_file_decode( $filename, array( 'associative' => true ) );
				if ( empty( $metadata ) || empty( $metadata['name'] ) ) {
					continue;
				}

				$block_name = $metadata['name'];
				$class_name = $this->block_class_from_string( $block_name );

				if ( $class_name && class_exists( $class_name, true ) ) {
					$block = $class_name::get_instance();
					$block->init();
				}
			}
		}
	}

	/**
	 * Register Custom Block Category
	 *
	 * @param array $categories return categories array.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public function custom_block_category( array $categories ): array {
		$categories = array_merge(
			array(
				array(
					'slug'  => 'green-press-wp',
					'title' => __( 'Table of Content', 'green-press-wp' ),
					'icon'  => 'welcome-add-page',
				),
			),
			$categories
		);
		return $categories;
	}

	/**
	 * Take a string with a block name, return the class name.
	 *
	 * @param string $string_value string to generate class name from.
	 *
	 * @return string|null class name with namespace
	 * @since 2.0.0
	 */
	public static function block_class_from_string( string $string_value ): ?string {
		// Force lowercase. Normalize.
		$string_value = strtolower( $string_value );

		// Default namespace for blocks.
		$namespace = 'GreenPressWP\Blocks\\';

		// Remove namespace from block name.
		if ( false !== strpos( $string_value, 'green-press-wp/' ) ) {
			$string_value = str_replace( 'green-press-wp/', '', $string_value );
		}

		// Blow up names on the hyphens.
		$split = explode( '-', $string_value );

		// Upper Case Words when we join things back together.
		// implode is used on the variable that is exploded above.
		return $namespace . implode( '_', array_map( 'ucfirst', (array) $split ) );
	}

	/**
	 * Localize all blocks configuration under one object
	 *
	 * @return void
	 * @since 2.0.0
	 */
	public function localize_gutenberg_blocks_config(): void {
		$blocks_config = apply_filters( 'gpwp_gutenberg_blocks_config', array() );

		wp_localize_script(
			'wp-edit-post',
			'gpwp_gutenberg_blocks_config',
			$blocks_config
		);

		wp_enqueue_script(
			'gpwp-theme-customizer',
			get_template_directory_uri() . '/assets/admin/customizer.js',
			array( 'customize-preview' ),
			'1.0.0',
			true
		);

		wp_enqueue_style(
			'gpwp-theme-admin-styles',
			get_template_directory_uri() . '/assets/admin/customizer.css',
			array(),
			'1.0.0'
		);
	}
}
