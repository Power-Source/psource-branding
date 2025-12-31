<?php
/**
 * PSToolkit Signup Blog Description class.
 *
 * @package PSToolkit
 * @subpackage Front-end
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
if ( ! class_exists( 'PSToolkit_Signup_Blog_Description' ) ) {

	class PSToolkit_Signup_Blog_Description extends PSToolkit_Helper {

		public function __construct() {
			add_filter( 'pstoolkit_settings_signup_blog_description', array( $this, 'admin_options_page' ) );
			add_filter( 'add_signup_meta', array( $this, 'meta_filter' ) );
			add_filter( 'bp_signup_usermeta', array( $this, 'meta_filter' ) );
			add_action( 'signup_blogform', array( $this, 'signup_form' ) );
			add_action( 'bp_blog_details_fields', array( $this, 'signup_form' ) );
			add_filter( 'blog_template_exclude_settings', array( $this, 'nbt' ) );
			/**
			 * TODO: the following action is deprecated and should be replaced with wp_insert_site
			 */
			add_filter( 'wpmu_new_blog', array( $this, 'nbt' ) );
		}

		protected function set_options() {
			$description   = PSToolkit_Helper::sui_notice( __( 'Es gibt keine Einstellungen für dieses Modul. Es wurde lediglich die Möglichkeit hinzugefügt, den Seiten-Slogan während der Erstellung einzurichten.', 'ub' ) );
			$options       = array(
				'description' => array(
					'title'       => '', // Not title needed.
					'description' => $description,
				),
			);
			$this->options = $options;
		}

		/**
		 * Save the blogdescription value in meta
		 *
		 * @param type $meta
		 * @return type $meta
		 */
		public function meta_filter( $meta ) {
			if (
				isset( $_POST['blog_description'] )
				&& ! empty( $_POST['blog_description'] )
			) {
				$meta['blogdescription'] = $_POST['blog_description'];
			}
			return $meta;
		}

		/**
		 * Exclude option from New Site Template plugin copy
		 *
		 * @param string $and
		 * @return string
		 */
		public function nbt( $and ) {
			$and .= " AND `option_name` != 'blogdescription'";
			return $and;
		}

		/**
		 * Adds an additional field for Blog description,
		 * on signup form for ClassicPress or Buddypress
		 *
		 * @param type $errors
		 */
		public function signup_form( $errors ) {
			if ( ! empty( $errors ) ) {
				$error = $errors->get_error_message( 'blog_description' );
			}
			$desc = isset( $_POST['blog_description'] ) ? esc_attr( $_POST['blog_description'] ) : '';
			?>
		<label for="blog_description"><?php _e( 'Webseiten-Slogan', 'ub' ); ?>:</label>
		<input name="blog_description" type="text" id="blog_description" value="<?php echo $desc; ?>" autocomplete="off" maxlength="50" /><br />
			<?php _e( 'Erkläre in wenigen Worten, worum es auf dieser Webseite geht. Die Standardeinstellung wird verwendet, wenn sie leer gelassen wird.', 'ub' ); ?>
			<?php
		}
	}
}
new PSToolkit_Signup_Blog_Description();
