<div class="sui-modal sui-modal-sm">
	<div class="sui-modal-content" id="<?php echo esc_attr( $dialog_id ); ?>" aria-labelledby="<?php echo esc_attr( $dialog_id ) . '-title'; ?>" aria-describedby="<?php echo esc_attr( $dialog_id ) . '-description'; ?>" role="dialog" aria-modal="true">
		<div class="sui-box" role="document">
			<div class="sui-box-header sui-content-center sui-flatten">
				<button class="sui-button-icon sui-button-float--right" data-modal-close>
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Modal', 'ub' ); ?></span>
				</button>
				<h3 class="sui-box-title sui-lg" id="<?php echo esc_attr( $dialog_id ) . '-title'; ?>"><?php esc_html_e( 'Unterwebseiten löschen', 'ub' ); ?></h3>
			</div>
			<div class="sui-box-body sui-content-center sui-flatten">
				<p id="<?php echo esc_attr( $dialog_id ) . '-description'; ?>"><?php esc_html_e( 'Möchtest Du wirklich die in allen Unterwebseiten gespeicherten PSToolkit-Daten löschen?', 'ub' ); ?></p>
			</div>
			<div class="sui-box-footer sui-content-center sui-flatten">
				<div class="sui-form-field sui-actions-center">
					<button type="button" class="sui-modal-close sui-button sui-button-ghost" data-modal-close="<?php echo esc_attr( $dialog_id ); ?>"><?php echo esc_html_x( 'Abbrechen', 'button', 'ub' ); ?></button>
					<button type="button" class="sui-button sui-button-ghost sui-button-red sui-button-icon pstoolkit-data-delete-subsites-confirm" data-nonce="<?php echo esc_attr( $button_nonce ); ?>"><?php echo esc_html_x( 'LÖSCHEN', 'button', 'ub' ); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
