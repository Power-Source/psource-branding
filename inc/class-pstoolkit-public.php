<?php
if ( ! class_exists( 'PSToolkit_Public' ) ) {
	require_once dirname( __FILE__ ) . '/class-pstoolkit-base.php';
	class PSToolkit_Public extends PSToolkit_Base {

		/**
		 * Class constructor
		 */
		public function __construct() {
			parent::__construct();
			add_action( 'plugins_loaded', array( $this, 'load_modules' ) );
			/**
			 * Add Psource CP Toolkit submenu to Customize on Admin Bar
			 *
			 * @since 1.0.0
			 */
			add_action( 'admin_bar_menu', array( $this, 'add_submen_to_customize' ), 1134 );
		}

		/**
		 *  Check plugins those will be used if they are active or not
		 */
		public function load_modules() {
			// Load our remaining modules here
			foreach ( $this->configuration as $module => $plugin ) {
				/**
				 * is a public module?
				 */
				if ( ! isset( $plugin['public'] ) || ! $plugin['public'] ) {
					continue;
				}
				if ( pstoolkit_is_active_module( $module ) ) {
					if ( $this->should_be_module_off( $module ) ) {
						continue;
					}
					pstoolkit_load_single_module( $module );
				}
			}
		}

		/**
		 * Add Psource CP Toolkit to "Customize" as submenu.
		 *
		 * @since 1.0.0
		 */
		public function add_submen_to_customize() {
			if ( $this->is_network ) {
				return;
			}
			global $wp_admin_bar;
			$args = array(
				'parent' => 'customize',
				'id'     => 'pstoolkit',
				'title'  => __( 'Psource CP Toolkit', 'ub' ),
				'href'   => add_query_arg( 'page', 'branding', admin_url( 'admin.php' ) ),
			);
			$wp_admin_bar->add_menu( $args );
		}
	}
}
