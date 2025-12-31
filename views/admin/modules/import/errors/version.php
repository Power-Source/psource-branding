<div class="sui-header pstoolkit-import-error">
	<h1 class="sui-header-title"><?php esc_html_e( 'Importfehler', 'ub' ); ?></h1>
	<?php
	echo PSToolkit_Helper::sui_notice( // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
		sprintf(
			esc_html__( 'Die Datei, die Du importieren möchtest, ist für %1$sVersion%2$s. Bitte aktualisiere die Quellwebseite auf PSToolkit und exportiere sie erneut.', 'ub' ),
			sprintf(
				'<b>%s</b>',
				esc_html( $product )
			),
			sprintf(
				'<b>%s</b>',
				esc_html( $version )
			)
		)
	);
	?>
</div>
<?php $this->render( 'admin/modules/import/errors/footer', array( 'cancel_url' => $cancel_url ) ); ?>
