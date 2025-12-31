function pstoolkit_images_add_already_used_sites() {
	var sites = [];
	jQuery( '.pstoolkit-images-subsites .simple-option-media').each( function() {
		var id = jQuery( this ).data('blog-id');
		if ( id ) {
			sites.push( id );
		}
	});
	return sites;
}

jQuery( document ).ready( function( $ ) {
	/**
	 * init set
	 */
	$('select.pstoolkit-images-quantity').each( function() {
		var parent = $(this).closest( '.sui-row');
		var quant = $('option:selected', $('select.pstoolkit-images-quantity', parent ) );
		if ( 0 < quant.length ) {
			quant = quant.val();
			parent.data( 'previous', quant );
			$( 'input[type=number]', parent ).prop( 'max', pstoolkit_images.quants[ quant ].max );
		}
	});
	/**
	 * handle site add
	 */
	$( '#pstoolkit-images-search' ).on( 'select2:select', function (e) {
		var data = e.params.data;
	})
	$( '.pstoolkit-images-subsite-add' ).on( 'click', function() {
		var target = $('.pstoolkit-images-subsites' );
		var subsite = $( '#pstoolkit-images-search' );
		var data = subsite.SUIselect2( 'data' );
		if ( 0 === data.length ) {
			return;
		}
		/**
		 * Add row
		 */
		var template = wp.template( 'pstoolkit-images-subsite' );
		data = {
			id: data[0].id,
			subtitle: data[0].subtitle,
			title: data[0].title,
		}
		$('>.sui-notice', target )
			.hide()
			.after( template( data ) )
		;
		/**
		 * Reset SUIselect2
		 */
		subsite.val( null ).trigger( 'change' );
		/**
		 * Handle images
		 */
		var container_id = '#pstoolkit-images-subsite-container-' + data.id;
		target = $( container_id + ' .images' );
		template = wp.template( 'simple-options-media' );
		data = {
			id: 'favicon',
			image_id: 'time-'+Math.random().toString(36).substring(7),
			section_key: 'subsites',
			value: '',
			image_src: '',
			file_name: '',
			disabled: '',
			container_class: ''
		};
		target.append( template( data ) );
		$( '.button-select-image', target ).on( 'click', function( event ) {
			ub_media_bind( this, event );
		});
		$( '.image-reset', target ).on( 'click', function() {
			ub_bind_reset_image( this );
			return false;
		});
		$( '.pstoolkit-images-delete', container_id ).on( 'click', function() {
			$(container_id).remove();
		});
	});

	/**
	 * Delete
	 */
	$( '.pstoolkit-images-delete' ).on( 'click', function () {
		var data = {
			action: 'pstoolkit_images_delete_subsite',
			_wpnonce: $(this).data('nonce'),
			id: $(this).data('id')
		};
		$.post( ajaxurl, data, function( response ) {
			if ( response.success ) {
				window.location.reload();
			} else {
				SUI.openFloatNotice( response.data.message );
			}
		});
	});

	$('.pstoolkit-images-quantity').on( 'change', function() {
		var parent = $(this).closest( '.sui-row');
		var select = $('select.pstoolkit-images-quantity', parent );
		var quant = $('option:selected', select ).val()
		var prev = parent.data( 'previous' );
		var amount = $('.pstoolkit-images-amount', parent );
		var value = parseInt( amount.val() );
		value *= pstoolkit_images.quants[ prev ].quant;
		value /= pstoolkit_images.quants[ quant ].quant;
		amount.val( Math.floor( value ) ).prop( 'max', pstoolkit_images.quants[ quant ].max );
		parent.data( 'previous', quant );
	});

});
