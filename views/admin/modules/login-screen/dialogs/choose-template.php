<p class="sui-description"><?php esc_html_e( 'Passe eine unserer vorgefertigten Anmeldevorlagen an oder gestalte die Anmeldeseite von Grund auf neu.', 'ub' ); ?></p>
<?php
if ( $show_warning ) {
	echo PSToolkit_Helper::sui_notice( esc_html__( 'Sei vorsichtig, wenn Du eine Vorlage änderst, wird die von Dir vorgenommene Anpassung außer Kraft gesetzt.', 'ub' ), 'warning' ); // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
}
?>
<div class="sui-box-selectors">
	<ul>
<?php
foreach ( $elements as $k => $value ) {
	$classes = array(
		'pstoolkit-login-screen-li',
		sprintf( 'pstoolkit-login-screen-template-%s', $k ),
	);
	if ( $current === $value['id'] ) {
		$classes[] = 'pstoolkit-selected';
	}
	$classes = implode( ' ', $classes );
	printf( '<li class="%s">', esc_attr( $classes ) );
	printf( '<label for="%s" class="sui-box-selector">', esc_attr( $value['pstoolkit_id'] ) );
	printf(
		'<input type="radio" name="pstoolkit-login-screen-template" value="%s" id="%s" %s />',
		esc_attr( $value['id'] ),
		esc_attr( $value['pstoolkit_id'] ),
		checked( $current, $value['id'], false )
	);
	echo '<span class="pstoolkit-template-container"';
	if ( isset( $value['screenshot'] ) ) {
		printf(
			' style="background-image:url(%s);"',
			esc_attr( $value['screenshot'] )
		);
	}
	echo '>';
	printf(
		'<span class="login-screen-icon"><i class="sui-icon-%s" aria-hidden="true"></i></span>',
		'scratch' === $k ? 'pencil' : 'clipboard-notes'
	);
	printf(
		'<span class="login-screen-title">%s</span>',
		esc_html( $value['Name'] )
	);
	echo '</span>';
	echo '</label></li>';
}
?>
	</ul>
</div>

