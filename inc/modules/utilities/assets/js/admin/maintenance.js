function pstoolkit_maintenance_add_already_used_sites() {
	var sites = [];
	jQuery( '.pstoolkit-maintenance-subsites .simple-option-media').each( function() {
		var id = jQuery( this ).data('blog-id');
		if ( id ) {
			sites.push( id );
		}
	});
	return sites;
}

jQuery( document ).ready( function( $ ) {
	/**
	 * handle site add
	 */
	$( '.pstoolkit-maintenance-subsite-add' ).on( 'click', function() {
		var target = $('.pstoolkit-tab-mode-subsites' );
		var subsite = $( '#pstoolkit-maintenance-search' );
		var data = subsite.SUIselect2( 'data' );
		if ( 0 === data.length ) {
			return;
		}
		/**
		 * Add row
		 */
		var template = wp.template( 'pstoolkit-maintenance-subsite' );
		data = {
			id: data[0].id,
			subtitle: data[0].subtitle,
			title: data[0].title,
		}
		$( target ).append( template( data ) );
		/**
		 * Reset SUIselect2
		 */
		subsite.val('');
		/**
		 * Handle maintenance
		 */
		var container_id = '#pstoolkit-maintenance-subsite-container-' + data.id;
		$( '.pstoolkit-maintenance-delete', container_id ).on( 'click', function() {
			$(container_id).remove();
		});
	});

	/**
	 * Delete
	 */
	$( '.pstoolkit-maintenance-delete' ).on( 'click', function () {
		var data = {
			action: 'pstoolkit_maintenance_delete_subsite',
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

});
