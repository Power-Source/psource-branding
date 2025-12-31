(function($){
	// Save settings.
	$( '.pstoolkit-module-save-email-logs-settings' ).on( 'click', function () {
		var form = $( '.module-pstoolkit-form.module-emails-email-logs-php' );
		SUI.pstoolkitSaveSettings.call( this, $, form )
	});

	// Open Filters.
	$( '.sui-pagination-wrap .pstoolkit-open-inline-filter' ).on( 'click', function(e) {
		var $this    = $( this ),
			$wrapper = $this.closest( '.sui-pagination-wrap' ),
			$button  = $wrapper.find( '.sui-button-icon' ),
			$filters = $this.closest( '.pstoolkit-actions-bar' ).next( '.sui-pagination-filter' );

		$button.toggleClass( 'sui-active' );
		$filters.toggleClass( 'sui-open' );

		e.preventDefault();
		e.stopPropagation();
	});

	// Clear filters.
	$( '.pstoolkit-entries-clear-filter' ).on( 'click', function(e) {
		var $form = $( this ).closest('form');

		e.preventDefault();
		$form.find('.pstoolkit-filter-field').val( '' ).trigger('change');
	});

	// Toggle Clear Button.
	$( '.sui-pagination-filter .pstoolkit-filter-field' ).on( 'change apply.daterangepicker', toggleClearButton ).trigger('change');
	function toggleClearButton( e ) {
		let $form = $( this ).closest( 'form' );
		let $clearFilter = $form.find( '.pstoolkit-entries-clear-filter' );
		let is_one_not_empty = $form.find( '.pstoolkit-filter-field' ).map(function(){return $(this).val();}).get().some((element) => element !== '');

		if ( is_one_not_empty ) {
			$clearFilter.removeAttr( 'disabled' );
		} else {
			$clearFilter.prop( 'disabled', true );
		}
	}

	// Remove filter.
	$( '.sui-active-filter-remove' ).on( 'click', function(e) {
		let $this    = $( this ),
			possibleFilters = [ 'order_by', 'keyword', 'recipient', 'from_email', 'date_range' ],
			currentFilter = $this.data( 'filter' ),
			re = new RegExp( '&' + currentFilter + '=[^&]*', 'i' );

		if ( -1 !== possibleFilters.indexOf( currentFilter ) ) {
			location.href = location.href.replace( re, '' );
		}
	});

	setTimeout(
		function() {
			// Datepicker.
			$( 'input.pstoolkit-filter-date' ).daterangepicker({
				autoUpdateInput: false,
				autoApply: true,
				alwaysShowCalendars: true,
				ranges: window.pstoolkit_datepicker_ranges,
				locale: window.pstoolkit_datepicker_locale
		}) }, 3000 );

	$( 'input.pstoolkit-filter-date' ).on( 'apply.daterangepicker', function( ev, picker ) {
		$( this ).val( picker.startDate.format( 'MM/DD/YYYY' ) + ' - ' + picker.endDate.format( 'MM/DD/YYYY' ) );
	});

    /**
     * Delete item
     */
    $('.pstoolkit-email-logs-delete').on( 'click', function() {
        if ( 'bulk' === $(this).data('id' ) ) {
            return false;
        }
        var data = {
            action: 'pstoolkit_email_logs_delete',
            _wpnonce: $(this).data('nonce'),
            id: $(this).data('id' )
        };
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                window.location.reload();
            } else {
                SUI.openFloatNotice( response.data.message );
            }
        });
    });

    /**
     * Bulk: confirm
     */
    $( '.pstoolkit-email-logs-delete[data-id=bulk]').on( 'click', function() {
        var data = {
            action: 'pstoolkit_email_logs_delete_bulk',
            _wpnonce: $(this).data('nonce'),
            ids: [],
        }
        $('input[type=checkbox]:checked', $('#pstoolkit-email-logs-table' ) ).each( function() {
            data.ids.push( $(this).val() );
        });
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                window.location.reload();
            } else {
                SUI.openFloatNotice( response.data.message );
            }
        });
        return false;
    });

	// Disable/Enable Apply button
	$( '#pstoolkit-email-logs-table .check-column input, .pstoolkit-box-actions select[name="pstoolkit_action"]' ).on( 'change', function() {
		var checkboxCount = $( '#pstoolkit-email-logs-table .check-column input:checked' ).length,
			applyButtons = $(  'button.pstoolkit-bulk-delete' );

		applyButtons.each( function() {
			var action = $( this ).closest( 'form' ).find( 'select[name="pstoolkit_action"] option:selected' ).val();

			if ( '-1' !== action && checkboxCount ) {
				$( this ).removeAttr( 'disabled' );
			} else {
				$( this ).prop( 'disabled', true );
			}
		});
	});

	// Change chevron down(up)
	$( '#pstoolkit-email-logs-table tr.sui-accordion-item' ).on( 'click', function() {
		var chevron = $(this).find( '.sui-accordion-open-indicator > span' );
		if (chevron.hasClass('sui-icon-chevron-down')) {
			chevron.removeClass('sui-icon-chevron-down').addClass('sui-icon-chevron-up');
		} else {
			chevron.addClass('sui-icon-chevron-down').removeClass('sui-icon-chevron-up');
		}
	});

})( jQuery );
