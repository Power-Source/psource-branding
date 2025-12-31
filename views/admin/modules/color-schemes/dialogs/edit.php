<div class="sui-modal sui-modal-lg">
	<div class="sui-modal-content" id="<?php echo esc_attr( $dialog_id ); ?>" aria-labelledby="<?php echo esc_attr( $dialog_id ) . '-title'; ?>" role="dialog" aria-modal="true">
		<div class="sui-box" role="document">
			<div class="sui-box-header">
				<button class="sui-button-icon sui-button-float--right" data-modal-close>
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Modal', 'ub' ); ?></span>
				</button>
				<h3 class="sui-box-title" id="<?php echo esc_attr( $dialog_id ) . '-title'; ?>"><?php esc_html_e( 'Farbschema bearbeiten', 'ub' ); ?></h3>
			</div>
			<div class="sui-box-body">
				<div class="sui-form-field pstoolkit-border-bottom">
					<label for="pstoolkit-color-scheme-name" class="sui-settings-label"><?php esc_attr_e( 'Name', 'ub' ); ?></label>
					<span class="sui-description"><?php esc_html_e( 'Wähle einen Namen für dieses benutzerdefinierte Farbschema.', 'ub' ); ?></span>
					<input id="pstoolkit-color-scheme-name" type="text" name="pstoolkit[scheme_name]" class="sui-form-control" required="required" value="<?php echo esc_attr( $scheme_name ); ?>" />
					<span class="hidden"><?php esc_html_e( 'Schemaname darf nicht leer sein!', 'ub' ); ?></span>
				</div>
				<div class="sui-form-field pstoolkit-accordion-below">
					<label class="sui-settings-label"><?php esc_attr_e( 'Farben', 'ub' ); ?></label>
					<span class="sui-description"><?php esc_html_e( 'Passe die Standardfarbkombinationen nach Deinen Wünschen an.', 'ub' ); ?></span>
				</div>
				<div class="sui-accordion ">
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Allgemein', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Hintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $general_background,
		'name'  => 'pstoolkit[general_background]',
	)
);
?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Links', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Statisch', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Standardlink', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $links_static_default,
		'name'  => 'pstoolkit[links_static_default]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Löschen / Papierkorb / Spam -Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $links_static_delete,
		'name'  => 'pstoolkit[links_static_delete]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Inaktives Plugin-Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $links_static_inactive,
		'name'  => 'pstoolkit[links_static_inactive]',
	)
);
?>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Standardlink', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $links_static_default_hover,
		'name'  => 'pstoolkit[links_static_default_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Löschen / Papierkorb / Spam Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $links_static_delete_hover,
		'name'  => 'pstoolkit[links_static_delete_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Inaktives Plugin-Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $links_static_inactive_hover,
		'name'  => 'pstoolkit[links_static_inactive_hover]',
	)
);
?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Formulare', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Kontrollkästchen / Optionsfeld￼', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $form_checkbox,
		'name'  => 'pstoolkit[form_checkbox]',
	)
);
?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Core-Benutzeroberfläche', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Statisch', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primäre Schaltfläche', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $core_ui_primary_button_background,
		'name'  => 'pstoolkit[core_ui_primary_button_background]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primäre Schaltfläche Text', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $core_ui_primary_button_color,
		'name'  => 'pstoolkit[core_ui_primary_button_color]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primäre Schaltfläche Textschatten', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $core_ui_primary_button_shadow_color,
		'name'  => 'pstoolkit[core_ui_primary_button_shadow_color]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Deaktiviert Schaltfläche', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $core_ui_disabled_button_background,
		'name'  => 'pstoolkit[core_ui_disabled_button_background]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Deaktiviert Schaltfläche Text', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $core_ui_disabled_button_color,
		'name'  => 'pstoolkit[core_ui_disabled_button_color]',
	)
);
?>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primäre Schaltfläche', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $core_ui_primary_button_background_hover,
		'name'  => 'pstoolkit[core_ui_primary_button_background_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primäre Schaltfläche Text', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $core_ui_primary_button_color_hover,
		'name'  => 'pstoolkit[core_ui_primary_button_color_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Primäre Schaltfläche Textschatten', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $core_ui_primary_button_shadow_color_hover,
		'name'  => 'pstoolkit[core_ui_primary_button_shadow_color_hover]',
	)
);
?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Tabellen Anzeige', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Statisch', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Anzeige Switch-Symbol', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $list_tables_switch_icon,
		'name'  => 'pstoolkit[list_tables_switch_icon]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Beitragskommentare Zähler', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $list_tables_post_comment_count,
		'name'  => 'pstoolkit[list_tables_post_comment_count]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Alternative Zeile', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $list_tables_alternate_row,
		'name'  => 'pstoolkit[list_tables_alternate_row]',
	)
);
?>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Anzeige Switch-Symbol', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $list_tables_switch_icon_hover,
		'name'  => 'pstoolkit[list_tables_switch_icon_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Beitragskommentare Zähler', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $list_tables_post_comment_count_hover,
		'name'  => 'pstoolkit[list_tables_post_comment_count_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Paginierung / Schaltfläche / Symbol', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $list_tables_pagination_hover,
		'name'  => 'pstoolkit[list_tables_pagination_hover]',
	)
);
?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Admin-Menü', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Statisch', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Aktuell', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Aktuell Hover', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Fokus', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_color,
		'name'  => 'pstoolkit[admin_menu_color]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link Hintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_background,
		'name'  => 'pstoolkit[admin_menu_background]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Symbol', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_icon_color,
		'name'  => 'pstoolkit[admin_menu_icon_color]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Untermenü Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_submenu_link,
		'name'  => 'pstoolkit[admin_menu_submenu_link]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Untermenü Link Hintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_submenu_background,
		'name'  => 'pstoolkit[admin_menu_submenu_background]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Blase', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_bubble_color,
		'name'  => 'pstoolkit[admin_menu_bubble_color]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Blasenhintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_bubble_background,
		'name'  => 'pstoolkit[admin_menu_bubble_background]',
	)
);
?>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_color_hover,
		'name'  => 'pstoolkit[admin_menu_color_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link Hintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_background_hover,
		'name'  => 'pstoolkit[admin_menu_background_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Untermenü Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_submenu_link_hover,
		'name'  => 'pstoolkit[admin_menu_submenu_link_hover]',
	)
);
?>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_color_current,
		'name'  => 'pstoolkit[admin_menu_color_current]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link Hintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_background_curent,
		'name'  => 'pstoolkit[admin_menu_background_curent]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Symbol', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_icon_color_current,
		'name'  => 'pstoolkit[admin_menu_icon_color_current]',
	)
);
?>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Link', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_color_current_hover,
		'name'  => 'pstoolkit[admin_menu_color_current_hover]',
	)
);
?>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Symbol', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_menu_icon_color_focus,
		'name'  => 'pstoolkit[admin_menu_icon_color_focus]',
	)
);
?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Admin-Leiste', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-tabs sui-tabs-flushed">
										<div data-tabs="">
											<div class="active"><?php esc_html_e( 'Statisch', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Hover', 'ub' ); ?></div>
											<div class=""><?php esc_html_e( 'Fokus', 'ub' ); ?></div>
										</div>
										<div data-panes="">
											<div class="active">
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Hintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_background,
		'name'  => 'pstoolkit[admin_bar_background]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Farbe', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_color,
		'name'  => 'pstoolkit[admin_bar_color]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Symbol', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_icon_color,
		'name'  => 'pstoolkit[admin_bar_icon_color]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Untermenüsymbol und Links', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_submenu_icon_color,
		'name'  => 'pstoolkit[admin_bar_submenu_icon_color]',
	)
);
?>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Element Hintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_item_background_hover,
		'name'  => 'pstoolkit[admin_bar_item_background_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Elementfarbe', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_item_color_hover,
		'name'  => 'pstoolkit[admin_bar_item_color_hover]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Untermenüsymbol und Links', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_submenu_icon_color_hover,
		'name'  => 'pstoolkit[admin_bar_submenu_icon_color_hover]',
	)
);
?>
												</div>
											</div>
											<div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Element Hintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_item_background_focus,
		'name'  => 'pstoolkit[admin_bar_item_background_focus]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Elementfarbe', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_item_color_focus,
		'name'  => 'pstoolkit[admin_bar_item_color_focus]',
	)
);
?>
												</div>
												<div class="sui-form-field">
													<label class="sui-label"><?php esc_html_e( 'Untermenüsymbol und Links', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_bar_submenu_icon_color_focus,
		'name'  => 'pstoolkit[admin_bar_submenu_icon_color_focus]',
	)
);
?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Medien-Uploader', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Fortschrittsanzeige￼', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_media_progress_bar_color,
		'name'  => 'pstoolkit[admin_media_progress_bar_color]',
	)
);
?>
									</div>
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Ausgewählter Anhang￼', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_media_selected_attachment_color,
		'name'  => 'pstoolkit[admin_media_selected_attachment_color]',
	)
);
?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Themes', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Aktiver Themenhintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_themes_background,
		'name'  => 'pstoolkit[admin_themes_background]',
	)
);
?>
									</div>
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Hintergrund für aktive Themenaktionen', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_themes_actions_background,
		'name'  => 'pstoolkit[admin_themes_actions_background]',
	)
);
?>
									</div>
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Theme Details Schaltfläche Hintergrund', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_themes_details_background,
		'name'  => 'pstoolkit[admin_themes_details_background]',
	)
);
?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="sui-accordion-item">
						<div class="sui-accordion-item-header">
							<div class="sui-accordion-item-title"><?php esc_html_e( 'Plugins', 'ub' ); ?></div>
							<div class="sui-accordion-col-auto">
								<button type="button" class="sui-button-icon sui-accordion-open-indicator" aria-label="<?php esc_html_e( 'Öffne Element', 'ub' ); ?>"><i class="sui-icon-chevron-down" aria-hidden="true"></i></button>
							</div>
						</div>
						<div class="sui-accordion-item-body">
							<div class="sui-box">
								<div class="sui-box-body">
									<div class="sui-form-field">
										<label class="sui-label"><?php esc_html_e( 'Fortschrittsanzeige￼', 'ub' ); ?></label>
<?php
$this->render(
	'admin/common/options/sui-colorpicker',
	array(
		'value' => $admin_plugins_border_color,
		'name'  => 'pstoolkit[admin_plugins_border_color]',
	)
);
?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="sui-box-footer sui-space-between">
				<button class="sui-button sui-button-ghost" type="button" data-modal-close=""><?php esc_html_e( 'Abbrechen', 'ub' ); ?></button>
				<button class="sui-button <?php echo esc_attr( $button_apply_class ); ?>" data-nonce="<?php echo esc_attr( $button_apply_nonce ); ?>" type="button">
					<?php esc_html_e( 'Aktualisieren', 'ub' ); ?>
				</button>
			</div>
		</div>
	</div>
</div>
