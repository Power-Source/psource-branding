<?php
// Footer.
$args    = array(
	'text' => __( 'Abbrechen', 'ub' ),
	'sui'  => 'ghost',
	'data' => array(
		'modal-close' => '',
	),
);
$footer  = $this->button( $args );
$args    = array(
	'sui'   => 'blue',
	'text'  => __( 'Einstellungen speichern', 'ub' ),
	'class' => 'pstoolkit-module-save-email-logs-settings',
);
$footer .= $this->button( $args );

// Dialog.
$args = array(
	'id'           => $id,
	'title'        => __( 'Protokolleinstellungen', 'ub' ),
	'content'      => $content,
	'confirm_type' => false,
	'footer'       => array(
		'content' => $footer,
		'classes' => array( 'sui-space-between' ),
	),
	'classes'      => array(
		'sui-modal-lg',
		$this->get_name( 'dialog' ),
	),
);
echo $this->sui_dialog( $args );
