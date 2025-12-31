<div class="sui-upload">
	<input type="file" value="" class="pstoolkit-upload" name="<?php echo esc_attr( $field_name ); ?>" />
	<button type="button" class="sui-upload-button"><i class="sui-icon-upload-cloud" aria-hidden="true"></i> <?php esc_html_e( 'Datei hochladen', 'ub' ); ?></button>
	<div class="sui-upload-file">
		<span></span>
		<button type="button" aria-label="<?php esc_attr_e( 'Datei löschen', 'ub' ); ?>"> <i class="sui-icon-close" aria-hidden="true"></i></button>
	</div>
</div>
<?php
echo PSToolkit_Helper::sui_inline_notice( 'pstoolkit-wrong-filetype' ); // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
