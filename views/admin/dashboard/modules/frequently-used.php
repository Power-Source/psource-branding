<div id="pstoolkit-dashboard-widget-frequently-used" class="sui-box sui-box-close">
	<div class="sui-box-header">
		<h3 class="sui-box-title"><i class="sui-icon-clock" aria-hidden="true"></i><?php esc_html_e( 'Häufig benutzt', 'ub' ); ?></h3>
	</div>
<?php
$is_empty = true;
if ( ! empty( $modules ) ) {
	foreach ( $modules as $id => $module ) {
		if ( ! isset( $module['name'] ) ) {
			continue;
		}
		$is_empty = false;
		break; // Break foreach
	}
}
if ( $is_empty ) {
	?>
	<div class="sui-box-body">
		<?php
			echo PSToolkit_Helper::sui_notice( // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
				esc_html__( 'Wir haben momentan nicht genügend Daten. Sobald Du mit dem Plugin interagierst, werden wir Daten sammeln und Deine häufig verwendeten Module hier anzeigen.', 'ub' ),
				'default'
			);
		?>
	</div>
	<?php
} else {
	?>
	<div class="sui-box-body">
		<p><?php esc_attr_e( 'Hier findest Du Deine Top 5 häufig verwendeten Module.', 'ub' ); ?></p>
	</div>
	<table class="sui-table sui-table-flushed">
	<?php $this->render( 'admin/dashboard/modules/table-header', array( 'mode' => $mode ) ); ?>
		<tbody>
	<?php
	foreach ( $modules as $id => $module ) {
		if ( ! isset( $module['name'] ) ) {
			continue;
		}
		$args = array(
			'id'     => $id,
			'module' => $module,
			'mode'   => $mode,
		);
		$this->render( 'admin/dashboard/modules/one-row', $args );
	}
	?>
		</tbody>
	</table>
<?php } ?>
</div>
