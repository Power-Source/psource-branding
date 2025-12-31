/**
 * PSToolkit: Signup Code
 * https://n3rds.work/
 *
 * Copyright (c) 2019 WMS N@W
 * Licensed under the GPLv2 +  license.
 */
/* global window, SUI, ajaxurl */
/**
 * Globals
 */
var PSToolkit = PSToolkit || {};
/**
 * Bind row buttons
 */
PSToolkit.signup_code_row_buttons_bind = function(container) {
    var $ = jQuery;
    $('.pstoolkit-signup-code-user, .pstoolkit-signup-code-blog', container).each(function() {
        $('.sui-button-icon', $(this)).has('.sui-icon-trash').on('click', function() {
            $.fn.pstoolkit_flag_status(this);
            $(this).closest('.sui-box').detach();
        });
    });
};
jQuery(window.document).ready(function($) {
    "use strict";
    /**
     * Bind
     */
    PSToolkit.signup_code_row_buttons_bind($('.pstoolkit-admin-page'));
    /**
     * Add
     */
    $('.pstoolkit-add', $('.pstoolkit-signup-code-user, .pstoolkit-signup-code-blog')).on('click', function() {
        var template = wp.template($(this).data('template'));
        var $target = $('.sui-box-builder-body .sui-box-builder-fields', $(this).closest('.sui-box-builder'));
        var new_row_id = 'new-' + $.fn.pstoolkit_generate_id();
        var args = {
            id: new_row_id
        };
        $target.append(template(args));
        $.fn.pstoolkit_flag_status(this);
        PSToolkit.signup_code_row_buttons_bind($(this).closest('.sui-tab-boxed'));

        // Initialize the new select field
        var $select = jQuery('[data-id="' + new_row_id + '"] select');
        SUI.suiSelect($select);
    });
});