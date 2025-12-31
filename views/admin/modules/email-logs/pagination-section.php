<?php
/**
 * Pagination section.
 *
 * @package PSToolkit
 */

?>

<div class="sui-box-body">

	<div class="pstoolkit-box-actions">

		<div class="pstoolkit-actions-bar">

			<?php // ELEMENT: Bulk Actions. ?>
			<form method="post" class="pstoolkit-bulk-actions-container pstoolkit-bulk-actions">

				<select
					name="pstoolkit_action"
					class="sui-select-sm"
					id="pstoolkit-select-bulk-actions-<?php echo $is_bottom ? 'bottom' : 'top'; ?>"
				>
					<option value="-1"><?php esc_html_e( 'Massenaktionen', 'ub' ); ?></option>
					<option value="delete-all"><?php esc_html_e( 'Massenlöschung', 'ub' ); ?></option>
				</select>

				<input
					type="hidden"
					name="pstoolkit_nonce"
					value="<?php echo esc_attr( wp_create_nonce( 'pstoolkit_entries_request' ) ); ?>"
				/>

				<button
					class="pstoolkit-bulk-delete sui-button"
					data-dialog="pstoolkit-email-logs-delete-bulk"
					type="button"
					<?php disabled( true ); ?>
				>
					<?php esc_html_e( 'Anwenden', 'ub' ); ?>
				</button>

			</form>

			<?php // ELEMENT: Pagination. ?>
			<div class="pstoolkit-pagination pstoolkit-pagination-desktop">

				<div class="sui-pagination-wrap">

					<?php /* translators: result count */ ?>
					<span class="sui-pagination-results"><?php printf( esc_html( _n( '%d Ergebnis', '%d Ergebnisse', $total, 'ub' ) ), esc_html( $total ) ); ?></span>

					<?php
					$args = array(
						'total'  => $total,
						'limit'  => $limit,
						'module' => $module,
					);
					$this->render( '/admin/common/modules/pagination-list', $args );

					// Filter icon.
					?>
					<button class="sui-button-icon sui-button-outlined pstoolkit-open-inline-filter">
						<i class="sui-icon-filter" aria-hidden="true"></i>
						<span class="sui-screen-reader-text"><?php echo esc_html__( 'Filter Ergebnisse', 'ub' ); ?></span>
					</button>

				</div>

			</div>

		</div>

		<div class="sui-pagination-filter">

			<form method="get">

				<input type="hidden" name="page" value="branding_group_emails">
				<input type="hidden" name="module" value="email-logs">

				<div class="sui-row">

					<div class="sui-col-md-4">

						<div class="sui-form-field">
							<label class="sui-label"><?php esc_html_e( 'E-Mail-Datumsbereich', 'ub' ); ?></label>
							<div class="sui-date">
								<span class="sui-icon-calendar" aria-hidden="true"></span>
								<input type="text"
									name="date_range"
									value="<?php echo esc_attr( $date_range ); ?>"
									placeholder="<?php esc_html_e( 'Wähle einen Datumsbereich', 'ub' ); ?>"
									class="pstoolkit-filter-date sui-form-control pstoolkit-filter-field" />
							</div>
						</div>

					</div>

					<div class="sui-col-md-4">

						<div class="sui-form-field">
							<label class="sui-label"><?php esc_html_e( 'Von Email', 'ub' ); ?></label>
							<input type="email"
								name="from_email"
								placeholder="<?php esc_html_e( 'z.B. example@gmail.com', 'ub' ); ?>"
								class="sui-form-control pstoolkit-filter-field"
								value="<?php echo esc_attr( $from_email ); ?>" />
						</div>

					</div>

					<div class="sui-col-md-4">

						<div class="sui-form-field">
							<label class="sui-label"><?php esc_html_e( 'Empfänger', 'ub' ); ?></label>
							<input type="email"
								name="recipient"
								placeholder="<?php esc_html_e( 'z.B. example@gmail.com', 'ub' ); ?>"
								class="sui-form-control pstoolkit-filter-field"
								value="<?php echo esc_attr( $recipient ); ?>" />
						</div>

					</div>

				</div>

				<div class="sui-row">

					<div class="sui-col-md-4">

						<div class="sui-form-field">
							<label class="sui-label"><?php esc_html_e( 'Schlagwort', 'ub' ); ?></label>
							<div class="sui-control-with-icon">
								<input type="text"
									name="keyword"
									placeholder="<?php esc_html_e( 'z.B. gmail', 'ub' ); ?>"
									class="sui-form-control pstoolkit-filter-field"
									value="<?php echo esc_attr( $keyword ); ?>" />
								<span class="sui-icon-magnifying-glass-search" aria-hidden="true"></span>
							</div>
						</div>

					</div>

					<div class="sui-col-md-4">

						<div class="sui-form-field">
							<label class="sui-label"><?php esc_html_e( 'Sortieren nach', 'ub' ); ?></label>
							<select name="order_by" id="pstoolkit-select-order-by-<?php echo $is_bottom ? 'bottom' : 'top'; ?>">
								<?php foreach ( $order_by_array as $key => $name ) { ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $order_by ); ?>><?php echo esc_html( $name ); ?></option>
								<?php } ?>
							</select>
						</div>

					</div>

					<div class="sui-col-md-4">

						<div class="sui-form-field">
							<label class="sui-label"><?php esc_html_e( 'Sortierreihenfolge', 'ub' ); ?></label>
							<select name="order" id="pstoolkit-select-order-<?php echo $is_bottom ? 'bottom' : 'top'; ?>">
								<?php foreach ( $order_array as $key => $name ) { ?>
									<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $key, $order ); ?>><?php echo esc_html( $name ); ?></option>
								<?php } ?>
							</select>
						</div>

					</div>

				</div>

				<div class="sui-filter-footer">

					<button type="button" class="sui-button sui-button-ghost pstoolkit-entries-clear-filter">
						<?php esc_html_e( 'Filter löschen', 'ub' ); ?>
					</button>

					<button class="sui-button">
						<?php esc_html_e( 'Anwenden', 'ub' ); ?>
					</button>

				</div>

			</form>

		</div>

		<?php if ( $is_filtered && ! $is_bottom ) { ?>

			<div class="sui-pagination-filters-list">

				<label class="sui-label"><?php esc_html_e( 'Aktive Filter', 'ub' ); ?></label>

				<div class="sui-pagination-active-filters">

					<?php if ( $date_range ) { ?>
						<span class="sui-active-filter">
							<?php esc_html_e( 'E-Mail-Datum:', 'ub' ); ?> <?php echo esc_html( $date_range ); ?>
						<span class="sui-active-filter-remove" data-filter="date_range" role="button"><span class="sui-screen-reader-text"><?php esc_html_e( 'Entferne diesen Filter', 'ub' ); ?></span></span></span>
					<?php } ?>

					<?php if ( $from_email ) { ?>
						<span class="sui-active-filter">
							<?php esc_html_e( 'Von Email:', 'ub' ); ?> <?php echo esc_html( $from_email ); ?>
						<span class="sui-active-filter-remove" data-filter="from_email" role="button"><span class="sui-screen-reader-text"><?php esc_html_e( 'Entferne diesen Filter', 'ub' ); ?></span></span></span>
					<?php } ?>

					<?php if ( $recipient ) { ?>
						<span class="sui-active-filter">
							<?php esc_html_e( 'Empfänger:', 'ub' ); ?> <?php echo esc_html( $recipient ); ?>
						<span class="sui-active-filter-remove" data-filter="recipient" role="button"><span class="sui-screen-reader-text"><?php esc_html_e( 'Entferne diesen Filter', 'ub' ); ?></span></span></span>
					<?php } ?>

					<?php if ( $keyword ) { ?>
						<span class="sui-active-filter">
							<?php esc_html_e( 'Hat Schlagwort:', 'ub' ); ?> <?php echo esc_html( $keyword ); ?>
						<span class="sui-active-filter-remove" data-filter="keyword" role="button"><span class="sui-screen-reader-text"><?php esc_html_e( 'Entferne diesen Filter', 'ub' ); ?></span></span></span>
					<?php } ?>

					<?php if ( $order_by ) { ?>
						<span class="sui-active-filter">
							<?php esc_html_e( 'Sortieren nach:', 'ub' ); ?> <?php echo esc_html( $order_by ); ?>
						<span class="sui-active-filter-remove" data-filter="order_by" role="button"><span class="sui-screen-reader-text"><?php esc_html_e( 'Entferne diesen Filter', 'ub' ); ?></span></span></span>
					<?php } ?>

				</div>

			</div>

		<?php } ?>

	</div>
</div>
