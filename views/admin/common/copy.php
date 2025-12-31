<?php
$dialog_id = sprintf( 'pstoolkit-copy-settings-%s', $module['module'] );
$data_name = '_' . PSToolkit_Helper::hyphen_to_underscore( $dialog_id );
?>
<button type="button" class="sui-button sui-button-ghost" data-modal-open="<?php echo esc_attr( $dialog_id ); ?>" data-modal-mask="true" data-data-name="<?php echo esc_attr( $data_name ); ?>" ><?php echo esc_html_x( 'Kopiere Einstellungen', 'button', 'ub' ); ?></button>
<div class="sui-modal sui-modal-sm">
	<div class="sui-modal-content" id="<?php echo esc_attr( $dialog_id ); ?>" aria-labelledby="<?php echo esc_attr( $dialog_id ) . '-title'; ?>" aria-describedby="<?php echo esc_attr( $dialog_id ) . '-description'; ?>" role="dialog" aria-modal="true">
		<div class="sui-box" role="document">
			<div class="sui-box-header sui-content-center  sui-flatten">
				<button class="sui-button-icon sui-button-float--right" data-modal-close>
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Modal', 'ub' ); ?></span>
				</button>
				<h3 class="sui-box-title sui-lg" id="<?php echo esc_attr( $dialog_id ) . '-title'; ?>"><?php esc_html_e( 'Kopiere Einstellungen', 'ub' ); ?></h3>
			</div>
			<div class="sui-box-body sui-content-center sui-flatten">
				<p id="<?php echo esc_attr( $dialog_id ) . '-description'; ?>"><?php esc_html_e( 'Wähle das Modul aus, von dem Du die Einstellungen kopieren möchtest, und gib die Abschnitte an, von denen die Einstellungen kopiert werden sollen.', 'ub' ); ?></p>
				<div class="sui-form-field">
					<label for="dialog-text-5" class="sui-label"><?php esc_html_e( 'Einstellungen kopieren von', 'ub' ); ?></label>
					<select class="pstoolkit-copy-settings-select">
						<option value=""><?php esc_html_e( 'Modul wählen', 'ub' ); ?></option>
<?php
asort( $related );
foreach ( $related as $module_key => $data ) {
	printf(
		'<option value="%s">%s</option>',
		esc_attr( $module_key ),
		esc_html( $data['title'] )
	);
}
?>
					</select>
				</div>
<?php
foreach ( $related as $module_key => $data ) {
	printf(
		'<div class="pstoolkit-copy-settings-options pstoolkit-copy-settings-%s hidden">',
		esc_attr( $module_key )
	);
	foreach ( $data['options'] as $value => $label ) {
		?>
<label class="sui-checkbox sui-checkbox-stacked">
<input type="checkbox" class="pstoolkit-copy-settings-section" value="<?php echo esc_attr( $value ); ?>" />
	<span aria-hidden="true"></span>
	<span><?php echo esc_html( $label ); ?></span>
</label>
		<?php
	}
	echo '</div>';
}
?>
			</div>
			<div class="sui-box-footer sui-space-between sui-flatten">
				<button type="button" class="sui-button sui-button-ghost" data-modal-close=""><?php echo esc_html_x( 'Abbrechen', 'Dialog "Copy Settings" button', 'ub' ); ?></button>
				<button type="button" class="sui-modal-close sui-button sui-button-blue pstoolkit-copy-settings-copy-button" data-module="<?php echo esc_attr( $module['module'] ); ?>" data-nonce="<?php echo esc_attr( wp_create_nonce( $dialog_id ) ); ?>" disabled="disabled"><?php echo esc_html_x( 'Kopieren', 'Dialog "Copy Settings" button', 'ub' ); ?></button>
			</div>
		</div>
	</div>
</div>
