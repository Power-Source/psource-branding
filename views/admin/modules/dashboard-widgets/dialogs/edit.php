<div class="sui-modal sui-modal-lg">
	<div class="sui-modal-content" id="<?php echo esc_attr( $dialog_id ); ?>" aria-labelledby="<?php echo esc_attr( $dialog_id ) . '-title'; ?>" role="dialog" aria-modal="true">
		<div class="sui-box" role="document">
			<div class="sui-box-header">
				<button class="sui-button-icon sui-button-float--right" data-modal-close> 
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Modal', 'ub' ); ?></span>
				</button>
				<h3 class="sui-box-title" id="<?php echo esc_attr( $dialog_id ) . '-title'; ?>">
					<span class="pstoolkit-new"><?php esc_html_e( 'Text Widget hinzufügen', 'ub' ); ?></span>
					<span class="pstoolkit-edit"><?php esc_html_e( 'Text-Widget bearbeiten', 'ub' ); ?></span>
				</h3>
			</div>
			<div class="sui-box-body">
				<div class="sui-tabs sui-tabs-flushed">
					<div data-tabs="">
						<div class="pstoolkit-first-tab active"><?php esc_html_e( 'Allgemeines', 'ub' ); ?></div>
						<div><?php esc_html_e( 'Sichtbarkeit', 'ub' ); ?></div>
					</div>
					<div data-panes="">
						<div class="active <?php echo esc_attr( $dialog_id ); ?>-pane-general">
<div class="sui-form-field pstoolkit-general-title">
	<label for="pstoolkit-dashboard-widgets-title" class="sui-label"><?php esc_html_e( 'Titel', 'ub' ); ?></label>
	<input id="pstoolkit-dashboard-widgets-title" type="text" name="pstoolkit[title]" value="" data-required="required" aria-describedby="input-description" class="sui-form-control" placeholder="<?php esc_attr_e( 'Gib hier den Titel des Text-Widgets ein...', 'ub' ); ?>" />
	<span class="hidden"><?php esc_html_e( 'Dieses Feld kann nicht leer sein!', 'ub' ); ?></span>
</div>
<div class="sui-form-field pstoolkit-general-content simple-option-wp_editor">
	<label for="pstoolkit-dashboard-widgets-content-{{data.id}}" class="sui-label"><?php esc_html_e( 'Inhalt', 'ub' ); ?></label>
	<div class="pstoolkit-editor-placeholder hidden" aria-hidden="true"><?php esc_attr_e( 'Füge hier Deinen Text-Widget-Inhalt hinzu...', 'ub' ); ?></div>
<?php
$id   = $dialog_id . '-content';
$args = array(
	'textarea_name' => 'pstoolkit[content]',
	'textarea_rows' => 9,
	'teeny'         => true,
);
wp_editor( '', $id, $args );
?>
</div>
						</div>
						<div class="<?php echo esc_attr( $dialog_id ); ?>-pane-visibility"></div>
					</div>
				</div>
				<input type="hidden" name="pstoolkit[id]" value="new" />
				<input type="hidden" name="pstoolkit[nonce]" value="" />
			</div>
			<div class="sui-box-footer sui-space-between">
				<button class="sui-button sui-button-ghost" type="button" data-modal-close=""><?php esc_html_e( 'Abbrechen', 'ub' ); ?></button>
				<button class="sui-button pstoolkit-dashboard-widgets-save pstoolkit-save" type="button">
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

