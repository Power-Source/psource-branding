<?php
$dialog_id    = empty( $dialog_id ) ? '' : $dialog_id;
$search_nonce = empty( $search_nonce ) ? '' : $search_nonce;
?>

<div class="sui-modal sui-modal-lg">

	<div class="sui-modal-content"
		id="<?php echo esc_attr( $dialog_id ); ?>"
		aria-modal="true"
		aria-labelledby="<?php echo esc_attr( $dialog_id ) . '-title'; ?>"
		role="dialog">

		<div class="sui-box pstoolkit-custom-admin-menu-dialog" role="document">
			<div class="sui-box-header">
				<button class="sui-button-icon sui-button-float--right" data-modal-close>
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Modal', 'ub' ); ?></span>
				</button>
				<h3 class="sui-box-title" id="<?php echo esc_attr( $dialog_id ) . '-title'; ?>">
					<?php esc_html_e( 'Benutzerdefiniertes Admin-Menü', 'ub' ); ?>
				</h3>
			</div>

			<div class="sui-box-body">
				<div class="sui-side-tabs pstoolkit-admin-menu-main-tabs">
					<div class="sui-tabs-menu">
						<label class="sui-tab-item active">
							<input type="radio" data-tab-menu="configure"><?php esc_html_e( 'Menüelemente konfigurieren', 'ub' ); ?></label>
						<label class="sui-tab-item">
							<input type="radio" data-tab-menu="settings"><?php esc_html_e( 'Einstellungen', 'ub' ); ?></label>
					</div>
					<div class="sui-tabs-content">
						<div class="sui-tab-boxed active" data-tab-content="configure">
							<p><?php esc_html_e( "Passe das Administratormenü nach Benutzerrolle oder separat für benutzerdefinierte Benutzer an. Du kannst die Reihenfolge der Menüelemente ändern, nicht gewünschte Elemente ausblenden und nach Bedarf neue Elemente hinzufügen.", 'ub' ); ?></p>

							<div class="sui-row">
								<div class="sui-col-md-12">
									<label>
										<select class="sui-select"
												id="pstoolkit-admin-menu-role-user-switch"
												data-minimum-results-for-search="-1">
											<option value="-" <?php checked( true ); ?>>
												<?php echo esc_html( 'Wähle die Anpassungsoption' ); ?>
											</option>
											<option value="roles">
												<?php echo esc_html( 'Benutzerregeln' ); ?>
											</option>
											<option value="users">
												<?php echo esc_html( 'Benutzerdefiniert' ); ?>
											</option>
										</select>
									</label>
								</div>
							</div>

							<?php
							$this->render( 'admin/modules/admin_menu/dialogs/custom-admin-menu-roles', array() );
							$this->render(
								'admin/modules/admin_menu/dialogs/custom-admin-menu-users',
								array(
									'search_nonce' => $search_nonce,
								)
							);
							?>
						</div>
						<div class="sui-tab-boxed" data-tab-content="settings">
							<div class="sui-row">
								<div class="sui-col-md-3"></div>
								<div class="sui-col-md-9">
									<?php
										$message = sprintf(
											esc_html__( 'Gehe noch einen Schritt weiter mit Deinem benutzerdefinierten Administratormenü, indem Du steuerst, was Deine Benutzer mit dem %1$sPS Mitgliedschaften Plugin%2$s tun können und was nicht.', 'ub' ),
											'<a href="https://n3rds.work/piestingtal_source/ps-mitgliedschaften-plugin/" target="_blank">',
											'</a>'
										);
										echo PSToolkit_Helper::sui_notice( $message, 'info' );
										?>
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</div>
