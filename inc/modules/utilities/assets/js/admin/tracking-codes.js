;jQuery( document ).ready( function( $ ) {
    $('.wp-list-table.tracking-codes span.delete a').on( 'click', function() {
        return window.confirm( ub_tracking_codes.delete );
    });
    $('.tab-tracking-codes .button.action').on( 'click', function() {
        var value = $('select', $(this).parent()).val();
        if ( '-1' === value ) {
            return false;
        }
        if ( 'delete' === value ) {
            return window.confirm( ub_tracking_codes.bulk_delete );
        }
        return true;
    });
    /**
     * save code
     */
    $( 'button.pstoolkit-tracking-codes-save' ).on( 'click', function() {
        var dialog = $(this).closest( '.sui-modal' );
        var data = {
            action: 'pstoolkit_tracking_codes_save',
            _wpnonce: $(this).data('nonce'),
        };
        $('input, select, textarea', dialog ).each( function() {
            if ( undefined === $(this).prop( 'name' ) ) {
                return;
            }
            if ( 'radio' === $(this).prop( 'type' ) ) {
                if ( $(this).is(':checked' ) ) {
                    data[$(this).data('name')] = $(this).val();
                }
            } else {
                data[$(this).prop('name')] = $(this).val();
            }
        });
        var i= 0;
        var editor = $('.pstoolkit-general-code label', dialog ).prop( 'for' );
        data['pstoolkit[code]'] = SUI.editors[ editor ].getValue();
        $.post( ajaxurl, data, function( response ) {
            if ( response.success ) {
                window.location.reload();
            } else {
                SUI.openFloatNotice( response.data.message );
            }
        });
    });
    /**
     * reset
     */
    $( '.pstoolkit-tracking-codes-reset' ).on( 'click', function() {
        var id = $(this).data( 'id' );
        var dialog = $( '#pstoolkit-tracking-codes-' + id );
        var args = {
            action: 'pstoolkit_admin_panel_tips_reset',
            id: id,
            _wpnonce: $(this).data( 'nonce' )
        };
        $.post(
            ajaxurl,
            args,
            function ( response ) {
                if (
                    'undefined' !== typeof response.success &&
                    response.success &&
                    'undefined' !== typeof response.data
                ) {
                    var data = response.data;
                    if ( 'undefined' !== typeof data.active ) {
                        $('.pstoolkit-general-active input[value='+data.active+']', dialog ).click();
                    }
                    if ( 'undefined' !== typeof data.title ) {
                        $('[name="pstoolkit[title]"]', dialog ).val( data.title );
                    }
                    if ( 'undefined' !== typeof data.code ) {
                        var editor_id = 'pstoolkit-general-code-' + id;
                        var all = document.querySelectorAll('.ace_editor');
                        for (var i = 0; i < all.length; i++) {
                            if (
                                all[i].env &&
                                all[i].env.editor &&
                                all[i].env.textarea &&
                                all[i].env.textarea.id &&
                                editor_id === all[i].env.textarea.id
                            ) {
                                all[i].env.editor.setValue( data.code );
                            }
                        }
                    }
                    if ( 'undefined' !== typeof data.place ) {
                        $('.pstoolkit-location-place input[value='+data.place+']', dialog ).click();
                    }
                    if ( 'undefined' !== typeof data.filter ) {
                        $('.pstoolkit-location-filter input[value='+data.filter+']', dialog ).click();
                    }
                    if ( 'undefined' !== typeof data.users ) {
                        $('select[name="pstoolkit[users]"]', dialog ).SUIselect2( 'val', [ data.users ] );
                    }
                    if ( 'undefined' !== typeof data.authors ) {
                        $('select[name="pstoolkit[authors]"]', dialog ).SUIselect2( 'val', [ data.authors ] );
                    }
                    if ( 'undefined' !== typeof data.archives ) {
                        $('select[name="pstoolkit[archives]"]', dialog ).SUIselect2( 'val', [ data.archives ] );
                    }
                }
            }
        );
    });
    /**
     * delete item/bulk
     */
    $( '.pstoolkit-tracking-codes-delete' ).on( 'click', function() {
        var id = $(this).data('id');
        var action = 'pstoolkit_tracking_codes_delete';
        var ids = [];
        if ( 'bulk' === id ) {
            action = 'pstoolkit_tracking_codes_bulk_delete';
            $('tbody .check-column input:checked').each( function() {
                ids.push( $(this).val() );
            });
        }
        var data = {
            action: action,
            id: $(this).data('id' ),
            ids: ids,
            _wpnonce: $(this).data('nonce'),
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
     * User filter exclusions
     */
    function pstoolkit_tracking_codes_user_filter_exclusion( e ) {
        var select = e.target;
        var data = e.params.data;
        if ( data.selected ) {
            switch ( data.id ) {
                case 'logged':
                    $('option', select ).each( function() {
                        $(this).prop( 'disabled', false );
                    });
                    $('[value=anonymous]', select ).prop( 'disabled', true );

                    break;
                case 'anonymous':
                    $('option', select ).each( function() {
                        $(this).prop( 'disabled', true );
                    });
                    $('[value=anonymous]', select ).prop( 'disabled', false );
                    break;
            }
        } else {
            switch ( data.id ) {
                case 'logged':
                    $('[value=anonymous]', select ).prop( 'disabled', false );
                    break;
                case 'anonymous':
                    $('option', select ).each( function() {
                        $(this).prop( 'disabled', false );
                    });
                    break;
            }
        }
    }
    $('.pstoolkit-tracking-codes-filter-users').on( 'select2:select', function( e ) {
        pstoolkit_tracking_codes_user_filter_exclusion( e );
        $(e.target).SUIselect2({
            dropdownCssClass: 'sui-select-dropdown'
        });
    });
    $('.pstoolkit-tracking-codes-filter-users').on( 'select2:unselect', function( e ) {
        pstoolkit_tracking_codes_user_filter_exclusion( e );
        // Added timeout because select2 doesn't allow enough time for the select element to load causing an error.
        setTimeout(function() {
            $(e.target).SUIselect2({
                dropdownCssClass: 'sui-select-dropdown'
            });
        });
    });
});
