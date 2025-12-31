<?php
/**
 * PSToolkit Data class.
 *
 * Class that handle Settings functionality.
 *
 * @since 1.0.0
 *
 * @package PSToolkit
 * @subpackage Settings
 */
if ( ! class_exists( 'PSToolkit_Data' ) ) {

	/**
	 * Class PSToolkit_Data.
	 */
	class PSToolkit_Data extends PSToolkit_Helper {

		/**
		 * Option name
		 *
		 * @since 1.0.0
		 */
		protected $option_name = 'ub_data';

		/**
		 * PSToolkit_Data constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			parent::__construct();
			$this->module = 'data';
			/**
			 * PSToolkit Admin Class actions
			 *
			 * @since 3.0,0
			 */
			add_filter( 'pstoolkit_settings_data', array( $this, 'admin_options_page' ) );
			add_filter( 'pstoolkit_settings_data_process', array( $this, 'update' ) );
			/**
			 * Add custom content title
			 *
			 * @since 3.0,0
			 */
			add_filter( 'pstoolkit_before_module_form', array( $this, 'add_title_before_form' ), 10, 2 );
			/**
			 * Change bottom save button params
			 *
			 * @since 3.0,0
			 */
			add_filter( 'pstoolkit_after_form_save_button_args', array( $this, 'change_bottom_save_button' ), 10, 2 );
			/**
			 * Add dialog
			 *
			 * @since 3.0,0
			 */
			add_filter( 'pstoolkit_get_module_content', array( $this, 'add_dialog' ), 10, 2 );
			/**
			 * Handla AJAX actions
			 *
			 * @since 1.0.0
			 */
			add_action( 'wp_ajax_pstoolkit_data_reset', array( $this, 'ajax_reset' ) );
			add_action( 'wp_ajax_pstoolkit_data_delete_subsites', array( $this, 'ajax_delete_subsites_data' ) );
			/**
			 * handle uninstall
			 */
			add_action( 'pstoolkit_uninstall_plugin', array( $this, 'uninstall_plugin' ) );
		}

		/**
		 * Build form with options.
		 *
		 * @since 1.0.0
		 */
		protected function set_options() {
			$options = array(
				'uninstallation' => array(
					'title'       => __( 'Deinstallation', 'ub' ),
					'description' => __( 'Was möchtest Du mit Deinen Einstellungen und gespeicherten Daten tun, wenn Du dieses Plugin deinstallierst?', 'ub' ),
					'fields'      => array(
						'settings' => array(
							'label'       => __( 'Einstellungen', 'ub' ),
							'description' => __( 'Wähle ob Du Deine Einstellungen für das nächste Mal speichern oder zurücksetzen möchtest.', 'ub' ),
							'type'        => 'sui-tab',
							'options'     => array(
								'preserve' => __( 'Erhalten', 'ub' ),
								'reset'    => __( 'Zurücksetzen', 'ub' ),
							),
							'default'     => 'preserve',
						),
						'data'     => array(
							'label'       => __( 'Daten', 'ub' ),
							'description' => __( 'Wähle aus, ob Protokolldaten beibehalten oder entfernt werden sollen.', 'ub' ),
							'type'        => 'sui-tab',
							'options'     => array(
								'keep'   => __( 'Behalten', 'ub' ),
								'remove' => __( 'Entfernen', 'ub' ),
							),
							'default'     => 'keep',
							'after'       => PSToolkit_Helper::sui_notice(
								__( 'Diese Option wirkt sich nur auf die Daten der Hauptwebseite aus. Wenn Du Daten der Unterwebseiten löschen möchtest, bevor Du das Plugin deinstallierst, verwende bitte die folgende Einstellung.', 'ub' ),
								'default'
							),
						),
					),
				),
				'subsites'       => array(
					'title'       => __( 'Unterwebseiten', 'ub' ),
					'description' => __( 'Verwalte hier die in jeder Unterwebseite gespeicherten Daten.', 'ub' ),
					'fields'      => array(
						'button' => array(
							'label'       => __( 'Daten löschen', 'ub' ),
							'type'        => 'button',
							'value'       => __( 'Unterwebseiten löschen', 'ub' ),
							'sui'         => array( 'red', 'ghost' ),
							'description' => __( 'Möchtest Du die Daten aller Unterwebsites löschen? Verwende diese Option, um Daten von allen Unterwebseiten manuell zu löschen.', 'ub' ),
							'data'        => array(
								'modal-open' => $this->get_name( 'confirm-delete-subsites' ),
								'modal-mask' => 'true',
							),
							'before'      => sprintf( '<div id="%s">', $this->get_name( 'delete-subsites-container' ) ),
							'after'       => '</div>',
						),
					),
				),
				'reset'          => array(
					'title'       => __( 'Einstellungen zurücksetzen', 'ub' ),
					'description' => __( 'Musst Du neu anfangen? Verwende diese Schaltfläche, um zu den Standardeinstellungen zurückzukehren.', 'ub' ),
					'fields'      => array(
						'button' => array(
							'type'        => 'button',
							'value'       => __( 'Zurücksetzen', 'ub' ),
							'icon'        => 'undo',
							'sui'         => 'ghost',
							'description' => array(
								'content'  => __( 'Hinweis: Dadurch werden alle Einstellungen sofort auf ihren Standardzustand zurückgesetzt, Deine Daten bleiben jedoch erhalten.', 'ub' ),
								'position' => 'bottom',
							),
							'data'        => array(
								'modal-open' => $this->get_name( 'confirm-reset' ),
								'modal-mask' => 'true',
							),
						),
					),
				),
			);
			/**
			 * remove some options from single site install
			 */
			if ( $this->is_network && ! is_network_admin() ) {
				unset( $options['uninstallation'] );
			}
			if ( ! $this->is_network || ! is_network_admin() ) {
				unset( $options['subsites'] );
				unset( $options['uninstallation']['fields']['data']['after'] );
			}
			$this->options = $options;
		}

		/**
		 * Add title before form.
		 *
		 * @since 1.0.0
		 *
		 * @param string $content Current content.
		 * @param array  $module Current module.
		 */
		public function add_title_before_form( $content, $module ) {
			if ( $this->module !== $module['module'] ) {
				return $content;
			}
			$template    = $this->get_template_name( 'header' );
			$description = ! $this->is_network || $this->is_network_admin
				? esc_html__( 'Steuere was mit Deinen Einstellungen und Daten geschehen soll. Einstellungen werden als Modulkonfigurationen betrachtet. Daten umfassen die vorübergehenden Bits wie Protokolle, häufig verwendete Module, die letzte Import-/Exportzeit und andere Informationen, die im Laufe der Zeit gespeichert werden.', 'ub' )
				: esc_html__( 'Steuere was mit Deinen Einstellungen geschehen soll.', 'ub' );

			$content .= $this->render( $template, array( 'description' => $description ), true );
			return $content;
		}

		/**
		 * Add SUI dialog
		 *
		 * @since 1.0.0
		 *
		 * @param string $content Current module content.
		 * @param array  $module Current module.
		 */
		public function add_dialog( $content, $module ) {
			if ( $this->module !== $module['module'] ) {
				return $content;
			}
			/**
			 * Dialog Reset
			 */
			$args = array(
				'dialog_id' => $this->get_name( 'confirm-reset' ),
				'nonce'     => $this->get_nonce_value( 'reset' ),
				'blog_id'   => 0,
			);
			if ( $this->is_network && ! is_network_admin() ) {
				$blog_id         = get_current_blog_id();
				$args['nonce']   = $this->get_nonce_value( 'reset', $blog_id );
				$args['blog_id'] = $blog_id;
			}
			$template = $this->get_template_name( 'dialogs/confirm-reset' );
			$content .= $this->render( $template, $args, true );
			/**
			 * Dialog settings
			 */
			$args = array(
				'dialog_id'    => $this->get_name( 'confirm-delete-subsites' ),
				'button_nonce' => $this->get_nonce_value( 'delete-subsites' ),
				'button_class' => $this->get_name( 'delete-subsites' ),
			);
			/**
			 * values
			 */
			$template = $this->get_template_name( 'dialogs/confirm-delete-subsites' );
			$content .= $this->render( $template, $args, true );
			return $content;
		}

		/**
		 * AJAX: reset item
		 *
		 * @since 1.0.0
		 */
		public function ajax_reset() {
			$blog_id      = intval( filter_input( INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT ) );
			$nonce_action = $this->get_nonce_action( 'reset' );
			if ( 0 < $blog_id ) {
				$nonce_action = $this->get_nonce_action( 'reset', $blog_id );
			}
			$this->check_input_data( $nonce_action );
			if ( 0 < $blog_id ) {
				$result = $this->reset_subsite( $blog_id );
				if ( is_wp_error( $result ) ) {
					$message = array(
						'message' => $result->get_error_message(),
					);
					wp_send_json_error( $message );
				}
			} else {
				/**
				 * reset
				 */
				$result = $this->delete_all_plugin_data( true );
				if ( is_wp_error( $result ) ) {
					$message = array(
						'message' => $result->get_error_message(),
					);
					wp_send_json_error( $message );
				}
			}
			$url = add_query_arg( 'page', 'branding', network_admin_url( 'admin.php' ) );
			if ( 0 < $blog_id ) {
				$url = add_query_arg( 'page', 'branding', admin_url( 'admin.php' ) );
			}
			wp_send_json_success(
				array(
					'url' => $url,
				)
			);
		}

		/**
		 * Delete all plugin options!
		 */
		private function delete_all_plugin_data( $delete_settings_too = false, $blog_id = false ) {
			$variables = $this->get_variables( $delete_settings_too );
			if ( is_wp_error( $variables ) ) {
				return $variables;
			}
			foreach ( $variables as $key ) {
				if ( 'ub_stats' === $key ) {
					continue;
				}
				if ( false === $blog_id ) {
					delete_option( $key );
				} else {
					delete_blog_option( $blog_id, $key );
				}
				delete_site_option( $key );
			}
			/**
			 * delete_all_plugin_data
			 */
			if ( $delete_settings_too ) {
				$this->delete_settings( $blog_id );
			}
			return true;
		}

		private function delete_settings( $blog_id ) {
			if ( false !== $blog_id ) {
				switch_to_blog( $blog_id );
			}

			// Remove admin_panel_tip CPT.
			$posts = get_posts(
				array(
					'post_type'   => 'admin_panel_tip',
					'numberposts' => -1,
				)
			);
			foreach ( $posts as $post ) {
				wp_delete_post( $post->ID, true );
			}
			// Remove all relevant usermeta.
			delete_metadata( 'user', 0, 'show_welcome_dialog', '', true );
			delete_metadata( 'user', 0, 'tips_dismissed', '', true );
			delete_metadata( 'user', 0, 'show_tips', '', true );
			delete_metadata( 'user', 0, 'PSToolkit_Cookie_Notice', '', true );

			if ( false !== $blog_id ) {
				restore_current_blog();
			}
		}

		/**
		 * handle uninstall plugin
		 *
		 * @since 1.0.0
		 */
		public function uninstall_plugin() {
			/**
			 * Get data in old way, plugin is not installed, we can not check
			 * how it is installed
			 */
			$this->data = get_site_option( $this->option_name );
			if ( empty( $this->data ) ) {
				$this->data = get_option( $this->option_name );
			}
			$this->set_data();
			$value = $this->get_value( 'uninstallation', 'settings', 'preserve' );
			if ( 'reset' === $value ) {
				$value               = $this->get_value( 'uninstallation', 'data', 'keep' );
				$delete_settings_too = 'remove' === $value;
				$this->delete_all_plugin_data( $delete_settings_too );
			}
			$value = $this->get_value( 'uninstallation', 'data', 'keep' );
			if ( 'remove' === $value ) {
				delete_site_option( 'ub_stats' );
			}
		}

		/**
		 * AJAX to delete data from all subsites, site by site.
		 *
		 * @since 1.0.0
		 */
		public function ajax_delete_subsites_data() {
			if ( ! function_exists( 'get_sites' ) ) {
				$this->json_error();
			}
			$html   = '';
			$args   = array();
			$offset = intval( filter_input( INPUT_POST, 'offset', FILTER_SANITIZE_NUMBER_INT ) );
			if ( 0 === $offset ) {
				$nonce_action = $this->get_nonce_action( 'delete-subsites' );
				$this->check_input_data( $nonce_action );
				$template = $this->get_template_name( 'progress-bar' );
				$html     = $this->render( $template, array(), true );
			} else {
				$nonce_action = $this->get_nonce_action( 'delete-subsites', $offset );
				$this->check_input_data( $nonce_action );
			}
			/**
			 * Count
			 */
			$get_sites_args = array(
				'count' => true,
			);
			$count          = get_sites( $get_sites_args );
			/**
			 * get ids
			 */
			$get_sites_args = array(
				'number' => 1,
				'offset' => $offset,
				'fields' => 'ids',
			);
			$site           = get_sites( $get_sites_args );
			if ( empty( $site ) ) {
				$html  = sprintf(
					'<span class="sui-description">%s</span>',
					esc_html( 'Möchtest Du die Daten aller Unterwebseiten löschen? Verwende diese Option, um Daten von allen Unterwebseiten manuell zu löschen.', 'ub' )
				);
				$html .= PSToolkit_Helper::sui_notice( __( 'Daten von allen Unterwebseiten erfolgreich gelöscht.', 'ub' ), 'success' );
				$args  = array(
					'offset' => 'end',
					'html'   => $html,
				);
				wp_send_json_success( $args );
			}
			$site_id = array_shift( $site );
			$offset++;
			$args = array(
				'offset'   => $offset,
				'nonce'    => $this->get_nonce_value( 'delete-subsites', $offset ),
				'html'     => $html,
				'progress' => intval( ( 100 * $offset ) / $count ),
				'state'    => '',
			);
			/**
			 * Skip main site
			 */
			if ( is_main_site( $site_id ) ) {
				wp_send_json_success( $args );
			}
			/**
			 * Do Magic with subsite!
			 */
			$this->delete_all_plugin_data( true, $site_id );
			/**
			 * send return data
			 */
			$site          = get_blog_details( $site_id );
			$args['state'] = sprintf(
				__( 'Daten von %s löschen', 'ub' ),
				$this->bold( $site->blogname )
			);
			wp_send_json_success( $args );
		}

		/**
		 * reset subsite
		 *
		 * @since 3.2.0
		 */
		private function reset_subsite( $blog_id ) {
			switch_to_blog( $blog_id );
			$variables = $this->get_variables( true );
			if ( is_wp_error( $variables ) ) {
				return $variables;
			}
			foreach ( $variables as $key ) {
				delete_option( $key );
			}
			$this->delete_settings( $blog_id );
			return true;
		}

		/**
		 * Get variables
		 *
		 * @since 3.2.0
		 */
		private function get_variables( $delete_settings_too ) {
			$variables = array();
			if ( $delete_settings_too ) {
				$variables = array(
					'pstoolkit_db_version',
					'pstoolkit_activated_modules',
					'pstoolkit_delete_settings',
					'pstoolkit_messages',
				);
			}
			$contfiguration = $this->uba->get_configuration();
			if ( empty( $contfiguration ) || ! is_array( $contfiguration ) ) {
				return new WP_Error( 'error', __( 'Ups... Fehlende Konfiguration...', 'ub' ) );
			}
			foreach ( $contfiguration as $module ) {
				if ( isset( $module['options'] ) ) {
					$variables = array_merge( $variables, $module['options'] );
				}
			}
			$variables = array_filter( $variables );
			return $variables;
		}
	}
}
new PSToolkit_Data();
