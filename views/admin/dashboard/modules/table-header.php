<thead>
	<tr>
		<th class="sui-table--name"><?php esc_attr_e( 'Modul', 'ub' ); ?></th>
<?php if ( 'subsite' === $mode ) { ?>
		<th class="sui-table--status"><?php esc_attr_e( 'Bearbeiten', 'ub' ); ?></th>
<?php } else { ?>
		<th class="sui-table--status"><?php esc_attr_e( 'Status', 'ub' ); ?></th>
<?php } ?>
	</tr>
</thead>

