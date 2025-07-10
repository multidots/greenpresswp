<?php
/**
 * The template for displaying the footer
 *
 * @package GreenPressWP
 */

?>
	<footer id="colophon" class="site-footer">
		<div class="container">
			<div class="site-info">
				<div class="site-footer-menu">
					<?php
						wp_nav_menu(
							array(
								'theme_location'  => 'menu-2',
								'menu_id'         => 'footer-menu',
								'menu_class'      => 'footer-menu-list',
								'container'       => 'ul',
								'container_class' => 'footer-menu-list',
							)
						);
						?>
				</div>
				<?php
				$social_links = get_theme_mod( 'social_icons', '[]' );
				$social_links = json_decode( $social_links, true );

				if ( ! empty( $social_links ) && is_array( $social_links ) ) :
					?>
					<ul class="site-social-icon">
						<?php foreach ( $social_links as $social ) : ?>
							<?php
							$icon_url  = isset( $social['icon'] ) ? esc_url( $social['icon'] ) : '';
							$icon_link = isset( $social['link'] ) ? esc_url( $social['link'] ) : '';
							if ( ! empty( $icon_url ) && ! empty( $icon_link ) ) :
								?>
								<li>
									<a target="_blank" href="<?php echo esc_url( $icon_link ); ?>" rel="noopener noreferrer">
										<img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php esc_attr_e( 'Social Icon', 'green-press-wp' ); ?>" style="width: 24px; height: 24px;" />
									</a>
								</li>
							<?php endif; ?>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
