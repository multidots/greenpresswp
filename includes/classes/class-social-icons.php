<?php
/**
 * Social icon repeater control.
 *
 * @package GreenPressWP
 */

/**
 * Class Echo_Customize
 */
class Social_Icons extends WP_Customize_Control {

	/**
	 * Render content for social icons UI.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function render_content(): void {
		$value = json_decode( $this->value(), true );
		$value = is_array( $value ) ? $value : array();
		?>
		<label><span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span></label>
		<?php if ( ! empty( $this->description ) ) : ?>
			<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
		<?php endif; ?>
		<div class="social-icons-repeater-wrapper">
			<ul class="social-icons-repeater-list">
				<?php foreach ( $value as $item ) : ?>
					<li class="repeater-item">
						<div class="icon-preview-wrapper">
							<?php if ( ! empty( $item['icon'] ) ) : ?>
								<img src="<?php echo esc_url( $item['icon'] ); ?>" class="icon-preview" />
							<?php endif; ?>
						</div>
						<input type="hidden" class="icon-class" value="<?php echo esc_url( $item['icon'] ); ?>" />
						<button class="upload-icon button"><?php esc_html_e( 'Upload Icon', 'green-press-wp' ); ?></button>
						<input type="url" class="icon-link" value="<?php echo esc_url( $item['link'] ); ?>" placeholder="https://your-url.com" />
						<button class="remove-icon"><?php esc_html_e( '×', 'green-press-wp' ); ?></button>
					</li>
				<?php endforeach; ?>
			</ul>
			<button class="add-icon"><?php esc_html_e( '+ Add Social Icon', 'green-press-wp' ); ?></button>
			<input type="hidden" class="social-icons-repeater-json" <?php $this->link(); ?> value="<?php echo esc_attr( wp_json_encode( $value ) ); ?>">
		</div>
		<?php
	}
}
