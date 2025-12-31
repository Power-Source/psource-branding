<?php
// If we are on a campus install then we should be hiding some of the modules
if ( ! defined( 'UB_ON_CAMPUS' ) ) {
	define( 'UB_ON_CAMPUS', false ); }
// Allows the branding admin menus to be hidden on a single site install
if ( ! defined( 'UB_HIDE_ADMIN_MENU' ) ) {
	define( 'UB_HIDE_ADMIN_MENU', false ); }
// Allows the main blog to be changed from the default with an id of 1
if ( ! defined( 'UB_MAIN_BLOG_ID' ) ) {
	define( 'UB_MAIN_BLOG_ID', 1 ); }

/**
 * Group list
 *
 * @since 1.0.0
 */
function pstoolkit_get_groups_list() {
	$groups = array(
		'admin'     => array(
			'icon'                  => 'dashicons-dashboard',
			'title'                 => __( 'Admin-Bereich', 'ub' ),
			'documentation_chapter' => 'admin-area',
			'description'           => __( 'Passe die verschiedenen Teile Deines ClassicPress-Verwaltungsbereichs an.', 'ub' ),
		),
		'widgets'   => array(
			'icon'                  => 'thumbnails',
			'title'                 => __( 'Widgets', 'ub' ),
			'documentation_chapter' => 'widgets',
			'description'           => __( 'Passe die vorhandenen Widgets an oder füge dem ClassicPress-Dashboard benutzerdefinierte Feeds hinzu. Aktualisiert außerdem das im Front-End angezeigte Meta-Widget entsprechend Deinem Branding.', 'ub' ),
		),
		'emails'    => array(
			'icon'                  => 'mail',
			'title'                 => __( 'E-Mails', 'ub' ),
			'documentation_chapter' => 'email',
			'description'           => __( 'Passe das Design, den Inhalt und die Header ausgehender E-Mails von Deiner ClassicPress-Webseite vollständig an oder richte einen SMTP-Server ein.', 'ub' ),
		),
		'front-end' => array(
			'icon'                  => 'monitor',
			'title'                 => __( 'Frontend', 'ub' ),
			'documentation_chapter' => 'front-end',
			'description'           => __( 'Passe jeden Teil des Frontends Deiner ClassicPress-Webseite an das Theme Deiner Webseite an.', 'ub' ),
		),
		'data'      => array(
			'icon'                  => 'cloud-migration',
			'title'                 => __( 'Einstellungen', 'ub' ),
			'documentation_chapter' => 'settings',
			'description'           => __( 'Importiere vorhandene Konfigurationen, um PSToolkit innerhalb weniger Sekunden einzurichten, oder exportiere die Konfigurationen dieser Installation für andere Webseiten.', 'ub' ),
			'menu-position'         => 'bottom',
		),
		'utilities' => array(
			'icon'                  => 'wrench-tool',
			'title'                 => __( 'Dienstprogramme', 'ub' ),
			'documentation_chapter' => 'utilities',
			'description'           => __( 'Dienstprogramme sind zusätzliche Komponenten Deiner Webseite, die nach Deinen Wünschen angepasst werden können.', 'ub' ),
		),
	);
	return $groups;
}

/**
 * Modules list
 *
 * @since 1.9.4
 */
function pstoolkit_get_modules_list( $mode = 'full' ) {
	global $wp_version, $pstoolkit_network, $pstoolkit_modules_list;

	if ( 'keys' == $mode && ! empty( $pstoolkit_modules_list ) ) {
		return $pstoolkit_modules_list;
	}
	$modules = array(
		/**
		 * data
		 *
		 * @since 1.8.6
		 */
		'utilities/data.php'                    => array(
			'module'                 => 'data',
			'name'                   => __( 'Data', 'ub' ),
			'description'            => __( 'Steuere was mit Deinen Einstellungen und Daten geschehen soll.', 'ub' ),
			'group'                  => 'data',
			'instant'                => 'on',
			'hide-on-dashboard'      => true,
			'add-bottom-save-button' => true,
			'options'                => array( 'ub_data' ),
			'allow-override'         => 'allow',
			'allow-override-message' => 'hide',
		),
		/**
		 * Permissions
		 * URGENT: it must be first loaded module!
		 * DO NOT move it from begining of this array.
		 *
		 * @since 3.1.0
		 */
		'utilities/permissions.php'             => array(
			'module'                 => 'permissions',
			'name'                   => __( 'Berechtigungen', 'ub' ),
			// 'description' => __( 'Use this tool to allow modules in subsites to override the PSToolkit network configurations.', 'ub' ),
			'group'                  => 'data',
			'instant'                => 'on',
			'add-bottom-save-button' => true,
			'public'                 => true,
			'options'                => array(
				'ub_permissions',
			),
			'allow-override'         => 'no',
			'hide-on-dashboard'      => true,
		),
		'admin/bar.php'                         => array(
			'module'         => 'admin-bar',
			'name'           => __( 'Admin-Leiste', 'ub' ),
			'description'    => __( 'Passe die Admin-Leiste so an, dass Du das Logo der Admin-Leiste ändern, die Sichtbarkeit von Menüelementen steuern, benutzerdefinierte Menüelemente hinzufügen oder die vorhandenen neu anordnen kannst.', 'ub' ),
			'public'         => true,
			'group'          => 'admin',
			'options'        => array(
				'ub_admin_bar',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'wdcab',
				'admin_bar_logo',
				'ub_admin_bar_menus',
				'ub_admin_bar_order',
				'ub_admin_bar_style',
			),
			'allow-override' => 'allow',
			'has-help'       => true,
		),
		'admin/footer.php'                      => array(
			'module'         => 'admin-footer-text',
			'name'           => __( 'Admin-Fußzeile', 'ub' ),
			'description'    => __( 'Zeige in der Fußzeile jeder Administrationsseite einen benutzerdefinierten Text an. ', 'ub' ),
			'group'          => 'admin',
			'options'        => array(
				'ub_admin_footer',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'admin_footer_text',
			),
			'allow-override' => 'allow',
		),
		/**
		 * Admin menu
		 *
		 * @since 1.0.0
		 */
		'admin/menu.php'                        => array(
			'module'         => 'admin_menu',
			'since'          => '1.0.0',
			'name'           => __( 'Admin-Menü', 'ub' ),
			'description'    => __( 'Mit diesem Modul kannst Du das Admin-Menü vollständig nach Benutzerrolle oder nach benutzerdefiniertem Benutzer anpassen. Du kannst die Menüelemente nach Bedarf hinzufügen, ausblenden und neu anordnen. Du kannst den Link Manager oder den Link "Dashboard" im Admin-Bereich für Benutzer ohne Webseite aktivieren (in WP Multisite).', 'ub' ),
			'group'          => 'admin',
			'public'         => true,
			'wp'             => '3.5',
			'options'        => array(
				'ub_admin_menu',
				'ub_custom_admin_menu',
			),
			'allow-override' => 'allow',
		),
		/**
		 * Admin Message
		 */
		'admin/message.php'                     => array(
			'module'         => 'admin-message',
			'name'           => __( 'Admin-Nachricht', 'ub' ),
			'description'    => __( 'Zeige eine benutzerdefinierte Nachricht auf den ClassicPress-Administrationsseiten an.', 'ub' ),
			'group'          => 'admin',
			'options'        => array(
				'ub_admin_message',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'admin_message',
			),
			'allow-override' => 'allow',
			'has-help'       => true,
		),
		/**
		 * Color Schemes
		 */
		'admin/color-schemes.php'               => array(
			'module'         => 'color-schemes',
			'name'           => __( 'Farbschemata', 'ub' ),
			'description'    => __( 'Wähle aus, welche Farbschemata im Benutzerprofil verfügbar sein sollen, erzwinge das Farbschema für jeden Benutzer auf der Webseite/im Netzwerk oder lege das Standardfarbschema für neu registrierte Benutzer fest.', 'ub' ),
			'group'          => 'admin',
			'public'         => true,
			'options'        => array(
				'ub_color_schemes',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'ucs_admin_active_plugin_border_color',
				'ucs_admin_active_theme_actions_background_color',
				'ucs_admin_active_theme_background_color',
				'ucs_admin_active_theme_details_background_color',
				'ucs_admin_bar_background_color',
				'ucs_admin_bar_icon_color',
				'ucs_admin_bar_item_hover_background_color',
				'ucs_admin_bar_item_hover_focus_background',
				'ucs_admin_bar_item_hover_focus_color',
				'ucs_admin_bar_item_hover_text_color',
				'ucs_admin_bar_submenu_icon_color',
				'ucs_admin_bar_text_color',
				'ucs_admin_media_progress_bar_color',
				'ucs_admin_media_selected_attachment_color',
				'ucs_admin_menu_background_color',
				'ucs_admin_menu_bubble_background_color',
				'ucs_admin_menu_bubble_text_color',
				'ucs_admin_menu_current_background_color',
				'ucs_admin_menu_current_icons_color',
				'ucs_admin_menu_current_link_color',
				'ucs_admin_menu_current_link_hover_color',
				'ucs_admin_menu_icons_color',
				'ucs_admin_menu_link_color',
				'ucs_admin_menu_link_hover_background_color',
				'ucs_admin_menu_link_hover_color',
				'ucs_admin_menu_submenu_background_color',
				'ucs_admin_menu_submenu_link_color',
				'ucs_admin_menu_submenu_link_hover_color',
				'ucs_background_color',
				'ucs_checkbox_radio_color',
				'ucs_color_scheme_name',
				'ucs_default_color_scheme',
				'ucs_default_link_hover_color',
				'ucs_delete_trash_spam_link_color',
				'ucs_delete_trash_spam_link_hover_color',
				'ucs_disabled_button_background_color',
				'ucs_disabled_button_text_color',
				'ucs_force_color_scheme',
				'ucs_inactive_plugins_color',
				'ucs_primary_button_background_color',
				'ucs_primary_button_hover_background_color',
				'ucs_primary_button_hover_text_color',
				'ucs_primary_button_text_color',
				'ucs_primary_button_text_color_shadow',
				'ucs_primary_button_text_color_shadow_hover',
				'ucs_table_alternate_row_color',
				'ucs_table_list_hover_color',
				'ucs_table_post_comment_icon_color',
				'ucs_table_post_comment_strong_icon_color',
				'ucs_table_view_switch_icon_color',
				'ucs_table_view_switch_icon_hover_color',
				'ucs_visible_color_schemes',
			),
			'allow-override' => 'allow',
		),
		/**
		 * Admin Custom CSS
		 */
		'admin/custom-css.php'                  => array(
			'module'         => 'custom-admin-css',
			'name'           => __( 'Benutzerdefinierte CSS', 'ub' ),
			'description'    => $pstoolkit_network ? __( 'Füge benutzerdefiniertes CSS hinzu, das dem Header jeder Administrationsseite für jede Webseite hinzugefügt wird.', 'ub' ) : __( 'Füge benutzerdefiniertes CSS hinzu, das dem Header jeder Administrationsseite hinzugefügt wird.', 'ub' ),
			'group'          => 'admin',
			'options'        => array(
				'ub_admin_css',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'global_admin_css',
			),
			'allow-override' => 'allow',
			'has-help'       => true,
		),
		'admin/help-content.php'                => array(
			'module'         => 'admin-help-content',
			'name'           => __( 'Hilfeinhalt', 'ub' ),
			'description'    => __( 'Ändere den vorhandenen Hilfeinhalt, füge ein neues Hilfeelement hinzu oder füge eine Hilfeseitenleiste hinzu. ', 'ub' ),
			'group'          => 'admin',
			'options'        => array(
				'ub_admin_help_items',
				'ub_admin_help',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'admin_help_content',
			),
			'allow-override' => 'allow',
			'has-help'       => true,
		),
		/**
		 * Images
		 *
		 * @since 1.0.0
		 */
		'utilities/images.php'                  => array(
			'module'         => 'images',
			'since'          => '1.0.0',
			'name'           => __( 'Bilder', 'ub' ),
			'description'    => __( 'Füge ein Favicon hinzu und überschreibe das Standardlimit für die Bilddateigröße von ClassicPress basierend auf verschiedenen Benutzerrollen.', 'ub' ),
			'group'          => 'utilities',
			'public'         => true,
			'wp'             => '4.3',
			'options'        => array(
				'ub_images',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'ub_img_upload_filesize_Administrator',
				'ub_img_upload_filesize_Author',
				'ub_img_upload_filesize_Editor',
				'ub_img_upload_filesize_Contributor',
				'ub_img_upload_filesize_Subscriber',
				'ub_img_upload_filesize_administrator',
				'ub_img_upload_filesize_author',
				'ub_img_upload_filesize_editor',
				'ub_img_upload_filesize_contributor',
				'ub_img_upload_filesize_subscriber',
				'ub_favicons',
			),
			'allow-override' => 'allow',
			'has-help'       => true,
		),
		/**
		 * Site Generator
		 */
		'utilities/site-generator.php'          => array(
			'module'         => 'site-generator',
			'name'           => __( 'Seiten Generator', 'ub' ),
			'description'    => __( 'Ändere die "Generatorinformationen" und "Generatorlink" von ClassicPress in etwas, das Du bevorzugst.', 'ub' ),
			'public'         => true,
			'group'          => 'utilities',
			'options'        => array(
				'ub_site_generator_replacement',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'site_generator_replacement',
				'site_generator_replacement_link',
			),
			'allow-override' => 'allow',
			'has-help'       => true,
		),
		/**
		 * Text Replacement
		 */
		'utilities/text-replacement.php'        => array(
			'module'           => 'text-replacement',
			'name'             => __( 'Textersetzung', 'ub' ),
			'description'      => __( 'Ersetze jeglichen Text von Deinen Admin-Seiten und/oder Front-End-Seiten durch eine benutzerfreundliche Oberfläche. Damit kannst Du beispielsweise das Wort „ClassicPress“ durch Deinen eigenen Webseiten-Namen ersetzen.', 'ub' ),
			'public'           => true,
			'group'            => 'utilities',
			'options'          => array(
				'ub_text_replacement',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'translation_table',
			),
			'status-indicator' => 'hide',
			'allow-override'   => 'allow',
			'has-help'         => true,
		),
		/**
		 * Website Mode
		 *
		 * @since 1.2.1
		 */
		'utilities/maintenance.php'             => array(
			'module'         => 'maintenance',
			'name'           => __( 'Webseiten-Modus', 'ub' ),
			'wp'             => '4.6',
			'since'          => '1.2.1',
			'description'    => __( 'Aktiviere den Wartungsmodus oder den Coming Soon-Modus für Deine Webseite und erstelle eine benutzerdefinierte Seite, die Deinen Besuchern angezeigt wird.', 'ub' ),
			'public'         => true,
			'group'          => 'utilities',
			'options'        => array( 'ub_maintenance' ),
			'allow-override' => 'allow',
		),
		/**
		 * Comments Control
		 *
		 * @since 1.2.6
		 */
		'utilities/comments-control.php'        => array(
			'module'         => 'comments-control',
			'name'           => __( 'Kommentarsteuerung', 'ub' ),
			'description'    => __( 'Deaktiviere die Kommentare zu den Beiträgen, Seiten oder auf Deiner gesamten Webseite. Erweiterte Optionen wie Whitelisting-IPs sind ebenfalls verfügbar.', 'ub' ),
			'wp'             => '3.9',
			'public'         => true,
			'group'          => 'utilities',
			'options'        => array(
				'ub_comments_control',
				'ub_comments_control_cpt',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'limit_comments_allowed_ips',
				'limit_comments_denied_ips',
			),
			'allow-override' => 'allow',
		),
		/**
		 * Tracking codes
		 *
		 * @since 1.3.0
		 */
		'utilities/tracking-codes.php'          => array(
			'module'           => 'tracking-codes',
			'since'            => '1.3.0',
			'name'             => __( 'Tracking-Codes', 'ub' ),
			'description'      => __( 'Aktiviere dieses Modul, um den Tracking-Code in Deine Webseite einzufügen. Du kannst den Code an verschiedenen Stellen einfügen, zB &lt;head&gt;, nach &lt;body&gt; oder vor &lt;/body&gt;. Es besteht auch die Möglichkeit, den Code auf der gesamten Webseite einzufügen oder unter bestimmten Bedingungen einzufügen.', 'ub' ),
			'group'            => 'utilities',
			'public'           => true,
			'options'          => array( 'ub_tracking_codes' ),
			'status-indicator' => 'hide',
			'allow-override'   => 'allow',
		),
		'emails/headers.php'                    => array(
			'module'         => 'emails-header',
			'name'           => __( 'Von Header', 'ub' ),
			'description'    => __( 'Lege einen Standard-Absendernamen und eine Absender-E-Mail für Deine ausgehenden ClassicPress-E-Mails fest.', 'ub' ),
			'public'         => true,
			'group'          => 'emails',
			'options'        => array(
				'ub_emails_headers',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'ub_from_email',
				'ub_from_name',
			),
			'allow-override' => 'allow',
		),
		/**
		 * Email Template
		 *
		 * @since 1.2.4
		 */
		'emails/template.php'                   => array(
			'module'         => 'email-template',
			'name'           => __( 'E-Mail-Vorlage', 'ub' ),
			'description'    => __( 'Höre auf, nur Text-E-Mails von Deiner Website zu senden. Wähle entweder aus unseren vorgefertigten E-Mail-Vorlagen oder bringe Deine eigene HTML-Vorlage mit. Dieses Plugin umschließt jede in der HTML-Vorlage gesendete ClassicPress-E-Mail.', 'ub' ),
			'public'         => true,
			'group'          => 'emails',
			'options'        => array(
				'ub_email_template',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'html_template',
			),
			'allow-override' => 'allow',
		),
		/**
		 * Custom Login Screen
		 *
		 * @since 1.8.5
		 */
		'login-screen/login-screen.php'         => array(
			'module'         => 'login-screen',
			'menu_title'     => __( 'Anmeldebildschirm', 'ub' ),
			'wp'             => '4.6',
			'name'           => __( 'Anmeldebildschirm anpassen', 'ub' ),
			'description'    => __( 'Passe den Standard-Anmeldebildschirm mit diesem Modul an. Du kannst entweder mit einer unserer vorgefertigten Vorlagen beginnen oder von vorne beginnen.', 'ub' ),
			'public'         => true,
			'group'          => 'front-end',
			'options'        => array(
				'ub_login_screen',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'global_login_css',
			),
			'allow-override' => 'allow',
			'has-help'       => true,
		),
		/**
		 * Blog creation: signup code
		 *
		 * @since 1.2.1
		 */
		'login-screen/signup-code.php'          => array(
			'module'         => 'signup-code',
			'name'           => __( 'Benutzerregistrierung', 'ub' ),
			'description'    => __( 'Passe die Standardanmeldefunktion mit diesem Modul an. Mit der Anmeldecode-Funktion kannst Du die Benutzer- und Blog-Registrierungen auf den Benutzer mit einem bestimmten Anmeldecode beschränken.', 'ub' ),
			'since'          => '1.2.1',
			'public'         => true,
			'group'          => 'front-end',
			'options'        => array( 'ub_signup_codes' ),
			'allow-override' => 'no', // Global only
		),
		/**
		 * db-error-page
		 *
		 * @since 2.0.0
		 */
		'front-end/db-error-page.php'           => array(
			'module'         => 'db-error-page',
			'main-blog-only' => true,
			'since'          => '2.0.0',
			'name'           => __( 'DB-Fehlerseite', 'ub' ),
			'description'    => __( 'Erstelle eine benutzerdefinierte Datenbankfehlerseite, damit Deine Besucher beim nächsten Mal nicht nur den Textfehler "Fehler beim Herstellen einer Datenbankverbindung" sehen.', 'ub' ),
			'group'          => 'front-end',
			'options'        => array( 'ub_db_error_page' ),
			'allow-override' => 'no', // Global only
		),
		/**
		 * ms-site-check
		 *
		 * @since 2.0.0
		 */
		'front-end/site-status-page.php'        => array(
			'module'         => 'ms-site-check',
			'network-only'   => true,
			'main-blog-only' => true,
			'since'          => '2.0.0',
			'name'           => __( 'Webseiten-Statusseiten', 'ub' ),
			'description'    => __( 'Erstelle benutzerdefinierte Seiten für gelöschte, inaktive, archivierte oder Spam-Blogs.', 'ub' ),
			'group'          => 'front-end',
			'options'        => array( 'ub_ms_site_check' ),
			'allow-override' => 'no', // Global only
		),
		'content/header.php'                    => array(
			'module'         => 'content-header',
			'name'           => __( 'Header-Inhalt', 'ub' ),
			'description'    => __( 'Füge jeden gewünschten Inhalt in die Kopfzeile jeder Seite Deines Multisite-Netzwerks ein. Du kannst beispielsweise einige Nachrichten/Benachrichtigungen für Deine Besucher über den regulären Webseiten-Header setzen.', 'ub' ),
			'public'         => true,
			'group'          => 'front-end',
			'options'        => array(
				'ub_content_header',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'global_header_content',
			),
			'allow-override' => 'allow',
			'has-help'       => true,
		),
		'content/footer.php'                    => array(
			'module'         => 'content-footer',
			'name'           => __( 'Fußzeileninhalt', 'ub' ),
			'description'    => __( 'Füge beliebige Inhalte in die Fußzeile jedes Blogs oder jeder Webseite in Deinem Netzwerk ein. Du kannst beispielsweise Einbettungen, Nutzungsbedingungen usw. hinzufügen.', 'ub' ),
			'public'         => true,
			'group'          => 'front-end',
			'options'        => array( 'ub_global_footer_content' ),
			'allow-override' => 'allow',
		),
		/**
		 * Cookie Notice
		 *
		 * @since 1.2.0
		 */
		'front-end/cookie-notice.php'           => array(
			'module'         => 'cookie-notice',
			'since'          => '1.2.0',
			'name'           => __( 'Cookie-Hinweis', 'ub' ),
			'description'    => __( 'Mit Cookie Notice kannst Du Benutzer elegant darüber informieren, dass Deine Webseite Cookies verwendet, und die DSGVO-Bestimmungen des EU-Cookie-Gesetzes einhalten.', 'ub' ),
			'public'         => true,
			'group'          => 'front-end',
			'options'        => array( 'ub_cookie_notice' ),
			'allow-override' => 'allow',
		),
		/**
		 * Author Box
		 *
		 * @since 1.2.1
		 */
		'front-end/author-box.php'              => array(
			'module'         => 'author-box',
			'name'           => __( 'Autorenbox', 'ub' ),
			'description'    => __( 'Fügt am Ende Deiner Beiträge ein ansprechendes Autorenfeld hinzu, in dem der Autorenname, der Autorengravatar sowie die Autorenbeschreibung und die sozialen Profile angezeigt werden.', 'ub' ),
			'public'         => true,
			'group'          => 'front-end',
			'options'        => array( 'ub_author_box' ),
			'allow-override' => 'allow',
		),
		/**
		 * Custom MS email content
		 *
		 * @since 1.2.6
		 */
		'emails/registration.php'               => array(
			'module'         => 'registration-emails',
			'network-only'   => true,
			'main-blog-only' => true,
			'menu_title'     => __( 'Registration Email', 'ub' ),
			'name'           => __( 'MultiSite Registration Emails', 'ub' ),
			'description'    => __( 'Passe den Inhalt der neuen Blog-Benachrichtigungs-E-Mail, der neuen Benutzer-Anmelde-E-Mail oder der Begrüßungs-E-Mail an, die nach der Aktivierung der Webseite in Deinem Netzwerk mit mehreren Webseiten gesendet wird.', 'ub' ),
			'public'         => true,
			'group'          => 'emails',
			'options'        => array(
				'ub_registration_emails',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'global_ms_register_mails',
			),
			'allow-override' => 'no', // Global functionality.
		),
		/**
		 * Accessibility settings.
		 *
		 * @since 1.0.0
		 */
		'utilities/accessibility.php'           => array(
			'module'                 => 'accessibility',
			'name'                   => __( 'Barrierefreiheit', 'ub' ),
			'description'            => __( 'Aktiviere die Unterstützung für alle verfügbaren Verbesserungen der Barrierefreiheit.', 'ub' ),
			'group'                  => 'data',
			'instant'                => 'on',
			'options'                => array( 'ub_accessibility' ),
			'add-bottom-save-button' => true,
			'hide-on-dashboard'      => true,
			'allow-override'         => 'allow',
			'allow-override-message' => 'hide',
		),
		/**
		 * Export
		 *
		 * @since 1.2.6
		 */
		'utilities/export.php'                  => array(
			'module'                 => 'export',
			'name'                   => __( 'Exportieren', 'ub' ),
			'description'            => __( 'Verwende dieses Tool, um die CP Toolkit-Konfigurationen zu exportieren.', 'ub' ),
			'group'                  => 'data',
			'instant'                => 'on',
			'allow-override'         => 'allow',
			'allow-override-message' => 'hide',
		),
		/**
		 * Import
		 *
		 * @since 1.2.6
		 */
		'utilities/import.php'                  => array(
			'module'                 => 'import',
			'name'                   => __( 'Importieren', 'ub' ),
			'description'            => __( 'Verwende dieses Tool, um die CP Toolkit-Konfigurationen zu importieren.', 'ub' ),
			'group'                  => 'data',
			'instant'                => 'on',
			'allow-override'         => 'allow',
			'allow-override-message' => 'hide',
		),
		/**
		 * Dashboard Widgets
		 *
		 * @since 1.0.0
		 */
		'widgets/dashboard-widgets.php'         => array(
			'module'         => 'dashboard-widgets',
			'since'          => '2.0.0',
			'name'           => __( 'Dashboard Widgets', 'ub' ),
			'description'    => __( 'Entferne Standard-Widgets aus dem Dashboard, passe die Begrüßungsnachricht des Dashboards an oder füge dem Dashboard neue Text-Widgets hinzu.', 'ub' ),
			'group'          => 'widgets',
			'options'        => array(
				'ub_dashboard_widgets',
				'ub_dashboard_widgets_items',
				'ub_rwp_all_active_dashboard_widgets',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'ub_custom_welcome_message',
				'ub_remove_wp_dashboard_widgets',
				'psource_dashboard_text_widgets_options',
			),
			'allow-override' => 'allow',
			'has-help'       => true,
		),
		/**
		 * Dashboard Feeds
		 *
		 * @since 1.2.6
		 */
		'widgets/dashboard-feeds.php'           => array(
			'module'           => 'dashboard-feeds',
			'name'             => __( 'Dashboard Feeds', 'ub' ),
			'description'      => __( 'Passe das Dashboard mit diesem einfachen Widget zum Ersetzen von Dashboard-Feeds blitzschnell für jeden Benutzer an. Keine WP-Entwicklungsnachrichten oder Matts aktuelles Fotoset mehr.', 'ub' ),
			'group'            => 'widgets',
			'wp'               => '3.8',
			'options'          => array(
				'pstoolkit_dashboard_feeds',
				/**
				 * Deprecated options names before PSToolkit 2.0.0
				 *
				 * @since 1.0.0
				 */
				'psource_df_widget_options',
			),
			'status-indicator' => 'hide',
			'allow-override'   => 'allow',
		),
		'widgets/meta-widget.php'               => array(
			'module'           => 'rebranded-meta-widget',
			'name'             => __( 'Meta Widget', 'ub' ),
			'description'      => __( 'Benenne das Standard-Meta-Widget in allen Blogs mit mehreren Webseiten mit einem Widget mit dem Link "Powered By" für Deine Webseite. Der Link "ClassicPress.org" im Meta-Widget wird durch den Titel Deiner Webseite ersetzt, der auf Deine Webseite verweist.', 'ub' ),
			'public'           => true,
			'group'            => 'widgets',
			'status-indicator' => 'hide',
			'allow-override'   => 'no', // No configuration!
		),
		/**
		 * Blog creation
		 *
		 * @since 1.2.6
		 */
		'front-end/signup-blog-description.php' => array(
			'module'           => 'signup-blog-description',
			'network-only'     => true,
			'menu_title'       => __( 'Blog Beschreibung', 'ub' ),
			'name'             => __( 'Blog-Beschreibung zur Blog-Erstellung', 'ub' ),
			'description'      => __( 'Ermöglicht neuen Bloggern, ihren Slogan festzulegen, wenn sie einen Blog in Multisite erstellen.', 'ub' ),
			'public'           => true,
			'group'            => 'front-end',
			'options'          => array( '' ),
			'allow-override'   => 'no', // MU only
			'status-indicator' => 'hide',
		),
		/**
		 * SMTP
		 *
		 * @since 2.0.0
		 */
		'emails/smtp.php'                       => array(
			'module'         => 'smtp',
			'since'          => '1.0.0',
			'name'           => __( 'SMTP', 'ub' ),
			'name_alt'       => __( 'SMTP-Konfiguration', 'ub' ),
			'description'    => __( 'Mit SMTP kannst Du alle ausgehenden E-Mails über einen SMTP-Server konfigurieren und senden. Dadurch wird verhindert, dass Deine E-Mails in den Junk-/Spam-Ordner der Empfänger gelangen.', 'ub' ),
			'public'         => true,
			'group'          => 'emails',
			'options'        => array( 'ub_smtp' ),
			'allow-override' => 'allow',
		),
		/**
		 * Email Logs.
		 *
		 * @since 3.4
		 */
		'emails/email-logs.php'                 => array(
			'module'           => 'email-logs',
			'since'            => '1.4',
			'name'             => __( 'Email Logs', 'ub' ),
			'name_alt'         => __( 'Email Logs', 'ub' ),
			'description'      => __( 'Mit dem Psource CP Toolkit erhältst Du detaillierte Informationen zu Deinen E-Mails. Du kannst die Empfängerinformationen überprüfen und den gesamten Protokollverlauf exportieren.', 'ub' ),
			'public'           => true,
			'only_pro'         => false,
			'group'            => 'emails',
			'options'          => array( 'ub_email_logs' ),
			'status-indicator' => 'hide',
			'allow-override'   => 'allow',
		),
		/**
		 * Document
		 *
		 * @since 2.3.0
		 */
		'front-end/document.php'                => array(
			'module'         => 'document',
			'since'          => '1.3.0',
			'name'           => __( 'Dokument', 'ub' ),
			'description'    => __( 'Ermögliche das Ändern der Standardeinstellungen für die Eintragsanzeige.', 'ub' ),
			'group'          => 'front-end',
			'public'         => true,
			'options'        => array( 'ub_document' ),
			'allow-override' => 'allow',
		),
		/**
		 * Theme Additional CSS
		 *
		 * @since 3.1.3
		 */
		'admin/theme-additional-css.php'        => array(
			'module'       => 'theme-additional-css',
			'network-only' => true,
			'name'         => __( 'Customizer', 'ub' ),
			'description'  => __( 'Mit dieser Funktion können Administratoren von Unterwebseiten benutzerdefiniertes CSS über das Theme Customizer-Tool hinzufügen.', 'ub' ),
			'group'        => 'admin',
			'public'       => true,
			'options'      => array(
				'ub_theme_additional_css',
			),
		),
	);
	/**
	 * filter by WP version
	 */
	foreach ( $modules as $slug => $data ) {
		if ( isset( $data['wp'] ) ) {
			$compare = version_compare( $wp_version, $data['wp'] );
			if ( 0 > $compare ) {
				unset( $modules[ $slug ] );
			}
		}
	}
	apply_filters( 'pstoolkit_available_modules', $modules );
	$keys = array_keys( $modules );
	sort( $keys );
	$pstoolkit_modules_list = $keys;
	if ( 'keys' == $mode ) {
		return $keys;
	}
	return $modules;
}

