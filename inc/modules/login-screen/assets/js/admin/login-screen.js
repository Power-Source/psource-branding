jQuery( document ).ready( function( $ ) {
    /**
     * Show Template on first time
     */
    function pstoolkit_login_template_auto_show() {
        var pstoolkit_login_template_big_button = $( '.pstoolkit-settings-tab-content-login-screen .pstoolkit-section-theme button.pstoolkit-big-button' );
        var dialog_id = pstoolkit_login_template_big_button.data('modal-open');
        var current_tab = $('.sui-wrap .sui-sidenav .sui-vertical-tabs .sui-vertical-tab.current a').data('tab')
        if ( 'login-screen' !== current_tab ) {
            return;
        }
        if ( 'yes' === pstoolkit_login_template_big_button.data('has-configuration' ) ) {
            return;
        }
        if (
            'undefined' === typeof SUI ||
            'undefined' === typeof $( '#' + dialog_id )
        ) {
            window.setTimeout( pstoolkit_login_template_auto_show, 100 );
        } else {
            SUI.openModal( dialog_id, this, null, true );
        }
    }
    pstoolkit_login_template_auto_show();
    $('.sui-wrap .sui-sidenav .sui-vertical-tabs .sui-vertical-tab a[data-tab=login-screen]').on( 'click', function() {
        pstoolkit_login_template_auto_show();
    });
    /**
     * Radio selector change.
     */
    $( 'input[name=pstoolkit-login-screen-template]' ).on( 'change', function() {
        $( '.pstoolkit-login-screen-choose-template-dialog li').removeClass( 'pstoolkit-selected' );
        if( $(this).is(':checked') ) {
            $(this).closest('li').addClass( 'pstoolkit-selected' );
        }
    });
    /**
     * Show/hide Form Shadow options
     */
    $( '.ub-radio.pstoolkit-login-screen-form-style' ).on( 'change', function() {
        if (
            $(this).is( ':checked' )
            && 'shadow' === $(this).val()
        ) {
            $( '.sui-row.pstoolkit-login-screen-form-style' ).show();
            return;
        }
        $( '.sui-row.pstoolkit-login-screen-form-style' ).hide();
    });
    /**
     * Set selected template
     */
    $('.pstoolkit-login-screen-choose-template').on( 'click', function() {
        var id = $( 'input[name=pstoolkit-login-screen-template]:checked' ).val();
        if ( id ) {
            var data = {
                action: 'pstoolkit_login_screen_set_template',
                _wpnonce: $(this).data('nonce'),
                id: id
            };
            $.post( ajaxurl, data, function( response ) {
                if ( response.success ) {
                    window.location.reload();
                } else {
                    SUI.openFloatNotice( response.data.message );
                }
            });
        }
    });
});
