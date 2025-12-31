<div class="sui-modal sui-modal-lg">
	<div role="dialog" id="<?php echo esc_attr( $dialog_id ); ?>"class="sui-modal-content"  aria-modal="true" aria-labelledby="<?php echo esc_attr( $dialog_id ) . '-title'; ?>">
		<div class="sui-box" role="document">
			<div class="sui-box-header" id="<?php echo esc_attr( $dialog_id ) . '-title'; ?>">
				<button class="sui-button-icon sui-button-float--right" data-modal-close>
					<i class="sui-icon-close sui-md" aria-hidden="true"></i>
					<span class="sui-screen-reader-text"><?php esc_html_e( 'Schließe dieses Modal', 'ub' ); ?></span>
				</button>
				<h3 class="sui-box-title">
					<span class="pstoolkit-new"><?php esc_html_e( 'Benutzerdefiniertes Menüelement hinzufügen', 'ub' ); ?></span>
					<span class="pstoolkit-edit"><?php esc_html_e( 'Benutzerdefiniertes Menüelement bearbeiten', 'ub' ); ?></span>
				</h3>
			</div>
			<div class="sui-box-body">
				<div class="sui-tabs sui-tabs-flushed">
					<div data-tabs="">
						<div data-tab="general" class="active pstoolkit-first-tab"><?php esc_html_e( 'Allgemeines', 'ub' ); ?></div>
						<div data-tab="submenu"><?php esc_html_e( 'Untermenü', 'ub' ); ?></div>
						<div data-tab="visibility"><?php esc_html_e( 'Sichbarkeit', 'ub' ); ?></div>
					</div>
					<div data-panes="">
						<div data-tab="general" class="active <?php echo esc_attr( $dialog_id ); ?>-pane-general"></div>
						<div data-tab="submenu" class="<?php echo esc_attr( $dialog_id ); ?>-pane-submenu"></div>
						<div data-tab="visibility" class="<?php echo esc_attr( $dialog_id ); ?>-pane-visibility"></div>
					</div>
				</div>
				<input type="hidden" name="pstoolkit[id]" value="new" />
				<input type="hidden" name="pstoolkit[nonce]" value="new" />
			</div>
			<div class="sui-box-footer sui-space-between">
				<button class="sui-button sui-button-ghost" type="button" data-modal-close=""><?php esc_html_e( 'Abbrechen', 'ub' ); ?></button>
				<button class="sui-button pstoolkit-admin-bar-save pstoolkit-save" data-nonce="<?php echo esc_attr( $nonce_edit ); ?>" type="button">
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

