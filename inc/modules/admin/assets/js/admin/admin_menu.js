(function ($) {
	var /**
		 * @type {PSToolkit.Menu_Tabs}
		 */
		role_tabs,
		/**
		 * @var {PSToolkit.Menu_Tabs}
		 */
		user_tabs;

	$(function () {
		$('[data-modal-open="pstoolkit-admin_menu-custom-admin-menu"]').on('click', fix_overflow_tabs);

		init_role_tabs();
		init_user_tabs();
		handle_mode_change();
		get_role_user_dropdown().on('select2:select', handle_mode_change);
		get_user_search_select().on('select2:select', handle_user_selected);
	});

	/**
	 * When the page is initialized, the dialog is hidden and so overflow tabs don't do width calculations correctly
	 * Triggering the resize event forces recalculation
	 */
	function fix_overflow_tabs() {
		setTimeout(function () {
			$(window).trigger('resize');
		}, 1000);
	}

	function handle_mode_change() {
		var value = get_role_user_dropdown().SUIselect2('val'),
			$roles = $('.pstoolkit-custom-admin-menu-roles'),
			$users = $('.pstoolkit-custom-admin-menu-users');

		if (value === 'roles') {
			role_tabs.activate_first_tab();
			user_tabs.destroy_active_tab();

			$roles.show();
			$users.hide();
		} else if (value === 'users') {
			user_tabs.activate_first_tab();
			role_tabs.destroy_active_tab();

			$users.show();
			$roles.hide();
		} else {
			user_tabs.destroy_active_tab();
			role_tabs.destroy_active_tab();

			$roles.hide();
			$users.hide();
		}

		fix_overflow_tabs();
	}

	function get_role_user_dropdown() {
		return $('#pstoolkit-admin-menu-role-user-switch');
	}

	function get_user_search_select() {
		return $('#pstoolkit-admin-menu-user-search');
	}

	function init_role_tabs() {
		if (!!role_tabs) {
			return;
		}

		role_tabs = new PSToolkit.Menu_Tabs(false);

		$('.pstoolkit-custom-admin-menu-roles').html(role_tabs.get_el());

		_.each(pstoolkit_custom_menu.role_menu_keys, function (display_name, menu_key) {
			role_tabs.add_tab(menu_key, display_name, false);
		});
	}

	function init_user_tabs() {
		if (!!user_tabs) {
			return;
		}

		user_tabs = new PSToolkit.Menu_Tabs(true);

		$('.pstoolkit-custom-admin-menu-user-tabs-container').html(user_tabs.get_el());

		_.each(pstoolkit_custom_menu.user_menu_keys, function (display_name, menu_key) {
			user_tabs.add_tab(menu_key, display_name, false);
		});
	}

	function handle_user_selected() {
		var $select = $(this),
			user_id = $select.val(),
			menu_key = 'user-' + user_id,
			select2 = $select.data('select2'),
			text = menu_key;

		if (select2 && select2.data && select2.data().length) {
			text = _.propertyOf(select2.data()[0])('title') || text;
		}

		user_tabs.add_tab(menu_key, text, true);
		$select.val('').trigger('change.select2');
	}
})(jQuery);
