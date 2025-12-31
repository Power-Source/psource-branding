/**
 * PSToolkit: Admin Bar
 * https://n3rds.work/
 *
 * Copyright (c) 2018-2021 WMS N@W
 * Licensed under the GPLv2 +  license.
 */
/* global window, SUI, ajaxurl */
/**
 * Globals
 */
var PSToolkit = PSToolkit || {};
PSToolkit.admin_bar_dialog_edit = 'pstoolkit-admin-bar-edit';
PSToolkit.admin_bar_dialog_delete = 'pstoolkit-admin-bar-delete';
var $pstoolkit_admin_bar_entries_parent;
jQuery(document).ready(function($) {
    $pstoolkit_admin_bar_entries_parent = $('.pstoolkit-settings-tab-content-admin-bar .pstoolkit-admin-bar-items-custom-entries');
});
/**
 * Bind row buttons
 */
jQuery('.pstoolkit-admin-bar-items-custom-entries').on('click', '.pstoolkit-admin-bar-item-edit', function(e) {
    var jQuerybutton = jQuery(this);
    var jQuerydialog = jQuery('#' + PSToolkit.admin_bar_dialog_edit);
    var jQueryparent = jQuerybutton.closest('.sui-builder-field');
    var data = {
        id: 'undefined' !== typeof jQueryparent.data('id') ? jQueryparent.data('id') : 'new'
    };
    var template, nonce;
    e.preventDefault();
    /**
     * Dialog class
     */
    if ('new' === data.id) {
        jQuerydialog.addClass('pstoolkit-dialog-new');
        nonce = jQuerybutton.data('nonce');
    } else {
        jQuerydialog.removeClass('pstoolkit-dialog-new');
        nonce = jQueryparent.data('nonce');
    }
    /**
     * fetch data
     */
    var args = {
        action: 'pstoolkit_admin_bar_get',
        _wpnonce: nonce,
        id: data.id
    };
    jQuery('.sui-box-title span.edit', jQuerydialog).show();
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
    /**
     * set ID
     */
    jQuery('input[name="pstoolkit[id]"]', jQuerydialog).val(data.id);
    jQuery('input[name="pstoolkit[nonce]"]', jQuerydialog).val(jQueryparent.data('nonce'));
    /**
     * General
     */
    template = wp.template(PSToolkit.admin_bar_dialog_edit + '-pane-general');
    jQuery('.' + PSToolkit.admin_bar_dialog_edit + '-pane-general', jQuerydialog).html(template(data));
    /**
     * submenu
     */
    template = wp.template(PSToolkit.admin_bar_dialog_edit + '-pane-submenu');
    jQuery('.' + PSToolkit.admin_bar_dialog_edit + '-pane-submenu', jQuerydialog).html(template(data));
    /**
     * visibility
     */
    template = wp.template(PSToolkit.admin_bar_dialog_edit + '-pane-visibility');
    jQuery('.' + PSToolkit.admin_bar_dialog_edit + '-pane-visibility', jQuerydialog).html(template(data));
    /**
     * Re-init elements
     */
    pstoolkit_admin_bar_redirect_bind();
    pstoolkit_admin_bar_dashicons_bind(data.icon);
    pstoolkit_admin_bar_submenu_bind();
    if ('undefined' !== typeof data.submenu) {
        jQuery.each(data.submenu, function(id, args) {
            pstoolkit_admin_bar_submenu_add(args);
        });
    }
    SUI.suiTabs();
    SUI.pstoolkitSideTabs();
    jQuery('.sui-accordion', jQuerydialog).each(function() {
        SUI.suiAccordion(this);
    });
    jQuery('.sui-tabs-flushed .pstoolkit-first-tab', jQuerydialog).trigger('click');
    // Open edit dialog
    SUI.openModal(
        PSToolkit.admin_bar_dialog_edit,
        this,
        undefined,
        true
    );
});
/**
 * Search icons
 */
function pstoolkit_admin_bar_dashicons_bind(icon) {
    var $dialog = jQuery('#' + PSToolkit.admin_bar_dialog_edit),
        select = new PSToolkit.Dashicon_Select(
            jQuery('.pstoolkit-admin-bar-edit-pane-general .pstoolkit-general-icon'),
            icon
        );

    jQuery(select).on('dashicon-selected', function() {
        jQuery('.pstoolkit-visibility-mobile', $dialog).show();
    });

    jQuery(select).on('dashicon-cleared', function() {
        jQuery('.pstoolkit-visibility-mobile', $dialog).hide();
    });
}

jQuery(document).ready(function($) {
    var PSToolkit_Ordering = {
        children: function(hide) {
            hide = typeof hide === "undefined" ? true : false;
            if (hide) {
                $("#wpadminbar ul#wp-admin-bar-root-default > li").css({
                    cursor: "move"
                }).find(".ab-sub-wrapper").css({
                    visibility: "hidden"
                });
            } else {
                $("#wpadminbar ul#wp-admin-bar-root-default > li").css({
                    cursor: "default"
                }).find(".ab-sub-wrapper").css({
                    visibility: "visible"
                });
            }

        },
        sortable: function(make) {
            make = typeof make === "undefined" ? true : false;
            if (make) {
                $("#wpadminbar ul#wp-admin-bar-root-default .ab-item").addClass("click_disabled");
                $("#wpadminbar ul#wp-admin-bar-root-default").sortable({
                    axis: "x",
                    forceHelperSize: true,
                    forcePlaceholderSize: true,
                    distance: 2,
                    handle: ".ab-item",
                    tolerance: "intersect",
                    cursor: "move"
                }).sortable("enable");
            } else {
                $("#wpadminbar ul#wp-admin-bar-root-default .ab-item").removeClass("click_disabled");
                $("#wpadminbar ul#wp-admin-bar-root-default").sortable("disable");
            }
        },
        wiggle: function(wiggle) {
            wiggle = typeof wiggle === "undefined" ? true : false;
            var $el = $("#wpadminbar ul#wp-admin-bar-root-default > li");
            if (wiggle) {
                $(document).scrollTop(0);
                $el.ClassyWiggle("start", {
                    degrees: ['2', '4', '2', '0', '-2', '-4', '-2', '0'],
                    delay: 90
                });
            } else {
                $el.ClassyWiggle("stop");
            }
        },
        add_save_button: function() {
            $("#ub_admin_bar_save_ordering").remove();
            $("#wp-admin-bar-root-default").after('<div class="sui-wrap"><button id="ub_admin_bar_save_ordering" class="sui-button sui-button-blue" type="button"><span class="sui-loading-text"><i class="sui-icon-save"></i>' + ub_admin.buttons.save_changes + '</span></button></div>');
        },
        start: function() {
            this.children();
            this.sortable();
            this.wiggle();
            this.add_save_button();
        },
        stop: function() {
            this.children(false);
            this.sortable(false);
            this.wiggle(false);
            $("#ub_admin_bar_save_ordering").slideUp(100, function() {
                $(this).remove();
            });
        },
        save: function() {
            var self = this,
                $button = $("#ub_admin_bar_save_ordering");
            $button.prop("disabled", true).addClass("ub_loading");
            order = [];
            $("#wpadminbar #wp-admin-bar-root-default > li").each(function() {
                if (typeof this.id === "string" && this.is !== "") {
                    order.push(this.id.replace("wp-admin-bar-", ""));
                }
            });
            $.ajax({
                url: ajaxurl,
                type: 'post',
                data: {
                    action: 'pstoolkit_admin_bar_order_save',
                    _wpnonce: $('#pstoolkit-admin-bar-reorder-nonce').val(),
                    order: order
                },
                success: function(response) {
                    if ("undefined" !== typeof response.data.message) {
                        if (response.success) {
                            SUI.openFloatNotice(response.data.message, 'info');
                        } else {
                            SUI.openFloatNotice(response.data.message);
                        }
                    }
                },
                complete: function() {
                    $button.prop("disabled", false).removeClass("ub_loading").remove();
                    self.stop();
                }
            });
        }
    };
    $("#ub_admin_bar_start_ordering").on("click", function(e) {
        e.preventDefault();
        PSToolkit_Ordering.start();
    });
    $(document).on("click", "#ub_admin_bar_save_ordering", function(e) {
        e.preventDefault();
        PSToolkit_Ordering.save();
    });
});
/**
 * Add item
 */
jQuery(window.document).ready(function($) {
    "use strict";
    /**
     * Open add/edit modal
     */
    $('.pstoolkit-admin-bar-save').on('click', function() {
        var parent = $('.sui-box-body', $(this).closest('.sui-box'));
        var $dialog = $(this).closest('.sui-modal');
        var reqired = false;
        var id = $(this).data('id');
        $('[data-required=required]', parent).each(function() {
            if ('' === $(this).val()) {
                var local_parent = $(this).parent();
                var accordion_parent;
                local_parent.addClass('sui-form-field-error');
                $('span.hidden', local_parent).addClass('sui-error-message');
                /**
                 * Go only to first field
                 */
                if (!reqired) {
                    /**
                     * Go to proper tab
                     */
                    $('div[data-tabs] div[data-tab=' + $(this).closest('[data-tab]').data('tab') + ']', $dialog).trigger('click');
                    /**
                     * Check & go to proper accordion item
                     */
                    accordion_parent = $(this).closest('.sui-accordion-item');
                    if (0 < accordion_parent.length) {
                        if (!accordion_parent.hasClass('sui-accordion-item--open')) {
                            $('.sui-accordion-open-indicator', accordion_parent).trigger('click');
                        }
                    }
                }
                reqired = true;
            }
        });
        if (reqired) {
            return;
        }
        var data = {
            action: 'pstoolkit_admin_bar_menu_save',
            _wpnonce: $(this).data('nonce'),
            id: id,
        };
        $('input, textarea', parent).each(function() {
            var n = $(this).prop('name');
            switch ($(this).prop('type')) {
                case 'checkbox':
                case 'radio':
                    if ($(this).is(':checked')) {
                        data[n] = $(this).val();
                    }
                    break;
                default:
                    data[n] = $(this).val();
            }
        });
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                var $row = $('[data-id=' + response.data.id + ']', $pstoolkit_admin_bar_entries_parent);
                if (0 < $row.length) {
                    $('.sui-builder-field-label', $row).html(response.data.title_to_show);
                    $('.sui-builder-field', $row).data('nonce', response.data.nonce);
                    SUI.closeModal();
                } else {
                    var template = wp.template(PSToolkit.admin_bar_dialog_edit + '-row');
                    $('.sui-box-builder-fields', $pstoolkit_admin_bar_entries_parent).append(template(response.data));
                    SUI.closeModal();
                }
            } else {
                SUI.openFloatNotice(response.data.message);
            }
        });
    });
    /**
     * Delete feed
     */
    $('.pstoolkit-admin-bar-items-custom-entries').on('click', '.pstoolkit-admin-bar-item-delete', function() {
        /**
         * Set data on delete modal
         */
        var $parent = jQuery(this).closest('.sui-builder-field');
        jQuery('button.pstoolkit-admin-bar-delete', jQuery('#' + PSToolkit.admin_bar_dialog_delete))
            .data('nonce', $parent.data('nonce'))
            .data('id', $parent.data('id'));
        SUI.openModal(
            PSToolkit.admin_bar_dialog_delete,
            this,
            undefined,
            true
        );
    });
    $('.pstoolkit-admin-bar-delete').on('click', function() {
        var data = {
            action: 'pstoolkit_admin_bar_delete',
            _wpnonce: $(this).data('nonce'),
            id: $(this).data('id')
        };
        $.post(ajaxurl, data, function(response) {
            if (response.success) {
                $('[data-id=' + data.id + ']', $pstoolkit_admin_bar_entries_parent).detach();
                SUI.closeModal();
                SUI.openFloatNotice(response.data.message, 'success');
            } else {
                SUI.openFloatNotice(response.data.message);
            }
        });
    });
    /**
     * Reset order
     */
    $('.pstoolkit-admin-bar-reset').on('click', function() {
        var data = {
            action: 'pstoolkit_admin_bar_order_reset',
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
    /**
     * Show popular builders
     */
    $('#pstoolkit_popular_builders').on('click', function(e) {
        SUI.openModal('pstoolkit-admin-bar-add-popular-builders', this, null, true);
    });
    /**
     * Show/hide Add button on popular builders dialog
     */
    $('#pstoolkit-popular-builders').on('change', function(e) {
        var value = !$(this).val();
        $('.pstoolkit-admin-bar-add-popular-builders').prop('disabled', value);
    });
    // Adding popular builder
    $('.pstoolkit-admin-bar-add-popular-builders').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var $dialog = $(this).closest('.sui-modal'),
            builders = $('#pstoolkit-popular-builders', $dialog).val(),
            value = jQuery.trim($('#builders textarea').val());

        value += (value ? '\n' : '') + builders.join('\n');
        $('#builders textarea').val(value);
        $('#pstoolkit-popular-builders', $dialog).val('').trigger('change');

        SUI.closeModal();
    });
});
/**
 * Submenu: add
 */
function bind_pstoolkit_submenu_title(parent) {
    jQuery('.pstoolkit-admin-bar-submenu-title input[type=text]', parent).on('change paste cut keydown keyup keypress', function(event) {
        jQuery('.sui-accordion-item-title', jQuery(this).closest('.sui-accordion-item')).html(
            '<i class="sui-icon-drag" aria-hidden="true"></i>' + jQuery(this).val()
        );
    });
}

function pstoolkit_admin_bar_submenu_add(args) {
    var $button = jQuery('.pstoolkit-admin-bar-submenu-add', jQuery('#' + PSToolkit.admin_bar_dialog_edit));
    var target = jQuery('.sui-box-builder-body', $button.closest('.sui-form-field'));
    var template = wp.template($button.data('template'));
    var submenu;
    jQuery('.sui-accordion', target).append(template(args));
    SUI.pstoolkitSideTabs();
    jQuery('.pstoolkit-admin-bar-no-submenu').hide();
    submenu = jQuery('#pstoolkit-admin-bar-submenu-' + args.id);
    bind_pstoolkit_submenu_title(submenu);
    jQuery('.pstoolkit-admin-bar-submenu-delete', submenu).on('click', function() {
        var parent = jQuery(this).closest('.sui-box-builder-body');
        jQuery(this).closest('.sui-accordion-item').detach();
        if (1 > jQuery('.sui-accordion-item', parent).length) {
            jQuery('.pstoolkit-admin-bar-no-submenu', parent).show();
        }
    });
    jQuery('.pstoolkit-sui-accordion-sortable').sortable({
        items: '.ui-sortable-handle'
    });
}

function pstoolkit_admin_bar_submenu_bind() {
    bind_pstoolkit_submenu_title(jQuery('body'));
    jQuery('.pstoolkit-admin-bar-submenu-add').on('click', function() {
        var args = {
            id: Math.random().toString(36).substring(2, 15) + Math.random().toString(36).substring(2, 15),
            target: 'current',
            url: 'admin',
            url_admin: '',
            url_site: '',
            url_custom: ''
        };
        pstoolkit_admin_bar_submenu_add(args);
    });
    /**
     * Submenu: delete
     */
    jQuery('.pstoolkit-admin-bar-submenu-delete').on('click', function() {
        jQuery(this).closest('.sui-accordion-item').detach();
    });
    jQuery('.pstoolkit-sui-accordion-sortable').sortable({
        items: '.ui-sortable-handle'
    });
}
/**
 * change custom element visibility
 */
function pstoolkit_admin_bar_redirect_bind() {
    var $dialog = jQuery('#' + PSToolkit.admin_bar_dialog_edit);
    jQuery('input[name="pstoolkit[url]"]', $dialog).on('change', function() {
        var value = jQuery('.pstoolkit-general-url input:checked', $dialog).val();
        if (undefined === value) {
            value = jQuery('.pstoolkit-general-url .active input', $dialog).val();
        }
        switch (value) {
            case 'custom':
                jQuery('.pstoolkit-general-custom', $dialog).show();
                jQuery('.pstoolkit-admin-bar-url-options', $dialog).show();
                break;
            case 'main':
            case 'current':
            case 'wp-admin':
                jQuery('.pstoolkit-general-custom', $dialog).hide();
                jQuery('.pstoolkit-admin-bar-url-options', $dialog).show();
                break;
            default:
                jQuery('.pstoolkit-general-custom', $dialog).hide();
                jQuery('.pstoolkit-admin-bar-url-options', $dialog).hide();
        }
    });
}