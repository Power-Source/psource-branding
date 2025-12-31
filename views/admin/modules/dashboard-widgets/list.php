<div class="sui-box-builder">
	<div class="sui-box-builder-header"><?php echo $button; ?></div>
	<div class="sui-box-builder-body">
		<div class="sui-box-builder-fields pstoolkit-dashboard-widgets-items">
<?php
if ( is_array( $items ) ) {
	foreach ( $items as $id => $args ) {
		$this->render( $template, $args );
	}
}
?>
		</div>
<?php echo $button_plus; ?>
		<span class="sui-box-builder-message<?php echo esc_attr( empty( $items ) ? '' : ' hidden' ); ?>"><?php esc_html_e( 'Es wurde noch kein Text-Widget hinzugefügt. Klicke auf "+Text-Widget hinzufügen", um Dein erstes Text-Widget mit einem einfachen Assistenten hinzuzufügen.', 'ub' ); ?></span>
	</div>
</div>
