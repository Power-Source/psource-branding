<?php
$has_configuration = empty( $has_configuration ) ? false : $has_configuration;
$screenshot        = empty( $screenshot ) ? '' : $screenshot;
$dialog_id         = empty( $dialog_id ) ? '' : $dialog_id;

$icon     = $has_configuration ? 'pencil' : 'plus';
$value    = $screenshot
	? esc_html__( 'Vorlage ändern', 'ub' )
	: esc_html__( 'Wähle eine Vorlage', 'ub' );
$classes  = 'pstoolkit-big-button';
$classes .= $screenshot ? ' pstoolkit-has-theme' : '';
$style    = $screenshot
	? sprintf( 'background-image: url("%s");', $screenshot )
	: '';
?>

<button class="<?php echo esc_attr( $classes ); ?>"
		data-modal-open="<?php echo esc_attr( $dialog_id ); ?>"
		data-modal-mask="true"
		data-edit="<?php esc_attr_e( 'Vorlage ändern', 'ub' ); ?>"
		data-choose="<?php esc_attr_e( 'Wähle eine Vorlage', 'ub' ); ?>"
		data-has-configuration="<?php echo $has_configuration ? 'yes' : 'no'; ?>"
		type="button"
		style="<?php echo esc_attr( $style ); ?>">

	<span class="sui-loading-text">
		<i class="sui-icon-<?php echo esc_attr( $icon ); ?>"></i><?php echo esc_html( $value ); ?>
	</span>
</button>
