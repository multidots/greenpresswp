<?php
/**
 * Register Menus.
 *
 * @package GreenPressWP
 */

declare( strict_types = 1 );

namespace GreenPressWP\Includes;

use GreenPressWP\Includes\Traits\Singleton;

/**
 * Class Menus
 */
class Menus {
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
		add_action( 'init', array( $this, 'register_menus' ) );
	}

	/**
	 * Register Menus
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function register_menus(): void {
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary Menu', 'green-press-wp' ),
				'menu-2' => esc_html__( 'Footer Menu', 'green-press-wp' ),
			)
		);
	}
}
