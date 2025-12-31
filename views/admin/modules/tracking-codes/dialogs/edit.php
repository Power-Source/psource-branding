<input type="hidden" name="pstoolkit[id]" value="<?php echo esc_attr( $id ); ?>" class="pstoolkit-tracking-codes-id" />
<div class="sui-tabs sui-tabs-flushed">
	<div data-tabs="">
		<div class="active"><?php esc_attr_e( 'Allgemeines', 'ub' ); ?></div>
		<div><?php esc_attr_e( 'Standort', 'ub' ); ?></div>
	</div>
	<div data-panes="">
		<div class="active">
			<div class="sui-form-field pstoolkit-general-active">
				<label class="sui-label"><?php esc_attr_e( 'Status', 'ub' ); ?></label>
				<div class="sui-side-tabs sui-tabs">
					<div class="sui-tabs-menu">
						<label class="sui-tab-item<?php echo 'off' === $active ? ' active' : ''; ?>">
							<input type="radio" data-name="pstoolkit[active]"
								   name="pstoolkit[<?php echo esc_attr( $id ); ?>][active]"
								   value="off" <?php checked( $active, 'off' ); ?>>

							<?php esc_attr_e( 'Inaktiv', 'ub' ); ?>
						</label>
						<label class="sui-tab-item<?php echo 'on' === $active ? ' active' : ''; ?>">
							<input type="radio" data-name="pstoolkit[active]"
								   name="pstoolkit[<?php echo esc_attr( $id ); ?>][active]"
								   value="on" <?php checked( $active, 'on' ); ?>>

							<?php esc_attr_e( 'Aktiv', 'ub' ); ?>
						</label>
					</div>
				</div>
			</div>
			<div class="sui-form-field pstoolkit-general-title">
				<label for="pstoolkit-general-title-<?php echo esc_attr( $id ); ?>" class="sui-label"><?php esc_attr_e( 'Name', 'ub' ); ?></label>
				<input id="pstoolkit-general-title-<?php echo esc_attr( $id ); ?>" type="text" name="pstoolkit[title]" value="<?php echo esc_attr( $title ); ?>" aria-describedby="input-description" class="sui-form-control" placeholder="<?php esc_attr_e( 'z.B. GA-Ansichten verfolgen', 'ub' ); ?>" />
			</div>
			<div class="sui-form-field pstoolkit-general-code" data-id="<?php echo esc_attr( $id ); ?>">
				<label for="pstoolkit-general-code-<?php echo esc_attr( $id ); ?>" class="sui-label"><?php esc_attr_e( 'Tracking Code', 'ub' ); ?></label>
				<textarea id="pstoolkit-general-code-<?php echo esc_attr( $id ); ?>" name="pstoolkit[code]" class="sui-ace-editor ub_html_editor" rows="10" placeholder="<?php esc_attr_e( 'Füge hier Deinen Tracking-Code ein...', 'ub' ); ?>"><?php echo $code; ?></textarea>
			</div>
		</div>
		<div>
			<div class="sui-form-field pstoolkit-location-place">
				<label class="sui-label"><?php esc_attr_e( 'Position einfügen', 'ub' ); ?></label>
				<div class="sui-side-tabs sui-tabs">
					<div class="sui-tabs-menu">
						<label class="sui-tab-item<?php echo 'head' === $place ? ' active' : ''; ?>">
							<input type="radio" data-name="pstoolkit[place]"
								   name="pstoolkit[<?php echo esc_attr( $id ); ?>][place]"
								   value="head" <?php checked( $place, 'head' ); ?>>

							<?php esc_attr_e( 'Im &lt;Head&gt;', 'ub' ); ?>
						</label>
						<label class="sui-tab-item<?php echo 'body' === $place ? ' active' : ''; ?>">
							<input type="radio" data-name="pstoolkit[place]"
								   name="pstoolkit[<?php echo esc_attr( $id ); ?>][place]"
								   value="body" <?php checked( $place, 'body' ); ?>>

							<?php esc_attr_e( 'Nach &lt;Body&gt;', 'ub' ); ?>
						</label>
						<label class="sui-tab-item<?php echo 'footer' === $place ? ' active' : ''; ?>">
							<input type="radio" data-name="pstoolkit[place]"
								   name="pstoolkit[<?php echo esc_attr( $id ); ?>][place]"
								   value="footer" <?php checked( $place, 'footer' ); ?>>

							<?php esc_attr_e( 'Vor &lt;/Body&gt;', 'ub' ); ?>
						</label>
					</div>
				</div>
			</div>
<?php
/*******************************
 *
 * LOCATION
 *******************************/
?>
			<div class="sui-form-field pstoolkit-location-filter">
				<label class="sui-label"><?php esc_attr_e( 'Standortfilter', 'ub' ); ?></label>
				<div class="sui-side-tabs sui-tabs">
					<div class="sui-tabs-menu">
						<label class="sui-tab-item<?php echo 'off' === $filter ? ' active' : ''; ?>">
							<input type="radio" data-name="pstoolkit[filter]"
								   name="pstoolkit[<?php echo esc_attr( $id ); ?>][filter]"
								   value="off" <?php checked( $filter, 'off' ); ?>>

							<?php esc_attr_e( 'Deaktivieren', 'ub' ); ?>
						</label>
						<label class="sui-tab-item<?php echo 'on' === $filter ? ' active' : ''; ?>">
							<input type="radio" data-name="pstoolkit[filter]"
								   name="pstoolkit[<?php echo esc_attr( $id ); ?>][filter]"
								   value="on" <?php checked( $filter, 'on' ); ?>
								   data-name="filter" data-tab-menu="pstoolkit-tracking-codes-filter-status-on">

							<?php esc_attr_e( 'Aktivieren', 'ub' ); ?>
						</label>
					</div>
					<div class="sui-tabs-content">
						<div class="sui-tab-boxed<?php echo 'on' === $filter ? ' active' : ''; ?>" data-tab-content="pstoolkit-tracking-codes-filter-status-on">
							<div class="sui-form-field pstoolkit-location-users">
								<label for="pstoolkit-location-users-<?php echo esc_attr( $id ); ?>" class="sui-label"><?php esc_attr_e( 'Benutzer', 'ub' ); ?></label>
								<span class="sui-description"><?php esc_attr_e( 'Du kannst den protokollierten Status und/oder die Benutzerrolle auswählen.', 'ub' ); ?></span>
								<select name="pstoolkit[users]" multiple="multiple" class="sui-select pstoolkit-<?php echo esc_attr( $module ); ?>-filter-users" >
<?php
foreach ( $data_users as $value => $label ) {
	$extra    = '';
	$selected = is_array( $users ) && in_array( $value, $users ) ? ' selected="selected"' : '';
	if ( is_array( $users ) && in_array( 'anonymous', $users ) && 'anonymous' !== $value ) {
		$selected = '';
		$extra    = ' disabled="disabled"';
	}

	printf(
		'<option value="%s"%s%s>%s</option>',
		esc_attr( $value ),
		$selected,
		$extra,
		esc_html( $label )
	);
}
?>
								</select>
							</div>
<?php
/*******************************
 *
 * AUTHORS
 *******************************/
?>
							<div class="sui-form-field pstoolkit-Location-authors">
								<label for="pstoolkit-location-authors-<?php echo esc_attr( $id ); ?>" class="sui-label"><?php esc_attr_e( 'Autoren', 'ub' ); ?></label>
								<span class="sui-description"><?php esc_attr_e( 'Dieser Filter wird nur bei einmaliger Eingabe verwendet.', 'ub' ); ?></span>
								<select name="pstoolkit[authors]" class="sui-select" multiple="multiple">
<?php
foreach ( $data_authors as $value => $label ) {
	printf(
		'<option value="%s"%s>%s</option>',
		esc_attr( $value ),
		is_array( $authors ) && in_array( $value, $authors ) ? ' selected="selected"' : '',
		esc_html( $label )
	);
}
?>
								</select>
							</div>
<?php
/*******************************
 *
 * CONTENT TYPE
 *******************************/
?>
							<div class="sui-form-field pstoolkit-Location-archives">
								<label for="pstoolkit-location-archives-<?php echo esc_attr( $id ); ?>" class="sui-label"><?php esc_attr_e( 'Inhaltstyp', 'ub' ); ?></label>
								<select name="pstoolkit[archives]" class="sui-select sui-select sui-select" multiple="multiple">
								<?php
								foreach ( $data_archives as $value => $label ) {
									printf(
										'<option value="%s"%s>%s</option>',
										esc_attr( $value ),
										is_array( $archives ) && in_array( $value, $archives ) ? ' selected="selected"' : '',
										esc_html( $label )
									);
								}
								?>
								</select>
								<span class="sui-description"><?php esc_attr_e( 'Du kannst den Code bestimmten Inhaltstypen hinzufügen.', 'ub' ); ?></span>
							</div>
<?php
/*******************************
 *
 * SITES
 *******************************/
if ( $is_network_admin ) {
	?>
							<div class="sui-form-field pstoolkit-location-sites">
								<label for="pstoolkit-location-sites-<?php echo esc_attr( $id ); ?>" class="sui-label"><?php esc_attr_e( 'Seiten', 'ub' ); ?></label>
								<span class="sui-description"><?php esc_attr_e( 'Dieser Filter wird nur bei einmaliger Eingabe verwendet.', 'ub' ); ?></span>
								<select name="pstoolkit[sites]" class="sui-select" multiple="multiple">
	<?php
	foreach ( $data_sites as $site ) {
		printf(
			'<option value="%s"%s>%s - %s</option>',
			esc_attr( $site['id'] ),
			is_array( $sites ) && in_array( $site['id'], $sites ) ? ' selected="selected"' : '',
			esc_html( $site['title'] ),
			esc_html( $site['subtitle'] )
		);
	}
	?>
								</select>
							</div>
<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
