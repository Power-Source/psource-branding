<?php
/**
 * Theme Additional CSS  class.
 *
 * @package PSToolkit
 * @subpackage Widgets
 *
 * @since 3.1.3
 */
if ( ! class_exists( 'PSToolkit_Theme_Aditional_CSS' ) ) {
	class PSToolkit_Theme_Aditional_CSS extends PSToolkit_Helper {

		public function __construct() {
			parent::__construct();
			add_filter( 'pstoolkit_settings_theme_additional_css', array( $this, 'admin_options_page' ) );
			add_filter( 'map_meta_cap', array( $this, 'allow_edit_css' ), 10, 4 );
		}

		/**
		 * set options
		 *
		 * @since 3.1.3
		 */
		protected function set_options() {
			$message       = sprintf(
				__( 'Um benutzerdefiniertes CSS hinzuzufügen, rufe das <a href="%s">Customizer</a>-Menü Deines Themes auf.', 'ub' ),
				admin_url( 'customize.php' )
			);
			$notice        = PSToolkit_Helper::sui_notice( $message, 'info' );
			$options       = array(
				'desc' => array(
					'title'       => __( 'Customizer CSS', 'ub' ),
					'description' => __( 'Mit dieser Funktion können Administratoren von Unterwebseiten benutzerdefiniertes CSS über das Theme Customizer-Tool hinzufügen.', 'ub' ),
					'fields'      => array(
						'html' => array(
							'type'  => 'description',
							'value' => $notice,
						),
					),
				),
			);
			$this->options = $options;
		}

		public function allow_edit_css( $caps, $cap, $user_id, $args ) {
			if ( 'edit_css' === $cap ) {
				if ( current_user_can( 'administrator' ) ) {
					return array( 'unfiltered_html' );
				}
			}
			return $caps;
		}
	}
}
new PSToolkit_Theme_Aditional_CSS();
