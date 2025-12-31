<?php
$args = array(
	'title'                          => __( 'Dashboard', 'ub' ),
	'show_manage_all_modules_button' => $show_manage_all_modules_button,
	'documentation_chapter'          => $this->get_current_group_documentation_chapter(),
	'helps'                          => $helps,
);
$this->render( 'admin/common/header', $args );
?>
<section id="sui-pstoolkit-content" class="sui-container">
<?php
$args = array(
	'stats'   => $stats,
	'modules' => $modules,
	'groups'  => $groups,
	'mode'    => 'subsite',
	'class'   => $this->get_hide_branding_class(),
	'style'   => $this->get_box_summary_image_style(),
);
$this->render( 'admin/dashboard/subsite/widget-summary', $args );
$this->render( 'admin/dashboard/widget-modules', $args );
?>
</section>
<?php if ( $message['show'] && is_super_admin() ) { ?>
	<div
		id="pstoolkit-notice-permissions-settings-data"
		class="sui-hidden"
		data-nonce="<?php echo esc_attr( $message['nonce'] ); ?>"
		data-id="<?php echo esc_attr( $message['user_id'] ); ?>"
	>
	<?php
		printf(
			esc_html__( '%1$s, Hier können nur Module verwendet werden, denen Du Zugriff auf die Unterwebseite gewährt hast. Du kannst Module zu den %2$sBerechtigungen-Einstellungen%3$s hinzufügen oder daraus entfernen.', 'ub' ),
			esc_html( $message['username'] ),
			'<a href="' . esc_url( $message['url'] ) . '">',
			'</a>'
		);
	?>
	</div>
	<?php
}
