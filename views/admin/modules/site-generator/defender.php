<div class="sui-box sui-summary">
	<div class="sui-summary-image-space" aria-hidden="true"></div>
	<div>
		<?php
		echo PSToolkit_Helper::sui_notice( // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
			''
			. esc_html__( 'Dieser Abschnitt wurde deaktiviert, da Defender so konfiguriert ist, dass die Generatorinformationen aus Sicherheitsgründen von Deiner Seite entfernt werden. Wenn Du jedoch die Generatorinformationen auf Deiner Webseite weiterhin aktivieren und weiter anpassen möchtest, ändere die Einstellungen für die Generatorinformationen in Defender.', 'ub' ) .
			'<br><br><a class="sui-button sui-button-ghost" href="' . esc_url( $link ) . '">' . esc_html_x( 'Defender Einstellungen', 'button', 'ub' ) . '</a>',
			'warning'
		);
		?>
	</div>
</div>
