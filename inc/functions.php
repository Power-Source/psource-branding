<?php
// We initially need to make sure that this function exists, and if not then include the file that has it.
if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
	require_once ABSPATH . '/wp-admin/includes/plugin.php';
}

function pstoolkit_get_url_valid_schema( $url ) {
	$valid_url   = $url;
	$v_valid_url = parse_url( $url );
	if ( isset( $v_valid_url['scheme'] ) && 'https' === $v_valid_url['scheme'] ) {
		if ( ! is_ssl() ) {
			$valid_url = str_replace( 'https', 'http', $valid_url );
		}
	} else {
		if ( is_ssl() ) {
			$valid_url = str_replace( 'http', 'https', $valid_url );
		}
	}
	return $valid_url;
}

function pstoolkit_url( $extended ) {
	global $pstoolkit_url;
	return pstoolkit_get_url_valid_schema( $pstoolkit_url ) . $extended;
}

function pstoolkit_dir( $extended ) {
	global $pstoolkit_dir;
	return $pstoolkit_dir . ltrim( $extended, '/' );
}

function pstoolkit_files_url( $extended ) {
	return pstoolkit_url( 'inc/' . $extended );
}

function pstoolkit_files_dir( $extended ) {
	return pstoolkit_dir( 'inc/' . $extended );
}

// modules loading code
function pstoolkit_is_active_module( $module ) {
	$modules = get_pstoolkit_activated_modules();
	$active  = in_array( $module, array_keys( $modules ) );
	if ( $active ) {
		return $active;
	}
	$active = in_array( $module, array_keys( $modules ) );
	return $active;
}

/**
 * UB Get Option
 *
 * 2.0.0 @parm $mode Mode to allow avoid filters.  Default normal.
 * 3.0.2 @param bool $force_network get option from the network
 */
function pstoolkit_get_option( $option, $default = false, $mode = 'normal', $force_network = false ) {
	global $pstoolkit_network;
	if ( $pstoolkit_network ) {
		$force_local = apply_filters( 'pstoolkit_force_local_option', false, $option );
		if ( $force_local && ! $force_network ) {
			$value = get_option( $option, $default );
			/**
			 * Failover, get from network configuration
			 */
			if ( empty( $value ) ) {
				$value = get_site_option( $option, $default, false );
			}
		} else {
			$value = get_site_option( $option, $default );
		}
	} else {
		$value = get_option( $option, $default );
	}
	/**
	 * For mode 'raw' do nor use filters.
	 *
	 * @since 1.0.0
	 */
	if ( 'raw' === $mode ) {
		return $value;
	}
	$value = apply_filters( 'ub_get_option', $value, $option, $default );
	$value = apply_filters( 'ub_get_option-' . $option, $value, $option, $default );
	return $value;
}

/**
 * UB Get Option filtered to remove some options.
 *
 * @since 3.1.0
 */
function pstoolkit_get_option_filtered( $option ) {
	$value = pstoolkit_get_option( $option );
	if ( is_array( $value ) ) {
		unset( $value['imported'] );
		unset( $value['plugin_version'] );
	}
	return $value;
}

function pstoolkit_update_option( $option, $value = null ) {
	global $pstoolkit_network;
	do_action( 'pstoolkit_admin_stats_write', $option );
	if ( $pstoolkit_network ) {
		$force_local = apply_filters( 'pstoolkit_force_local_option', false, $option );
		if ( $force_local ) {
			return update_option( $option, $value );
		} else {
			return update_site_option( $option, $value );
		}
	} else {
		return update_option( $option, $value );
	}
}

function pstoolkit_add_option( $option, $value = null, $autoload = 'yes' ) {
	global $pstoolkit_network;
	if ( $pstoolkit_network ) {
		$force_local = apply_filters( 'pstoolkit_force_local_option', false, $option );
		if ( $force_local ) {
			return add_option( $option, $value, '', $autoload );
		} else {
			return add_site_option( $option, $value );
		}
	} else {
		return add_option( $option, $value, '', $autoload );
	}
}

function pstoolkit_delete_option( $option ) {
	global $pstoolkit_network;
	if ( $pstoolkit_network ) {
		$force_local = apply_filters( 'pstoolkit_force_local_option', false, $option );
		if ( $force_local ) {
			return delete_option( $option );
		} else {
			return delete_site_option( $option );
		}
	} else {
		return delete_option( $option );
	}
}

/**
 * Get modules
 *
 * 2.0.0 @parm $mode Mode. Default normal.
 */
function get_pstoolkit_activated_modules( $mode = 'normal' ) {
	global $pstoolkit_modules;
	if ( empty( $pstoolkit_modules ) ) {
		$pstoolkit_modules = pstoolkit_get_option( 'pstoolkit_activated_modules', array(), $mode );
	}
	/**
	 * For mode 'raw' do nor use filters.
	 *
	 * @since 1.0.0
	 */
	if ( 'raw' === $mode ) {
		return $pstoolkit_modules;
	}
	/**
	 * Filter allow to turn on/off modules.
	 *
	 * @since 1.9.4
	 *
	 * @param array $modules Active modules array.
	 */
	$modules = apply_filters( 'pstoolkit_activated_modules', $pstoolkit_modules );
	return $modules;
}

function update_pstoolkit_activated_modules( $data ) {
	global $pstoolkit_modules;
	$pstoolkit_modules = $data;
	pstoolkit_update_option( 'pstoolkit_activated_modules', $pstoolkit_modules );
}

function pstoolkit_load_single_module( $module ) {
	$modules = pstoolkit_get_modules_list( 'keys' );
	if ( in_array( $module, $modules ) ) {
		$file = pstoolkit_files_dir( 'modules/' . $module );
		if ( is_file( $file ) ) {
			include_once $file;
		}
	}
}

function pstoolkit_has_menu( $menuhook ) {
	global $submenu;
	$menu = ( isset( $submenu['branding'] ) ) ? $submenu['branding'] : false;
	if ( is_array( $menu ) ) {
		foreach ( $menu as $key => $m ) {
			if ( $m[2] == $menuhook ) {
				return true;
			}
		}
	}
	// if we are still here then we didn't find anything
	return false;
}

/*
Function based on the function wp_upload_dir, which we can't use here because it insists on creating a directory at the end.
 */
function pstoolkit_wp_upload_url() {
	global $switched;
	$siteurl       = get_option( 'siteurl' );
	$upload_path   = get_option( 'upload_path' );
	$upload_path   = trim( $upload_path );
	$main_override = is_multisite() && defined( 'MULTISITE' ) && is_main_site();
	if ( empty( $upload_path ) ) {
		$dir = WP_CONTENT_DIR . '/uploads';
	} else {
		$dir = $upload_path;
		if ( 'wp-content/uploads' == $upload_path ) {
			$dir = WP_CONTENT_DIR . '/uploads';
		} elseif ( 0 !== strpos( $dir, ABSPATH ) ) {
			// $dir is absolute, $upload_path is (maybe) relative to ABSPATH
			$dir = path_join( ABSPATH, $dir );
		}
	}
	if ( ! $url = get_option( 'upload_url_path' ) ) {
		if ( empty( $upload_path ) || ( 'wp-content/uploads' == $upload_path ) || ( $upload_path == $dir ) ) {
			$url = WP_CONTENT_URL . '/uploads';
		} else {
			$url = trailingslashit( $siteurl ) . $upload_path;
		}
	}
	if ( defined( 'UPLOADS' ) && ! $main_override && ( ! isset( $switched ) || false === $switched ) ) {
		$dir = ABSPATH . UPLOADS;
		$url = trailingslashit( $siteurl ) . UPLOADS;
	}
	if ( defined( 'UPLOADS' ) && is_multisite() && ! $main_override && ( ! isset( $switched ) || false === $switched ) ) {
		if ( defined( 'BLOGUPLOADDIR' ) ) {
			$dir = untrailingslashit( BLOGUPLOADDIR );
		}
		$url = str_replace( UPLOADS, 'files', $url );
	}
	$bdir = $dir;
	$burl = $url;
	return $burl;
}

function pstoolkit_wp_upload_dir() {
	global $switched;
	$siteurl       = get_option( 'siteurl' );
	$upload_path   = get_option( 'upload_path' );
	$upload_path   = trim( $upload_path );
	$main_override = is_multisite() && defined( 'MULTISITE' ) && is_main_site();
	if ( empty( $upload_path ) ) {
		$dir = WP_CONTENT_DIR . '/uploads';
	} else {
		$dir = $upload_path;
		if ( 'wp-content/uploads' == $upload_path ) {
			$dir = WP_CONTENT_DIR . '/uploads';
		} elseif ( 0 !== strpos( $dir, ABSPATH ) ) {
			// $dir is absolute, $upload_path is (maybe) relative to ABSPATH
			$dir = path_join( ABSPATH, $dir );
		}
	}
	if ( ! $url = get_option( 'upload_url_path' ) ) {
		if ( empty( $upload_path ) || ( 'wp-content/uploads' == $upload_path ) || ( $upload_path == $dir ) ) {
			$url = WP_CONTENT_URL . '/uploads';
		} else {
			$url = trailingslashit( $siteurl ) . $upload_path;
		}
	}
	if ( defined( 'UPLOADS' ) && ! $main_override && ( ! isset( $switched ) || false === $switched ) ) {
		$dir = ABSPATH . UPLOADS;
		$url = trailingslashit( $siteurl ) . UPLOADS;
	}
	if ( defined( 'UPLOADS' ) && is_multisite() && ! $main_override && ( ! isset( $switched ) || false === $switched ) ) {
		if ( defined( 'BLOGUPLOADDIR' ) ) {
			$dir = untrailingslashit( BLOGUPLOADDIR );
		}
		$url = str_replace( UPLOADS, 'files', $url );
	}
	$bdir = $dir;
	$burl = $url;
	return $bdir;
}

/**
 * Returns option name from module name.
 */
function pstoolkit_get_option_name_by_module( $module ) {
	return apply_filters( 'pstoolkit_get_option_name', 'unknown', $module );
}

/**
 * show deprecated module information
 *
 * @since 1.8.7
 */
function pstoolkit_deprecated_module( $deprecated, $substitution, $tab, $removed_in = 0 ) {
	$url = is_network_admin() ? network_admin_url( 'admin.php' ) : admin_url( 'admin.php' );
	$url = add_query_arg(
		array(
			'page' => 'branding',
			'tab'  => $tab,
		),
		$url
	);
	echo '<div class="ub-deprecated-module"><p>';
	printf(
		__( '%1$s Modul ist veraltet. Bitte verwende das Modul %2$s.', 'ub' ),
		sprintf( '<b>%s</b>', esc_html( $deprecated ) ),
		sprintf( '<b><a href="%s">%s</a></b>', esc_url( $url ), esc_html( $substitution ) )
	);
	echo '</p>';
	if ( $removed_in ) {
		printf(
			'<p>%s</p>',
			sprintf(
				__( 'Das Modul wird in der <b>PSToolkit%s-Version entfernt</b>.', 'ub' ),
				$removed_in
			)
		);
	}
	echo '</div>';
}

/**
 * register_activation_hook
 *
 * @since 1.8.8
 */
function pstoolkit_register_activation_hook() {
	$version = pstoolkit_get_option( 'ub_version' );
	$compare = version_compare( $version, '1.8.8', '<' );
	/**
	 * Turn off plugin "HTML E-mail Template" and turn on module.
	 *
	 * @since 1.8.8
	 */
	if ( 0 < $compare ) {
		/**
		 * Turn off "HTML E-mail Templates" plugin and turn on "HTML E-mail
		 * Templates" module instead.
		 */
		$turn_on_module_htmlemail = false;
		if ( is_network_admin() ) {
			$plugins = get_site_option( 'active_sitewide_plugins' );
			if ( array_key_exists( 'htmlemail/htmlemail.php', $plugins ) ) {
				unset( $plugins['htmlemail/htmlemail.php'] );
				update_site_option( 'active_sitewide_plugins', $plugins );
				$turn_on_module_htmlemail = true;
			}
		} else {
			$plugins = get_option( 'active_plugins' );
			if ( in_array( 'htmlemail/htmlemail.php', $plugins ) ) {
				$new = array();
				foreach ( $plugins as $plugin ) {
					if ( 'htmlemail/htmlemail.php' == $plugin ) {
						$turn_on_module_htmlemail = true;
						continue;
					}
					$new[] = $plugin;
				}
				update_option( 'active_plugins', $new );
			}
		}
		if ( $turn_on_module_htmlemail ) {
			global $uba;
			$uba = new PSToolkit_Admin();
			$uba->activate_module( 'htmlemail.php' );
		}
	}
	$file = dirname( dirname( __FILE__ ) ) . '/psource-branding.php';
	$data = get_plugin_data( $file );
	pstoolkit_update_option( 'ub_version', $data['Version'] );
}
/**
 * Set required PSToolkit defaults.
 *
 * @since 1.9.5
 * @since 3.1.0 Try to turn off active plugin inside a network and when it is
 *              already network activated.
 */
function set_pstoolkit( $base ) {
	global $pstoolkit_dir, $pstoolkit_url, $pstoolkit_plugin_file, $pstoolkit_network, $uba, $ubp;
	/**
	 * Set pstoolkit_dir
	 */
	$pstoolkit_dir = plugin_dir_path( $base );
	if ( defined( 'WPMU_PLUGIN_DIR' ) && file_exists( WPMU_PLUGIN_DIR . '/' . basename( $base ) ) ) {
		$pstoolkit_dir = trailingslashit( WPMU_PLUGIN_DIR );
	}
	/**
	 * set $pstoolkit_url
	 */
	$pstoolkit_url = plugin_dir_url( $base );
	if ( defined( 'WPMU_PLUGIN_URL' ) && defined( 'WPMU_PLUGIN_DIR' ) && file_exists( WPMU_PLUGIN_DIR . '/' . basename( $base ) ) ) {
		$pstoolkit_url = trailingslashit( WPMU_PLUGIN_URL );
	}
	/**
	 * set $pstoolkit_plugin_file
	 */
	$pstoolkit_plugin_file = plugin_basename( $base );
	/**
	 * set $pstoolkit_network
	 */
	if ( ! function_exists( 'is_plugin_active_for_network' ) ) {
		require_once ABSPATH . '/wp-admin/includes/plugin.php';
	}
	$pstoolkit_network = is_multisite() && is_plugin_active_for_network( $pstoolkit_plugin_file );
	if ( $pstoolkit_network ) {
		/**
		 * Check is activated on network and subsite
		 *
		 * @since 3.1.0
		 */
		$is_single = is_plugin_active( $pstoolkit_plugin_file );
		if ( $is_single ) {
			deactivate_plugins( basename( $base ) );
		}
	}
	/**
	 * include dir
	 */
	$include_dir = $pstoolkit_dir . '/inc';
	/**
	 * load files
	 */
	require_once $include_dir . '/class-pstoolkit-admin.php';
	if ( is_admin() ) {
		// Add in the contextual help
		include_once $include_dir . '/class-simple-options.php';
		// Include the admin class
		global $uba;
		$uba = new PSToolkit_Admin();
	} else {
		// Include the public class
		require_once $include_dir . '/class-pstoolkit-public.php';
		$ubp = new PSToolkit_Public();
	}
	/**
	 * handle ajax
	 */
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		include_once $include_dir . '/class-simple-options.php';
		new Simple_Options();
	}
}

/**
 * Get main blog ID
 *
 * Get main blog ID and be compatible with Multinetwork installation.
 *
 * https://n3rds.work/forums/topic/bug-report-multinetwork-compatibility#post-1147189
 *
 * @since 1.9.8
 *
 * @return integer $mainblogid Main Blog ID
 */
function pstoolkit_get_main_site_id() {
	if ( function_exists( 'get_main_site_for_network' ) ) {
		return get_main_site_for_network();
	}
	if ( function_exists( 'get_network' ) ) {
		return get_network()->site_id;
	}
	return 1;
}

/**
 * register_deactivation_hook
 *
 * @since 2.1.0
 */
function pstoolkit_register_deactivation_hook() {
	wp_unschedule_hook( 'pstoolkit_email_logs_cleaning' );
}

/**
 * Set the uninstallation hook for the PSToolkit plugin.
 *
 * @since 2.3.0
 */
function pstoolkit_register_uninstall_hook() {
	pstoolkit_load_single_module( 'utilities/data.php' );
	do_action( 'pstoolkit_uninstall_plugin' );
}

/**
 * get $uba object
 *
 * @since 3.0.1
 */
function pstoolkit_get_uba_object() {
	global $uba;
	if ( is_null( $uba ) ) {
		$uba = new PSToolkit_Admin();
	}
	return $uba;
}

/**
 * Get a value from an array. If nothing is found for the provided keys, returns null.
 *
 * @param array        $array The array to search (haystack).
 * @param array|string $key The key to use for the search.
 *
 * @return null|mixed The array value found or null if nothing found.
 */
function pstoolkit_get_array_value( $array, $key ) {
	if ( ! is_array( $key ) ) {
		$key = array( $key );
	}

	if ( ! is_array( $array ) ) {
		return null;
	}

	$value = $array;
	foreach ( $key as $key_part ) {
		$value = isset( $value[ $key_part ] ) ? $value[ $key_part ] : null;
	}

	return $value;
}
