<div class="sui-header pstoolkit-import-error">
	<?php $this->render( 'admin/modules/import/header' ); ?>
	<?php
	echo PSToolkit_Helper::sui_notice( // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
		sprintf(
			esc_html__( 'Die Datei %s, die Du importieren möchtest, enthält keine Modulkonfigurationen. Bitte überprüfe Deine Datei oder lade eine andere Datei hoch.', 'ub' ),
			'<b>' . esc_html( $filename ) . '</b>'
		)
	);
	?>
</div>
<?php $this->render( 'admin/modules/import/errors/footer', array( 'cancel_url' => $cancel_url ) ); ?>
