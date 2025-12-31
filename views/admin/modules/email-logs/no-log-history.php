<?php
// Notice is SMTP module is disabled.
$notice = static::maybe_add_smtp_notice();
?>
<div class="sui-box-body sui-message sui-message-lg">
	<img
		src="<?php echo esc_html( pstoolkit_url( 'assets/images/pstoolkit/confused@1x.png' ) ); ?>"
		srcset="<?php echo esc_html( pstoolkit_url( 'assets/images/pstoolkit/confused@2x.png' ) ); ?> 2x"
		class="sui-image"
		aria-hidden="true"
	/>
	<h2><?php esc_html_e( 'Noch kein Protokollverlauf!', 'ub' ); ?></h2>
	<?php if ( $notice ) { ?>
		<div style="text-align: left;">
			<?php echo $notice; // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	<?php } else { ?>
		<p><?php esc_html_e( 'Du hast noch keine Protokolle. Wenn Du dies hast, kannst Du hier alle Protokolle anzeigen.', 'ub' ); ?></p>
	<?php } ?>
</div>
