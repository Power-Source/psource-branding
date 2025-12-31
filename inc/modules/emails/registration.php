<?php
/**
 * PSToolkit Registration Emails class.
 *
 * @package PSToolkit
 * @subpackage Emails
 */
if ( ! class_exists( 'PSToolkit_Registration_Emails' ) ) {

	class PSToolkit_Registration_Emails  extends PSToolkit_Helper {

		protected $option_name = 'ub_registration_emails';
		private $blog_title;

		public function __construct() {
			parent::__construct();
			$this->module = 'registration-emails';
			add_filter( 'pstoolkit_settings_registration_emails', array( $this, 'admin_options_page' ) );
			add_filter( 'pstoolkit_settings_registration_emails_process', array( $this, 'update' ) );
			/**
			 * replace
			 */
			/** Those filters are documented in wp-includes/ms-functions.php */
			add_filter( 'wpmu_signup_blog_notification_email', array( $this, 'blog_signup_email' ) );
			add_filter( 'wpmu_signup_blog_notification_subject', array( $this, 'blog_signup_subject' ) );
			add_filter( 'wpmu_signup_user_notification_email', array( $this, 'user_signup_email' ) );
			add_filter( 'wpmu_signup_user_notification_subject', array( $this, 'user_signup_subject' ) );
			/**
			 * Notify a user that their blog activation has been successful.
			 */
			add_filter( 'update_welcome_email', array( $this, 'welcome_email' ), 11, 6 );
			add_filter( 'update_welcome_subject', array( $this, 'welcome_subject' ), 11 );
			/**
			 * AJAX axtions
			 */
			add_action( 'wp_ajax_pstoolkit_registration_emails_reset', array( $this, 'ajax_section_reset' ) );
			/**
			 * upgrade options
			 *
			 * @since 1.0.0
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}

		/**
		 * Upgrade option
		 *
		 * @since 2.1.0
		 */
		public function upgrade_options() {
			$value = pstoolkit_get_option( 'global_ms_register_mails' );
			if ( empty( $value ) ) {
				return;
			}
			pstoolkit_delete_option( 'global_ms_register_mails' );
			$this->update_value( $value );
		}

		/**
		 * modify option name
		 *
		 * @since 1.9.2
		 */
		public function get_module_option_name( $option_name, $module ) {
			if ( is_string( $module ) && 'registration-emails' == $module ) {
				return $this->option_name;
			}
			return $option_name;
		}

		/**
		 * Blog Signup Email Body
		 */
		public function blog_signup_email( $value ) {
			return $this->filter( $value, 'wpmu_signup_blog_notification', 'message' );
		}

		/**
		 * Blog Signup Email Subject
		 */
		public function blog_signup_subject( $value ) {
			return $this->filter( $value, 'wpmu_signup_blog_notification', 'title' );
		}

		/**
		 * User Signup Email Body
		 */
		public function user_signup_email( $value ) {
			return $this->filter( $value, 'wpmu_signup_user_notification', 'message' );
		}

		/**
		 * User Signup Email Subject
		 */
		public function user_signup_subject( $value ) {
			return $this->filter( $value, 'wpmu_signup_user_notification', 'title' );
		}

		/**
		 * User welcome Email Body
		 *
		 * @since 1.0.0
		 */
		public function welcome_email( $welcome_email, $blog_id, $user_id, $password, $title, $meta ) {
			$this->blog_title = $title;
			$welcome_email    = $this->filter( $welcome_email, 'wpmu_welcome_notification', 'message' );
			$current_network  = get_network();
			$user             = get_userdata( $user_id );
			$url              = get_blogaddress_by_id( $blog_id );
			$welcome_email    = str_replace( 'SITE_NAME', $current_network->site_name, $welcome_email );
			$welcome_email    = str_replace( 'BLOG_TITLE', $title, $welcome_email );
			$welcome_email    = str_replace( 'BLOG_URL', $url, $welcome_email );
			$welcome_email    = str_replace( 'USERNAME', $user->user_login, $welcome_email );
			$welcome_email    = str_replace( 'PASSWORD', $password, $welcome_email );
			return $welcome_email;
		}

		/**
		 * User welcome Email Subject
		 *
		 * @since 1.0.0
		 */
		public function welcome_subject( $subject ) {
			$current_network = get_network();
			$subject         = sprintf(
				$this->filter( $subject, 'wpmu_welcome_notification', 'title' ),
				$current_network->site_name,
				wp_unslash( $this->blog_title )
			);
			return $subject;
		}

		/**
		 * Chage value helper
		 *
		 * @since 1.0.0
		 *
		 * @param string $value Value to filter
		 * @param string $name Section name.
		 * @param string $key Section key.
		 *
		 * @return string $value Value after filter.
		 */
		private function filter( $value, $name, $key ) {
			$this->set_data();
			if ( 'on' == $this->get_value( $name, 'status', 'off' ) ) {
				$value = $this->get_value( $name, $key );
			}
			return $value;
		}

		protected function set_options() {
			$new_blog_message    = __( "Um Deinen Blog zu aktivieren, klicke bitte auf den folgenden Link:\n\n%1\$s\n\nNach der Aktivierung erhältst Du *eine weitere E-Mail* mit Deinem Login.\n\nNach der Aktivierung kannst Du Deine Webseite hier besuchen:\n\n%2\$s", 'ub' );
			$new_blog_title      = _x( '[%1$s] Aktiviere %2$s', 'New site notification email subject', 'ub' );
			$new_sign_up_message = __( "Um Deinen Benutzer zu aktivieren, klicke bitte auf den folgenden Link:\n\n%s\n\nNach der Aktivierung erhältst Du *eine weitere E-Mail* mit Deinem Login.", 'ub' );
			$new_sign_up_title   = _x( '[%1$s] Aktiviere %2$s', 'New user notification email subject', 'ub' );
			$welcome_email       = __(
				'Hallo USERNAME,

Deine neue SITE_NAME-Webseite wurde erfolgreich eingerichtet unter:
BLOG_URL

Du kannst Dich mit den folgenden Informationen beim Administratorkonto anmelden:

Benutzername: USERNAME
Passwort: PASSWORD
Hier anmelden: BLOG_URLwp-login.php

Wir wünschen Dir viel Spaß mit Deiner neuen Webseite. Vielen Dank!

--Das Team @ SITE_NAME',
				'ub'
			);
			$options             = array(
				'wpmu_signup_blog_notification' => array(
					'title'       => __( 'Neuer Blog', 'ub' ),
					'description' => __( 'Sende eine benutzerdefinierte Kopie, wenn ein neuer Blog veröffentlicht wird.', 'ub' ),
					'fields'      => array(
						'status'  => array(
							'type'           => 'checkbox',
							'checkbox_label' => __( 'Passe die E-Mail-Benachrichtigung für neue Blogs an', 'ub' ),
							'options'        => array(
								'on'  => __( 'Ja', 'ub' ),
								'off' => __( 'Nein', 'ub' ),
							),
							'default'        => 'off',
							'classes'        => array( 'switch-button' ),
							'slave-class'    => 'wpmu_signup_blog_notification',
						),
						'title'   => array(
							'type'    => 'text',
							'label'   => __( 'Betreff', 'ub' ),
							'master'  => 'wpmu_signup_blog_notification',
							'default' => $new_blog_title,
							'group'   => array(
								'begin'   => true,
								'classes' => array( 'sui-border-frame' ),
							),
						),
						'message' => array(
							'type'    => 'textarea',
							'label'   => __( 'Email Inhalt', 'ub' ),
							'master'  => 'wpmu_signup_blog_notification',
							'default' => $new_blog_message,
						),
						'reset'   => $this->get_button_reset_array( 'wpmu_signup_blog_notification' ),
					),
				),
				'wpmu_signup_user_notification' => array(
					'title'       => __( 'Benutzeranmeldung', 'ub' ),
					'description' => __( 'Sende eine benutzerdefinierte Kopie, wenn sich ein Benutzer in Deinem Netzwerk anmeldet.', 'ub' ),
					'fields'      => array(
						'status'  => array(
							'type'           => 'checkbox',
							'checkbox_label' => __( 'Passe die Anmelde-E-Mail für neue Benutzer an', 'ub' ),
							'options'        => array(
								'on'  => __( 'Ja', 'ub' ),
								'off' => __( 'Nein', 'ub' ),
							),
							'default'        => 'off',
							'classes'        => array( 'switch-button' ),
							'slave-class'    => 'wpmu_signup_user_notification',
						),
						'title'   => array(
							'type'    => 'text',
							'label'   => __( 'Betreff', 'ub' ),
							'master'  => 'wpmu_signup_user_notification',
							'default' => $new_sign_up_title,
							'group'   => array(
								'begin'   => true,
								'classes' => array( 'sui-border-frame' ),
							),
						),
						'message' => array(
							'type'    => 'textarea',
							'label'   => __( 'Email Inhalt', 'ub' ),
							'master'  => 'wpmu_signup_user_notification',
							'default' => $new_sign_up_message,
						),
						'reset'   => $this->get_button_reset_array( 'wpmu_signup_user_notification' ),
					),
				),
				'wpmu_welcome_notification'     => array(
					'title'       => __( 'Seiten-Aktivierung', 'ub' ),
					'description' => __( 'Sende eine benutzerdefinierte Kopie, sobald eine neue Webseite in Deinem Netzwerk registriert ist.', 'ub' ),
					'fields'      => array(
						'status'  => array(
							'type'           => 'checkbox',
							'checkbox_label' => __( 'Passe die E-Mail zur Aktivierung neuer Webseiten an', 'ub' ),
							'options'        => array(
								'on'  => __( 'Ja', 'ub' ),
								'off' => __( 'Nein', 'ub' ),
							),
							'default'        => 'off',
							'classes'        => array( 'switch-button' ),
							'slave-class'    => 'wpmu_welcome_notification',
						),
						'title'   => array(
							'type'    => 'text',
							'label'   => __( 'Betreff', 'ub' ),
							'master'  => 'wpmu_welcome_notification',
							'default' => __( 'Neue %1$s Webseite: %2$s', 'ub' ),
							'group'   => array(
								'begin'   => true,
								'classes' => array( 'sui-border-frame' ),
							),
						),
						'message' => array(
							'type'    => 'textarea',
							'label'   => __( 'Email Inhalt', 'ub' ),
							'master'  => 'wpmu_welcome_notification',
							'default' => $welcome_email,
						),
						'reset'   => $this->get_button_reset_array( 'wpmu_welcome_notification' ),
					),
				),
			);
			/**
			 * change settings for single site
			 */
			if ( $this->is_network ) {
				/**
				 * handle settings
				 */
				$status = get_site_option( 'registration' );
				if ( 'none' === $status || 'user' === $status ) {
					$url    = network_admin_url( 'settings.php' );
					$notice = array(
						'type'  => 'description',
						'value' => PSToolkit_Helper::sui_notice(
							sprintf(
								__( 'Die Blog-Registrierung wurde deaktiviert. Klicke <a href="%s">hier</a>, um die Webseiten-Registrierung für Dein Netzwerk zu aktivieren.', 'ub' ),
								$url
							)
						),
					);
					$options['wpmu_signup_blog_notification']['fields'] = array( 'notice' => $notice );
				}
			}
			/**
			 * set users registration
			 */
			$options       = $this->set_users_can_register( $options );
			$this->options = $options;
		}

		/**
		 * Common reset button
		 *
		 * @since 1.0.0
		 */
		private function get_button_reset_array( $id ) {
			$args                   = $this->get_options_fields_reset( $id );
			$args['reset']['group'] = array(
				'end' => true,
			);
			return $args['reset'];
		}

		/**
		 * Reset section
		 *
		 * @since 1.0.0
		 */
		public function ajax_section_reset() {
			$id           = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$nonce_action = $this->get_nonce_action( $id, 'reset' );
			$this->check_input_data( $nonce_action, array( 'id' ) );
			$keys = array(
				'new'  => 'wpmu_signup_blog_notification',
				'site' => 'wpmu_welcome_notification',
				'user' => 'wpmu_signup_user_notification',
			);
			if ( isset( $keys[ $id ] ) ) {
				$this->delete_value( $keys[ $id ] );
				$uba     = pstoolkit_get_uba_object();
				$message = array(
					'type'    => 'success',
					'message' => sprintf( 'Der ausgewählte Abschnitt wurde zurückgesetzt.', 'ub' ),
				);
				$uba->add_message( $message );
				wp_send_json_success();
			}
			$this->json_error();
		}

		/**
		 * Set user registration is not allowed message
		 *
		 * @since 1.0.0
		 */
		private function set_users_can_register( $data ) {
			$is_open = $this->is_user_registration_open();
			if ( false === $is_open ) {
				return $data;
			}
			$data['wpmu_signup_user_notification']['fields'] = array( 'notice' => $this->get_users_can_register_notice() );
			return $data;
		}
	}
}
new PSToolkit_Registration_Emails();
