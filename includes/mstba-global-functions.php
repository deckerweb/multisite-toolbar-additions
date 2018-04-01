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
 * @since  1.8.0
 *
 * @param  $wpversion String for a given WordPress version for checking.
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
 * @since  1.7.0
 *
 * @uses   get_locale()
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

}  // end of function ddw_mstba_is_wpgermanformal


/**
 * String for "Dashboard" - re-useable and filterable.
 *
 * @since  1.7.0
 *
 * @uses   ddw_mstba_is_wpgermanformal()
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

}  // end of function ddw_mstba_string_dashboard


/**
 * String for Super Admin menu location.
 *
 * @since   1.0.0
 * @version 1.7.0
 *
 * @uses    is_multisite()
 *
 * @global  $GLOBALS[ 'wp_customize' ]
 *
 * @return  string $mstba_menu_string String for menu location.
 */
function ddw_mstba_string_super_admin_menu_location() {

	/** Helper strings */
	$string_via       = esc_html__( 'via Plugin', 'multisite-toolbar-additions' );
	$string_plugin    = esc_html__( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' );
	$string_site_type = ( is_multisite() ) ? __( 'Multisite', 'multisite-toolbar-additions' ) : __( 'Site', 'multisite-toolbar-additions' );

	/** Build menu location string */
	if ( isset( $GLOBALS[ 'wp_customize' ] ) ) {

		$mstba_menu_string = sprintf(
			esc_attr__( '%s Toolbar Menu', 'multisite-toolbar-additions' ),
			$string_site_type
		);

	} else {

		$mstba_menu_string = sprintf(
			'<span title="%s: %s">' . esc_attr__( '%s Toolbar Menu', 'multisite-toolbar-additions' ) . '</span>',
			$string_via,
			$string_plugin,
			$string_site_type
		);

	}  // end if

	/** Output */
	return $mstba_menu_string;
	
}  // end of function ddw_mstba_super_admin_menu_location_string


/**
 * String for restricted Site Admin menu location.
 *
 * @since  1.7.0
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

}  // end of function ddw_mstba_string_restricted_admin_menu_location


/**
 * Filterable capability for custom site admin menus.
 *    Default: 'edit_theme_options'
 *
 * @since  1.7.0
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

}  // end of function ddw_mstba_restricted_admin_menu_cap


/**
 * Restrict editing access of special custom "Super Admin Admin" toolbar menu.
 *
 * @since 1.7.0
 *
 * @uses  ddw_mstba_restrict_nav_menu_edit_access()
 */
function ddw_mstba_restrict_super_admin_menu_access() {

	ddw_mstba_restrict_nav_menu_edit_access(
		'mstba_menu',
		'edit_theme_options'
	);

}  // end of function ddw_mstba_restrict_super_admin_menu_access


/**
 * Restrict editing access of special custom "Restricted Admin" toolbar menu.
 *
 * @since 1.7.0
 *
 * @uses  ddw_mstba_restrict_nav_menu_edit_access()
 * @uses  ddw_mstba_restricted_admin_menu_cap()
 */
function ddw_mstba_restrict_admin_menu_access() {

	ddw_mstba_restrict_nav_menu_edit_access(
		'mstba_restricted_admin_menu',
		ddw_mstba_restricted_admin_menu_cap()
	);

}  // end of function ddw_mstba_restrict_admin_menu_access


/**
 * Get the ID of a nav menu that is set to one of our special menu locations.
 *
 * @since  1.7.0
 *
 * @uses   get_nav_menu_locations()
 *
 * @param  string $single_menu_location
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

}  // end of function ddw_mstba_get_menu_id_from_menu_location


/**
 * Keep 'administrator' users from editing this special admin menu.
 *
 * NOTE I:  Eventually, the real blocking depends on (filterable)
 *          'edit_theme_options' cap.
 * NOTE II: Super admins have full access, of course! :)
 *
 * @since  1.7.0
 *
 * @uses   ddw_mstba_get_menu_id_from_menu_location()
 *
 * @param  string $single_menu_location
 * @param  string $checked_capability
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

}  // end of function ddw_mstba_restrict_edit_admin_menu


/**
 * Helper function for returning plugin installer admin url.
 *
 * @since  1.8.0
 *
 * @uses   ddw_mstba_is_wpversion() For WP version check.
 * @uses   network_admin_url()
 *
 * @return string String of admin url.
 */
function ddw_mstba_plugin_install_link() {

	/** For WordPress 4.0+ */
	if ( ddw_mstba_is_wpversion( '4.0' ) ) {

		return network_admin_url( 'plugin-install.php?tab=featured' );

	} // end if

	return network_admin_url( 'plugin-install.php?tab=dashboard' );

}  // end of function ddw_mstba_plugin_install_link


/**
 * Helper function for returning theme installer admin url.
 *
 * @since  1.7.1
 *
 * @uses   ddw_mstba_is_wpversion() For WP version check.
 * @uses   network_admin_url()
 *
 * @return string String of admin url.
 */
function ddw_mstba_theme_install_link() {

	/** For WordPress 3.9+ */
	if ( ddw_mstba_is_wpversion( '3.9' ) ) {

		return network_admin_url( 'theme-install.php' );

	} // end if

	return network_admin_url( 'theme-install.php?tab=dashboard' );

}  // end of function ddw_mstba_theme_install_link


/**
 * Helper function for returning theme uploader admin url.
 *
 * @since  1.7.1
 *
 * @uses   ddw_mstba_is_wpversion() For WP version check.
 * @uses   network_admin_url()
 *
 * @return string String of admin url.
 */
function ddw_mstba_theme_upload_link() {

	/** For WordPress 3.9+ wp_ajax_query_themes */
	if ( ddw_mstba_is_wpversion( '3.9' ) ) {

		return network_admin_url( 'theme-install.php?upload' );

	} // end if

	return network_admin_url( 'theme-install.php?tab=upload' );

}  // end of function ddw_mstba_theme_upload_link


/**
 * Helper function for generating custom links.
 *
 * @since  1.7.1
 *
 * @param  string $site
 * @param  int    $ref
 * @param  bool   $www
 * @param  bool   $ssl
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

}  // end of function ddw_mstba_affwp