<?php

require_once 'class-pstoolkit-smtp-importer.php';

class PSToolkit_SMTP_Importer_WP_Mail_Bank extends PSToolkit_SMTP_Importer {

	public function __construct() {
		$this->option    = 'update_email_configuration';
		$this->translate = array(
			'header'              => array(
				'from_email'      => 'sender_email',
				'from_name_force' => 'sender_name_configuration',
				'from_name'       => 'sender_name',
			),
			'server'              => array(
				'smtp_host'            => 'hostname',
				'smtp_type_encryption' => 'enc_type',
				'smtp_port'            => 'port',
				'smtp_insecure_ssl'    => '',
			),
			'smtp_authentication' => array(
				'smtp_authentication' => '',
				'smtp_username'       => 'username',
				'smtp_password'       => 'password',
			),
		);
		add_filter( 'pstoolkit_smtp_import_update_email_configuration_password', array( $this, 'base64_decode' ) );
		add_filter( 'pstoolkit_smtp_import_update_email_configuration_sender_name_configuration', array( $this, 'sanitize_on' ) );
	}

	public function import( $module ) {
		$this->module = $module;
		$this->proceed();
	}
}
