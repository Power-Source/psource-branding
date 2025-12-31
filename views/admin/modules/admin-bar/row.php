<div class="sui-builder-field" data-nonce="<?php echo esc_attr( $nonce ); ?>" data-id="<?php echo esc_attr( $id ); ?>">
	<div class="sui-builder-field-label">
	<?php
	$is_url = filter_var( $title, FILTER_VALIDATE_URL );
	if ( $is_url ) {
		printf(
			'<img src="%s" class="pstoolkit-image" title="%s" />',
			esc_url( $title ),
			esc_attr( $title )
		);
	} else {
		if ( ! empty( $icon ) ) {
			printf( '<span class="dashicons dashicons-%s"></span>', esc_attr( $icon ) );
		}
		echo esc_attr( $title );
	}
	?>
	</div>
	<div class="sui-button-icon sui-button-red sui-hover-show pstoolkit-admin-bar-item-delete">
		<i class="sui-icon-trash" aria-hidden="true"></i>
		<span class="sui-screen-reader-text"><?php esc_html_e( 'Element entfernen', 'ub' ); ?></span>
	</div>
	<span class="sui-builder-field-border sui-hover-show" aria-hidden="true"></span>
	<div class="sui-button-icon pstoolkit-admin-bar-item-edit">
		<i class="sui-icon-widget-settings-config" aria-hidden="true"></i>
	</div>
</div>

