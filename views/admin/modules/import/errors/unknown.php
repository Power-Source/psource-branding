<div class="sui-header pstoolkit-import-error">
	<?php $this->render( 'admin/modules/import/header' ); ?>
	<?php
	echo PSToolkit_Helper::sui_notice( // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
		sprintf(
			esc_html__( 'Beim Hochladen von %s ist ein unbekannter Fehler aufgetreten. Bitte versuche es erneut.', 'ub' ),
			sprintf(
				'<b>%s</b>',
				esc_html( $filename )
			)
		)
	);
	?>
</div>
<?php
$this->render( 'admin/modules/import/errors/footer', array( 'cancel_url' => $cancel_url ) );
