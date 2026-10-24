<?php
/**
 * Wrong module template.
 *
 * @since 3.0.7
 */
?>
<div class="sui-box" data-tab="unknown">
	<div class="sui-box-header">
		<h2 class="sui-box-title"><?php esc_html_e( 'Unbekanntes Modul', 'ub' ); ?></h2>
	</div>
	<div class="sui-box-body">
		<?php
			echo PSToolkit_Helper::sui_notice( esc_html__( 'Das ausgewählte Modul existiert nicht oder ist nicht verfügbar.', 'ub' ) ); // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
		?>
	</div>
</div>

