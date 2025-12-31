<?php
/**
 * PSToolkit Accessibility class.
 *
 * Class that handle accessibility settings functionality.
 *
 * @since      2.0.0
 *
 * @package PSToolkit
 * @subpackage Settings
 */
if ( ! class_exists( 'PSToolkit_Accessibility' ) ) {

	/**
	 * Class PSToolkit_Accessibility.
	 */
	class PSToolkit_Accessibility extends PSToolkit_Helper {

		/**
		 * Module option name.
		 *
		 * @since 1.0.0
		 *
		 * @var string
		 */
		protected $option_name = 'ub_accessibility';

		/**
		 * PSToolkit_Accessibility constructor.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {
			// Set module name.
			$this->module = 'accessibility';
			parent::__construct();
			// Handle module settings.
			add_filter( 'pstoolkit_settings_accessibility', array( $this, 'admin_options_page' ) );
			add_filter( 'pstoolkit_settings_accessibility_process', array( $this, 'update' ) );
			// Add custom content title.
			add_filter( 'pstoolkit_before_module_form', array( $this, 'add_title_before_form' ), 10, 2 );
			// Change bottom save button params.
			add_filter( 'pstoolkit_after_form_save_button_args', array( $this, 'change_bottom_save_button' ), 10, 2 );
		}

		/**
		 * Build form with options.
		 *
		 * Set settings form fields for the module.
		 *
		 * @since 1.0.0
		 */
		protected function set_options() {
			$options       = array(
				'description'   => array(
					'content' => __( 'Aktiviere die Unterstützung für alle Verbesserungen der Barrierefreiheit, die in der Plugin-Oberfläche verfügbar sind.', 'ub' ),
				),
				'accessibility' => array(
					'title'       => __( 'Kontrastreicher Modus', 'ub' ),
					'description' => __( 'Erhöhe die Sichtbarkeit und Zugänglichkeit der Elemente und Komponenten des Plugins, um die WCAG AAA-Anforderungen zu erfüllen.', 'ub' ),
					'fields'      => array(
						'high_contrast' => array(
							'checkbox_label' => __( 'Aktiviere kontrastreichen Modus', 'ub' ),
							'description'    => array(
								'content'  => '',
								'position' => 'bottom',
							),
							'type'           => 'checkbox',
							'classes'        => array( 'switch-button' ),
							'default'        => 'off',
						),
					),
				),
			);
			$this->options = $options;
		}

		/**
		 * Add title before form.
		 *
		 * @param string $content Current content.
		 * @param array  $module  Current module.
		 *
		 * @since 1.0.0
		 *
		 * @return string
		 */
		public function add_title_before_form( $content, $module ) {
			if ( $this->module === $module['module'] ) {
				$template = $this->get_template_name( 'header' );
				$content .= $this->render( $template, array(), true );
			}
			return $content;
		}
	}
}
new PSToolkit_Accessibility();
