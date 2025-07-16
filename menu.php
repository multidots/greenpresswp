<?php
/**
 * The Menu our theme
 *
 * @package GreenPressWP
 */

get_header();
?>

	<main id="primary" class="site-main green-press-wp menu-page">
		<div class="container">
			<nav id="site-navigation" class="main-navigation">
				<h1><?php esc_html_e( 'Menu', 'green-press-wp' ); ?></h1>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
					)
				);
				?>
			</nav><!-- #site-navigation -->
		</div>
	</main><!-- #main -->

<?php
get_footer();