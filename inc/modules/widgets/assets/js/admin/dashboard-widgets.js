/**
 * PSToolkit: Dashboard Widgets
 * https://n3rds.work/
 *
 * Copyright (c) 2018-2021 WMS N@W
 * Licensed under the GPLv2 +  license.
 */
/* global window, SUI, ajaxurl */
var PSToolkit = PSToolkit || {};
/**
 * Dialogs
 */
PSToolkit.dashboard_widgets_dialog_edit = 'pstoolkit-dashboard-widgets-edit';
PSToolkit.dashboard_widgets_dialog_delete = 'pstoolkit-dashboard-widgets-delete';
/**
 * Delete item
 */
jQuery('.pstoolkit-dashboard-widgets-delete').on('click', function(e) {
    var data = {
        action: 'pstoolkit_dashboard_widget_delete',
        _wpnonce: jQuery(this).data('nonce'),
        id: jQuery(this).data('id')
    };
    e.preventDefault();
    jQuery.post(ajaxurl, data, function(response) {
        if (response.success) {
            var jQueryparent = jQuery('.pstoolkit-dashboard-widgets-items');
            jQuery('[data-id=' + response.data.id + ']', jQueryparent).detach();
            SUI.closeModal();
            SUI.openFloatNotice(response.data.message, 'success');
            if (1 > jQuery('[data-id]', jQueryparent).length) {
                jQuery('.sui-box-builder-message', jQueryparent.parent()).show();
            }
        } else {
            SUI.openFloatNotice(response.data.message);
        }
    });
});
/**
 * Dialog edit
 */
jQuery('.pstoolkit-settings-tab-content-dashboard-widgets .pstoolkit-section-text').on('click', '.pstoolkit-dashboard-widgets-item-edit', function(e) {
    var jQuerybutton = jQuery(this);
    var template;
    var jQuerydialog = jQuery('#' + PSToolkit.dashboard_widgets_dialog_edit);
    var jQueryparent = jQuerybutton.closest('.sui-builder-field');
    var data = {
        id: 'undefined' !== typeof jQueryparent.data('id') ? jQueryparent.data('id') : 'new',
        title: '',
        content: '',
        content_meta: '',
        nonce: jQuerybutton.data('nonce'),
        site: 'on',
        network: 'on'
    };
    var editor;
    e.preventDefault();
    /**
     * Dialog title
     */
    if ('new' === data.id) {
        jQuerydialog.addClass('pstoolkit-dialog-new');
    } else {
        var args = {
            action: 'pstoolkit_dashboard_widgets_get',
            _wpnonce: jQueryparent.data('nonce'),
            id: data.id
        };
        jQuerydialog.removeClass('pstoolkit-dialog-new');
        jQuery.ajax({
            url: ajaxurl,
            method: 'POST',
            data: args,
            async: false
        }).success(function(response) {
            if (!response.success) {
                SUI.openFloatNotice(response.data.message);
            }
            data = response.data;
        });
        if ('undefined' === typeof data.title) {
            return false;
        }
        data.nonce = jQueryparent.data('nonce');
    }
    /**
     * set
     */
    jQuery('input[name="pstoolkit[title]"]', jQuerydialog).val(data.title);
    jQuery('input[name="pstoolkit[content]"]', jQuerydialog).val(data.content);
    jQuery('input[name="pstoolkit[id]"]', jQuerydialog).val(data.id);
    jQuery('input[name="pstoolkit[nonce]"]', jQuerydialog).val(data.nonce);
    editor = jQuery('textarea', jQuerydialog);
    editor.val(data.content);
    editor = editor.prop('id');
    editor = tinymce.get(editor);
    if (null !== editor) {
        editor.setContent(data.content);
    }
    /**
     * visibility
     */
    template = wp.template(PSToolkit.dashboard_widgets_dialog_edit + '-pane-visibility');
    jQuery('.' + PSToolkit.dashboard_widgets_dialog_edit + '-pane-visibility', jQuerydialog).html(template(data));
    /**
     * Re-init elements
     */
    SUI.pstoolkitSideTabs();
    jQuery('.sui-tabs-flushed .pstoolkit-first-tab', jQuerydialog).trigger('click');
    // Open edit dialog
    SUI.openModal(
        PSToolkit.dashboard_widgets_dialog_edit,
        this,
        undefined,
        true
    );
});
/**
 * Dialog delete
 */
jQuery('.pstoolkit-settings-tab-content-dashboard-widgets .pstoolkit-section-text').on('click', '.pstoolkit-dashboard-widgets-item-delete', function(e) {
    var jQuerydialog = jQuery('#' + PSToolkit.dashboard_widgets_dialog_delete);
    var jQueryparent = jQuery(this).closest('.sui-builder-field');
    jQuery('.pstoolkit-dashboard-widgets-delete', jQuerydialog)
        .data('id', jQueryparent.data('id'))
        .data('nonce', jQueryparent.data('nonce'));
    SUI.openModal(
        PSToolkit.dashboard_widgets_dialog_delete,
        this,
        undefined,
        true
    );
});

/**
 * Add feed
 */
jQuery(window.document).ready(function($) {
    "use strict";
    /**
     * Sortable
     */
    $.fn.pstoolkit_dashboard_widgets_sortable_init = function() {
        $('.pstoolkit-dashboard-widgets-items').sortable({
            items: '.sui-builder-field'
        });
    }
    $.fn.pstoolkit_dashboard_widgets_sortable_init();
    /**
     * Save Dashboard Widget
     */
    $('.pstoolkit-dashboard-widgets-save').on('click', function() {
        var $parent = $(this).closest('.sui-modal');
        var editor_id = PSToolkit.dashboard_widgets_dialog_edit + '-content';
        var data = {
            action: 'pstoolkit_dashboard_widget_save',
            _wpnonce: $('input[name="pstoolkit[nonce]"]', $parent).val(),
            id: $('input[name="pstoolkit[id]"]', $parent).val(),
            content: $.fn.pstoolkit_editor(editor_id),
            title: $('input[name="pstoolkit[title]"]', $parent).val(),
            site: $('[name="pstoolkit[site]"]:checked', $parent).val(),
            network: $('[name="pstoolkit[network]"]:checked', $parent).val(),
        };
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                var $parent = $('.pstoolkit-dashboard-widgets-items');
                var $row = $('[data-id=' + response.data.id + ']', $parent);
                if (0 < $row.length) {
                    $('.sui-builder-field-label', $row).html(response.data.title);
                    $('.sui-builder-field', $row)
                        .data('id', response.data.id)
                        .data('nonce', response.data.nonce);
                } else {
                    var template = wp.template(PSToolkit.dashboard_widgets_dialog_edit + '-row');
                    $parent.append(template(response.data));
                }
                SUI.closeModal();
                SUI.openFloatNotice(response.data.message, 'success');
                $.fn.pstoolkit_dashboard_widgets_sortable_init;
            } else {
                SUI.openFloatNotice(response.data.message);
            }
        });
    });
    /**
     * Dialog "Reset Widget Visibility List"
     */
    $('#pstoolkit-dashboard-widgets-visibility-reset .pstoolkit-data-reset-confirm').on('click', function() {
        var data = {
            action: 'pstoolkit_dashboard_widget_visibility_reset',
            _wpnonce: $(this).data('nonce')
        };
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                window.location.reload();
            } else {
                SUI.openFloatNotice(response.data.message);
            }
        });
    });
});