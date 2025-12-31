<?php
/**
 * PSToolkit Email Headers class.
 *
 * @package PSToolkit
 * @subpackage Emails
 */
if ( ! class_exists( 'PSToolkit_Email_Headers' ) ) {

	/**
	 * Class PSToolkit_Email_Headers
	 */
	class PSToolkit_Email_Headers extends PSToolkit_Helper {

		/**
		 * Module option name.
		 *
		 * @var string
		 */
		protected $option_name = 'ub_emails_headers';

		/**
		 * Constructor.
		 */
		public function __construct() {
			parent::__construct();
			$this->module = 'emails-headers';
			/**
			 * Register hooks.
			 */
			add_filter( 'pstoolkit_settings_emails_header', array( $this, 'admin_options_page' ) );
			add_filter( 'pstoolkit_settings_emails_header_process', array( $this, 'update' ), 10, 1 );
			add_filter( 'wp_mail_from', array( $this, 'from_email' ) );
			add_filter( 'wp_mail_from_name', array( $this, 'from_email_name' ) );
			add_action( 'init', array( $this, 'upgrade_options' ) );
			/**
			 * Add Reply To header
			 *
			 * @since 3.4
			 */
			add_action( 'phpmailer_init', array( $this, 'add_reply_to' ), 10, 1 );
		}

		/**
		 * Upgrade module data to new structure.
		 *
		 * @since 1.0.0
		 */
		public function upgrade_options() {
			$ub_from_email = pstoolkit_get_option( 'ub_from_email', false );
			$ub_from_name  = pstoolkit_get_option( 'ub_from_name', false );
			if (
				false === $ub_from_email
				&& false === $ub_from_name
			) {
				return;
			}
			$data = array(
				'headers' => array(
					'email' => $ub_from_email,
					'name'  => $ub_from_name,
				),
			);
			$this->update_value( $data );
			pstoolkit_delete_option( 'ub_from_email' );
			pstoolkit_delete_option( 'ub_from_name' );
		}

		/**
		 * Set module options for admin page.
		 *
		 * @since 1.0.0
		 */
		protected function set_options() {
			$options      = array(
				'headers'  => array(
					'title'       => __( 'Email von', 'ub' ),
					'description' => __( 'Wähl die Standard-Absender-E-Mail und den Absendernamen für alle ausgehenden ClassicPress-E-Mails.', 'ub' ),
					'fields'      => array(
						'email' => array(
							'label' => __( 'Absender-E-Mail-Adresse', 'ub' ),
							'type'  => 'email',
						),
						'name'  => array(
							'label' => __( 'Absender', 'ub' ),
						),
					),
				),
				'reply-to' => array(
					'title'       => __( 'Antwort an', 'ub' ),
					'description' => __( 'Wähle aus, ob Du "Antwort auf" im Header hinzufügen möchtest.', 'ub' ),
					'fields'      => array(
						'email' => array(
							'label' => __( 'Antwort an E-Mail-Adresse', 'ub' ),
							'type'  => 'email',
						),
						'name'  => array(
							'label'       => __( 'Antworte auf den Namen', 'ub' ),
							'type'        => 'text',
							'description' => array(
								'content'  => __( 'Hinweis: Um eine Antwort auf den Namen hinzuzufügen, solltest Du zuerst einen Wert für die Antwort auf die E-Mail-Adresse hinzufügen.', 'ub' ),
								'position' => 'bottom',
							),
							'disabled'    => true,
						),
					),
				),
			);
			$current_user = wp_get_current_user();
			if ( is_a( $current_user, 'WP_User' ) ) {
				$options['headers']['fields']['email']['placeholder']  = $current_user->user_email;
				$options['headers']['fields']['name']['placeholder']   = $current_user->display_name;
				$options['reply-to']['fields']['email']['placeholder'] = sprintf( __( 'z.B. %s', 'ub' ), $current_user->user_email );
				$options['reply-to']['fields']['name']['placeholder']  = sprintf( __( 'z.B. %s', 'ub' ), $current_user->display_name );
			}
			$this->options = $options;
		}

		/**
		 * Change email from address.
		 *
		 * @param string $email From email.
		 *
		 * @return mixed|null|string
		 */
		public function from_email( $email ) {
			$value = $this->get_value( 'headers', 'email' );
			if ( is_email( $value ) ) {
				return $value;
			}
			return $email;
		}

		/**
		 * Change email from name.
		 *
		 * @param string $from From name.
		 *
		 * @return mixed|null|string
		 */
		public function from_email_name( $from ) {
			$value = $this->get_value( 'headers', 'name' );
			if ( ! empty( $value ) ) {
				return $value;
			}
			return $from;
		}

		/**
		 * Set Reply To email header
		 *
		 * @since 3.4
		 */
		public function add_reply_to( $phpmailer ) {
			$reply_to_email = $this->get_value( 'reply-to', 'email' );
			if ( ! empty( $reply_to_email ) && is_email( $reply_to_email ) ) {
				$reply_to_name = $this->get_value( 'reply-to', 'name', '' );
				$phpmailer->addReplyTo( $reply_to_email, $reply_to_name );
			}
		}
	}
}
new PSToolkit_Email_Headers();
