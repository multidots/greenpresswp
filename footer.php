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
				<div class="site-footer-content">
					<?php
					$footer_text = get_theme_mod( 'footer_text' );
					if ( ! empty( $footer_text ) ) :
						echo wp_kses_post( $footer_text );
					else :
						?>
						<p><?php esc_html_e( 'Powered by Multidots.', 'green-press-wp' ); ?></p>
						<?php
					endif;
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
