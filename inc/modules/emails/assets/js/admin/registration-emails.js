jQuery( document ).ready( function( $ ) {
    /**
     * reset section
     */
    $('.pstoolkit-registration-emails-reset').on( 'click', function() {
        var data = {
            action: 'pstoolkit_registration_emails_reset',
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
});
