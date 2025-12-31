<?php
/**
 * PSToolkit Admin Panel Tips class.
 *
 * Class that handles admin panel tips.
 *
 * @package PSToolkit
 * @subpackage AdminArea
 */
if ( ! class_exists( 'PSToolkit_Admin_Panel_Tips' ) ) {
	/**
	 * Class PSToolkit_Admin_Panel_Tips
	 */
	class PSToolkit_Admin_Panel_Tips extends PSToolkit_Helper {
		/**
		 * Admin url.
		 *
		 * @var string
		 */
		private $admin_url = '';

		/**
		 * Custom post type name.
		 *
		 * @var string
		 */
		private $post_type = 'admin_panel_tip';

		/**
		 * Meta field name.
		 *
		 * @var string
		 */
		private $meta_field_name = '_ub_page';

		/**
		 * Meta field name till.
		 *
		 * @var string
		 */
		private $meta_field_name_till = '_ub_till';

		/**
		 * User meta "Show Tips" name.
		 * It can be changed on profile page.
		 *
		 * @since 3.0.6
		 *
		 * @var string
		 */
		private $profile_show_tips_name = 'show_tips';

		/**
		 * PSToolkit_Admin_Panel_Tips constructor.
		 */
		public function __construct() {
			parent::__construct();
			$this->module = 'admin-panel-tips';
			// Register hooks for the module.
			add_action( 'save_post', array( $this, 'save_post' ) );
			add_action( 'save_post', array( $this, 'save_post_till' ) );
			add_action( 'admin_notices', array( $this, 'output' ) );
			add_action( 'profile_personal_options', array( $this, 'profile_option_output' ) );
			add_action( 'personal_options_update', array( $this, 'profile_option_update' ) );
			add_action( 'wp_ajax_pstoolkit_admin_panel_tips', array( $this, 'ajax_save_dissmissed' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_action( 'init', array( $this, 'custom_post_type' ), 100 );
			add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		}

		/**
		 * Set options for the module.
		 *
		 * We don't have any options for this module,
		 * so just show the text.
		 *
		 * @access protected
		 */
		protected function set_options() {
			$description   = PSToolkit_Helper::sui_notice( __( 'Dieses Modul hat keine globale Konfiguration. Bitte gehe zum Webseite-Administrator und füge einige Tipps hinzu!', 'ub' ) );
			$this->options = array(
				'description' => array(
					'title'       => '', // No title needed.
					'description' => $description,
				),
			);
		}

		/**
		 * Register custom post type.
		 *
		 * Register custom post type for the admin
		 * panel tips module.
		 *
		 * @uses register_post_type()
		 */
		public function custom_post_type() {
			// We need this only in admin side.
			if ( ! is_admin() ) {
				return;
			}
			// Do not load on multisite network admin.
			if ( is_multisite() && is_network_admin() ) {
				return;
			}
			// CPT labels.
			$labels = array(
				'name'                  => _x( 'Tipps', 'Tip General Name', 'ub' ),
				'singular_name'         => _x( 'Tipp', 'Tip Singular Name', 'ub' ),
				'menu_name'             => __( 'Tipps', 'ub' ),
				'name_admin_bar'        => __( 'Tipp', 'ub' ),
				'archives'              => __( 'Tipp Archiv', 'ub' ),
				'attributes'            => __( 'Tippattribute', 'ub' ),
				'parent_item_colon'     => __( 'Elterntipp:', 'ub' ),
				'all_items'             => __( 'Tipps', 'ub' ),
				'add_new_item'          => __( 'Neuen Tipp hinzufügen', 'ub' ),
				'add_new'               => __( 'Neuen hinzufügen', 'ub' ),
				'new_item'              => __( 'Neuer Tipp', 'ub' ),
				'edit_item'             => __( 'Tipp bearbeiten', 'ub' ),
				'update_item'           => __( 'Update-Tipp', 'ub' ),
				'view_item'             => __( 'Tipp anzeigen', 'ub' ),
				'view_items'            => __( 'Tipps anzeigen', 'ub' ),
				'search_items'          => __( 'Suche Tipp', 'ub' ),
				'not_found'             => __( 'Nicht gefunden', 'ub' ),
				'not_found_in_trash'    => __( 'Nicht im Papierkorb gefunden', 'ub' ),
				'featured_image'        => __( 'Ausgewähltes Bild', 'ub' ),
				'set_featured_image'    => __( 'Stelle ausgewähltes Bild ein', 'ub' ),
				'remove_featured_image' => __( 'Entferne ausgewähltes Bild', 'ub' ),
				'use_featured_image'    => __( 'Als ausgewähltes Bild verwenden', 'ub' ),
				'insert_into_item'      => __( 'In Artikel einfügen', 'ub' ),
				'uploaded_to_this_item' => __( 'Hochgeladen auf diesen Artikel', 'ub' ),
				'items_list'            => __( 'Liste der Tipps', 'ub' ),
				'items_list_navigation' => __( 'Tipps Liste Navigation', 'ub' ),
				'filter_items_list'     => __( 'Elementliste filtern', 'ub' ),
			);
			// Do not show CPT in Admin area on subisite if permissions forbid it.
			$show_ui = true;
			if ( is_multisite() && ! is_main_site() ) {
				$allowed = apply_filters( 'pstoolkit_module_check_for_subsite', false, 'admin_menu', array() );
				$show_ui = ! ! $allowed;
			}
			// CPT arguments.
			$args = array(
				'label'               => __( 'Tipps für das Admin-Panel', 'ub' ),
				'description'         => __( 'Tipp Beschreibung', 'ub' ),
				'labels'              => $labels,
				'supports'            => array( 'title', 'editor' ),
				'hierarchical'        => false,
				'public'              => false,
				'show_ui'             => $show_ui,
				'show_in_admin_bar'   => false,
				'can_export'          => true,
				'has_archive'         => false,
				'exclude_from_search' => false,
				'publicly_queryable'  => false,
				'menu_icon'           => $this->uba->get_u_logo(),
			);
			// Register cpt.
			register_post_type( $this->post_type, $args );
		}

		/**
		 * Ajax to hide tips for the user.
		 *
		 * Store a flag in user meta to hide admin
		 * panel tips for the user.
		 */
		public function ajax_save_dissmissed() {
			$keys = array( 'nonce', 'id', 'user_id' );
			foreach ( $keys as $key ) {
				if ( ! isset( $_POST[ $key ] ) ) {
					wp_send_json_error();
				}
			}
			/**
			 * Sanitize input
			 */
			$nonce   = filter_input( INPUT_POST, 'nonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			$user_id = filter_input( INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT );
			$post_id = filter_input( INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT );
			/**
			 * Dismiss
			 */
			$nonce_action = $this->get_nonce_action( $post_id, 'dismiss' );
			if ( wp_verify_nonce( $nonce, $nonce_action ) ) {
				$dismissed_tips   = (array) get_user_meta( $user_id, 'tips_dismissed', true );
				$dismissed_tips[] = $post_id;
				update_user_meta( $user_id, 'tips_dismissed', $dismissed_tips );
				wp_send_json_success();
			}
			/**
			 * Hide it all
			 */
			$nonce_action = $this->get_nonce_action( $post_id, 'hide' );
			if ( wp_verify_nonce( $nonce, $nonce_action ) ) {
				update_user_meta( $user_id, $this->profile_show_tips_name, 'no' );
				wp_send_json_success();
			}
			// Show json error.
			wp_send_json_error();
		}

		/**
		 * Enqueue scripts and styles for the module.
		 *
		 * @uses wp_enqueue_style()
		 * @uses wp_enqueue_script()
		 */
		public function enqueue_scripts() {
			$handler = $this->get_name();
			wp_enqueue_style( $handler, plugins_url( 'assets/css/admin/admin-panel-tips.css', __FILE__ ), array(), $this->build );
			wp_enqueue_script( $handler, plugins_url( 'assets/js/admin/admin-panel-tips.js', __FILE__ ), array( 'jquery' ), $this->build, true );
			$data = array(
				'saving' => __( 'Speichern...', 'ub' ),
			);
			wp_localize_script( $handler, 'pstoolkit_admin_panel_tips', $data );
		}

		/**
		 * Update user meta for tips.
		 */
		public function profile_option_update() {
			global $user_id;
			$show_tips = intval( filter_input( INPUT_POST, $this->profile_show_tips_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS ) );
			$show_tips = 0 === $show_tips ? 'no' : 'yes';
			update_user_meta( $user_id, $this->profile_show_tips_name, $show_tips );
		}

		/**
		 * Admin notices for admin panel tips.
		 *
		 * Show admin notices for admin panel tips.
		 */
		public function output() {
			// Avoid activate/deactivate actions.
			if ( isset( $_GET['updated'] ) || isset( $_GET['activated'] ) ) {
				return;
			}
			// Do not show tips on PSToolkit pages.
			$current_screen = get_current_screen();
			if ( 'branding' === $current_screen->parent_base ) {
				return;
			}
			global $current_user;
			// Hide if turned off.
			$show_tips = get_user_meta( $current_user->ID, $this->profile_show_tips_name, true );
			if ( 'no' === $show_tips ) {
				return;
			}
			$meta_query = array(
				'relation' => 'AND',
				array(
					'relation' => 'OR',
					array(
						'key'   => $this->meta_field_name,
						'value' => 'everywhere',
					),
					array(
						'key'   => $this->meta_field_name,
						'value' => $current_screen->parent_file,
					),
				),
				array(
					'relation' => 'OR',
					array(
						'key'     => $this->meta_field_name_till,
						'compare' => 'NOT EXISTS',
					),
					array(
						'key'     => $this->meta_field_name_till,
						'value'   => time(),
						'compare' => '>',
						'type'    => 'NUMERIC',
					),
				),
			);
			$args       = array(
				'orderby'        => 'rand',
				'posts_per_page' => 1,
				'post_type'      => $this->post_type,
				'post_status'    => 'publish',
				'meta_query'     => $meta_query,
			);
			// Get closed tips list.
			$post__not_in = get_user_meta( get_current_user_id(), 'tips_dismissed', true );
			if ( ! empty( $post__not_in ) ) {
				if ( ! is_array( $post__not_in ) ) {
					$post__not_in = array( $post__not_in );
				}
				$args['post__not_in'] = $post__not_in;
			}
			// Get tips.
			$the_query = new WP_Query( $args );
			if ( $the_query->posts ) {
				$post = array_shift( $the_query->posts );
				if ( is_a( $post, 'WP_Post' ) ) {
					$content  = $post->post_content;
					$content  = do_shortcode( $content );
					$content  = wpautop( $content );
					$args     = array(
						'id'            => $post->ID,
						'nonce_dismiss' => $this->get_nonce_value( $post->ID, 'dismiss' ),
						'nonce_hide'    => $this->get_nonce_value( $post->ID, 'hide' ),
						'content'       => $content,
						'title'         => apply_filters( 'the_title', $post->post_title ),
						'user_id'       => get_current_user_id(),
					);
					$template = $this->get_template_name( 'tip' );
					$this->render( $template, $args );
				}
				wp_reset_postdata();
			}
		}

		/**
		 * Profile form field to show/hide tips.
		 *
		 * Let users hide or show tips from their profile
		 * edit page.
		 */
		public function profile_option_output() {
			if ( is_network_admin() ) {
				return;
			}
			$user_id   = get_current_user_id();
			$show_tips = get_user_meta( $user_id, $this->profile_show_tips_name, true );
			if ( null === $show_tips ) {
				$show_tips = true;
			} elseif ( preg_match( '/^(false|hidden|no)$/', $show_tips ) ) {
				$show_tips = false;
			} else {
				$show_tips = true;
			}
			$args     = array(
				$this->profile_show_tips_name => $show_tips,
			);
			$template = sprintf( '/admin/modules/%s/profile-option', $this->module );
			$this->render( $template, $args );
		}

		/**
		 * Save meta for tips post.
		 *
		 * While saving a admin tips post, save the meta
		 * to know where to load the admin notices for the
		 * admin panel tips.
		 *
		 * @param int $post_id Post ID.
		 *
		 * @since 1.8.6
		 */
		public function save_post( $post_id ) {
			// Continue only if post type is admin panel tips.
			if ( get_post_type( $post_id ) !== $this->post_type ) {
				return;
			}
			// Security check.
			if ( ! isset( $_POST['where_to_display_nonce'] ) || ! wp_verify_nonce( $_POST['where_to_display_nonce'], '_where_to_display_nonce' ) ) {
				return;
			}
			// Get meta values from the form.
			$values = array();
			if ( isset( $_POST[ $this->meta_field_name ] ) ) {
				$values = $_POST[ $this->meta_field_name ];
			}
			// Default value.
			if ( empty( $values ) ) {
				$values = array( 'everywhere' );
			}
			// Get current meta value.
			$current = get_post_meta( $post_id, $this->meta_field_name );
			// Remove unchecked items.
			foreach ( $current as $v ) {
				if ( in_array( $v, $values ) ) {
					continue;
				}
				delete_post_meta( $post_id, $this->meta_field_name, $v );
			}
			// Add new items.
			foreach ( $values as $v ) {
				if ( in_array( $v, $current ) ) {
					continue;
				}
				add_post_meta( $post_id, $this->meta_field_name, $v );
			}
		}

		/**
		 * Get where to display, from meta.
		 *
		 * @param string $key Meta key.
		 *
		 * @return bool|mixed|string
		 */
		public function where_to_display__get_meta( $key ) {
			global $post;
			$field = get_post_meta( $post->ID, $key, true );
			if ( ! empty( $field ) ) {
				return is_array( $field ) ? stripslashes_deep( $field ) : stripslashes( wp_kses_decode_entities( $field ) );
			}
			return false;
		}

		/**
		 * Add meta box to post form.
		 *
		 * Add new meta box to ask users, where
		 * to show admin panel tips.
		 *
		 * @uses add_meta_box()
		 *
		 * @since 1.8.8
		 */
		public function add_meta_boxes() {
			add_meta_box(
				'where_to_display',
				__( 'Wo anzeigen?', 'ub' ),
				array( $this, 'html' ),
				'admin_panel_tip',
				'side',
				'default'
			);
			add_meta_box(
				'till',
				__( 'Anzeige bis', 'ub' ),
				array( $this, 'add_till' ),
				'admin_panel_tip',
				'side',
				'default'
			);
		}

		/**
		 * HTML for meta box in post form.
		 *
		 * @param WP_Post $post Post object.
		 *
		 * @since 1.8.8
		 */
		public function html( $post ) {
			global $menu;
			// Nonce field.
			wp_nonce_field( '_where_to_display_nonce', 'where_to_display_nonce' );
			echo '<p>';
			esc_html_e( 'Wähle aus wo dieser Tipp angezeigt werden soll:', 'ub' );
			echo '</p>';
			$current = get_post_meta( $post->ID, $this->meta_field_name );
			$checked = in_array( 'everywhere', $current );
			echo '<ul>';
			printf(
				'<li><label><input type="checkbox" name="%s[]" value="everywhere" %s/> %s</label>',
				esc_attr( $this->meta_field_name ),
				checked( $checked, true, false ),
				esc_html__( 'Überall (außer Branding)', 'ub' )
			);
			foreach ( $menu as $one ) {
				if ( empty( $one[0] ) ) {
					continue;
				}
				// Disalow on branding pages.
				if ( 'branding' === $one[2] ) {
					continue;
				}
				$checked = in_array( $one[2], $current );
				printf(
					'<li><label><input type="checkbox" name="%s[]" value="%s" %s/> %s</label>',
					esc_attr( $this->meta_field_name ),
					esc_attr( $one[2] ),
					checked( $checked, true, false ),
					esc_html( preg_replace( '/<.+/', '', $one[0] ) )
				);
			}
			echo '</ul>';
		}

		/**
		 * Add meta box to get the expiry date.
		 *
		 * @param WP_Post $post Post object.
		 *
		 * @since 2.3.0
		 */
		public function add_till( $post ) {
			// Security check.
			wp_nonce_field( '_till_date_nonce', 'till_date_nonce' );
			printf( '<p>%s</p>', esc_html__( 'Bis zum:', 'ub' ) );
			printf( '<p class="description">%s</p>', esc_html__( 'Leer lassen für unbegrenzte Anzeigedauer.', 'ub' ) );
			$current = get_post_meta( $post->ID, $this->meta_field_name_till, true );
			if ( ! empty( $current ) ) {
				$current = date_i18n( get_option( 'date_format' ), $current );
			}
			$alt = sprintf( '%s_%s', $this->meta_field_name_till, $this->generate_id( $current ) );
			printf(
				'<input type="text" class="datepicker" name="%s[human]" value="%s" data-alt="%s" data-min="%s" />',
				esc_attr( $this->meta_field_name_till ),
				esc_attr( $current ),
				esc_attr( $alt ),
				esc_attr( date( 'y-m-d', time() ) )
			);
			printf(
				'<input type="hidden" name="%s[alt]" value="%s" id="%s" />',
				esc_attr( $this->meta_field_name_till ),
				esc_attr( $current ),
				esc_attr( $alt )
			);
			// Styles and scripts for the date picker.
			wp_enqueue_script( 'jquery-ui-datepicker' );
			wp_localize_jquery_ui_datepicker();
			wp_enqueue_style(
				$this->get_name( 'ui', 'jquery' ),
				pstoolkit_url( 'assets/css/vendor/jquery-ui.min.css' ),
				array(),
				'1.12.1'
			);
		}

		/**
		 * Save meta for expiry date of tips.
		 *
		 * While saving a admin tips post, save the meta
		 * to know when should stop showing the tips.
		 *
		 * @param int $post_id Post ID.
		 *
		 * @since 2.3.0
		 */
		public function save_post_till( $post_id ) {
			// Continue only for tips post.
			if ( get_post_type( $post_id ) !== $this->post_type ) {
				return;
			}
			// Security check.
			if ( ! isset( $_POST['till_date_nonce'] ) || ! wp_verify_nonce( $_POST['till_date_nonce'], '_till_date_nonce' ) ) {
				return;
			}
			// Get the values.
			$values = array();
			if ( isset( $_POST[ $this->meta_field_name_till ] ) ) {
				$values = $_POST[ $this->meta_field_name_till ];
			}
			// Delete existing value.
			delete_post_meta( $post_id, $this->meta_field_name_till );
			if ( isset( $values['human'] ) ) {
				if ( empty( $values['human'] ) ) {
					return;
				}
			} else {
				return;
			}
			if ( ! isset( $values['alt'] ) || empty( $values['alt'] ) ) {
				return;
			}
			$date = strtotime( sprintf( '%s 23:59:59', $values['alt'] ) );
			// Save new date.
			add_post_meta( $post_id, $this->meta_field_name_till, $date, true );
		}
	}
}
new PSToolkit_Admin_Panel_Tips();
