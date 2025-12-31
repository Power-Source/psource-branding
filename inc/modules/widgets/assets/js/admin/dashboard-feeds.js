/**
 * PSToolkit: Dashboard Feeds
 * https://n3rds.work/
 *
 * Copyright (c) 2018-2021 WMS N@W
 * Licensed under the GPLv2 +  license.
 */
/* global window, SUI, ajaxurl */

/**
 * Add feed
 */
jQuery(window.document).ready(function($) {
    "use strict";

    /**
     * Open add/edit modal
     */
    $('.pstoolkit-dashboard-feeds-add, .pstoolkit-dashboard-feeds-save').on('click', function() {
        var parent = $('.sui-box-body', $(this).closest('.sui-box'));
        var error = false;
        var id = $(this).data('id');
        $('[data-required=required]', parent).each(function() {
            var local_parent = $(this).parent();
            local_parent.removeClass('sui-form-field-error');
            $('span', local_parent).removeClass('sui-error-message');
            if ('' === $(this).val()) {
                local_parent.addClass('sui-form-field-error');
                $('span', local_parent).addClass('sui-error-message');
                error = true;
            }
        });
        $('input[type=number]', parent).each(function() {
            var min = $(this).prop('min');
            var local_parent = $(this).parent();
            if ('undefined' !== typeof min) {
                var val = parseInt($(this).val());
                $('.sui-error-message', local_parent).remove();
                local_parent.removeClass('sui-form-field-error');
                min = parseInt(min);
                if (val < min) {
                    local_parent.addClass('sui-form-field-error');
                    local_parent.append('<span class="sui-error-message">' + ub_admin.messages.form.number.min + '</span>');
                    error = true;
                }
            }
        });

        if (error) {
            return;
        }
        var data = {
            action: 'pstoolkit_dashboard_feed_save',
            _wpnonce: $(this).data('nonce'),
            id: id,
            link: $('#pstoolkit-general-link-' + id, parent).val(),
            url: $('#pstoolkit-general-url-' + id, parent).val(),
            title: $('#pstoolkit-general-title-' + id, parent).val(),
            items: $('#pstoolkit-display-items-' + id, parent).val(),
            show_summary: $('.pstoolkit-display-show_summary input[type=radio]:checked', parent).val(),
            show_date: $('.pstoolkit-display-show_date input[type=radio]:checked', parent).val(),
            show_author: $('.pstoolkit-display-show_author input[type=radio]:checked', parent).val(),
            site: $('.pstoolkit-visibility-site input[type=radio]:checked', parent).val(),
            network: $('.pstoolkit-visibility-network input[type=radio]:checked', parent).val(),
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
     * Delete feed
     */
    $('.pstoolkit-dashboard-feeds-delete').on('click', function() {
        if ('bulk' === $(this).data('id')) {
            return;
        }
        var data = {
            action: 'pstoolkit_dashboard_feed_delete',
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
    $('.pstoolkit-dashboard-feeds-delete[data-id=bulk]').on('click', function() {
        var data = {
            action: 'pstoolkit_dashboard_feed_delete_bulk',
            _wpnonce: $(this).data('nonce'),
            ids: [],
        }
        $('#pstoolkit-dashboard-feeds-panel .check-column :checked').each(function() {
            data.ids.push($(this).val());
        });
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                window.location.reload();
            } else {
                SUI.openFloatNotice(response.data.message);
            }
        });
    });
    /**
     * Try to fetch site name and feed
     */
    $('.pstoolkit-dashboard-feeds-url button').on('click', function() {
        var $parent = $(this).closest('.sui-tabs');
        var $input = $('input', $parent);
        var $target = $('.' + $input.data('target'), $parent);
        var field;
        var data = {
            action: 'pstoolkit_get_site_data',
            _wpnonce: $input.data('nonce'),
            id: $input.data('id'),
            url: $input.val(),
        }
        SUI.openInlineNotice('pstoolkit-feeds-info', ub_admin.messages.feeds.fetch, 'loading');
        $('.pstoolkit-list', $target).html('').hide();
        $.post(ajaxurl, data, function(response) {
            if (
                response.success &&
                'undefined' !== response.data
            ) {
                if (0 === response.data.length) {
                    SUI.openInlineNotice('pstoolkit-feeds-info', ub_admin.messages.feeds.no, 'warning');
                    return;
                }
                if (1 === response.data.length) {
                    /**
                     * Title
                     */
                    field = $('.pstoolkit-general-title input', $parent);
                    if (
                        '' === field.val() &&
                        'undefined' !== response.data[0].title
                    ) {
                        field.val(response.data[0].title);
                    }
                    /**
                     * href
                     */
                    field = $('.pstoolkit-general-url input', $parent);
                    if (
                        '' === field.val() &&
                        'undefined' !== response.data[0].href
                    ) {
                        field.val(response.data[0].href);
                    }
                } else {
                    var row = wp.template($input.data('tmpl') + '-row');
                    var list = '';
                    $.each(response.data, function(index, value) {
                        list += row(value);
                    });
                    $('.pstoolkit-list', $target).html(list).show();
                    $('label', $target).on('click', function() {
                        /**
                         * Title
                         */
                        field = $('.pstoolkit-general-title input', $parent);
                        field.val($('.pstoolkit-title', $(this)).html());
                        /**
                         * href
                         */
                        field = $('.pstoolkit-general-url input', $parent);
                        field.val($('.pstoolkit-href', $(this)).html());
                    });
                }
                SUI.closeNotice('pstoolkit-feeds-info');
            } else {
                SUI.openInlineNotice('pstoolkit-feeds-info', ub_admin.messages.feeds.no, 'warning');
            }
        });
    });
});