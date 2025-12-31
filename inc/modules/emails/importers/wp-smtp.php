<?php

require_once 'class-pstoolkit-smtp-importer.php';

class PSToolkit_SMTP_Importer_WP_SMTP extends PSToolkit_SMTP_Importer {

	public function __construct() {
		$this->option    = 'wp_smtp_options';
		$this->translate = array(
			'header'              => array(
				'from_email'      => 'from',
				'from_name_force' => 'on',
				'from_name'       => 'fromname',
			),
			'server'              => array(
				'smtp_host'            => 'host',
				'smtp_type_encryption' => 'smtpsecure',
				'smtp_port'            => 'port',
				'smtp_insecure_ssl'    => 'off',
			),
			'smtp_authentication' => array(
				'smtp_authentication' => 'smtpauth',
				'smtp_username'       => 'username',
				'smtp_password'       => 'password',
			),
		);
		add_filter( 'pstoolkit_smtp_import_wp_smtp_options_smtpauth', array( $this, 'sanitize_on' ) );
		add_filter( 'pstoolkit_smtp_import_wp_mail_smtp_smtp_auth', array( $this, 'sanitize_on' ) );
	}

	public function import( $module ) {
		$this->module = $module;
		$this->proceed();
	}
}
