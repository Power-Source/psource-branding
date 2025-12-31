<div class="sui-modal sui-modal-md">

	<div class="sui-modal-content sui-content-fade-in pstoolkit-new-features" id="pstoolkit-show-new-feature" aria-labelledby="pstoolkit-show-new-feature-title" aria-describedby="pstoolkit-show-new-feature-description" role="dialog" aria-modal="true">

		<div class="sui-box">

				<div class="sui-box-header sui-content-center sui-flatten sui-spacing-top--60">
					<figure class="sui-box-banner" aria-hidden="true">
						<img src="<?php echo pstoolkit_url( 'assets/images/pstoolkit/smtp-log-feature.png' ); // WPCS: XSS ok. ?>"
							srcset="<?php echo pstoolkit_url( 'assets/images/pstoolkit/smtp-log-feature@2x.png' ); // WPCS: XSS ok. ?> 2x"
							alt="<?php esc_html_e( 'Neue Werkzeuge', 'ub' ); ?>" />
					</figure>

					<button class="sui-button-icon sui-button-float--right" data-modal-close>
						<i class="sui-icon-close sui-md" aria-hidden="true"></i>
						<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Modal', 'ub' ); ?></span>
					</button>

					<h3 class="sui-box-title sui-lg" id="pstoolkit-show-new-feature-title"><?php esc_html_e( 'Neue Änderungen der SMTP-Protokollfunktion und der Rollenberechtigung', 'ub' ); ?></h3>

					<p class="sui-description" id="pstoolkit-show-new-feature-description"><?php esc_html_e( 'PSToolkit wurde eine neue SMTP-Protokollfunktion hinzugefügt, und die Optionen zum Anpassen der Berechtigungen für Administratormenürollen wurden verbessert.', 'ub' ); ?></p>

				</div>

				<div class="sui-box-body">

					<div class="sui-form-field">
						<ul class="pstoolkit-small-list">
							<li><span class="sui-settings-label sui-dark"><?php esc_html_e( 'SMTP-Protokoll', 'ub' ); ?></span></li>
						</ul>
						<p class="sui-description">
						<?php
							printf(
								esc_html__( 'Mit der SMTP-Protokollfunktion kannst Du mit der Funktion %1$sSMTP-Protokoll%2$s detaillierte Informationen zu Deinen E-Mails sammeln. Du kannst den E-Mail-Verlauf des Empfängers verfolgen und den Protokollverlauf exportieren.', 'ub' ),
								'<a target="_blank" href="' . add_query_arg(
									array(
										'page'   => 'branding_group_emails',
										'module' => 'email-logs',
									),
									network_admin_url( 'admin.php' )
								) . '">',
								'</a>'
							);
							?>
							</p>
					</div>

					<div class="sui-form-field">
						<ul class="pstoolkit-small-list">
							<li><span class="sui-settings-label sui-dark"><?php esc_html_e( 'Rollenberechtigungsänderungen', 'ub' ); ?></span></li>
						</ul>
						<p class="sui-description"><?php esc_html_e( 'Die Logik zum Anpassen des Admin-Menüs wurde aktualisiert. Jetzt können Benutzer Berechtigungen nur für Rollen ändern, die niedriger als ihre eigenen sind. Beispielsweise können Benutzer mit der Administratorrolle die Berechtigungen für alle Rollen ändern, während Redakteure die Berechtigungen für die Rollen Autor, Mitwirkender und Abonnent ändern können, die Berechtigungen für Administratoren jedoch nicht.', 'ub' ); ?></p>
					</div>

				</div>

				<div class="sui-box-footer sui-flatten sui-content-center sui-spacing-bottom--50 pstoolkit-new-feature-got-it" data-dismiss-id="new-feature" data-nonce="<?php echo esc_attr( wp_create_nonce( 'new-feature' ) ); ?>">
					<button type="button" class="sui-button"><?php esc_html_e( 'Ich habs', 'ub' ); ?></button>
				</div>

		</div>

	</div>

</div>
