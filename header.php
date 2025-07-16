<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package GreenPressWP
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'green-press-wp' ); ?></a>

	<header id="masthead" class="gpwp-header site-header">
		<div class="container">
			<?php
			$show_buttons_instead_menu = get_theme_mod( 'show_buttons_instead_menu', false );
			if ( $show_buttons_instead_menu ) {
				$btn_class = 'header-button';
			} else {
				$btn_class = 'menu-text-link';
			}
			?>
			<div class="gpwp-header-wrap <?php echo esc_attr( $btn_class ); ?>">
				<div class="site-branding">
					<?php
					$site_name   = get_theme_mod( 'gpwp_site_logo_title' );
					$description = get_bloginfo( 'description', 'display' );

					if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
						the_custom_logo();
					} else {
						echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="custom-logo-link" rel="home">';
						echo '<img src="' . esc_url( get_template_directory_uri() ) . '/assets/images/gpwp-logo.svg" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" alt="' . esc_attr( $site_name ) . '" />';
						echo '</a>';
					}
					?>
					<?php if ( ! empty( $site_name ) || ! empty( $description ) ) : ?>
						<div class="site-branding-desc">
							<?php
							if ( is_front_page() && is_home() ) :
								?>
								<?php if ( ! empty( $site_name ) ) : ?>
									<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( $site_name ); ?></a></h1>
								<?php endif; ?>
								<?php
								if ( $description || is_customize_preview() ) :
									?>
									<p class="site-description">
									<?php echo esc_html( $description ); ?>
									</p>
								<?php endif; ?>
								<?php
							else :
								?>
								<?php if ( ! empty( $site_name ) ) : ?>
									<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php echo esc_html( $site_name ); ?></a></p>
								<?php endif; ?>
								<?php
								if ( $description || is_customize_preview() ) :
									?>
									<p class="site-description">
									<?php echo esc_html( $description ); ?>
									</p>
								<?php endif; ?>
								<?php
							endif;
							?>
						</div>
					<?php endif; ?>
				</div><!-- .site-branding -->
				<?php
				
				if ( $show_buttons_instead_menu ) :
					// Header Buttons.
					$button_1_text       = get_theme_mod( 'header_button_1_text' );
					$button_1_url        = get_theme_mod( 'header_button_1_url' );
					$button_1_new_window = get_theme_mod( 'header_button_1_new_window', false );

					$button_2_text       = get_theme_mod( 'header_button_2_text' );
					$button_2_url        = get_theme_mod( 'header_button_2_url' );
					$button_2_new_window = get_theme_mod( 'header_button_2_new_window', false );

					if ( ! empty( $button_1_text ) && ! empty( $button_1_url ) || ! empty( $button_2_text ) && ! empty( $button_2_url ) ) :
						?>
						<div class="header-buttons-wrap">
							<?php if ( ! empty( $button_1_text ) && ! empty( $button_1_url ) ) : ?>
								<a href="<?php echo esc_url( $button_1_url ); ?>" 
									<?php echo $button_1_new_window ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
									class="header-button header-button-1">
									<?php echo esc_html( $button_1_text ); ?>
								</a>
							<?php endif; ?>

							<?php if ( ! empty( $button_2_text ) && ! empty( $button_2_url ) ) : ?>
								<a href="<?php echo esc_url( $button_2_url ); ?>" 
									<?php echo $button_2_new_window ? 'target="_blank" rel="noopener noreferrer"' : ''; ?>
									class="header-button header-button-2">
									<?php echo esc_html( $button_2_text ); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				<?php elseif ( has_nav_menu( 'menu-1' ) ) : ?>
					<div class="header-nav-wrap">
						<?php
						if ( get_query_var( 'menu' ) ) :
							?>
							<a id="gpwp-back-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="menu-text-link">&#x2716;<span class="screen-reader-text"><?php esc_html_e( 'Close menu', 'green-press-wp' ); ?></span></a>
							<script>
								var gpwp_home_url = '<?php echo esc_url( home_url( '/' ) ); ?>';
								if ( 0 === document.referrer.indexOf( gpwp_home_url ) ) {
									document.getElementById( 'gpwp-back-link' ).href = document.referrer;
								}
							</script>
							<?php
						else :
							?>
							<a href="<?php echo esc_url( ( get_option( 'permalink_structure' ) ? home_url( '/menu/' ) : home_url( '/?menu' ) ) ); ?>" class="menu-text-link"><?php esc_html_e( 'Menu', 'green-press-wp' ); ?></a>
							<?php
						endif;
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</header><!-- #masthead -->
