<?php
/**
 * Various helper functions needed throughout the plugin.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Functions
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.0.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.7.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Determining a certain version of WordPress for easier version comparing.
 *
 * @since 1.8.0
 *
 * @param $wpversion String for a given WordPress version for checking.
 *
 * @global string $GLOBALS[ 'wp_version' ]
 *
 * @return bool $is_version If checked version is TRUE or FALSE.
 */
function ddw_mstba_is_wpversion( $wpversion = '' ) {

	$is_version = ( version_compare( $GLOBALS[ 'wp_version' ], esc_attr( $wpversion ), '>='
	) ) ? TRUE : FALSE;

	return $is_version;

}  // end function


/**
 * Check for active plugin "WP German Formal" plus German locale based install.
 *
 * @since 1.7.0
 *
 * @uses get_locale()
 *
 * @return bool TRUE if plugin "WP German Formal" is active and we are in a
 *              German locale based install, otherwise FALSE.
 */
function ddw_mstba_is_wpgermanformal() {
	
	if ( defined( 'WPGF_PLUGIN_BASEDIR' )
		&& in_array( get_locale(), array( 'de_DE', 'de_AT', 'de_CH', 'de_LU', 'gsw' ) )
	) {

		return TRUE;

	}  // end if

	return FALSE;

}  // end function


/**
 * String for "Dashboard" - re-useable and filterable.
 *
 * @since 1.7.0
 *
 * @uses ddw_mstba_is_wpgermanformal()
 *
 * @return array $dashboard_string Array of varios string for "Dashboard" contexts - filterable.
 */
function ddw_mstba_string_dashboard() {

	/** Array of "Dashboard" strings */	
	$dashboard_string = apply_filters(
		'mstba_filter_string_dashboard',
		array(
			'dashboard'           => ddw_mstba_is_wpgermanformal() ? __( 'Guide', 'multisite-toolbar-additions' ) : __( 'Dashboard', 'multisite-toolbar-additions' ),
			'dashboard_main_site' => ddw_mstba_is_wpgermanformal() ? _x( 'Guide (Main Site)', 'Translators: For the tooltip', 'multisite-toolbar-additions' ) : _x( 'Dashboard (Main Site)', 'Translators: For the tooltip', 'multisite-toolbar-additions' ),
		)
	);

	/** Return the array */
	return (array) $dashboard_string;

}  // end function


/**
 * String for Super Admin menu location.
 *
 * @since 1.0.0
 * @version 1.7.0
 *
 * @uses is_multisite()
 *
 * @global $GLOBALS[ 'wp_customize' ]
 *
 * @return string $mstba_menu_string String for menu location.
 */
function ddw_mstba_string_super_admin_menu_location() {

	/** Helper strings */
	$string_via       = esc_html__( 'via Plugin', 'multisite-toolbar-additions' );
	$string_plugin    = esc_html__( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' );
	$string_site_type = ( is_multisite() ) ? __( 'Multisite', 'multisite-toolbar-additions' ) : __( 'Site', 'multisite-toolbar-additions' );

	/** Build menu location string */
	if ( isset( $GLOBALS[ 'wp_customize' ] ) ) {

		$mstba_menu_string = sprintf(
			/* translators: %s - Type of install/site: "Multisite" or "Site" */
			esc_attr__( '%s Toolbar Menu', 'multisite-toolbar-additions' ),
			$string_site_type
		);

	} else {

		$mstba_menu_string = sprintf(
			/* translators: %s - Type of install/site: "Multisite" or "Site" */
			'<span title="%s: %s">' . esc_attr__( '%s Toolbar Menu', 'multisite-toolbar-additions' ) . '</span>',
			$string_via,
			$string_plugin,
			$string_site_type
		);

	}  // end if

	/** Output */
	return $mstba_menu_string;
	
}  // end function


/**
 * String for restricted Site Admin menu location.
 *
 * @since 1.7.0
 *
 * @global $GLOBALS[ 'wp_customize' ]
 *
 * @return string $mstba_menu_string String for menu location.
 */
function ddw_mstba_string_restricted_admin_menu_location() {

	/** Helper strings */
	$string_restricted = __( 'Restricted Site Admin Menu', 'multisite-toolbar-additions' );
	$string_toolbar    = __( 'Toolbar', 'multisite-toolbar-additions' );

	/** Build menu location string */
	if ( isset( $GLOBALS[ 'wp_customize' ] ) ) {

		$mstba_menu_string = sprintf(
			'<span title="%s: %s">%s (%s)</span>',
			esc_html__( 'via Plugin', 'multisite-toolbar-additions' ),
			esc_html__( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' ),
			$string_restricted,
			$string_toolbar
		);

	} else {

		$mstba_menu_string = sprintf(
			'%s (%s)',
			$string_restricted,
			$string_toolbar
		);

	}  // end if

	/** Output */
	return $mstba_menu_string;

}  // end function


/**
 * Filterable capability for custom site admin menus.
 *    Default: 'edit_theme_options'
 *
 * @since 1.7.0
 *
 * @return string String of capability ID.
 */
function ddw_mstba_restricted_admin_menu_cap() {

	/** Set filterable cap */
	return sanitize_key(
		apply_filters(
			'mstba_filter_restricted_admin_menu_cap',
			'edit_theme_options'
		)
	);

}  // end function


/**
 * Restrict editing access of special custom "Super Admin Admin" toolbar menu.
 *
 * @since 1.7.0
 *
 * @uses ddw_mstba_restrict_nav_menu_edit_access()
 */
function ddw_mstba_restrict_super_admin_menu_access() {

	ddw_mstba_restrict_nav_menu_edit_access(
		'mstba_menu',
		'edit_theme_options'
	);

}  // end function


/**
 * Restrict editing access of special custom "Restricted Admin" toolbar menu.
 *
 * @since 1.7.0
 *
 * @uses ddw_mstba_restrict_nav_menu_edit_access()
 * @uses ddw_mstba_restricted_admin_menu_cap()
 */
function ddw_mstba_restrict_admin_menu_access() {

	ddw_mstba_restrict_nav_menu_edit_access(
		'mstba_restricted_admin_menu',
		ddw_mstba_restricted_admin_menu_cap()
	);

}  // end function


/**
 * Get the ID of a nav menu that is set to one of our special menu locations.
 *
 * @since 1.7.0
 *
 * @uses get_nav_menu_locations()
 *
 * @param string $single_menu_location
 *
 * @return string String of nav menu ID if menu set to menu location, 
 *                otherwise empty string.
 */
function ddw_mstba_get_menu_id_from_menu_location( $single_menu_location ) {

	$menu_id = '';

	/** Get menu locations */
	$menu_locations = get_nav_menu_locations();

	/** Check our special location */
	if ( isset( $menu_locations[ esc_attr( $single_menu_location ) ] ) ) {

		/** Get ID of nav menu */
		$menu_id = $menu_locations[ esc_attr( $single_menu_location ) ];

	} // end if

	/** Return ID of nav menu */
	return $menu_id;

}  // end function


/**
 * Keep 'administrator' users from editing this special admin menu.
 *
 * NOTE I:  Eventually, the real blocking depends on (filterable)
 *          'edit_theme_options' cap.
 * NOTE II: Super admins have full access, of course! :)
 *
 * @since 1.7.0
 *
 * @uses ddw_mstba_get_menu_id_from_menu_location()
 *
 * @param string $single_menu_location
 * @param string $checked_capability
 *
 * @global object $GLOBALS[ 'pagenow' ]
 */
function ddw_mstba_restrict_nav_menu_edit_access( $single_menu_location, $checked_capability ) {

	/** Bail early if current user is Super Admin */
	if ( is_super_admin() ) {

		return;

	}  // end if

	$menu_id = absint( ddw_mstba_get_menu_id_from_menu_location( esc_attr( $single_menu_location ) ) );

	/**
	 * Only for admin users remove edit access to the appended restricted admin menu.
	 *  - only in edit menu context for nav-menus.php
	 *  - only for the ID of the menu appended to our menu location.
	 */
	if ( ( current_user_can( esc_attr( $checked_capability ) ) /*|| current_user_can( 'administrator' )*/ )
		&& 'nav-menus.php' === $GLOBALS[ 'pagenow' ]
		&& (
				isset( $_GET[ 'action' ] )
				&& 'edit' === sanitize_key( wp_unslash( $_GET[ 'action' ] ) )
			)
		&& (
				isset( $_GET[ 'menu' ] )
				&& $menu_id === absint( $_GET[ 'menu' ] )
			)
	) {

		$mstba_deactivation_message = __( 'You have no sufficient permission to edit this special menu.', 'multisite-toolbar-additions' );

		wp_die(
			$mstba_deactivation_message,
			__( 'Plugin', 'multisite-toolbar-additions' ) . ': ' . __( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' ),
			array( 'back_link' => TRUE )
		);

	}  // end if

}  // end function


/**
 * Helper function for returning plugin installer admin url.
 *
 * @since 1.8.0
 *
 * @uses ddw_mstba_is_wpversion() For WP version check.
 * @uses network_admin_url()
 *
 * @return string String of admin url.
 */
function ddw_mstba_plugin_install_link() {

	/** For WordPress 4.0+ */
	if ( ddw_mstba_is_wpversion( '4.0' ) ) {

		return network_admin_url( 'plugin-install.php?tab=featured' );

	} // end if

	return network_admin_url( 'plugin-install.php?tab=dashboard' );

}  // end function


/**
 * Helper function for returning theme installer admin url.
 *
 * @since 1.7.1
 *
 * @uses ddw_mstba_is_wpversion() For WP version check.
 * @uses network_admin_url()
 *
 * @return string String of admin url.
 */
function ddw_mstba_theme_install_link() {

	/** For WordPress 3.9+ */
	if ( ddw_mstba_is_wpversion( '3.9' ) ) {

		return network_admin_url( 'theme-install.php' );

	} // end if

	return network_admin_url( 'theme-install.php?tab=dashboard' );

}  // end function


/**
 * Helper function for returning theme uploader admin url.
 *
 * @since 1.7.1
 *
 * @uses ddw_mstba_is_wpversion() For WP version check.
 * @uses network_admin_url()
 *
 * @return string String of admin url.
 */
function ddw_mstba_theme_upload_link() {

	/** For WordPress 3.9+ wp_ajax_query_themes */
	if ( ddw_mstba_is_wpversion( '3.9' ) ) {

		return network_admin_url( 'theme-install.php?upload' );

	} // end if

	return network_admin_url( 'theme-install.php?tab=upload' );

}  // end function


/**
 * Helper function for generating custom links.
 *
 * @since 1.7.1
 *
 * @param string $site
 * @param int    $ref
 * @param bool   $www
 * @param bool   $ssl
 *
 * @return string $link String of external url.
 */
function ddw_mstba_affwp( $site = '', $ref = '', $www = FALSE, $ssl = FALSE ) {

	/** Build link */
	$link = sprintf(
		'%1$s://%2$s%3$s?ref=%4$s',
		( $ssl ) ? 'https' : 'http',
		( $www ) ? 'www.' : '',
		esc_attr( $site ),
		esc_attr( $ref )
	);

	/** Output */
	return esc_url_raw( $link );

}  // end function


/**
 * Setting internal plugin helper values.
 *
 * @since 1.7.0
 * @since 2.0.0 Added Newsletter URL.
 *
 * @return array $mstba_info Array of info values.
 */
function ddw_mstba_info_values() {

	/** Get current user */
	$user = wp_get_current_user();

	/** Build Newsletter URL */
	$url_nl = sprintf(
		'https://deckerweb.us2.list-manage.com/subscribe?u=e09bef034abf80704e5ff9809&amp;id=380976af88&amp;MERGE0=%1$s&amp;MERGE1=%2$s',
		esc_attr( $user->user_email ),
		esc_attr( $user->user_firstname )
	);

	$mstba_info = array(

		'url_translate'     => 'https://translate.wordpress.org/projects/wp-plugins/multisite-toolbar-additions',
		'url_wporg_faq'     => 'https://wordpress.org/plugins/multisite-toolbar-additions/#faq',
		'url_wporg_forum'   => 'https://wordpress.org/support/plugin/multisite-toolbar-additions',
		'url_wporg_profile' => 'https://profiles.wordpress.org/daveshine/',
		'url_wporg_more'    => 'https://wordpress.org/plugins/search.php?q=toolbar+multisite',
		'url_ddw_series'    => 'https://wordpress.org/plugins/tags/ddwtoolbar',
		'url_snippets'      => 'https://gist.github.com/deckerweb/3498510',
		'url_fb_group'      => 'https://www.facebook.com/groups/ToolbarExtras/',
		'license'           => 'GPL-2.0-or-later',
		'url_license'       => 'https://opensource.org/licenses/GPL-2.0',
		'first_code'        => '2012',
		'url_donate'        => 'https://www.paypal.me/deckerweb',
		'url_newsletter'    => $url_nl,
		'url_plugin'        => 'https://github.com/deckerweb/multisite-toolbar-additions',
		'author'            => __( 'David Decker - DECKERWEB', 'multisite-toolbar-additions' ),
		'author_uri'        => 'https://deckerweb.de/',

	);  // end array

	return $mstba_info;

}  // end function


/**
 * Get URL of specific MSTBA info value.
 *
 * @since 1.9.1
 *
 * @uses ddw_mstba_info_values()
 *
 * @param string $url_key String of value key from array of ddw_mstba_info_values()
 * @param bool   $raw     If raw escaping or regular escaping of URL gets used
 * @return string URL for info value.
 */
function ddw_mstba_get_info_url( $url_key = '', $raw = FALSE ) {

	$mstba_info = (array) ddw_mstba_info_values();

	$output = esc_url( $mstba_info[ sanitize_key( $url_key ) ] );

	if ( TRUE === $raw ) {
		$output = esc_url_raw( $mstba_info[ esc_attr( $url_key ) ] );
	}

	return $output;

}  // end function


/**
 * Setting internal plugin helper values.
 *
 * @since 1.9.1
 *
 * @uses ddw_mstba_get_info_url()
 *
 * @param string $url_key String of value key
 * @param string $text    String of text and link attribute
 * @param string $class   String of CSS class
 * @return string HTML markup for linked URL.
 */
function ddw_mstba_get_info_link( $url_key = '', $text = '', $class = '' ) {

	$link = sprintf(
		'<a class="%1$s" href="%2$s" target="_blank" rel="nofollow noopener noreferrer" title="%3$s">%3$s</a>',
		strtolower( esc_attr( $class ) ),	//sanitize_html_class( $class ),
		ddw_mstba_get_info_url( $url_key ),
		esc_html( $text )
	);

	return $link;

}  // end function


/**
 * Get timespan of coding years for this plugin.
 *
 * @since 1.9.1
 * @since 1.9.3 Improved first year logic.
 *
 * @uses ddw_mstba_info_values()
 *
 * @param int $first_year Integer number of first year
 * @return string Timespan of years.
 */
function ddw_mstba_coding_years( $first_year = '' ) {

	$mstba_info = (array) ddw_mstba_info_values();

	$first_year = ( empty( $first_year ) ) ? absint( $mstba_info[ 'first_code' ] ) : absint( $first_year );

	/** Set year of first released code */
	$code_first_year = ( date( 'Y' ) == $first_year || 0 === $first_year ) ? '' : $first_year . '&#x02013;';

	return $code_first_year . date( 'Y' );

}  // end function


add_filter( 'install_themes_tabs', 'ddw_mstba_theme_installer_upload_tab', 20, 1 );
/**
 * Add new "virtual" Tab on the Theme Installer page - using that for ZIP uploads.
 *
 * @since 2.0.0
 *
 * @param array $tabs Array of the Tabs on the Theme Installer admin page.
 * @return array Array of the filtered/ extended Tabs on the Theme Installer
 *               admin page.
 */
function ddw_mstba_theme_installer_upload_tab( array $tabs ) {

	/** Add our own new Tab */
	$tabs[ 'mstba-upload' ] = __( 'Upload Theme', 'multisite-toolbar-additions' );

	/** Return the array of all Tabs */
	return $tabs;

}  // end function


add_action( 'install_themes_pre_mstba-upload', 'ddw_mstba_theme_installer_pre_upload_tab' );
/**
 * Necessary inbetween step to set a value for the global $paged variable.
 *   This is needed to avoid any PHP errors/notices.
 *
 * @since 2.0.0
 *
 * @global int $GLOBALS[ 'paged' ]
 */
function ddw_mstba_theme_installer_pre_upload_tab() {

	$GLOBALS[ 'paged' ] = 1;

}  // end function


add_action( 'install_themes_mstba-upload', 'ddw_mstba_theme_installer_upload_tab_content', 10, 1 );
/**
 * Render the content of our newly added Theme Installer Tab - using WordPress
 *   Core render function for the Theme ZIP file upload form.
 *   Note: The admin URL is then: 'theme-install.php?tab=mstba-upload'
 *
 * @since 2.0.0
 *
 * @uses install_themes_upload() WP Core function!
 */
function ddw_mstba_theme_installer_upload_tab_content( $paged ) {

	/** Add our few CSS styles inline to remove unwanted elements: */
	?>
		<style type="text/css">
			div.theme-browser.content-filterable,
			.wp-filter.hide-if-no-js,
			button.upload-view-toggle,
			span.spinner {
				display: none !important;
			}
		</style>
	<?php
  
	/** Render the WordPress Core Themes uploader input form */
	echo '<div class="show-upload-view"><div class="upload-theme">';
		install_themes_upload();
	echo '</div></div>';
	
}  // end function


add_action( 'admin_menu', 'ddw_mstba_add_installer_upload_pages', 999 );
add_action( 'network_admin_menu', 'ddw_mstba_add_installer_upload_pages', 999 );
/**
 * Optionally add admin sub menu item on "Appearance" for Theme ZIP Upload and
 *   on "Plugins" for Plugin ZIP Upload - but only when in Dev Mode (by Toolbar
 *   Extras).
 *
 * @since 2.0.0
 *
 * @see ddw_mstba_theme_installer_upload_tab_content()
 *
 * @uses ddw_tbex_display_items_dev_mode()
 * @uses ddw_tbex_use_devmode_uploader_menus()
 */
function ddw_mstba_add_installer_upload_pages() {

	/** Bail early if Toolbar Extras plugin placed same items */
	if ( defined( 'TBEX_PLUGIN_VERSION' )
		&& ( ddw_tbex_display_items_dev_mode() && ddw_tbex_use_devmode_uploader_menus() )
	) {
		return;
	}

	/** Theme ZIP uploader */
	if ( current_user_can( 'install_themes' )
		|| current_user_can( 'upload_themes' )	// Multisite only
	) {

		add_theme_page(
			esc_attr__( 'Theme Installer - Upload Theme', 'multisite-toolbar-additions' ),
			esc_attr__( 'Upload Theme ZIP', 'multisite-toolbar-additions' ),
			'edit_theme_options',
			network_admin_url( 'theme-install.php?tab=mstba-upload' )
		);
		
	}  // end if

	/** Plugin ZIP uploader */
	if ( current_user_can( 'install_plugins' )
		|| current_user_can( 'upload_plugins' )	// Multisite only
	) {

		add_plugins_page(
			esc_attr__( 'Plugin Installer - Upload Plugin', 'multisite-toolbar-additions' ),
			esc_attr__( 'Upload Plugin ZIP', 'multisite-toolbar-additions' ),
			'install_plugins',
			network_admin_url( 'plugin-install.php?tab=upload' )
		);
		
	}  // end if

}  // end function


add_filter( 'parent_file', 'ddw_mstba_parent_submenu_tweaks_mstba_uploaders' );
/**
 * When adding the additional Jetpack submenu items set the proper $parent_file
 *   and $submenu_file relationship for those items.
 *
 * @since 2.0.0
 *
 * @uses get_current_screen()
 *
 * @global string $GLOBALS[ 'submenu_file' ]
 *
 * @param string $parent_file The filename of the parent menu.
 * @return string $parent_file The tweaked filename of the parent menu.
 */
function ddw_mstba_parent_submenu_tweaks_mstba_uploaders( $parent_file ) {

	/** Bail early if Toolbar Extras plugin placed same items */
	if ( defined( 'TBEX_PLUGIN_VERSION' )
		&& ( ddw_tbex_display_items_dev_mode() && ddw_tbex_use_devmode_uploader_menus() )
	) {
		return $parent_file;
	}

	/** For: Plugin Uploader */
	if ( ( 'plugin-install' === get_current_screen()->id || 'plugin-install-network' === get_current_screen()->id )
		&& ( isset( $_GET[ 'tab' ] ) && 'upload' === sanitize_key( wp_unslash( $_GET[ 'tab' ] ) ) )
	) {

		$GLOBALS[ 'submenu_file' ] = esc_url( network_admin_url( 'plugin-install.php?tab=upload' ) );
		$parent_file = 'plugins.php';

	}  // end if

	/** For: Theme Uploader */
	if ( ( 'theme-install' === get_current_screen()->id || 'theme-install-network' === get_current_screen()->id )
		&& ( isset( $_GET[ 'tab' ] ) && 'mstba-upload' === sanitize_key( wp_unslash( $_GET[ 'tab' ] ) ) )
	) {

		$GLOBALS[ 'submenu_file' ] = esc_url( network_admin_url( 'theme-install.php?tab=mstba-upload' ) );
		$parent_file = 'themes.php';

	}  // end if

	return $parent_file;

}  // end function
