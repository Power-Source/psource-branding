<div class="sui-label"><?php esc_html_e( 'Anmeldecodes', 'ub' ); ?></div>
<div class="sui-box-builder <?php echo esc_attr( $container_class ); ?>">
	<div class="sui-box-builder-body">
		<div class="sui-box-builder-fields">
<?php
foreach ( $items as $id => $item ) {
	$item['roles'] = $roles;
	$this->render( $row, $item );
}
?>
		</div>
	</div>
	<div class="sui-box-builder-footer">
		<button type="button" class="sui-button sui-button-dashed pstoolkit-add" data-type="<?php echo esc_attr( $type ); ?>" data-template="<?php echo esc_attr( $this->get_name( 'row-' . $type ) ); ?>"><i class="sui-icon-plus" aria-hidden="true"></i><?php esc_html_e( 'Anmeldecode hinzufügen', 'ub' ); ?></button>
	</div>
</div>
<div class="sui-description"><?php esc_html_e( 'Benutzer müssen einen der Codes angeben, um sich erfolgreich anzumelden, und sie erhalten die Benutzerrolle, die dem von ihnen verwendeten Anmeldecode zugeordnet ist.', 'ub' ); ?></div>

