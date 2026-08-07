/**
 * JS for HTML Email templates Plugin
 */
/**
 * Load the SLider
 * @param {type} param
 */
jQuery( document ).ready( function($) {

    function pstoolkit_get_email_template_root( $context ) {
        var $root = $();

        if ( $context && $context.length ) {
            $root = $context.closest( '.pstoolkit-settings-tab-content-email-template' );
        }

        if ( ! $root.length ) {
            $root = $( '.pstoolkit-settings-tab-content-email-template:visible' ).first();
        }

        if ( ! $root.length ) {
            $root = $( '.pstoolkit-settings-tab-content-email-template' ).first();
        }

        return $root;
    }

    function pstoolkit_resolve_editor_id( $context ) {
        var $root = pstoolkit_get_email_template_root( $context );
        var $sourceField;
        var editor_id = '';

        if ( $root.length ) {
            $sourceField = $root.find( 'textarea[name="simple_options[content][email]"]' ).first();
            if ( $sourceField.length ) {
                editor_id = $sourceField.prop( 'id' ) ? $sourceField.prop( 'id' ) + '-editor' : '';
            }
        }

        if ( $root.length ) {
            if ( ! editor_id || ! $( '#' + editor_id ).length ) {
                editor_id = $root.find( '.sui-ace-editor.ub_html_editor' ).first().prop( 'id' ) || '';
            }
        }

        if ( ! editor_id ) {
            editor_id = $( '.sui-ace-editor.ub_html_editor' ).first().prop( 'id' ) || '';
        }

        if ( ! editor_id ) {
            editor_id = $( '.ub_html_editor' ).first().prop( 'id' ) || '';
        }

        return editor_id;
    }

    function pstoolkit_get_editor_value( editor_id ) {
        var editor;
        var source_field_id;

        editor = pstoolkit_ensure_ace_editor( editor_id );

        if ( ! editor_id ) {
            return '';
        }
        if ( editor ) {
            if ( 'function' === typeof editor.getValue ) {
                return editor.getValue();
            }
            if ( editor.getSession && 'function' === typeof editor.getSession ) {
                return editor.getSession().getValue();
            }
        }
        source_field_id = $( '#' + editor_id ).data( 'id' ) || '';
        if ( ! source_field_id && /-editor$/.test( editor_id ) ) {
            source_field_id = editor_id.replace( /-editor$/, '' );
        }
        if ( source_field_id ) {
            return $( '#' + source_field_id ).val() || '';
        }
        return $( '#' + editor_id ).val() || '';
    }

    function pstoolkit_set_editor_value( editor_id, value ) {
        var editor;
        var has_ace_editor = false;

        editor = pstoolkit_ensure_ace_editor( editor_id );

        if ( ! editor_id ) {
            return;
        }

        var $editorNode = $( '#' + editor_id );
        var source_field_id = $editorNode.data( 'id' ) || '';

        if ( ! source_field_id && /-editor$/.test( editor_id ) ) {
            source_field_id = editor_id.replace( /-editor$/, '' );
        }

        if ( editor ) {
            if ( 'function' === typeof editor.setValue ) {
                editor.setValue( value, -1 );
                has_ace_editor = true;
            } else if ( editor.getSession && 'function' === typeof editor.getSession ) {
                editor.getSession().setValue( value );
                has_ace_editor = true;
            }

            if ( has_ace_editor && 'function' === typeof editor.clearSelection ) {
                editor.clearSelection();
            }
            if ( has_ace_editor && 'function' === typeof editor.resize ) {
                editor.resize( true );
            }
        }

        if ( source_field_id ) {
            $( '#' + source_field_id ).val( value ).trigger( 'change' );
        }

        if ( ! has_ace_editor ) {
            // Fallback only: if ACE is not available, keep plain content in the node.
            $editorNode.text( value ).trigger( 'change' );
        }
    }

    function pstoolkit_ensure_ace_editor( editor_id ) {
        var editor;
        var $editorNode;
        var source_field_id;
        var initial_value;

        if ( ! editor_id ) {
            return null;
        }

        if ( window.SUI && SUI.editors && SUI.editors[ editor_id ] ) {
            return SUI.editors[ editor_id ];
        }

        if ( 'undefined' === typeof window.ace || 'function' !== typeof window.ace.edit ) {
            return null;
        }

        $editorNode = $( '#' + editor_id );
        if ( ! $editorNode.length ) {
            return null;
        }

        source_field_id = $editorNode.data( 'id' ) || '';
        if ( ! source_field_id && /-editor$/.test( editor_id ) ) {
            source_field_id = editor_id.replace( /-editor$/, '' );
        }

        if ( ! window.SUI ) {
            window.SUI = {};
        }
        if ( ! SUI.editors ) {
            SUI.editors = {};
        }

        try {
            editor = ace.edit( editor_id );
            editor.getSession().setUseWorker( false );
            editor.setShowPrintMargin( false );
            try {
                editor.setTheme( 'ace/theme/sui' );
            } catch ( themeError ) {
                // Keep default theme if custom theme is unavailable.
            }
            editor.getSession().setMode( $editorNode.hasClass( 'ub_html_editor' ) ? 'ace/mode/html' : 'ace/mode/css' );
            editor.session.setTabSize( 4 );

            if ( source_field_id ) {
                initial_value = $( '#' + source_field_id ).val() || '';
                if ( '' !== initial_value ) {
                    editor.getSession().setValue( initial_value );
                    editor.clearSelection();
                }
                editor.getSession().on( 'change', function() {
                    $( '#' + source_field_id ).val( editor.getSession().getValue() ).trigger( 'change' );
                } );
            }

            editor.resize( true );
            SUI.editors[ editor_id ] = editor;
            return editor;
        } catch ( e ) {
            return null;
        }
    }

    function pstoolkit_notice( message ) {
        if ( window.SUI && typeof SUI.openFloatNotice === 'function' ) {
            SUI.openFloatNotice( message );
            return;
        }
        window.alert( message );
    }

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
        var $root = pstoolkit_get_email_template_root( $button );
        var css = '';
        var editor_id = pstoolkit_resolve_editor_id( $button );
        var html = '<span class="sui-loading-text"><i class="sui-icon-';
        html += 'choose' === button ? 'plus':'pencil';
        html += '"></i>';
        html += $root.find( 'button.pstoolkit-big-button' ).data( button );
        html += '</span>';
        if ( '' !== image ) {
            css = 'url(' + image + ')';
        }
        pstoolkit_set_editor_value( editor_id, editor );
        $root.find( '#simple_options_theme_id' ).val( id );
        if ( 'edit' === button ) {
            $root.find( '.pstoolkit-big-button' )
                .addClass( 'pstoolkit-has-theme' )
            ;
        } else {
            $root.find( '.pstoolkit-big-button' )
                .removeClass( 'pstoolkit-has-theme' )
            ;
        }
        $root.find( 'button.pstoolkit-big-button' )
            .css( 'background-image', css )
            .html( html )
        ;
        if ( window.SUI && typeof SUI.closeModal === 'function' ) {
            SUI.closeModal();
        }
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
                    pstoolkit_notice( response.data.message );
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
        var $root = pstoolkit_get_email_template_root( button );
        var editor_id = pstoolkit_resolve_editor_id( button );
        var body = $('#pstoolkit-email-template-preview .sui-box-body' );
        body.html( button.data('message') );
                var param = {
                    action: 'pstoolkit_email_template_preview_email',
                    _wpnonce: button.data('nonce'),
                    content: pstoolkit_get_editor_value( editor_id ),
                    theme_id: $root.find( '#simple_options_theme_id' ).val()
                };
                jQuery.post(ajaxurl, param, function (res) {
                    if ( res && res.success ) {
                        body.html( res.data );
                        return;
                    }
                    pstoolkit_notice( ( res && res.data && res.data.message ) ? res.data.message : 'Preview konnte nicht geladen werden.' );
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
