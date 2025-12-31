<?php
/**
 * PSToolkit Email Logs Main Table
 *
 * @package PSToolkit
 * @subpackage Emails
 */

// Notice is SMTP module is disabled.
$notice = static::maybe_add_smtp_notice();
if ( $notice ) {
	?>
	<div class="sui-box-body">
		<?php echo $notice; // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped ?>
	</div>
<?php } ?>

<?php
	// Filter Bar.
	echo $filter_bar_top; // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
?>

<table class="sui-table sui-table-flushed sui-accordion">

	<thead>

		<tr>

			<th class="" width="45">
				<label for="pstoolkit-check-all-top" class="sui-checkbox sui-checkbox-sm">
					<input type="checkbox" id="pstoolkit-check-all-top" class="pstoolkit-cb-select-all">
					<span aria-hidden="true"></span>
				</label>
			</th>

			<?php foreach ( array_slice( $columns, 2, 4 ) as $column ) { ?>
				<th class="<?php echo ! empty( $column['class'] ) ? esc_attr( $column['class'] ) : ''; ?>"><?php echo esc_html( $column['title'] ); ?></th>
			<?php } ?>
		</tr>

	</thead>

	<tbody id="pstoolkit-email-logs-table">
		<?php
		if ( $items ) {

			foreach ( $items as $entry ) {
				$_id = $entry['id'];
				?>

				<!--Main line-->
				<tr class="sui-accordion-item" data-entry-id="<?php echo esc_attr( $_id ); ?>">

					<td class="check-column">

						<label class="sui-checkbox sui-checkbox-sm">
							<input
								type="checkbox"
								name="ids[]"
								value="<?php echo esc_attr( $_id ); ?>"
								id="email-entry-<?php echo esc_attr( $_id ); ?>"
							/>
							<span aria-hidden="true"></span>
							<?php /* translators: entry id */ ?>
							<span><?php printf( esc_html__( '%1$sEintragsnummer auswählen%2$s', 'ub' ), '<span class="sui-screen-reader-text">', '</span>' ); ?></span>
						</label>

					</td>

					<?php foreach ( array_slice( $columns, 2, 4 ) as $key => $column ) { ?>
						<td class="<?php echo ! empty( $column['class'] ) ? esc_attr( $column['class'] ) : ''; ?>">
							<?php
							$cell = ! empty( $entry[ $key ] ) ? $entry[ $key ] : '';
							if ( key( array_slice( $columns, -1 ) ) !== $key ) { // not last column.
								echo $cell; // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
							} else {
								?>
								<div class="pstoolkit-ellipsised-last-cell"><?php echo $cell; // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped ?></div>
								<span class="sui-accordion-open-indicator">
									<span class="sui-icon-chevron-down" aria-hidden="true"></span>
									<span class="sui-screen-reader-text"><?php esc_html_e( 'Klicke zum Öffnen', 'ub' ); ?></span>
								</span>
							<?php } ?>
						</td>
					<?php } ?>

				</tr>

				<!--Details-->
				<tr class="sui-accordion-item-content">

					<td colspan="4">

						<div class="sui-box">

							<div class="sui-box-body">

								<?php foreach ( $columns as $key => $column ) { ?>
									<div class="pstoolkit-details-row">
										<span class="sui-col-xs-4 sui-col-sm-2">
											<b><?php echo esc_html( $column['title'] ); ?></b>
										</span>

										<span class="sui-col-xs-8 sui-col-sm-10">
											<span class="sui-list-detail"
												style="margin-top: 0;">
												<?php
												if ( ! empty( $entry[ $key ] ) ) {
													// Make emails are clickable.
													// phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
													echo in_array( $key, array( 'from_email', 'recipient' ), true ) ? PSToolkit_Email_Logs::make_email_clickable( $entry[ $key ] ) : $entry[ $key ];
												}
												?>
											</span>

										</span>
									</div>
								<?php } ?>

							</div>

							<form method="post" action="<?php echo esc_attr( $export_form_action ); ?>" download>

								<div class="sui-box-footer sui-space-between">

									<button class="sui-button sui-button-red sui-button-ghost"
										data-id="<?php echo esc_attr( $_id ); ?>"
										data-modal-open="<?php echo esc_attr( $module_object->get_nonce_action( $_id, 'delete' ) ); ?>"
										data-modal-mask="true"
									>
										<span class="sui-icon-trash" aria-hidden="true"></span>
										<?php esc_html_e( 'Löschen', 'ub' ); ?>
									</button>

									<button class="sui-button"
										type="submit"
										data-title="<?php esc_html_e( 'Exportieren', 'ub' ); ?>"
										data-description="<?php esc_html_e( 'E-Mail-Details exportieren', 'ub' ); ?>"
									>
										<span class="sui-icon-download" aria-hidden="true"></span>
										<?php esc_html_e( 'Exportieren', 'ub' ); ?>
									</button>

								</div>
								<input type="hidden" name="email_log_id" value="<?php echo esc_attr( $_id ); ?>">
								<input type="hidden" name="pstoolkit_nonce" value="<?php echo esc_attr( $module_object->get_nonce_value( 'email_log_export' . $_id ) ); ?>">
							</form>

						</div>

						<?php echo $this->get_dialog_delete( $_id ); // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped ?>

					</td>

				</tr>

			<?php } ?>

		<?php } else { ?>

			<tr>
				<td colspan="4">
					<div class="sui-box-body">
						<?php echo PSToolkit_Helper::sui_notice( esc_html__( 'Es wurden keine E-Mail-Protokolle gefunden.', 'ub' ) ); // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped ?>
					</div>
				</td>
			</tr>

		<?php } ?>

	</tbody>

</table>

<?php
	// Filter Bar.
	echo $filter_bar_bottom; // phpcs:ignore ClassicPress.Security.EscapeOutput.OutputNotEscaped
