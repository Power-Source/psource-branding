<?php
/**
 * Wrong module template.
 *
 * @since 3.2.0
 */
?>
<div class="sui-box-body">
<?php
	echo PSToolkit_Helper::sui_notice( // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
		sprintf(
			__( 'Dieses Modul kann von Administratoren der Unterwebseite gemäß Deinen <a href="%s">Berechtigungseinstellungen</a> überschrieben werden.', 'ub' ),
			esc_url( $url )
		),
		'info'
	);
	?>
</div>

