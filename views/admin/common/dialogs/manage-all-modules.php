<div class="sui-modal pstoolkit-container-all-modules">
	<div
		role="dialog"
		aria-modal="true"
		id="pstoolkit-manage-all-modules"
		class="sui-modal-content"
		aria-labelledby="pstoolkit-manage-all-modules-title"
		aria-describedby="pstoolkit-manage-all-modules-description"
	>
		<div class="sui-box pstoolkit-manage-all-modules-box" role="document">
			<div class="sui-box-header">
				<h1 class="sui-header-title" id="pstoolkit-manage-all-modules-title"><?php esc_html_e( 'Alle Module verwalten', 'ub' ); ?></h1>
				<p id="pstoolkit-manage-all-modules-description"><?php esc_html_e( 'Wähle die Module aus, die aktiv sein sollen. Die gewählten Module sind bereits aktiv. In diesem Abschnitt kannst Du Module in großen Mengen aktivieren/deaktivieren, anstatt dies einzeln zu tun.', 'ub' ); ?></p>
			</div>
			<div class="sui-box-body">
				<section id="sui-pstoolkit-content" class="sui-container pstoolkit-avoid-flag">
					<div class="sui-row">
<?php
foreach ( $groups as $group_key => $group ) {
	if ( 'data' === $group_key ) {
		continue;
	}
	$actived = 0;
	foreach ( $modules[ $group_key ]['modules'] as $key => $module ) {
		if ( isset( $module['status'] ) && 'active' === $module['status'] ) {
			$actived++;
		}
	}
	$checked = $actived === count( $modules[ $group_key ]['modules'] );
	echo '<div class="sui-col">';
	printf( '<div class="sui-label">%s</div>', $group['title'] );
	$id = sprintf( 'pstoolkit-%s-%s', $group_key, 'all' );
	printf( '<label for="%s" class="sui-checkbox sui-checkbox-stacked">', esc_attr( $id ) );
	printf(
		'<input type="checkbox" class="pstoolkit-group-checkbox" id="%s" %s />',
		esc_html( $id ),
		checked( $checked, true, false )
	);
	echo '<span aria-hidden="true"></span>';
	printf( '<span>%s</span>', esc_html__( 'Alle', 'ub' ) );
	echo '</label>';
	foreach ( $modules[ $group_key ]['modules'] as $key => $module ) {
		$checked = isset( $module['status'] ) && 'active' === $module['status'];
		$id      = sprintf( 'pstoolkit-%s-%s', $group_key, $key );
		printf( '<label for="%s" class="sui-checkbox sui-checkbox-stacked">', esc_attr( $id ) );
		printf(
			'<input type="checkbox" id="%s" name="%s"%s />',
			esc_attr( $id ),
			esc_attr( $module['module'] ),
			checked( $checked, true, false )
		);
		echo '<span aria-hidden="true"></span>';
		// If menu title is set, use that instead of name for consistency.
		printf( '<span>%s</span>', isset( $module['menu_title'] ) ? esc_html( $module['menu_title'] ) : esc_html( $module['name'] ) );
		echo '</label>';
	}
	echo '</div>';
}
?>
					</div>
				</section>
			</div>
			<div class="sui-box-footer">
				<button class="sui-button sui-button-ghost" data-modal-close=""><?php echo esc_html_x( 'Abbrechen', 'button', 'ub' ); ?></button>
				<button class="sui-button sui-button-blue pstoolkit-save-all" type="button" data-nonce="<?php echo wp_create_nonce( 'pstoolkit-manage-all-modules' ); ?>">
					<span class="sui-loading-text"><?php echo esc_html_x( 'Änderungen speichern', 'button', 'ub' ); ?></span><i class="sui-icon-loader sui-loading" aria-hidden="true"> </i>
				</button>
			</div>
		</div>
	</div>
</div>

