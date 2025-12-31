<?php
$status      = $module['status'];
$status_text = __( 'Inaktiv', 'ub' );
$for_pro     = false;
if ( ! empty( $module['only_pro'] ) ) {
	$status  = 'inactive';
	$for_pro = true;
} elseif ( 'active' === $status ) {
	$status_text = __( 'Aktiv', 'ub' );
}
$url = add_query_arg(
	array(
		'page'   => sprintf( 'branding_group_%s', $module['group'] ),
		'module' => $module['module'],
	),
	is_network_admin() ? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' )
);
?>
<tr data-id="<?php echo esc_attr( $module['module'] ); ?>">
	<td class="sui-table--name sui-table-item-title">
		<?php if ( ! $for_pro ) { ?>
			<?php echo esc_attr( $module['name'] ); ?>
		<?php } else { ?>
			<span class="pstoolkit-module-for-pro"><?php echo esc_attr( $module['name'] ); ?></span>
			&nbsp;
			<?php echo PSToolkit_Helper::maybe_pro_tag(); // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped ?>
		<?php } ?>
	</td>
	<td class="sui-table--status<?php echo $for_pro ? ' pstoolkit-module-for-pro' : ''; ?>">
		<div class="pstoolkit-status-elements">
<?php if ( 'subsite' !== $mode ) { ?>
			<span class="pstoolkit-module-status sui-tooltip module-status-<?php echo esc_attr( $status ); ?>" data-tooltip="<?php echo esc_attr( $status_text ); ?>"></span>
<?php } ?>
			<a href="<?php echo esc_url( $url ); ?>" class="sui-button-icon sui-tooltip sui-tooltip-top-right-mobile" data-tooltip="<?php esc_attr_e( 'Modul bearbeiten', 'ub' ); ?>">
			<i class="sui-icon-pencil" aria-hidden="true"></i>
			</a>
		</div>
	</td>
</tr>

