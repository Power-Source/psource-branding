<div class="sui-modal sui-modal-alt sui-modal-sm pstoolkit-dialog-new">

	<div class="sui-modal-content" id="pstoolkit-permissions-add-user" aria-labelledby="pstoolkit-permissions-add-user-title" aria-describedby="pstoolkit-permissions-add-user-description" role="dialog" aria-modal="true">

		<div class="sui-box" role="document">

				<div class="sui-box-header  sui-content-center  sui-flatten">

					<button class="sui-button-icon sui-button-float--right" data-modal-close>
						<i class="sui-icon-close sui-md" aria-hidden="true"></i>
						<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Modal', 'ub' ); ?></span>
					</button>

					<h3 class="sui-box-title sui-lg" id="pstoolkit-permissions-add-user-title"><?php esc_html_e( 'Benutzer hinzufügen', 'ub' ); ?></h3>

				</div>

				<div class="sui-box-body sui-box-body-slim  sui-flatten">
					<?php $is_large = is_multisite() && wp_is_large_network( 'users' ); ?>
					<p id="pstoolkit-permissions-add-user-description" class="sui-description">
						<?php
						echo $is_large
							? esc_html__( 'Gib das Benutzer-Login oder die E-Mail-Adresse in das Feld ein, das hinzugefügt werden soll. Du kannst beliebig viele Benutzer hinzufügen.', 'ub' )
							: esc_html__( 'Gib den Benutzernamen in das Suchfeld ein, das hinzugefügt werden soll. Du kannst beliebig viele Benutzer hinzufügen.', 'ub' );
						?>
							</p>

					<div class="sui-form-field">
						<label class="sui-label" for="searchuser"><?php echo $is_large ? esc_html__( 'Benutzer Login oder E-Mail', 'ub' ) : esc_html__( 'Benutzer suchen', 'ub' ); ?></label>
						<div class="sui-control-with-icon">
							<?php if ( $is_large ) { ?>
								<input id="user_login" placeholder="<?php esc_html_e( 'Benutzer Login oder E-Mail', 'ub' ); ?>" class="sui-form-control" />
							<?php } else { ?>
								<select class="sui-select sui-form-control"
										id="searchuser"
										name="user"
										data-placeholder="<?php esc_html_e( 'Gib Benutzernamen ein', 'ub' ); ?>"
										data-hash="<?php echo esc_attr( wp_create_nonce( 'usersearch' ) ); ?>"
										data-language-searching="<?php esc_attr_e( 'Suchen...', 'ub' ); ?>"
										data-language-noresults="<?php esc_attr_e( 'keine Ergebnisse gefunden', 'ub' ); ?>"
										data-language-error-load="<?php esc_attr_e( 'Suchen...', 'ub' ); ?>"
								>
								</select>
							<?php } ?>
							<i class="sui-icon-profile-male" aria-hidden="true"></i>
						</div>
					</div>
				</div>

				<div class="sui-box-footer  sui-flatten sui-space-between">

					<a class="sui-button sui-button-ghost" data-modal-close><?php esc_html_e( 'Abbrechen', 'ub' ); ?></a>

					<button class="sui-button pstoolkit-permissions-add-user" data-nonce="<?php echo esc_attr( wp_create_nonce( 'add_user' ) ); ?>">
						<span class="sui-loading-text"><i class="sui-icon-check" aria-hidden="true"></i><?php esc_html_e( 'Hinzufügen', 'ub' ); ?></span>
						<span class="sui-loading-text-adding"><i class="sui-icon-loader" aria-hidden="true"></i><?php esc_html_e( 'Hinzufügen', 'ub' ); ?></span>
					</button>

				</div>

		</div>

	</div>

</div>
