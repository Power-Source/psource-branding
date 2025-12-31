<div class="sui-border-frame">
	<div class="sui-description"><?php esc_html_e( 'Benutzer mit Zugriff', 'ub' ); ?></div>
	<div class="sui-box-builder" id="pstoolkit-permissions-users">
		<div class="sui-box-builder-body">
			<div class="sui-box-builder-fields pstoolkit-admin-permissions-user-items">
	<?php
	if ( is_array( $items ) ) {
		foreach ( $items as $id => $args ) {
			$this->render( $template, $args );
		}
	}
	?>
			</div>
	<?php echo $button_plus; // phpcs:disable ClassicPress.Security.EscapeOutput.OutputNotEscaped ?>
		</div>
	</div>
</div>
