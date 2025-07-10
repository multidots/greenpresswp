/* eslint-disable no-alert */
jQuery( function ( $ ) {
	wp.customize( 'font_type', function ( setting ) {
		setting.bind( function ( value ) {
			// Toggle Google Font dropdown.
			wp.customize
				.control( 'google_font_name' )
				.toggle( 'google' === value );

			// Toggle System Font dropdown.
			wp.customize
				.control( 'system_font_family' )
				.toggle( 'system' === value );

			// Toggle Custom Font controls.
			wp.customize
				.control( 'custom_font_woff' )
				.toggle( 'custom' === value );

			wp.customize
				.control( 'custom_font_woff2' )
				.toggle( 'custom' === value );

			wp.customize
				.control( 'custom_font_name' )
				.toggle( 'custom' === value );
		} );
	} );

	function updateSocialIconsJson( container ) {
		const data = [];
		container.find( '.repeater-item' ).each( function () {
			const icon = $( this ).find( '.icon-class' ).val();
			const link = $( this ).find( '.icon-link' ).val();
			data.push( { icon, link } );
		} );
		container
			.find( '.social-icons-repeater-json' )
			.val( JSON.stringify( data ) )
			.trigger( 'change' );
	}

	$( '.social-icons-repeater-wrapper' ).each( function () {
		const container = $( this );

		container.on( 'click', '.add-icon', function ( e ) {
			e.preventDefault();
			container.find( '.social-icons-repeater-list' ).append( `
				<li class="repeater-item">
					<div class="icon-preview-wrapper"></div>
					<input type="hidden" class="icon-class" />
					<button class="upload-icon button">Upload Icon</button>
					<input type="url" class="icon-link" placeholder="https://your-url.com" />
					<button class="remove-icon">×</button>
				</li>
			` );
			updateSocialIconsJson( container );
		} );

		container.on( 'click', '.remove-icon', function ( e ) {
			e.preventDefault();
			$( this ).closest( '.repeater-item' ).remove();
			updateSocialIconsJson( container );
		} );

		container.on( 'input', '.icon-link', function () {
			updateSocialIconsJson( container );
		} );

		container.on( 'click', '.upload-icon', function ( e ) {
			e.preventDefault();
			const button = $( this );
			const item = button.closest( '.repeater-item' );
			const preview = item.find( '.icon-preview-wrapper' );
			const input = item.find( '.icon-class' );

			const media = wp.media( {
				title: 'Select SVG Icon',
				button: { text: 'Use this icon' },
				library: { type: 'image/svg+xml' },
				multiple: false,
			} );

			media.on( 'select', function () {
				const attachment = media
					.state()
					.get( 'selection' )
					.first()
					.toJSON();
				if ( attachment.url.endsWith( '.svg' ) ) {
					input.val( attachment.url );
					preview.html(
						`<img src="${ attachment.url }" class="icon-preview" />`
					);
					updateSocialIconsJson( container );
				} else {
					alert( 'Please select an SVG file.' );
				}
			} );

			media.open();
		} );
	} );
} );
