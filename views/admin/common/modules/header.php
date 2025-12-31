<?php
$classes          = empty( $classes ) ? array() : $classes;
$slug             = empty( $slug ) ? '' : $slug;
$current          = empty( $current ) ? '' : $current;
$box_title        = empty( $box_title ) ? '' : $box_title;
$status_indicator = empty( $status_indicator ) ? '' : $status_indicator;
$module           = empty( $module ) ? array() : $module;
$copy_button      = empty( $copy_button ) ? '' : $copy_button;
$buttons          = empty( $buttons ) ? '' : $buttons;
?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>"
	 data-tab="<?php echo esc_attr( sanitize_title( $slug ) ); ?>"<?php echo $current === $slug ? '' : ' style="display: none;"'; ?>>
	<div class="sui-box-status">
		<div class="sui-status">
			<div class="sui-status-module">
				<h2 class="sui-box-title"><?php echo esc_html( $box_title ); ?>
													 <?php
														/*if ( ! empty( $module['only_pro'] ) ) {
															echo PSToolkit_Helper::maybe_pro_tag(); }*/
														?>
				</h2>
			</div>

			<?php if ( 'show' === $status_indicator ) { ?>
				<div class="sui-status-changes sui-hidden pstoolkit-status-changes-unsaved">
					<i class="sui-icon-update" aria-hidden="true"></i>
					<span class="pstoolkit-hide-sm"><?php esc_html_e( 'Nicht gespeicherte Änderungen', 'ub' ); ?></span>
				</div>
				<div class="sui-status-changes pstoolkit-status-changes-saved">
					<i class="sui-icon-check-tick" aria-hidden="true"></i>
					<span class="pstoolkit-hide-sm"><?php esc_html_e( 'Gespeichert', 'ub' ); ?></span>
				</div>
			<?php } ?>
			<?php echo apply_filters( 'pstoolkit_settings_after_box_title', '', $module ); ?>
		</div>

		<div class="sui-actions">
			<?php echo $copy_button; ?>
			<?php echo $buttons; ?>
		</div>
		<?php echo apply_filters( 'pstoolkit_settings_after_box_title_after_actions', '', $module ); ?>
	</div>
</div>
