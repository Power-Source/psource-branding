<div class="sui-modal sui-modal-lg">
	<div class="sui-modal-content" id="<?php echo esc_attr( $dialog_id ); ?>" aria-labelledby="<?php echo esc_attr( $dialog_id ) . '-title'; ?>" role="dialog" aria-modal="true">
		<div class="sui-box" role="document">
			<div class="sui-box-header">
				<button class="sui-button-icon sui-button-float--right" data-modal-close>
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Modal', 'ub' ); ?></span>
				</button>
				<h3 class="sui-box-title" id="<?php echo esc_attr( $dialog_id ) . '-title'; ?>">
					<span class="pstoolkit-new"><?php esc_html_e( 'Hilfeelement hinzufügen', 'ub' ); ?></span>
					<span class="pstoolkit-edit"><?php esc_html_e( 'Hilfeelement bearbeiten', 'ub' ); ?></span>
				</h3>
			</div>
			<div class="sui-box-body">
				<div class="sui-form-field simple-option simple-option-text" >
					<label for="<?php echo esc_attr( $dialog_id ); ?>-title" class="sui-label"><?php esc_html_e( 'Titel', 'ub' ); ?></label>
					<input type="text" id="<?php echo esc_attr( $dialog_id ); ?>-title" name="pstoolkit[title]" class="sui-form-control" placeholder="<?php esc_attr_e( 'Gib hier den Titel des Hilfeelements ein...', 'ub' ); ?>" />
				</div>
				<div class="sui-form-field simple-option simple-option-wp_editor" >
				<label for="<?php echo esc_attr( $dialog_id ); ?>-content" class="sui-label"><?php esc_html_e( 'Inhalt', 'ub' ); ?></label>
					<div class="pstoolkit-editor-placeholder hidden" aria-hidden="true"><?php esc_attr_e( 'Gib hier den Inhalt des Hilfeartikels ein...', 'ub' ); ?></div>
<?php
$id   = $dialog_id . '-content';
$args = array(
	'textarea_name' => 'pstoolkit[content]',
	'textarea_rows' => 9,
	// 'textarea_placeholder' => esc_attr_e( 'Füge hier Deinen Hilfeartikelinhalt hinzu...', 'ub' ),
	'teeny'         => true,
);
wp_editor( '', $id, $args );
?>
				</div>
				<input type="hidden" name="pstoolkit[id]" value="new" />
			</div>
			<div class="sui-box-footer sui-space-between">
				<button class="sui-button sui-button-ghost" type="button" data-modal-close=""><?php esc_html_e( 'Abbrechen', 'ub' ); ?></button>
				<button class="sui-button pstoolkit-admin-help-content-save pstoolkit-save" type="button">
					<span class="sui-loading-text">
						<span class="pstoolkit-new"><i class="sui-icon-check"></i><?php esc_html_e( 'Hinzufügen', 'ub' ); ?></span>
						<span class="pstoolkit-edit"><?php esc_html_e( 'Aktualisieren', 'ub' ); ?></span>
					</span>
					<i class="sui-icon-loader sui-loading" aria-hidden="true"></i>
				</button>
			</div>
		</div>
	</div>
</div>

