<?php
$link = add_query_arg(
	array(
		'page'   => 'branding',
		'pstoolkit' => 'manage-all-modules',
	)
);
$args = array(
	'title'                          => __( 'Übersicht', 'ub' ),
	'documentation_chapter'          => 'dashboard',
	'show_manage_all_modules_button' => $show_manage_all_modules_button,
	'helps'                          => $helps,
);
$this->render( 'admin/common/header', $args );
?>
<section id="sui-pstoolkit-content" class="sui-container">
<?php
$args = array(
	'sui'     => $sui,
	'stats'   => $stats,
	'modules' => $modules,
	'groups'  => $groups,
	'mode'    => 'regular',
);
$this->render( 'admin/dashboard/widget-summary', $args );
$this->render( 'admin/dashboard/widget-modules', $args );
?>
</section>
