/**
 * PSToolkit: Admin Help Content
 * https://n3rds.work/
 *
 * Copyright (c) 2018-2021 WMS N@W
 * Licensed under the GPLv2 +  license.
 */
/* global window, SUI, ajaxurl */
var PSToolkit = PSToolkit || {};
PSToolkit.admin_help_content_dialog_edit = 'pstoolkit-admin-help-content-edit';
PSToolkit.admin_help_content_dialog_delete = 'pstoolkit-admin-help-content-delete';
jQuery(document).ready(function($) {
    "use strict";
    /**
     * Sortable
     */
    $.fn.pstoolkit_admin_help_content_sortable_init = function() {
        $('.pstoolkit-admin-help-content-items').sortable({
            items: '.sui-builder-field'
        });
    }
    $.fn.pstoolkit_admin_help_content_sortable_init();
    /**
     * Scroll window to top when a help menu opens
     */
    $(document).on('screen:options:open', function() {
        $('html, body').animate({ scrollTop: 0 }, 'fast');
    });
    /**
     * SUI: add item
     */
    $('.pstoolkit-admin-help-content-save').on('click', function() {
        var button = $(this);
        var $dialog = button.closest('.sui-modal');
        var id = $('[name="pstoolkit[id]"]', $dialog).val();
        var editor_id = $('textarea.wp-editor-area', $dialog).prop('id');
        var content = $.fn.pstoolkit_editor(editor_id);
        var data = {
            action: 'pstoolkit_admin_help_save',
            _wpnonce: button.data('nonce'),
            id: id,
            title: $('input[type=text]', $dialog).val(),
            content: content,
        };
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                var $parent = $('.module-admin-help-content-php .pstoolkit-admin-help-content-items');
                var $row = $('[data-id=' + response.data.id + ']', $parent);
                if (0 < $row.length) {
                    $('.sui-builder-field-label', $row).html(response.data.title);
                    $('.sui-builder-field', $row)
                        .data('id', response.data.id)
                        .data('nonce', response.data.nonce);
                } else {
                    var template = wp.template(PSToolkit.admin_help_content_dialog_edit + '-row');
                    $parent.append(template(response.data));
                    $row = $('[data-id=' + response.data.id + ']', $parent);
                }
                SUI.closeModal();
                SUI.openFloatNotice(response.data.message, 'success');
                $.fn.pstoolkit_admin_help_content_sortable_init;
            } else {
                SUI.openFloatNotice(response.data.message);
            }
        });
    });
    /**
     * Dialog delete
     */
    $('.pstoolkit-settings-tab-content-admin-help-content .pstoolkit-section-items').on('click', '.pstoolkit-admin-help-content-item-delete', function() {
        var $dialog = $('#' + PSToolkit.admin_help_content_dialog_delete);
        var $parent = $(this).closest('.sui-builder-field');
        $('.pstoolkit-admin-help-content-delete', $dialog)
            .data('id', $parent.data('id'))
            .data('nonce', $parent.data('nonce'));
        SUI.openModal(
            PSToolkit.admin_help_content_dialog_delete,
            this,
            undefined,
            true
        );
    });
    /**
     * SUI: delete item
     */
    $('.pstoolkit-admin-help-content-delete').on('click', function() {
        var button = $(this);
        var data = {
            action: 'pstoolkit_admin_help_delete',
            _wpnonce: button.data('nonce'),
            id: button.data('id'),
        };
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                var $parent = $('.module-admin-help-content-php .pstoolkit-admin-help-content-items');
                $('[data-id=' + data.id + ']', $parent).detach();
                SUI.closeModal();
                SUI.openFloatNotice(response.data.message, 'success');
            } else {
                SUI.openFloatNotice(response.data.message);
            }
        });
    });
    /**
     * Dialog edit
     */
    jQuery('.pstoolkit-settings-tab-content-admin-help-content .pstoolkit-section-items').on('click', '.pstoolkit-admin-help-content-item-edit', function(e) {
        var $button = $(this);
        var template;
        var $dialog = $('#' + PSToolkit.admin_help_content_dialog_edit);
        var $parent = $button.closest('.sui-builder-field');
        var data = {
            id: 'undefined' !== typeof $parent.data('id') ? $parent.data('id') : 'new',
            title: '',
            content: '',
            nonce: $button.data('nonce')
        };
        var editor = $('textarea[name="pstoolkit[content]"]', $dialog).prop('id');
        editor = tinymce.get(editor);
        e.preventDefault();
        /**
         * Dialog title
         */
        if ('new' === data.id) {
            $dialog.addClass('pstoolkit-dialog-new');
        } else {
            var args = {
                action: 'pstoolkit_admin_help_content_get',
                _wpnonce: $parent.data('nonce'),
                id: data.id
            };
            $dialog.removeClass('pstoolkit-dialog-new');
            $.ajax({
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
            data.nonce = $parent.data('nonce');
        }
        /**
         * set
         */
        $('input[name="pstoolkit[title]"]', $dialog).val(data.title);
        $('textarea[name="pstoolkit[content]"]', $dialog).val(data.content);
        if (null !== editor) {
            editor.setContent(data.content);
        }
        $('.pstoolkit-admin-help-content-save', $dialog).data('nonce', data.nonce);
        $('input[name="pstoolkit[id]"]', $dialog).val(data.id);
        // Open edit dialog
        SUI.openModal(
            PSToolkit.admin_help_content_dialog_edit,
            this,
            undefined,
            true
        );
    });
});