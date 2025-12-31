<canvas
	class="pstoolkit-focal"
	id="<?php echo esc_attr( $html_id ); ?>"
	width="300"
	height="200"
	data-background-image="<?php echo esc_attr( $background_image ); ?>"
><?php esc_html_e( 'Dieser Text wird angezeigt, wenn Dein Browser HTML5 Canvas nicht unterstützt.', 'ub' ); ?></canvas>
<input type="hidden" name="<?php echo esc_attr( $field_name ); ?>[x]" value="<?php echo esc_attr( $value_x ); ?>" class="pstoolkit-focal-x" />
<input type="hidden" name="<?php echo esc_attr( $field_name ); ?>[y]" value="<?php echo esc_attr( $value_y ); ?>" class="pstoolkit-focal-y" />
<span class="sui-description">
	<?php esc_html_e( 'Bildposition:', 'ub' ); ?>
	<span class="pstoolkit-focal-x"><?php echo esc_attr( $value_x ); ?></span>%
	<span class="pstoolkit-focal-y"><?php echo esc_attr( $value_y ); ?></span>%
</span>
