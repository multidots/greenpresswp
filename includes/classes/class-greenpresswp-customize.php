<?php
/**
 * Customize theme options.
 *
 * @package GreenPressWP
 */

declare( strict_types = 1 );

namespace GreenPressWP\Includes;

use GreenPressWP\Includes\Traits\Singleton;
use WP_Customize_Upload_Control;

/**
 * Class GreenPressWP_Customize
 */
class GreenPressWP_Customize {

	use Singleton;

	/**
	 * Construct method.
	 */
	protected function __construct() {

		// Setup hooks.
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
		add_action( 'customize_register', array( $this, 'gpwp_theme_customize_register' ) );
		add_action( 'wp_footer', array( $this, 'load_footer_data' ) );
		add_action( 'wp_head', array( $this, 'load_head_data' ) );
	}

	/**
	 * Register theme customizer settings.
	 *
	 * @param \WP_Customize_Manager $wp_customize Customizer object.
	 *
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function gpwp_theme_customize_register( \WP_Customize_Manager $wp_customize ): void {

		require_once get_template_directory() . '/includes/classes/class-social-icons.php';

		// Add setting for Site Logo Title.
		$wp_customize->add_setting(
			'gpwp_site_logo_title',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
				'type'              => 'theme_mod',
			)
		);

		// Add control under Site Identity.
		$wp_customize->add_control(
			'gpwp_site_logo_title',
			array(
				'label'       => __( 'Site Logo Title', 'green-press-wp' ),
				'description' => __( 'This will be displayed beside site logo.', 'green-press-wp' ),
				'section'     => 'title_tagline',
				'type'        => 'text',
				'priority'    => 15, // Appears after Site Title.
			)
		);

		// Theme Options Panel.
		$wp_customize->add_panel(
			'theme_options_panel',
			array(
				'title'    => __( 'Theme Options', 'green-press-wp' ),
				'priority' => 10,
			)
		);

		// Theme Customizer Section.
		$wp_customize->add_section(
			'theme_customizer_section',
			array(
				'title' => __( 'Font Settings', 'green-press-wp' ),
				'panel' => 'theme_options_panel',
			)
		);

		// Color Options.
		$colors = array(
			'body_bg'                => array(
				'label'   => __( 'Body Background Color', 'green-press-wp' ),
				'default' => '#ffffff',
			),
			'text_color'             => array(
				'label'   => __( 'Text Color', 'green-press-wp' ),
				'default' => '#636363',
			),
			'heading_color'          => array(
				'label'   => __( 'Heading Color', 'green-press-wp' ),
				'default' => '#222222',
			),
			'link_color'             => array(
				'label'   => __( 'Link Color', 'green-press-wp' ),
				'default' => '#277A4B',
			),
			'link_hover_color'       => array(
				'label'   => __( 'Link Hover Color', 'green-press-wp' ),
				'default' => '#222222',
			),
			'block_quote_color'      => array(
				'label'   => __( 'Block Quote Color', 'green-press-wp' ),
				'default' => '#277A4B',
			),
			'site_title_color'       => array(
				'label'   => __( 'Site Title Color', 'green-press-wp' ),
				'default' => '#222222',
			),
			'site_tagline_color'     => array(
				'label'   => __( 'Site Tagline Color', 'green-press-wp' ),
				'default' => '#909090',
			),
			'header_bg_color'        => array(
				'label'   => __( 'Header Background Color', 'green-press-wp' ),
				'default' => '#ffffff',
			),
			'header_nav_link_color'  => array(
				'label'   => __( 'Header Navigation Link Color', 'green-press-wp' ),
				'default' => '#277A4B',
			),
			'footer_bg_color'        => array(
				'label'   => __( 'Footer Background Color', 'green-press-wp' ),
				'default' => '#f5f4f4',
			),
			'footer_text_link_color' => array(
				'label'   => __( 'Footer Text & Navigation Link Color', 'green-press-wp' ),
				'default' => '#000',
			),
		);

		foreach ( $colors as $id => $color ) {
			$wp_customize->add_setting(
				$id,
				array(
					'default'           => $color['default'],
					'sanitize_callback' => 'sanitize_hex_color',
				)
			);
			$wp_customize->add_control(
				new \WP_Customize_Color_Control(
					$wp_customize,
					$id,
					array(
						'label'    => $color['label'],
						'section'  => 'colors',
						'settings' => $id,
					)
				)
			);
		}

		// Fonts.
		$wp_customize->add_setting(
			'font_type',
			array(
				'default'           => 'system',
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			'font_type',
			array(
				'label'   => __( 'Font Type', 'green-press-wp' ),
				'section' => 'theme_customizer_section',
				'type'    => 'select',
				'choices' => array(
					''       => __( 'Default', 'green-press-wp' ),
					'system' => __( 'System Font', 'green-press-wp' ),
					'custom' => __( 'Custom Font', 'green-press-wp' ),
					'google' => __( 'Google Font', 'green-press-wp' ),
				),
			)
		);

		// Google Fonts.
		$google_fonts = array(
			''                 => __( 'Select Google Font', 'green-press-wp' ),
			'Roboto'           => __( 'Roboto', 'green-press-wp' ),
			'Open Sans'        => __( 'Open Sans', 'green-press-wp' ),
			'Lato'             => __( 'Lato', 'green-press-wp' ),
			'Montserrat'       => __( 'Montserrat', 'green-press-wp' ),
			'Poppins'          => __( 'Poppins', 'green-press-wp' ),
			'Playfair Display' => __( 'Playfair Display', 'green-press-wp' ),
			'Merriweather'     => __( 'Merriweather', 'green-press-wp' ),
			'Raleway'          => __( 'Raleway', 'green-press-wp' ),
			'Nunito'           => __( 'Nunito', 'green-press-wp' ),
			'Ubuntu'           => __( 'Ubuntu', 'green-press-wp' ),
			'Oswald'           => __( 'Oswald', 'green-press-wp' ),
		);

		$wp_customize->add_setting(
			'google_font_name',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'google_font_name',
			array(
				'label'           => __( 'Select Google Font', 'green-press-wp' ),
				'section'         => 'theme_customizer_section',
				'type'            => 'select',
				'choices'         => $google_fonts,
				'active_callback' => array(
					$this,
					'is_google_font_selected',
				),

			)
		);

		// --- Custom Font Upload ---
		$wp_customize->add_setting(
			'custom_font_woff',
			array(
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Upload_Control(
				$wp_customize,
				'custom_font_woff',
				array(
					'label'           => __( 'Upload .woff Font', 'green-press-wp' ),
					'section'         => 'theme_customizer_section',
					'active_callback' => array(
						$this,
						'is_custom_font_selected',
					),
				)
			)
		);

		$wp_customize->add_setting(
			'custom_font_woff2',
			array(
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Upload_Control(
				$wp_customize,
				'custom_font_woff2',
				array(
					'label'           => __( 'Upload .woff2 Font', 'green-press-wp' ),
					'section'         => 'theme_customizer_section',
					'active_callback' => array(
						$this,
						'is_custom_font_selected',
					),
				)
			)
		);

		// --- Custom Font Name ---
		$wp_customize->add_setting(
			'custom_font_name',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'custom_font_name',
			array(
				'label'           => __( 'Custom Font Family Name', 'green-press-wp' ),
				'description'     => __( 'The name to use in CSS (e.g., "MyCustomFont")', 'green-press-wp' ),
				'section'         => 'theme_customizer_section',
				'type'            => 'text',
				'active_callback' => array(
					$this,
					'is_custom_font_selected',
				),
			)
		);

		// --- System Font Dropdown ---
		$system_fonts = array(
			''                       => __( 'Select System Font', 'green-press-wp' ),
			'Arial, sans-serif'      => __( 'Arial', 'green-press-wp' ),
			'Georgia, serif'         => __( 'Georgia', 'green-press-wp' ),
			'Helvetica, sans-serif'  => __( 'Helvetica', 'green-press-wp' ),
			'Times New Roman, serif' => __( 'Times New Roman', 'green-press-wp' ),
			'Courier New, monospace' => __( 'Courier New', 'green-press-wp' ),
			'Verdana, sans-serif'    => __( 'Verdana', 'green-press-wp' ),
			'Tahoma, sans-serif'     => __( 'Tahoma', 'green-press-wp' ),
			'Palatino, serif'        => __( 'Palatino', 'green-press-wp' ),
			'Garamond, serif'        => __( 'Garamond', 'green-press-wp' ),
			'Impact, sans-serif'     => __( 'Impact', 'green-press-wp' ),
		);
		$wp_customize->add_setting(
			'system_font_family',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'system_font_family',
			array(
				'label'           => __( 'Select System Font', 'green-press-wp' ),
				'section'         => 'theme_customizer_section',
				'type'            => 'select',
				'choices'         => $system_fonts,
				'active_callback' => array(
					$this,
					'is_system_font_selected',
				),
			)
		);

		// General Settings Section.
		$wp_customize->add_section(
			'general_settings_section',
			array(
				'title' => __( 'General Settings', 'green-press-wp' ),
				'panel' => 'theme_options_panel',
			)
		);

		$wp_customize->add_setting(
			'default_og_image',
			array(
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new \WP_Customize_Image_Control(
				$wp_customize,
				'default_og_image',
				array(
					'label'       => __( 'Default OG Image', 'green-press-wp' ),
					'section'     => 'general_settings_section',
					'settings'    => 'default_og_image',
					'description' => __( 'Recommended size: 1200x630 pixels and use WebP format for better performance.', 'green-press-wp' ),
				)
			)
		);

		$wp_customize->add_setting(
			'social_icons',
			array(
				'default'           => '[]',
				'sanitize_callback' => function ( $input ) {
					$input = json_decode( $input, true );
					if ( ! is_array( $input ) ) {
						return '[]';
					}
					return wp_json_encode(
						array_map(
							function ( $item ) {
								return array(
									'icon' => sanitize_text_field( $item['icon'] ),
									'link' => esc_url_raw( $item['link'] ),
								);
							},
							$input
						)
					);
				},
			)
		);

		$wp_customize->add_control(
			new \Social_Icons(
				$wp_customize,
				'social_icons',
				array(
					'label'       => __( 'Social Icons', 'green-press-wp' ),
					'section'     => 'general_settings_section',
					'description' => __( 'Add your social media icons and links. Use WebP or SVG icons for better performance.', 'green-press-wp' ),
					'settings'    => 'social_icons',
				)
			)
		);

		// Third Party Scripts Section.
		$wp_customize->add_section(
			'third_party_scripts_section',
			array(
				'title' => __( 'Third Party Integration', 'green-press-wp' ),
				'panel' => 'theme_options_panel',
			)
		);

		$wp_customize->add_setting(
			'scripts_header',
			array(
				'default'           => '',
				'sanitize_callback' => array( $this, 'gpwp_theme_allow_script_tags' ),

			)
		);
		$wp_customize->add_control(
			'scripts_header',
			array(
				'label'   => __( 'Scripts in Header', 'green-press-wp' ),
				'section' => 'third_party_scripts_section',
				'type'    => 'textarea',
			)
		);

		$wp_customize->add_setting(
			'scripts_footer',
			array(
				'default'           => '',
				'sanitize_callback' => array( $this, 'gpwp_theme_allow_script_tags' ),
			)
		);
		$wp_customize->add_control(
			'scripts_footer',
			array(
				'label'   => __( 'Scripts in Footer', 'green-press-wp' ),
				'section' => 'third_party_scripts_section',
				'type'    => 'textarea',
			)
		);

		// Header Settings Section.
		$wp_customize->add_section(
			'header_settings_section',
			array(
				'title' => __( 'Header Settings', 'green-press-wp' ),
				'panel' => 'theme_options_panel',
			)
		);

		// Show Buttons Instead of Menu.
		$wp_customize->add_setting(
			'show_buttons_instead_menu',
			array(
				'default'           => false,
				'sanitize_callback' => 'rest_sanitize_boolean',
			)
		);
		$wp_customize->add_control(
			'show_buttons_instead_menu',
			array(
				'label'       => __( 'Show Buttons Instead of Menu', 'green-press-wp' ),
				'description' => __( 'Check this to display header buttons instead of the navigation menu.', 'green-press-wp' ),
				'section'     => 'header_settings_section',
				'type'        => 'checkbox',
			)
		);

		// Header Button 1 Settings.
		$wp_customize->add_setting(
			'header_button_1_text',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'header_button_1_text',
			array(
				'label'           => __( 'Button 1 Text', 'green-press-wp' ),
				'description'     => __( 'Enter the text for the first header button.', 'green-press-wp' ),
				'section'         => 'header_settings_section',
				'type'            => 'text',
				'active_callback' => array(
					$this,
					'is_buttons_enabled',
				),
			)
		);

		$wp_customize->add_setting(
			'header_button_1_url',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'header_button_1_url',
			array(
				'label'           => __( 'Button 1 URL', 'green-press-wp' ),
				'description'     => __( 'Enter the URL for the first header button.', 'green-press-wp' ),
				'section'         => 'header_settings_section',
				'type'            => 'url',
				'active_callback' => array(
					$this,
					'is_buttons_enabled',
				),
			)
		);

		$wp_customize->add_setting(
			'header_button_1_new_window',
			array(
				'default'           => false,
				'sanitize_callback' => 'rest_sanitize_boolean',
			)
		);
		$wp_customize->add_control(
			'header_button_1_new_window',
			array(
				'label'           => __( 'Open Button 1 in New Window', 'green-press-wp' ),
				'section'         => 'header_settings_section',
				'type'            => 'checkbox',
				'active_callback' => array(
					$this,
					'is_buttons_enabled',
				),
			)
		);

		// Header Button 2 Settings.
		$wp_customize->add_setting(
			'header_button_2_text',
			array(
				'default'           => '',
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'header_button_2_text',
			array(
				'label'           => __( 'Button 2 Text', 'green-press-wp' ),
				'description'     => __( 'Enter the text for the second header button.', 'green-press-wp' ),
				'section'         => 'header_settings_section',
				'type'            => 'text',
				'active_callback' => array(
					$this,
					'is_buttons_enabled',
				),
			)
		);

		$wp_customize->add_setting(
			'header_button_2_url',
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			'header_button_2_url',
			array(
				'label'           => __( 'Button 2 URL', 'green-press-wp' ),
				'description'     => __( 'Enter the URL for the second header button.', 'green-press-wp' ),
				'section'         => 'header_settings_section',
				'type'            => 'url',
				'active_callback' => array(
					$this,
					'is_buttons_enabled',
				),
			)
		);

		$wp_customize->add_setting(
			'header_button_2_new_window',
			array(
				'default'           => false,
				'sanitize_callback' => 'rest_sanitize_boolean',
			)
		);
		$wp_customize->add_control(
			'header_button_2_new_window',
			array(
				'label'           => __( 'Open Button 2 in New Window', 'green-press-wp' ),
				'section'         => 'header_settings_section',
				'type'            => 'checkbox',
				'active_callback' => array(
					$this,
					'is_buttons_enabled',
				),
			)
		);

		// Footer Settings Section.
		$wp_customize->add_section(
			'footer_settings_section',
			array(
				'title' => __( 'Footer Settings', 'green-press-wp' ),
				'panel' => 'theme_options_panel',
			)
		);

		$wp_customize->add_setting(
			'footer_text',
			array(
				'default'           => '',
				'sanitize_callback' => 'wp_kses_post',
			)
		);
		$wp_customize->add_control(
			'footer_text',
			array(
				'label'       => __( 'Footer Text', 'green-press-wp' ),
				'description' => __( 'Enter the text to display in the footer. HTML is allowed.', 'green-press-wp' ),
				'section'     => 'footer_settings_section',
				'type'        => 'textarea',
			)
		);

		// Custom Logo Control.
		$control = $wp_customize->get_control( 'custom_logo' );

		if ( $control ) {
			$control->description = __( 'Use WebP or SVG logo for better performance.', 'green-press-wp' );
		}
	}

	/**
	 * Load data in the footer.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function load_footer_data(): void {

		// Footer custom scripts.
		$allowed = array(
			'script' => array(
				'type' => true,
			),
		);
		echo wp_kses( get_theme_mod( 'scripts_footer' ), $allowed );
	}

	/**
	 * Load data in the head.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function load_head_data(): void {

		// Header custom Scripts.
		$allowed = array(
			'script' => array(
				'type' => true,
			),
		);
		echo wp_kses( get_theme_mod( 'scripts_header' ), $allowed );

		// OG meta tag.
		if ( is_singular() ) {
			global $post;

			// Try to get featured image (priority).
			if ( has_post_thumbnail( $post->ID ) ) {
				$image = get_the_post_thumbnail_url( $post->ID, 'full' );
			} else {
				// Fallback to Customizer OG image.
				$image = get_theme_mod( 'default_og_image' );
			}

			if ( $image ) {
				echo '<meta property="og:image" content="' . esc_url( $image ) . '">' . "\n";
			}
		}

		// Dynamic CSS for colors and fonts.
		$styles = '';

		// Font styles.
		$font_type = get_theme_mod( 'font_type', 'system' );

		switch ( $font_type ) {
			case 'google':
				$font_name = get_theme_mod( 'google_font_name' );
				if ( $font_name ) {
					$font_url = str_replace( ' ', '+', $font_name );
					echo "<link href='https://fonts.googleapis.com/css2?family={$font_url}:wght@400;700&display=swap' rel='stylesheet'>"; // phpcs:ignore
					$styles .= "body { font-family: '{$font_name}', sans-serif; }";
				}
				break;

			case 'custom':
				$woff_url  = get_theme_mod( 'custom_font_woff' );
				$woff2_url = get_theme_mod( 'custom_font_woff2' );
				$font_name = get_theme_mod( 'custom_font_name' );
				if ( ( $woff_url || $woff2_url ) && $font_name ) {
					$src = array();
					if ( $woff2_url ) {
						$src[] = "url('{$woff2_url}') format('woff2')";
					}
					if ( $woff_url ) {
						$src[] = "url('{$woff_url}') format('woff')";
					}
					$src_str = implode( ",\n", $src );

					$styles .= "
					@font-face {
						font-family: '{$font_name}';
						src: {$src_str};
						font-display: swap;
					}
					body {
						font-family: '{$font_name}', sans-serif;
					}
				";
				}
				break;

			case 'system':
				$system_font = get_theme_mod( 'system_font_family' );
				if ( $system_font ) {
					$styles .= "body { font-family: {$system_font}; }";
				}
				break;
		}

		if ( $styles ) {
			echo '<style>' . $styles . '</style>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		}
	}

	/**
	 * Sanitize script tags.
	 *
	 * @param string $input Input string.
	 * @return string Sanitized output.
	 */
	public function gpwp_theme_allow_script_tags( string $input ): string {
		$allowed_tags = array(
			'script' => array(
				'type'  => true,
				'src'   => true,
				'async' => true,
				'defer' => true,
			),
		);

		return wp_kses( $input, $allowed_tags );
	}

	/**
	 * Check if Google Font is selected.
	 *
	 * @param \WP_Customize_Control $control Control object.
	 *
	 * @return bool
	 */
	public function is_google_font_selected( \WP_Customize_Control $control ): bool {
		$font_type = $control->manager->get_setting( 'font_type' )->value();
		return 'google' === $font_type;
	}

	/**
	 * Check if Custom Font is selected.
	 *
	 * @param \WP_Customize_Control $control Control object.
	 *
	 * @return bool
	 */
	public function is_custom_font_selected( \WP_Customize_Control $control ): bool {
		$font_type = $control->manager->get_setting( 'font_type' )->value();
		return 'custom' === $font_type;
	}

	/**
	 * Check if System Font is selected.
	 *
	 * @param \WP_Customize_Control $control Control object.
	 *
	 * @return bool
	 */
	public function is_system_font_selected( \WP_Customize_Control $control ): bool {
		$font_type = $control->manager->get_setting( 'font_type' )->value();
		return 'system' === $font_type;
	}

	/**
	 * Check if Buttons are enabled instead of menu.
	 *
	 * @param \WP_Customize_Control $control Control object.
	 *
	 * @return bool
	 */
	public function is_buttons_enabled( \WP_Customize_Control $control ): bool {
		$show_buttons = $control->manager->get_setting( 'show_buttons_instead_menu' )->value();
		return (bool) $show_buttons;
	}
}
