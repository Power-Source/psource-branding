<script type="text/html" id="tmpl-menu-item-container">
	<div class="sui-box-builder">
		<?php if ( ! empty( $no_menu_items ) ) { ?>
			<div class="sui-box-builder-body">
			<?php
			echo PSToolkit_Helper::sui_notice( // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
				sprintf(
					esc_html__( 'Wenn Du hier kein Admin-Menüelement siehst, besuche bitte die %1$sDashboard-Seite%2$s Deiner Hauptseite und kehre auf diese Seite zurück, um die Admin-Menüelemente anzupassen.', 'ub' ),
					'<a href="' . esc_url( admin_url() ) . '" target="_blank">',
					'</a>'
				),
				'info'
			);
			?>
			</div>
		<?php } else { ?>
		<div class="sui-box-builder-header">
			<div class="sui-builder-options sui-options-inline">
				<label class="sui-checkbox sui-checkbox-sm">
					<input type="checkbox" class="pstoolkit-menu-select-all"/>
					<span aria-hidden="true"></span>
					<span><?php esc_html_e( 'Wähle Alle', 'ub' ); ?></span>
				</label>

				<span class="pstoolkit-custom-menu-bulk-controls">
					<button class="sui-button-icon sui-button-outlined sui-tooltip pstoolkit-custom-admin-menu-duplicate"
							data-tooltip="<?php esc_html_e( 'Klonen', 'ub' ); ?>">

						<i class="sui-icon-copy" aria-hidden="true"></i>
						<span class="sui-screen-reader-text">
							<?php esc_html_e( 'Klonen', 'ub' ); ?>
						</span>
					</button>

					<button class="sui-button-icon sui-button-outlined sui-tooltip pstoolkit-custom-admin-menu-make-invisible"
							data-tooltip="<?php esc_html_e( 'Verstecken, aber Zugriff erlauben', 'ub' ); ?>">

						<i class="sui-icon-eye-hide" aria-hidden="true"></i>
						<span class="sui-screen-reader-text">
							<?php esc_html_e( 'Verstecken, aber Zugriff erlauben', 'ub' ); ?>
						</span>
					</button>

					<button class="sui-button-icon sui-button-outlined sui-tooltip pstoolkit-custom-admin-menu-make-visible"
							data-tooltip="<?php esc_html_e( 'Einblenden', 'ub' ); ?>">

						<i class="sui-icon-eye" aria-hidden="true"></i>
						<span class="sui-screen-reader-text">
							<?php esc_html_e( 'Einblenden', 'ub' ); ?>
						</span>
					</button>

					<button class="sui-button-icon sui-button-outlined sui-tooltip pstoolkit-custom-admin-menu-hide"
							data-tooltip="<?php esc_html_e( 'Zugriff ausblenden und deaktivieren', 'ub' ); ?>">

						<i class="sui-icon-unlock" aria-hidden="true"></i>
						<span class="sui-screen-reader-text">
							<?php esc_html_e( 'Zugriff ausblenden und deaktivieren', 'ub' ); ?>
						</span>
					</button>

					<button class="sui-button-icon sui-button-outlined sui-tooltip pstoolkit-custom-admin-menu-unhide"
							data-tooltip="<?php esc_html_e( 'Einblenden und Zugriff aktivieren', 'ub' ); ?>">

						<i class="sui-icon-lock" aria-hidden="true"></i>
						<span class="sui-screen-reader-text">
							<?php esc_html_e( 'Einblenden und Zugriff aktivieren', 'ub' ); ?>
						</span>
					</button>
				</span>
			</div>
		</div>

		<div class="sui-box-builder-body">
			<div class="sui-builder-fields sui-accordion"></div>

			<button class="sui-button sui-button-dashed">
				<i class="sui-icon-plus" aria-hidden="true"></i>
				<?php esc_html_e( 'Element hinzufügen', 'ub' ); ?>
			</button>
		</div>
		<?php } ?>
	</div>
</script>
