/**
 * PSToolkit: Text Replacement
 * https://n3rds.work/
 *
 * Copyright (c) 2018 WMS N@W
 * Licensed under the GPLv2 +  license.
 */
/* global window, SUI, ajaxurl */
jQuery(window.document).ready(function($) {
    "use strict";
    /**
     * Open add/edit modal
     */
    $('.pstoolkit-text-replacement-new, .pstoolkit-text-replacement-edit').on('click', function() {
        var parent = $('.sui-box-body', $(this).closest('.sui-box'));
        var id = $(this).data('id');
        var required = false;
        $('[data-required=required]', parent).each(function() {
            if ('' === $(this).val()) {
                var local_parent = $(this).parent();
                local_parent.addClass('sui-form-field-error');
                $('span', local_parent).addClass('sui-error-message');
                required = true;
            }
        });
        if (required) {
            return;
        }
        var data = {
            action: 'pstoolkit_text_replacement_save',
            _wpnonce: $(this).data('nonce'),
            id: id,
            find: $('#pstoolkit-text-replacement-find-' + id, parent).val(),
            replace: $('#pstoolkit-text-replacement-replace-' + id, parent).val(),
            domain: $('#pstoolkit-text-replacement-domain-' + id, parent).val(),
            scope: $('.pstoolkit-text-replacement-scope input[type=radio]:checked', parent).val(),
            ignorecase: $('.pstoolkit-text-replacement-ignorecase input[type=radio]:checked', parent).val(),
            exclude_url: $('.pstoolkit-text-replacement-exclude_url input[type=radio]:checked', parent).val(),
        };
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                window.location.reload();
            } else {
                $.each(response.data.fields, function(name, message) {
                    var field = $(name, parent).closest('.sui-form-field');
                    field.addClass('sui-form-field-error');
                    $('span.hidden', field).addClass('sui-error-message').html(message);
                });
            }
        });
    });
    /**
     * Delete item
     */
    $('.pstoolkit-text-replacement-delete').on('click', function() {
        if ('bulk' === $(this).data('id')) {
            return false;
        }
        var data = {
            action: 'pstoolkit_text_replacement_delete',
            _wpnonce: $(this).data('nonce'),
            id: $(this).data('id')
        };
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                window.location.reload();
            } else {
                SUI.openFloatNotice(response.data.message);
            }
        });
    });
    /**
     * Bulk: confirm
     */
    $('.pstoolkit-text-replacement-delete[data-id=bulk]').on('click', function() {
        var data = {
            action: 'pstoolkit_text_replacement_delete_bulk',
            _wpnonce: $(this).data('nonce'),
            ids: [],
        }
        $('input[type=checkbox]:checked', $('#pstoolkit-text-replacement-items-table')).each(function() {
            data.ids.push($(this).val());
        });
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                window.location.reload();
            } else {
                SUI.openFloatNotice(response.data.message);
            }
        });
        return false;
    });
});