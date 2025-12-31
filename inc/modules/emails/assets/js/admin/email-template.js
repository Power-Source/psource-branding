/**
 * JS for HTML Email templates Plugin
 */
/**
 * Load the SLider
 * @param {type} param
 */
jQuery( document ).ready( function($) {

    /**
     * Show Template on first time
     */
    function pstoolkit_email_template_auto_show() {
        var pstoolkit_email_template_big_button = $( '.pstoolkit-settings-tab-content-email-template .pstoolkit-section-theme button.pstoolkit-big-button' );
        var dialog_id = pstoolkit_email_template_big_button.data('modal-open');
        var current_tab = $('.sui-wrap .sui-sidenav .sui-vertical-tabs .sui-vertical-tab.current a').data('tab')
        if ( 'email-template' !== current_tab ) {
            return;
        }
        if ( 'yes' === pstoolkit_email_template_big_button.data('has-configuration' ) ) {
            return;
        }
        if (
            'undefined' === typeof SUI ||
            'undefined' === typeof $( '#' + dialog_id )
        ) {
            window.setTimeout( pstoolkit_email_template_auto_show, 100 );
        } else {
            SUI.openModal( dialog_id, this, null, true );
        }
    }
    pstoolkit_email_template_auto_show();
    $('.sui-wrap .sui-sidenav .sui-vertical-tabs .sui-vertical-tab a[data-tab=email-template]').on( 'click', function() {
        pstoolkit_email_template_auto_show();
    });

    /**
     * Set template content to editor.
     *
     * @param editor
     * @param id
     * @param image
     * @param button
     */
    function pstoolkit_email_template_set_button( $button, editor, id, image, button ) {
        var css = '';
        /**
         * find Email content editor ID
         */
        var editor_id = $('.ub_html_editor', $button.closest( 'form' ) ).prop( 'id' );
        // Email content editor.
        var $editor = SUI.editors[ editor_id ];
        var html = '<span class="sui-loading-text"><i class="sui-icon-';
        html += 'choose' === button ? 'plus':'pencil';
        html += '"></i>';
        html += $('.module-emails-template-php button.pstoolkit-big-button').data( button );
        html += '</span>';
        if ( '' !== image ) {
            css = 'url(' + image + ')';
        }
        $editor.setValue( editor );
        $('.module-emails-template-php #simple_options_theme_id').val( id );
        if ( 'edit' === button ) {
            $('.module-emails-template-php .pstoolkit-big-button')
                .addClass( 'pstoolkit-has-theme' )
            ;
        } else {
            $('.module-emails-template-php .pstoolkit-big-button')
                .removeClass( 'pstoolkit-has-theme' )
            ;
        }
        $('.module-emails-template-php button.pstoolkit-big-button')
            .css( 'background-image', css )
            .html( html )
        ;
        SUI.closeModal();
    }

    /**
     * Handle template choose
     */
    $( '.pstoolkit-email-template-choose-template' ).on( 'click', function() {
        var $button = $(this);
        var id = $( 'input[name=pstoolkit-email-template-template]:checked' ).val();
        if ( id ) {
            if ( 'scratch' === id ) {
                pstoolkit_email_template_set_button( $button, '', '', '', 'choose' );
                return;
            }
            var data = {
                action: 'pstoolkit_email_template_set_template',
                _wpnonce: $(this).data('nonce'),
                id: id
            };
            $.post( ajaxurl, data, function( response ) {
                if ( response.success ) {
                    pstoolkit_email_template_set_button(
                        $button,
                        response.data.content,
                        response.data.id,
                        response.data.screenshot,
                        'edit'
                    );
                } else {
                    SUI.openFloatNotice( response.data.message );
                }
            });
        }
    });

    /**
     * preview
     */
    $('.pstoolkit-email-template-preview').on( 'click', function(e) {
        e.stopImmediatePropagation();
        var button = $(this);
        var editor_id = $('.ub_html_editor', button.closest('.sui-box-body') ).prop('id');
        var body = $('#pstoolkit-email-template-preview .sui-box-body' );
        body.html( button.data('message') );
                var param = {
                    action: 'pstoolkit_email_template_preview_email',
                    _wpnonce: button.data('nonce'),
                    content: SUI.editors[ editor_id ].getValue(),
                    theme_id: $('#simple_options_theme_id').val()
                };
                jQuery.post(ajaxurl, param, function (res) {
                    body.html( res.data );
                });
    });

    /**
     * Radio selector change.
     */
    $( 'input[name=pstoolkit-email-template-template]' ).on( 'change', function() {
        $( '.pstoolkit-choose-template-dialog li').removeClass( 'pstoolkit-selected' );
        if( $(this).is(':checked') ) {
            $(this).closest('li').addClass( 'pstoolkit-selected' );
        }
    });

});
