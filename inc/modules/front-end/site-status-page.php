<?php
/**
 * PSToolkit Site Status Pages class.
 *
 * @package PSToolkit
 * @subpackage Front-end
 */
if ( ! class_exists( 'PSToolkit_Site_Status_Pages' ) ) {

	class PSToolkit_Site_Status_Pages extends PSToolkit_Helper {
		protected $option_name = 'ub_ms_site_check';
		private $is_ready      = false;
		private $is_ready_dir  = false;
		private $error_files   = array(
			'deleted'   => 'blog-deleted.php',
			// it do not works, WP do not set "deleted" to "2" (inactive).
			// 'inactive' => 'blog-inactive.php',
			'suspended' => 'blog-suspended.php',
		);
		private $db_error_dir;
		protected $file       = __FILE__;
		private $file_updated = false;

		public function __construct() {
			parent::__construct();
			$this->check();
			$this->module = 'ms-site-check';
			/**
			 * hooks
			 */
			add_filter( 'pstoolkit_settings_ms_site_check', array( $this, 'admin_options_page' ) );
			if ( $this->is_ready ) {
				add_filter( 'pstoolkit_settings_ms_site_check_process', array( $this, 'update' ), 10, 1 );
			}
			/**
			 * Regenerate file after value update.
			 *
			 * @since 3.1.0
			 */
			add_action( 'update_option_' . $this->option_name, array( $this, 'update_option_action' ), 10, 3 );
			add_action( 'update_site_option_' . $this->option_name, array( $this, 'update_site_option_action' ), 10, 4 );
			/**
			 * add related config
			 *
			 * @since 2.3.0
			 */
			add_filter( 'pstoolkit_related_modules', array( $this, 'add_related_background' ) );
			add_filter( 'pstoolkit_related_modules', array( $this, 'add_related_logo' ) );
			add_filter( 'pstoolkit_related_modules', array( $this, 'add_related_social_media_settings' ) );
			add_filter( 'pstoolkit_related_modules', array( $this, 'add_related_social_media' ) );
			/**
			 * upgrade options
			 *
			 * @since 1.0.0
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );

			/**
			 * Activate / Deactivate this module
			 *
			 * @since 3.3.1
			 */
			add_action( 'pstoolkit_module_activated', array( $this, 'module_activated' ) );
			add_action( 'pstoolkit_module_deactivated', array( $this, 'module_deactivated' ) );
		}

		/**
		 * Create error files if the relevant options already exist during activating the current module
		 *
		 * @param string $module
		 */
		public function module_activated( $module ) {
			if ( 'front-end/site-status-page.php' !== $module ) {
				return;
			}

			$value = $this->get_value();
			$this->update_files( $value );
		}

		/**
		 * Delete error files during deactivating the current module
		 *
		 * @param string $module
		 */
		public function module_deactivated( $module ) {
			if ( 'front-end/site-status-page.php' !== $module ) {
				return;
			}

			// Delete error files
			foreach ( $this->error_files as $f ) {
				$file = $this->db_error_dir . '/' . $f;
				if ( is_file( $file ) && is_writable( $file ) ) {
					unlink( $file );
				}
			}
		}

		/**
		 * Upgrade option
		 *
		 * @since 1.0.0
		 */
		public function upgrade_options() {
			$value = $this->get_value();
			/**
			 * Check we have plugin_version in saved data
			 */
			if ( isset( $value['plugin_version'] ) ) {
				/**
				 * do not run again big upgrade if config was saved by PSToolkit
				 */
				$version_compare = version_compare( $value['plugin_version'], '2.0.0' );
				if ( -1 < $version_compare ) {
					return;
				}
				return;
			}
			$data = array(
				'show'    => array(),
				'content' => array(),
				'design'  => array(),
				'colors'  => array(),
			);
			if ( isset( $value['show'] ) ) {
				$data['show'] = $value['show'];
			}
			/**
			 * Common migration
			 */
			$data = $this->common_upgrade_options( $data, $value );
			/**
			 * document_suspended
			 */
			if ( isset( $value['document_suspended'] ) ) {
				$v = $value['document_suspended'];
				if ( isset( $v['title'] ) ) {
					$data['content']['suspended_title'] = $v['title'];
				}
				if ( isset( $v['content'] ) ) {
					$data['content']['suspended_content'] = $v['content'];
				}
				if ( isset( $v['content_meta'] ) ) {
					$data['content']['suspended_content_meta'] = $v['content_meta'];
				}
			}
			/**
			 * document_deleted
			 */
			if ( isset( $value['document_deleted'] ) ) {
				$v = $value['document_deleted'];
				if ( isset( $v['title'] ) ) {
					$data['content']['deleted_title'] = $v['title'];
				}
				if ( isset( $v['content'] ) ) {
					$data['content']['deleted_content'] = $v['content'];
				}
				if ( isset( $v['content_meta'] ) ) {
					$data['content']['deleted_content_meta'] = $v['content_meta'];
				}
			}
			$this->update_value( $data );
			$this->update_files( $data );
		}

		/**
		 * Regenerate file after value update for single site.
		 *
		 * @since 3.1.0
		 */
		public function update_option_action( $old_value, $value, $option_name ) {
			$this->update_files( $value );
		}

		/**
		 * Regenerate file after value update for multisite.
		 *
		 * @since 3.1.0
		 */
		public function update_site_option_action( $option_name, $value, $old_value, $network_id ) {
			$this->update_files( $value );
		}

		/**
		 * Create or update `wp-content/blog-?.php` is possible.
		 *
		 * @since 2.0.0
		 */
		private function update_files( $value ) {
			if ( $this->file_updated ) {
				return false;
			}
			$this->file_updated = true;

			$this->data = $value;
			/**
			 * set data
			 */
			$template_master = $this->get_template();
			$classes         = array( 'pstoolkit-settings-ms-site-check' );
			foreach ( $this->error_files as $slug => $f ) {
				$file  = $this->db_error_dir . '/' . $f;
				$value = $this->get_value( 'show', $slug );
				if ( 'on' !== $value ) {
					if ( is_file( $file ) && is_writable( $file ) ) {
						unlink( $file );
					}
					continue;
				}
				$css            = '';
				$args           = array(
					'language'                       => get_bloginfo( 'language' ),
					'logo'                           => '',
					'content_deleted_title'          => '',
					'content_deleted_content_meta'   => '',
					'content_suspended_title'        => '',
					'content_suspended_content_meta' => '',
					'head'                           => '',
					'body_classes'                   => array(
						$this->get_name(),
						$slug,
					),
					'social_media'                   => '',
					'title'                          => get_bloginfo( 'name' ),
					'after_body_tag'                 => $this->html_background_common( false ),
				);
				$background_css = $this->css_background_common( 'body', false, false );
				$template       = $this->get_template_name( $slug );
				/**
				 * Common: Logo
				 */
				$logo_css = $this->css_logo_common( '#logo', false );
				if ( ! empty( $logo_css ) ) {
					$css         .= $logo_css;
					$args['logo'] = '<div id="logo">';
					$url          = $this->get_value( 'content', 'logo_url' );
					if ( ! empty( $url ) ) {
						$alt           = $this->get_value( 'content', 'logo_alt', '' );
						$args['logo'] .= sprintf(
							'<a href="%s" title="%s">%s</a>',
							esc_url( $url ),
							esc_attr( $alt ),
							esc_html( $alt )
						);
					}
					$args['logo'] .= '</div>';
				}
				/**
				 * Common: Social Media
				 */
				$css_dependencies = array();
				$result           = $this->common_options_social_media( $slug );
				if ( ! empty( $result['social_media'] ) ) {
					$args['social_media'] = sprintf(
						'<div id="social">%s</div>',
						$result['social_media']
					);
					$args['body_classes'] = array_merge( $args['body_classes'], $result['body_classes'] );
					$css_dependencies[]   = $result['stylesheet'];
				}
				/**
				 * BODY
				 */
				$css .= $this->common_body_css();
				/**
				 * .page
				 */
				$css .= $this->common_document_css( '.page' );
				/**
				 * h1
				 */
				$value = $this->get_value( 'colors', 'message_title' );
				$css  .= sprintf( '.page h1{%s}', $this->css_color( $value ) );
				/**
				 * content
				 */
				$value = $this->get_value( 'colors', 'message_description' );
				$css  .= sprintf( '.page .content{%s}', $this->css_color( $value ) );
				/**
				 * Custom CSS
				 *
				 * @since 1.0.0
				 */
				$value = $this->get_value( 'css', 'css', null );
				if ( ! empty( $value ) ) {
					$css .= $value;
				}
				/**
				 * replace
				 */
				foreach ( $this->data as $section => $data ) {
					if ( ! is_array( $data ) ) {
						continue;
					}
					foreach ( $data as $name => $value ) {
						if ( empty( $value ) ) {
							$value = '';
						}
						if ( ! is_string( $value ) ) {
							$value = '';
						}
						if ( ! empty( $value ) ) {
							switch ( $section ) {
								case 'content':
									switch ( $name ) {
										case 'suspended_title':
										case 'deleted_title':
											$value = sprintf( '<h1>%s</h1>', esc_html( $value ) );
											break;
										case 'suspended_content_meta':
										case 'deleted_content_meta':
											$value = sprintf( '<div class="content">%s</div>', $value );
											break;
										default:
											break;
									}
									break;
								default:
									break;
							}
						}
						$re          = sprintf( '%s_%s', $section, $name );
						$args[ $re ] = $value;
					}
				}

				$css_file_handle = "ub-ms-{$slug}-styling";
				$this->enqueue( $css_file_handle, 'css/ms-site-check.css', $this->build, $css_dependencies );
				$args['styles'] = $css_file_handle;
				wp_add_inline_style( $css_file_handle, $background_css );
				wp_add_inline_style( $css_file_handle, $css );

				$content = $this->render( $template, $args, true );
				/**
				 * write
				 */
				$result = file_put_contents( $file, $content );
			}
		}

		/**
		 * Check that create od file is possible.
		 *
		 * @since 2.0.0
		 */
		private function check() {
			$this->db_error_dir  = dirname( get_theme_root() );
			$this->db_error_file = $this->db_error_dir . '/db-error.php';
			if ( ! is_dir( $this->db_error_dir ) || ! is_writable( $this->db_error_dir ) ) {
				return;
			}
			$this->is_ready_dir = true;
			$this->is_ready     = true;
		}

		/**
		 * Set options
		 *
		 * @since 2.0.0
		 */
		protected function set_options() {
			if ( ! $this->is_ready ) {
				$value = __( 'Hoppla! Etwas ist schief gelaufen.', 'ub' );
				if ( false == $this->is_ready_dir ) {
					$value = sprintf(
						__( 'Verzeichnis %s ist nicht beschreibbar, wir können keine Dateien erstellen.', 'ub' ),
						sprintf( '<code>%s</code>', $this->db_error_dir )
					);
				}
				$options       = array(
					'settings' => array(
						'hide-reset' => true,
						'title'      => __( 'Benutzerdefinierte Webseiten', 'ub' ),
						'fields'     => array(
							'message' => array(
								'type'    => 'description',
								'label'   => __( 'Fehler', 'ub' ),
								'value'   => $value,
								'classes' => array( 'message', 'message-error' ),
							),
						),
					),
				);
				$this->options = $options;
			}
			/**
			 * options
			 */
			$options = array(
				'show'    => array(
					'title'       => __( 'Modes', 'ub' ),
					'description' => __( 'Aktiviere die benutzerdefinierten Fehlerseiten für Webseiten in Deinem Netzwerk mit mehreren Webseiten, die angehalten oder gelöscht wurden.', 'ub' ),
					'fields'      => array(
						'suspended' => array(
							'type'        => 'sui-tab',
							'label'       => __( 'Angehalten/Archiviert', 'ub' ),
							'description' => __( 'Aktiviere eine benutzerdefinierte Fehlerseite für Webseiten, die in Deinem Netzwerk angehalten oder archiviert wurden.', 'ub' ),
							'options'     => array(
								'on'  => __( 'Aktivieren', 'ub' ),
								'off' => __( 'Deaktivieren', 'ub' ),
							),
							'default'     => 'off',
						),
						'deleted'   => array(
							'type'        => 'sui-tab',
							'label'       => __( 'Gelöscht', 'ub' ),
							'description' => __( 'Aktiviere eine benutzerdefinierte Fehlerseite für Webseiten, die in Deinem Netzwerk gelöscht wurden.', 'ub' ),
							'options'     => array(
								'on'  => __( 'Aktivieren', 'ub' ),
								'off' => __( 'Deaktivieren', 'ub' ),
							),
							'default'     => 'off',
						),
					),
				),
				'preview' => array(
					'title'       => __( 'Vorschau', 'ub' ),
					'description' => __( 'Hier kannst Du eine Vorschau Deiner benutzerdefinierten Fehlerseite anzeigen. Beachte dass die Vorschau beim Speichern Deiner Änderungen ständig aktualisiert wird.', 'ub' ),
					'fields'      => array(
						'suspended' => array(
							'type'    => 'link',
							'href'    => content_url( 'blog-suspended.php' ),
							'value'   => __( 'Angehalten/Archiviert', 'ub' ),
							'icon'    => 'eye',
							'classes' => array(
								'sui-button',
								$this->get_name( 'preview' ),
							),
							'target'  => $this->get_name( 'suspended' ),
						),
						'deleted'   => array(
							'type'    => 'link',
							'href'    => content_url( 'blog-deleted.php' ),
							'value'   => __( 'Gelöscht', 'ub' ),
							'icon'    => 'eye',
							'classes' => array(
								'sui-button',
								$this->get_name( 'preview' ),
							),
							'target'  => $this->get_name( 'deleted' ),
						),
					),
				),
				'content' => array(
					'title'       => __( 'Inhalt', 'ub' ),
					'description' => __( 'Passe den Standardinhalt Deiner Fehlerseiten an.', 'ub' ),
					'show-as'     => 'accordion',
					'fields'      => $this->get_options_fields( 'content', array( 'logo', 'content', 'social', 'reset' ) ),
				),
				'design'  => array(
					'title'       => __( 'Design', 'ub' ),
					'description' => __( 'Passe den Standardinhalt Deiner Fehlerseiten an.', 'ub' ),
					'show-as'     => 'accordion',
					'fields'      => $this->get_options_fields( 'design', array( 'logo', 'background', 'social', 'document', 'reset' ) ),
				),
				'colors'  => array(
					'title'       => __( 'Farben', 'ub' ),
					'description' => __( 'Passe die Standardfarbkombinationen nach Deinen Wünschen an.', 'ub' ),
					'show-as'     => 'accordion',
					'fields'      => $this->get_options_fields( 'colors', array( 'logo', 'error_message', 'document', 'reset' ) ),
				),
				/**
				 * Custom CSS
				 *
				 * @since 1.0.0
				 */
				'css'     => $this->get_custom_css_array(),
			);
			/**
			 * Check files
			 */
			foreach ( $this->error_files as $id => $file ) {
				$file = WP_CONTENT_DIR . '/' . $file;
				if ( is_file( $file ) && is_readable( $file ) ) {
					continue;
				}

				// Show an error when file is not available
				$mode_label               = empty( $options['preview']['fields'][ $id ]['value'] )
					? ''
					: $options['preview']['fields'][ $id ]['value'];
				$mode_preview_unavailable = empty( $mode_label )
					? esc_html__( 'Vorschau ist nicht verfügbar. Speichere zuerst die Einstellungen!', 'ub' )
					: sprintf( esc_html__( '%s Vorschau ist nicht verfügbar. Speichere zuerst die Einstellungen!', 'ub' ), $mode_label );

				$options['preview']['fields'][ $id ] = array(
					'type'  => 'description',
					'value' => PSToolkit_Helper::sui_notice( $mode_preview_unavailable, 'info' ),
				);
			}
			$this->options = $options;
		}

		/**
		 * Options: Content
		 *
		 * @since 1.0.0
		 */
		public function get_options_fields_content_content( $defaults = array() ) {
			$data = array(
				'suspended_title'   => array(
					'label'     => __( 'Titel (optional)', 'ub' ),
					'default'   => __( 'Diese Seite wurde archiviert oder ausgesetzt.', 'ub' ),
					'accordion' => array(
						'begin' => true,
						'title' => __( 'Fehlermeldung', 'ub' ),
						'item'  => array(
							'classes' => array(
								$this->get_name( 'error_message' ),
							),
						),
					),
					'group'     => array(
						'begin' => true,
					),
					'panes'     => array(
						'begin'      => true,
						'title'      => __( 'Archiviert/Ausgesetzt', 'ub' ),
						'begin_pane' => true,
					),
				),
				'suspended_content' => array(
					'type'        => 'wp_editor',
					'label'       => __( 'Inhalt (optional)', 'ub' ),
					'placeholder' => esc_html__( 'Hier kannst Du eine Beschreibung für die Seite schreiben...', 'ub' ),
					'panes'       => array(
						'end_pane' => true,
					),
				),
				'deleted_title'     => array(
					'label'   => __( 'Titel (optional)', 'ub' ),
					'default' => __( 'Diese Seite wurde archiviert oder gelöscht.', 'ub' ),
					'panes'   => array(
						'title'      => __( 'Gelöscht', 'ub' ),
						'begin_pane' => true,
					),
				),
				'deleted_content'   => array(
					'type'        => 'wp_editor',
					'label'       => __( 'Inhalt (optional)', 'ub' ),
					'placeholder' => esc_html__( 'Hier kannst Du eine Beschreibung für die Seite schreiben...', 'ub' ),
					'accordion'   => array(
						'end' => true,
					),
					'group'       => array(
						'end' => true,
					),
					'panes'       => array(
						'end_pane' => true,
						'end'      => true,
					),
				),
			);
			/**
			 * Allow to change content logo fields.
			 *
			 * @since 1.0.0
			 *
			 * @param array $data logo options data.
			 * @param array $defaults Default values from function.
			 * @param string Current module name.
			 */
			return apply_filters( 'pstoolkit_' . __FUNCTION__, $data, $defaults, $this->module );
		}

		/**
		 * Override Common Options: Colors -> Error Message
		 *
		 * @since 1.0.0
		 */
		protected function get_options_fields_colors_error_message( $defaults = array() ) {
			$data = array(
				'message_title'       => array(
					'type'      => 'color',
					'label'     => __( 'Titel', 'ub' ),
					'accordion' => array(
						'begin' => true,
						'title' => __( 'Fehlermeldung', 'ub' ),
					),
					'default'   => esc_attr( isset( $defaults['document_color'] ) ? $defaults['document_color'] : '#000000' ),
				),
				'message_description' => array(
					'type'      => 'color',
					'label'     => __( 'Inhalt', 'ub' ),
					'accordion' => array(
						'end' => true,
					),
					'default'   => esc_attr( isset( $defaults['document_background'] ) ? $defaults['document_background'] : '#888888' ),
				),
			);
			/**
			 * Allow to change fields.
			 *
			 * @since 1.0.0
			 *
			 * @param array $data Options data.
			 * @param array $defaults Default values from function.
			 * @param string Current module name.
			 */
			return apply_filters( 'pstoolkit_' . __FUNCTION__, $data, $defaults, $this->module );
		}
	}
}
new PSToolkit_Site_Status_Pages();
