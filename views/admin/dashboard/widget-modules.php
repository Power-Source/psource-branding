<div id="pstoolkit-dashboard-widget-modules" class="sui-row">
	<div class="sui-col-sm-12 sui-col-md-6">
<?php
$stats['mode'] = $mode;
$this->render( 'admin/dashboard/modules/frequently-used', $stats );
$set = array( 'widgets', 'front-end' );
foreach ( $set as $one ) {
	if ( ! isset( $groups[ $one ] ) ) {
		continue;
	}
	if ( ! isset( $modules[ $one ] ) ) {
		continue;
	}
	$args = array(
		'group' => $one,
		'data'  => $modules[ $one ],
		'info'  => $groups[ $one ],
		'mode'  => $mode,
	);
	$this->render( 'admin/dashboard/modules/group', $args );
}
if ( isset( $modules['data'] ) ) {
	$data_modules        = pstoolkit_get_array_value( $modules, array( 'data', 'modules' ) );
	$data_modules        = empty( $data_modules ) ? array() : $data_modules;
	$hidden_module_count = count( array_filter( array_column( $data_modules, 'hide-on-dashboard' ) ) );

	if ( count( $data_modules ) > $hidden_module_count ) {
		$args = array(
			'group' => 'data',
			'data'  => $modules['data'],
			'info'  => $groups['data'],
			'stats' => $stats,
			'mode'  => $mode,
		);
		$this->render( 'admin/dashboard/modules/import-export', $args );
	}
}
?>
	</div>
	<div class="sui-col-sm-12 sui-col-md-6">
<?php
/*if ( ! PSToolkit_Helper::is_member() ) {
	$this->render( 'admin/dashboard/modules/upsell' );
}*/
$set = array( 'admin', 'emails', 'utilities' );
foreach ( $set as $one ) {
	if ( ! isset( $groups[ $one ] ) ) {
		continue;
	}
	if ( ! isset( $modules[ $one ] ) ) {
		continue;
	}
	$args = array(
		'group' => $one,
		'data'  => $modules[ $one ],
		'info'  => $groups[ $one ],
		'mode'  => $mode,
	);
	$this->render( 'admin/dashboard/modules/group', $args );
}
?>
	</div>
</div><?php // #sui-dashboard-widget-modules ?>
<div class="sui-box hidden" id="pstoolkit-dashboard-search-no-results">
	<div class="pstoolkit-empty">
		<h2 class="pstoolkit-image pstoolkit-image-confused">
	<?php _ex( 'Keine Ergebnisse für "<span></span>"', '&lt;span&gt; Tag ist der Platzhalter für die Suche nach Zeichenfolgen.', 'ub' ); ?></h2>
		<p><?php _e( 'Wir konnten keine Module finden, die Deiner Suche entsprechen. Vielleicht nochmal versuchen?', 'ub' ); ?></p>
	</div>
</div>

