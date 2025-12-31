<?php
$search_nonce = empty( $search_nonce ) ? '' : $search_nonce;

$input_too_short = esc_html__( 'Gib einen Benutzernamen in das Suchfeld ein.', 'ub' );
if ( is_multisite() ) {
	if ( is_main_site() ) {
		$input_too_short .= ' ' . esc_html__( 'Bitte beachte dass Du das Admin-Menü nur für die Benutzer anpassen kannst, die der Hauptseite hinzugefügt wurden.', 'ub' );
	} else {
		$input_too_short .= ' ' . esc_html__( 'Bitte beachte dass Du das Admin-Menü nur für die Benutzer dieser Unterwebseite anpassen kannst.', 'ub' );
	}
}
?>

<div class="pstoolkit-custom-admin-menu-users">
	<div class="sui-box-body">
		<div>
			<label for="pstoolkit-admin-menu-user-search" class="sui-label">
				<?php esc_html_e( 'Benutzerdefinierte Benutzer', 'ub' ); ?>
			</label>

			<select class="sui-select sui-select-ajax"
				id="pstoolkit-admin-menu-user-search"
				data-placeholder="<?php esc_attr_e( 'Suche Benutzer', 'ub' ); ?>"
				data-input-too-short="<?php echo esc_attr( $input_too_short ); ?>"
				data-dropdown-parent-class="pstoolkit-custom-admin-menu-users"
				data-action="pstoolkit_admin_menu_search_user"
				data-user-id="<?php echo esc_attr( get_current_user_id() ); ?>"
				data-nonce="<?php echo esc_attr( $search_nonce ); ?>">
			</select>

			<span class="sui-description">
				<?php esc_html_e( 'Suche und füge Benutzer hinzu, um das Administratormenü anzupassen.', 'ub' ); ?>
			</span>
		</div>
	</div>

	<div class="pstoolkit-custom-admin-menu-user-tabs-container sui-box-body"></div>
</div>
