<?php
$is_main_item         = empty( $is_main_item ) ? false : $is_main_item;
$settings_tab_content = $this->menu_item_settings();
?>
<script type="text/html" id="tmpl-<?php echo $is_main_item ? 'menu' : 'submenu'; ?>-builder-field">
	<div class="sui-builder-field sui-accordion-item sui-can-move <# if(data.is_invisible) { #>pstoolkit-menu-item-invisible<# } #> <# if(data.is_hidden) { #>pstoolkit-menu-item-hidden<# } #> <# if(!data.is_native) { #>pstoolkit-menu-item-non-native<# } #>"
		 data-slug="{{ data.slug }}">

		<div class="sui-accordion-item-header sui-can-move">

			<i class="sui-icon-drag" aria-hidden="true"></i>

			<div class="sui-builder-field-label">
				<label class="sui-checkbox">
					<input type="checkbox" class="pstoolkit-custom-admin-menu-is-selected"/>
					<span aria-hidden="true"></span>
				</label>

				<span class="pstoolkit-menu-item-icon-container"></span>
				<span class="pstoolkit-menu-item-title">{{ data.title || data.title_default }}</span>
			</div>

			<div class="pstoolkit-custom-admin-menu-controls">
				<button class="sui-button-icon sui-dropdown-anchor">
					<i class="sui-icon-more" aria-hidden="true"></i>
				</button>

				<ul>
					<li>
						<a class="sui-button-icon sui-hover-show sui-tooltip pstoolkit-custom-admin-menu-remove"
						   data-tooltip="<?php esc_html_e( 'Löschen', 'ub' ); ?>">

							<i class="sui-icon-trash" aria-hidden="true"></i>
							<span class="pstoolkit-custom-admin-menu-button-text">
								<?php esc_html_e( 'Löschen', 'ub' ); ?>
							</span>
						</a>
					</li>

					<li>
						<a class="sui-button-icon sui-hover-show sui-tooltip pstoolkit-custom-admin-menu-undo"
						   data-tooltip="<?php esc_html_e( 'Elementänderungen rückgängig machen', 'ub' ); ?>">

							<i class="sui-icon-undo" aria-hidden="true"></i>
							<span class="pstoolkit-custom-admin-menu-button-text">
								<?php esc_html_e( 'Elementänderungen rückgängig machen', 'ub' ); ?>
							</span>
						</a>
					</li>

					<li>
						<a class="sui-button-icon sui-hover-show sui-tooltip pstoolkit-custom-admin-menu-duplicate"
						   data-tooltip="<?php esc_html_e( 'Duplikat', 'ub' ); ?>">

							<i class="sui-icon-copy" aria-hidden="true"></i>
							<span class="pstoolkit-custom-admin-menu-button-text">
								<?php esc_html_e( 'Duplikat', 'ub' ); ?>
							</span>
						</a>
					</li>

					<li>
						<label class="pstoolkit-custom-admin-menu-is-invisible">
							<input type="checkbox" name="is_invisible" <# if(data.is_invisible) { #>checked<# } #> />

							<a class="sui-button-icon sui-hover-show sui-tooltip pstoolkit-custom-admin-menu-make-invisible"
							   data-tooltip="<?php esc_html_e( 'Verstecken, aber Zugriff erlauben', 'ub' ); ?>">

								<i class="sui-icon-eye-hide" aria-hidden="true"></i>
								<span class="pstoolkit-custom-admin-menu-button-text">
									<?php esc_html_e( 'Verstecken, aber Zugriff erlauben', 'ub' ); ?>
								</span>
							</a>

							<a class="sui-button-icon sui-hover-show sui-tooltip pstoolkit-custom-admin-menu-make-visible"
							   data-tooltip="<?php esc_html_e( 'Einblenden', 'ub' ); ?>">

								<i class="sui-icon-eye" aria-hidden="true"></i>
								<span class="pstoolkit-custom-admin-menu-button-text">
									<?php esc_html_e( 'Einblenden', 'ub' ); ?>
								</span>
							</a>
						</label>
					</li>

					<li>
						<label class="pstoolkit-custom-admin-menu-is-hidden">
							<input type="checkbox" name="is_hidden" <# if(data.is_hidden) { #>checked<# } #> />

							<a class="sui-button-icon sui-hover-show sui-tooltip pstoolkit-custom-admin-menu-hide"
							   data-tooltip="<?php esc_html_e( 'Zugriff ausblenden und deaktivieren', 'ub' ); ?>">

								<i class="sui-icon-unlock" aria-hidden="true"></i>
								<span class="pstoolkit-custom-admin-menu-button-text">
									<?php esc_html_e( 'Zugriff ausblenden und deaktivieren', 'ub' ); ?>
								</span>
							</a>

							<a class="sui-button-icon sui-hover-show sui-tooltip pstoolkit-custom-admin-menu-unhide"
							   data-tooltip="<?php esc_html_e( 'Einblenden und Zugriff aktivieren', 'ub' ); ?>">

								<i class="sui-icon-lock" aria-hidden="true"></i>
								<span class="pstoolkit-custom-admin-menu-button-text">
									<?php esc_html_e( 'Einblenden und Zugriff aktivieren', 'ub' ); ?>
								</span>
							</a>
						</label>
					</li>
				</ul>
			</div>

			<span class="sui-builder-field-border" aria-hidden="true"></span>

			<button class="sui-button-icon sui-accordion-open-indicator <?php echo $is_main_item ? 'sui-tooltip' : ''; ?>"
				<?php if ( $is_main_item ) : ?>
					data-tooltip="<?php esc_attr_e( 'Untermenü verwalten', 'ub' ); ?>"
				<?php endif; ?>
			>
				<i class="sui-icon-chevron-down" aria-hidden="true"></i>
				<span class="sui-screen-reader-text">
					<?php esc_html_e( 'Untermenü verwalten', 'ub' ); ?>
				</span>
			</button>

		</div>

		<div class="sui-accordion-item-body sui-box-body">

			<?php if ( ! $is_main_item ) : ?>
				<div class="pstoolkit-menu-item-settings-container">
					<?php echo $settings_tab_content; ?>
				</div>
			<?php else : ?>
				<div class="sui-tabs sui-tabs-flushed">
					<div data-tabs>
						<div class="active"><?php esc_html_e( 'Einstellungen', 'ub' ); ?></div>
						<div><?php esc_html_e( 'Untermenü', 'ub' ); ?></div>
					</div>

					<div data-panes>
						<div class="active">
							<div class="pstoolkit-menu-item-settings-container">
								<?php echo $settings_tab_content; ?>
							</div>
						</div>

						<div class="pstoolkit-submenu-container"></div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</script>
