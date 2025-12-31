<?php
/**
 * PSToolkit Document class.
 *
 * @since 2.3.0
 *
 * @package PSToolkit
 * @subpackage Front-end
 */
if ( ! class_exists( 'PSToolkit_Document' ) ) {
	class PSToolkit_Document extends PSToolkit_Helper {

		protected $option_name = 'ub_document';

		public function __construct() {
			parent::__construct();
			$this->module = 'document';
			/**
			 * UB admin actions
			 */
			add_filter( 'pstoolkit_settings_document', array( $this, 'admin_options_page' ) );
			add_filter( 'pstoolkit_settings_document_process', array( $this, 'update' ) );
			/**
			 * front end
			 */
			add_filter( 'the_content', array( $this, 'the_content' ), PHP_INT_MAX );
			add_filter( 'shortcode_atts_gallery', array( $this, 'shortcode_atts_gallery' ), PHP_INT_MAX, 4 );
			/**
			 * Password Protected Form
			 *
			 * @since 3.2.0
			 */
			add_filter( 'the_password_form', array( $this, 'password_form' ) );
			/**
			 * Password Protected Title
			 *
			 * @since 3.2.0
			 */
			add_filter( 'protected_title_format', array( $this, 'protected_title_format' ) );
			/**
			 * Upgrade options
			 */
			add_action( 'init', array( $this, 'upgrade_options' ) );
		}
		/**
		 * Upgrade options to new.
		 *
		 * @since 1.0.0
		 */
		public function upgrade_options() {
			$value = $this->get_value( 'configuration' );
			if ( empty( $value ) ) {
				return;
			}
			$data  = array(
				'content'           => array(),
				'shortcode_gallery' => $this->get_value( 'shortcode_gallery' ),
			);
			$value = $this->get_value( 'configuration', 'entry_header', 'off' );
			if ( 'on' === $value ) {
				$data['content']['entry_header']              = 'on';
				$data['content']['entry_header_content']      = $this->get_value( 'entry_header', 'content' );
				$data['content']['entry_header_content_meta'] = $this->get_value( 'entry_header', 'content_meta' );
			}
			$value = $this->get_value( 'configuration', 'entry_footer', 'off' );
			if ( 'on' === $value ) {
				$data['content']['entry_footer']              = 'on';
				$data['content']['entry_footer_content']      = $this->get_value( 'entry_footer', 'content' );
				$data['content']['entry_footer_content_meta'] = $this->get_value( 'entry_footer', 'content_meta' );
			}
			$this->update_value( $data );
		}

		/**
		 * change entry content
		 *
		 * @since 2.3.0
		 */
		public function the_content( $content ) {
			/**
			 * do not change on entries lists
			 */
			if ( ! is_singular() ) {
				return $content;
			}
			/**
			 * entry header
			 */
			$value = $this->get_value( 'content', 'entry_header', 'off' );
			if ( 'on' === $value ) {
				$value   = $this->get_value( 'content', 'entry_header_content_meta', '' );
				$content = $value . $content;
			}
			/**
			 * entry footer
			 */
			$value = $this->get_value( 'content', 'entry_footer', 'off' );
			if ( 'on' === $value ) {
				$value    = $this->get_value( 'content', 'entry_footer_content_meta', '' );
				$content .= $value;
			}
			return $content;
		}

		/**
		 * change shortcode gallery attributes
		 *
		 * @since 2.3.0
		 */
		public function shortcode_atts_gallery( $out, $pairs, $atts, $shortcode ) {
			$values = $this->get_value( 'shortcode_gallery' );
			if ( empty( $values ) || ! is_array( $values ) ) {
				return $out;
			}
			foreach ( $values as $key => $value ) {
				if ( 'do-not-change' === $value ) {
					continue;
				}
				/**
				 * exception for link
				 */
				if ( 'link' === $key && 'attachment' === $value ) {
					$value = '';
				}
				$out[ $key ] = $value;
			}
			return $out;
		}

		/**
		 * set options
		 *
		 * @since 2.3.0
		 */
		protected function set_options() {
			$data = array(
				'content'           => array(
					'title'   => __( 'Eintragsinhalt', 'ub' ),
					'show-as' => 'accordion',
					'fields'  => array(
						'entry_header_content' => array(
							'type'         => 'wp_editor',
							'label'        => __( 'Inhalt', 'ub' ),
							'display'      => 'sui-tab-content',
							'master'       => $this->get_name( 'header' ),
							'master-value' => 'on',
							'accordion'    => array(
								'begin' => true,
								'title' => __( 'Vor dem Eintrag Inhalt', 'ub' ),
							),
							'placeholder'  => esc_html__( 'Gib hier Deinen vorherigen Inhalt ein...', 'ub' ),
						),
						'entry_header'         => array(
							'type'        => 'sui-tab',
							'options'     => array(
								'off' => __( 'Deaktivieren', 'ub' ),
								'on'  => __( 'Aktivieren', 'ub' ),
							),
							'default'     => 'off',
							'slave-class' => $this->get_name( 'header' ),
							'accordion'   => array(
								'end' => true,
							),
						),
						'entry_footer_content' => array(
							'type'         => 'wp_editor',
							'label'        => __( 'Inhalt', 'ub' ),
							'display'      => 'sui-tab-content',
							'master'       => $this->get_name( 'footer' ),
							'master-value' => 'on',
							'accordion'    => array(
								'begin' => true,
								'title' => __( 'Nach dem Eintrag Inhalt', 'ub' ),
							),
							'placeholder'  => esc_html__( 'Gib hier Deinen Nach dem Eintrag-Inhalt ein…', 'ub' ),
						),
						'entry_footer'         => array(
							'type'        => 'sui-tab',
							'options'     => array(
								'off' => __( 'Deaktivieren', 'ub' ),
								'on'  => __( 'Aktivieren', 'ub' ),
							),
							'default'     => 'off',
							'slave-class' => $this->get_name( 'footer' ),
							'accordion'   => array(
								'end' => true,
							),
						),
					),
				),
				'protected'         => array(
					'title'       => __( 'Passwortgeschützt', 'ub' ),
					'description' => __( 'Ändere die Meldung, die für kennwortgeschützte Inhalte angezeigt wird.', 'ub' ),
					'show-as'     => 'accordion',
					'fields'      => array(
						'title_format' => array(
							'display'      => 'sui-tab-content',
							'label'        => __( 'Format', 'ub' ),
							'default'      => __( 'Geschützt: %s', 'ub' ),
							'accordion'    => array(
								'begin' => true,
								'title' => __( 'Titel', 'ub' ),
							),
							'master'       => $this->get_name( 'title-status' ),
							'master-value' => 'custom',
						),
						'title_status' => array(
							'type'        => 'sui-tab',
							'options'     => array(
								'default' => __( 'Standard', 'ub' ),
								'clear'   => __( 'Leeren', 'ub' ),
								'custom'  => __( 'Benutzerdefiniert', 'ub' ),
							),
							'default'     => 'default',
							'slave-class' => $this->get_name( 'title-status' ),
							'accordion'   => array(
								'end' => true,
							),
						),
						'form_message' => array(
							'display'      => 'sui-tab-content',
							'label'        => __( 'Nachricht', 'ub' ),
							'default'      => __( 'Dieser Inhalt ist Passwortgeschützt. Um es anzuzeigen, gib bitte Dein Passwort unten ein:', 'ub' ),
							'accordion'    => array(
								'begin' => true,
								'title' => __( 'Formular', 'ub' ),
							),
							'master'       => $this->get_name( 'form-status' ),
							'master-value' => 'custom',
						),
						'form_field'   => array(
							'display'      => 'sui-tab-content',
							'label'        => __( 'Feldtitel', 'ub' ),
							'default'      => __( 'Passwort:', 'ub' ),
							'master'       => $this->get_name( 'form-status' ),
							'master-value' => 'custom',
						),
						'form_button'  => array(
							'display'      => 'sui-tab-content',
							'label'        => __( 'Schaltfläche', 'ub' ),
							'default'      => _x( 'Eingabe', 'Schaltfläche auf dem Passwortschutzformular.', 'ub' ),
							'master'       => $this->get_name( 'form-status' ),
							'master-value' => 'custom',
						),
						'form_status'  => array(
							'type'        => 'sui-tab',
							'options'     => array(
								'default' => __( 'Standard', 'ub' ),
								'custom'  => __( 'Benutzerdefiniert', 'ub' ),
							),
							'default'     => 'default',
							'slave-class' => $this->get_name( 'form-status' ),
							'accordion'   => array(
								'end' => true,
							),
						),
					),
				),
				'shortcode_gallery' => array(
					'title'       => __( 'Shortcode [gallery]', 'ub' ),
					'description' => __( 'Eine ausführliche Beschreibung der Galerie-Shortcode-Option findest Du auf der Codex-Seite: <a href="https://codex.classicpress.org/Gallery_Shortcode" target="_blank">Galerie-Shortcode</a>.', 'ub' ),
					'show-as'     => 'accordion',
					'fields'      => array(
						'orderby'    => array(
							'type'        => 'radio',
							'label'       => __( 'Sortieren nach', 'ub' ),
							'options'     => array(
								'do-not-change' => __( 'Nicht ändern', 'ub' ),
								'menu_order'    => __( 'Bildreihenfolge in der Registerkarte Galerie festgelegt (CP-Standard)', 'ub' ),
								'title'         => __( 'Titel des Bildes', 'ub' ),
								'post_date'     => __( 'Datum/Uhrzeit', 'ub' ),
								'rand'          => __( 'Zufällig', 'ub' ),
								'ID'            => __( 'ID des Bildes', 'ub' ),
							),
							'default'     => 'do-not-change',
							'description' => __( 'Gib an, wie die Miniaturansichten der Anzeige sortiert werden sollen.', 'ub' ),
							'accordion'   => array(
								'begin' => true,
								'title' => __( 'Sortierung', 'ub' ),
							),
						),
						'order'      => array(
							'type'        => 'radio',
							'label'       => __( 'Sortierreihenfolge', 'ub' ),
							'options'     => array(
								'do-not-change' => __( 'Nicht ändern', 'ub' ),
								'ASC'           => __( 'Aufsteigend (CP Standard)', 'ub' ),
								'DESC'          => __( 'Absteigend', 'ub' ),
							),
							'default'     => 'do-not-change',
							'description' => __( 'Gib die Sortierreihenfolge an, in der Miniaturansichten angezeigt werden.', 'ub' ),
							'accordion'   => array(
								'end' => true,
							),
						),
						'columns'    => array(
							'type'        => 'number',
							'label'       => __( 'Spalten', 'ub' ),
							'min'         => 0,
							'description' => __( 'Gib die Anzahl der Spalten an. Die Galerie enthält am Ende jeder Zeile ein Umbruch-Tag und berechnet die Spaltenbreite entsprechend. Der Standardwert ist 3. Wenn Spalten auf 0 gesetzt sind, werden keine Zeilenumbrüche eingeschlossen. ', 'ub' ),
							'default'     => 3,
							'accordion'   => array(
								'begin' => true,
								'title' => __( 'Design', 'ub' ),
							),
						),
						'size'       => array(
							'type'        => 'radio',
							'label'       => __( 'Thumbnail Größe', 'ub' ),
							'options'     => array(
								'do-not-change' => __( 'Nicht ändern', 'ub' ),
								'thumbnail'     => __( 'Vorschaubild (CP Standard)', 'ub' ),
								'medium'        => __( 'Mittel', 'ub' ),
								'large'         => __( 'Groß', 'ub' ),
								'full'          => __( 'Voll', 'ub' ),
							),
							'default'     => 'do-not-change',
							'description' => __( 'Gib die Bildgröße an, die für die Miniaturansicht verwendet werden soll.', 'ub' ),
							'accordion'   => array(
								'end' => true,
							),
						),
						'link'       => array(
							'type'        => 'radio',
							'label'       => __( 'Vorschaubild Link', 'ub' ),
							'options'     => array(
								'do-not-change' => __( 'Nicht ändern', 'ub' ),
								'attachment'    => __( 'Anhangsseite (CP-Standard)', 'ub' ),
								'file'          => __( 'Link zur Bilddatei', 'ub' ),
								'none'          => __( 'Kein Link', 'ub' ),
							),
							'default'     => 'do-not-change',
							'description' => __( 'Gib an, wo das Bild verlinkt werden soll.', 'ub' ),
							'accordion'   => array(
								'begin' => true,
								'title' => __( 'Inhalt', 'ub' ),
								'end'   => true,
							),
						),
						'itemtag'    => array(
							'type'        => 'text',
							'label'       => __( 'Element-Tag', 'ub' ),
							'default'     => 'dl',
							'description' => __( 'Der Name des HTML-Tags, mit dem jedes Element in der Galerie eingeschlossen wird.', 'ub' ),
							'accordion'   => array(
								'begin' => true,
								'title' => __( 'HTML', 'ub' ),
							),
						),
						'icontag'    => array(
							'type'        => 'text',
							'label'       => __( 'Symbol Tag', 'ub' ),
							'default'     => 'dt',
							'description' => __( 'Der Name des HTML-Tags, mit dem jedes Miniaturbildsymbol in der Galerie eingeschlossen wird.', 'ub' ),
						),
						'captiontag' => array(
							'type'        => 'text',
							'label'       => __( 'Beschriftungs-Tag', 'ub' ),
							'default'     => 'dd',
							'description' => __( 'Der Name des HTML-Tags, mit dem jede Beschriftung eingeschlossen wird.', 'ub' ),
							'accordion'   => array(
								'end' => true,
							),
						),
					),
				),
			);
			if ( ! $this->is_network ) {
				global $_wp_additional_image_sizes;
				if ( is_array( $_wp_additional_image_sizes ) ) {
					foreach ( array_keys( $_wp_additional_image_sizes ) as $name ) {
						$data['shortcode_gallery']['fields']['size']['options'][ $name ] = ucwords( preg_replace( '/[-_]+/', ' ', $name ) );
					}
				}
			}
			$this->options = $data;
		}

		/**
		 * Change Password Protected Form
		 *
		 * @since 3.2.0
		 */
		public function password_form( $content ) {
			$value = $this->get_value( 'protected', 'form_status', 'default' );
			if ( 'custom' !== $value ) {
				return $content;
			}
			global $post;
			$label    = 'pwbox-' . ( empty( $post->ID ) ? rand() : $post->ID );
			$content  = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form" method="post">';
			$value    = $this->get_value( 'protected', 'form_message' );
			$content .= sprintf( '<p>%s</p>', $value, __( 'Dieser Inhalt ist passwortgeschützt. Um es anzuzeigen, gib bitte Dein Passwort unten ein:', 'ub' ) );
			$content .= sprintf( '<p><label for="%s">', esc_attr( $label ) );
			$content .= $this->get_value( 'protected', 'form_field', __( 'Passwort:', 'ub' ) );
			$content .= ' ';
			$content .= sprintf(
				'<input name="post_password" id="%s" type="password" size="20" />',
				esc_attr( $label )
			);
			$content .= '</label>';
			$content .= ' ';

			$content .= sprintf(
				'<input type="submit" name="Submit" value="%s" />',
				$this->get_value( 'protected', 'form_button', __( 'Eingabe', 'ub' ) )
			);
			$content .= '</p></form>';
			return $content;
		}

		/**
		 * Change Password Protected Title
		 *
		 * @since 3.2.0
		 */
		public function protected_title_format( $content ) {
			$value = $this->get_value( 'protected', 'title_status', 'default' );
			switch ( $value ) {
				case 'custom':
					return $this->get_value( 'protected', 'title_format', '%s' );
				case 'clear':
					return '%s';
				default:
					return $content;
			}
			return $content;
		}
	}
}
new PSToolkit_Document();
