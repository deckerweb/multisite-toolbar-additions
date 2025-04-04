<?php # -*- coding: utf-8 -*-
/**
 * Plugin Name:       Multisite Toolbar Additions
 * Plugin URI:        https://github.com/deckerweb/multisite-toolbar-additions
 * Description:       This plugin adds a lot of useful (Super) Admin links to the WordPress Admin Bar / Toolbar in Multisite, Network and Single Site installs. Also comes with support for third-party plugins!
 * Version:           3.1.0
 * Author:            David Decker - DECKERWEB
 * Author URI:        https://deckerweb.de/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       multisite-toolbar-additions
 * Domain Path:       /languages/
 * Network:           true
 * Requires WP:       6.7
 * Requires PHP:      7.4
 * GitHub Plugin URI: https://github.com/deckerweb/multisite-toolbar-additions
 * GitHub Branch:     master
 *
 * Copyright:         © 2012-2025 David Decker - DECKERWEB
 *
 *     This file is part of Multisite Toolbar Additions,
 *     a plugin for WordPress.
 *
 *     Multisite Toolbar Additions is free software:
 *     You can redistribute it and/or modify it under the terms of the
 *     GNU General Public License as published by the Free Software
 *     Foundation, either version 2 of the License, or (at your option)
 *     any later version.
 *
 *     Multisite Toolbar Additions is distributed in the hope that
 *     it will be useful, but WITHOUT ANY WARRANTY; without even the
 *     implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR
 *     PURPOSE. See the GNU General Public License for more details.
 *
 *     You should have received a copy of the GNU General Public License
 *     along with WordPress. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) exit( 'Sorry, you are not allowed to access this file directly.' );


/**
 * Setting constants.
 *
 * @since 1.0.0
 */
/** Plugin version */
$ddw_mstba_plugin_data = get_file_data( __FILE__, [ 'Version' => 'Version' ] );
define( 'MSTBA_PLUGIN_VERSION', $ddw_mstba_plugin_data[ 'Version' ] );	// '3.1.0'

/** Plugin directory */
define( 'MSTBA_PLUGIN_DIR', trailingslashit( dirname( __FILE__ ) ) );

/** Plugin base directory */
define( 'MSTBA_PLUGIN_BASEDIR', trailingslashit( dirname( plugin_basename( __FILE__ ) ) ) );


add_action( 'plugins_loaded', 'ddw_mstba_helper_constants', 0 );
/**
 * Helper function for making our helper constants available early but also
 *    unhookable if desired...
 *
 * @since 1.5.1
 * @since 3.0.0 Removed restricted admin menu.
 */
function ddw_mstba_helper_constants() {

	/** Define constants and set defaults for removing all or certain sections */
	if ( ! defined( 'MSTBA_DISPLAY_NETWORK_ITEMS' ) ) {
		define( 'MSTBA_DISPLAY_NETWORK_ITEMS', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_SUBSITE_ITEMS' ) ) {
		define( 'MSTBA_DISPLAY_SUBSITE_ITEMS', TRUE );
	}

	if ( ! defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) ) {
		define( 'MSTBA_SUPER_ADMIN_NAV_MENU', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP' ) ) {
		define( 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_SITE_EXTEND_GROUP' ) ) {
		define( 'MSTBA_DISPLAY_SITE_EXTEND_GROUP', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_SITE_GROUP' ) ) {
		define( 'MSTBA_DISPLAY_SITE_GROUP', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_RESOURCES' ) ) {
		define( 'MSTBA_DISPLAY_RESOURCES', TRUE );
	}

	if ( ! defined( 'MSTBA_DISPLAY_LIST_EDIT_MENUS' ) ) {
		define( 'MSTBA_DISPLAY_LIST_EDIT_MENUS', TRUE );
	}

}  // end of ddw_mstba_helper_constants()


add_action( 'init', 'ddw_mstba_init', 1 );
/**
 * Setup the plugin.
 *
 * Load the text domain for translation of the plugin.
 * Load admin helper functions - only within 'wp-admin'.
 * Add a WordPress custom menu to the toolbar - only do and display stuff for super admins.
 *
 * @see ddw_mstba_build_custom_menu()
 *
 * @since 1.0.0
 *
 * @uses load_textdomain() To load translations first from WP_LANG_DIR sub folder.
 * @uses load_plugin_textdomain() To additionally load default translations from plugin folder (default).
 * @uses ddw_mstba_menu_hook_priority() For (optionally) setting the hook priority via filter.
 */
function ddw_mstba_init() {

	/** Include global helper functions */
	require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-global-functions.php' );

	/** Include "Nav Menus" items support */
	require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-items-navmenus.php' );

	if ( is_multisite() ) require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-network-admin-additions.php' );

	/** Include admin helper functions */
	if ( is_admin() ) require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-admin-extras.php' );

	/** Add "Custom Menu" menus page link to plugin page */
	if ( ( is_admin() || is_network_admin() ) && current_user_can( 'edit_theme_options' ) ) {

		add_filter(
			'plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_mstba_custom_menu_link'
		);

		add_filter(
			'network_admin_plugin_action_links_' . plugin_basename( __FILE__ ),
			'ddw_mstba_custom_menu_link'
		);

	}  // end if is_admin() & cap check


	/** Check for Custom Menus support */
	if ( ! current_theme_supports( 'menus' ) ) {

		add_theme_support( 'menus' );

	}  // end if

	/** Only register & add additional toolbar menu for super admins */
	if ( ( defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) && MSTBA_SUPER_ADMIN_NAV_MENU )
		&& is_super_admin()
	) {

		require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-global-superadmin-menu.php' );

	}  // end if constant plus super admin check

	/** Restrict access to the above custom super admin menu */
	add_action( 'admin_menu', 'ddw_mstba_restrict_super_admin_menu_access', 1 );

}  // end function


add_action( 'wp_before_admin_bar_render', 'ddw_mstba_toolbar_main_site_remove_view_site' );
/**
 * Remove original 'View Site' for main site within Network Admin.
 *
 * @see ddw_mstba_toolbar_main_site_dashboard()
 *
 * @since 1.2.0
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_toolbar_main_site_remove_view_site() {

	global $wp_admin_bar;

	/** Only for super admins within network_admin & if network our items are enabled */
	if ( ( is_network_admin()
			&& ( defined( 'MSTBA_DISPLAY_NETWORK_ITEMS' ) && MSTBA_DISPLAY_NETWORK_ITEMS )
			&& is_super_admin()
			&& is_user_logged_in()
			&& is_admin_bar_showing()
		) || (
				is_admin()
				&& ( defined( 'MSTBA_DISPLAY_SUBSITE_ITEMS' ) && MSTBA_DISPLAY_SUBSITE_ITEMS )
				&& is_super_admin()
				&& is_user_logged_in()
				&& is_admin_bar_showing()
			)
	) {

		$wp_admin_bar->remove_node( 'view-site' );

	}  // end if network_admin check

	/** Remove original Custom Background / Header */
	if ( is_super_admin()
			&& is_user_logged_in()
			&& is_admin_bar_showing()
	) {

		$wp_admin_bar->remove_node( 'background' );
		$wp_admin_bar->remove_node( 'header' );

	}  // end if

}  // end function


add_action( 'admin_bar_menu', 'ddw_mstba_toolbar_main_site_dashboard' );
/**
 * Adding 'Dashboard' for main site within Network Admin.
 *
 * @since 1.2.0
 *
 * @uses ddw_mstba_string_dashboard()
 * @uses WP_Admin_Bar::add_node()
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_toolbar_main_site_dashboard() {

	global $wp_admin_bar;

	/** Only for super admins within network_admin & if network, our items are enabled */
	if ( is_network_admin()
		&& ( defined( 'MSTBA_DISPLAY_NETWORK_ITEMS' ) && MSTBA_DISPLAY_NETWORK_ITEMS )
		&& is_super_admin()
		&& is_user_logged_in()
		&& is_admin_bar_showing()
	) {

		$dashboard_string = (array) ddw_mstba_string_dashboard();

		/** Add 'Dashboard' for main site */
		$wp_admin_bar->add_node( array(  
			'parent' => 'site-name',  
			'id'     => 'ddw-mstba-main-site-dashboard',  
			'title'  => $dashboard_string[ 'dashboard' ],  
			'href'   => esc_url( admin_url( '/' ) ),  
			'meta'   => array( 'title'  => $dashboard_string[ 'dashboard_main_site' ] ),
		) );

		/** Re-add 'View Site' item */
		$wp_admin_bar->add_node( array(  
			'parent' => 'site-name',  
			'id'     => 'ddw-mstba-main-site-view',  
			'title'  => __( 'View Site', 'multisite-toolbar-additions' ),  
			'href'   => esc_url( get_home_url() ),  
			'meta'   => array( 'target' => '_blank' ),
		) );

	}  // end if is_network_admin() check

	/** Re-add 'View Site' item */
	if ( ( is_admin() && ! is_network_admin() )
		&& MSTBA_DISPLAY_SUBSITE_ITEMS
		&& is_super_admin()
		&& is_user_logged_in()
		&& is_admin_bar_showing()
	) {

		$wp_admin_bar->add_node( array(  
			'parent' => 'site-name',  
			'id'     => 'ddw-mstba-view_site',  
			'title'  => __( 'View Website', 'multisite-toolbar-additions' ),  
			'href'   => esc_url( get_home_url( get_current_blog_id(), '/' ) ),  //get_home_url( '/' )
			'meta'   => array(
				'target' => '_blank',
				'title'  => _x( 'View Website', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
			)
		) );

	}  // end if is_admin() check

}  // end function


add_action( 'admin_bar_menu', 'ddw_mstba_toolbar_additions', 99 );
/**
 * Add new menu items to the WordPress Toolbar / Admin Bar.
 * 
 * @since 1.0.0
 *
 * @uses WP_Admin_Bar::remove_node()
 * @uses WP_Admin_Bar::add_node()
 * @uses WP_Admin_Bar::add_group()
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_toolbar_additions() {

	global $wp_admin_bar;

	/**
	 * Required WordPress cabability to display new toolbar bar entries
	 * Only showing items if toolbar / admin bar is activated and super admin user is logged in!
	 *
	 * @since 1.0.0
	 */
	
	if ( ! is_super_admin()
		|| ! is_user_logged_in()
		|| ! is_admin_bar_showing()
		|| ! ( defined( 'MSTBA_DISPLAY_NETWORK_ITEMS' ) && MSTBA_DISPLAY_NETWORK_ITEMS )	// allows for custom disabling
	) {

		return;

	}  // end if


	/** Remove original "Visit Network" menu item (only to re-add later on as last item!) */
	$wp_admin_bar->remove_node( 'network-admin-v' );

	/** Set unique prefix for toolbar ID */
	$mstba_prefix = 'ddw-mstba-';
	
	/** Create parent menu item references */
	$networkplugins = $mstba_prefix . 'networkplugins';				// sub level: network plugins
	$networkthemes = $mstba_prefix . 'networkthemes';				// sub level: network themes
	$networkextgroup = $mstba_prefix . 'networkextgroup';				// sub level: network extend group ("hook" place)
		$networkext_wppiwik = $mstba_prefix . 'networkext_wppiwik';			// third level: wp-piwik (network)
		$networkext_codesnippets = $mstba_prefix . 'networkext_codesnippets';	// third level: code snippets (network)
		$networkext_msrobotstxt = $mstba_prefix . 'networkext_msrobotstxt';		// third level: ms robots.txt (network)
		$networkext_wpmudomainmapping = $mstba_prefix . 'networkext_wpmudomainmapping';	// third level: wpmu domain mapping (network)
		$networkext_wpmigratedbpro = $mstba_prefix . 'networkext_wpmigratedbpro';	// third level: wp migrate db pro (network)
		$networkext_wpmsar = $mstba_prefix . 'networkext_wpmsar';			// third level: wpms admin report (network)
	$siteextgroup = $mstba_prefix . 'siteextgroup';					// sub level: site extend group ("hook" place)
		$siteext_wppiwik = $mstba_prefix . 'siteext_wppiwik';				// third level: wp-piwik (site)
		$siteext_relevanssi = $mstba_prefix . 'siteext_relevanssi';			// third level: relevanssi/premium
		$siteext_codesnippets = $mstba_prefix . 'siteext_codesnippets';		// third level: code snippets (site)
		$siteext_msrobotstxt = $mstba_prefix . 'siteext_msrobotstxt';		// third level: ms robots.txt (site)
		$siteext_wpmigratedbpro = $mstba_prefix . 'siteext_wpmigratedbpro';	// third level: wp migrate db pro (site)
		$siteext_stream = $mstba_prefix . 'siteext_stream';					// third level: stream (site)
	$sitegroup = $mstba_prefix . 'sitegroup';						// sub level: site group ("hook" place)
		$widgets = $mstba_prefix . 'widgets';								// third level: widgets
		$navmenus = $mstba_prefix . 'navmenus';								// third level: nav menus
			$navmenugroup = $mstba_prefix . 'navmenugroup';							// fourth level: nav menu group
		$mcbase = $mstba_prefix . 'mcbase';									// third level: manage content base item
		$medialibrary = $mstba_prefix . 'medialibrary';						// third level: media library
		$editthemes = $mstba_prefix . 'editthemes';							// third level: edit themes
		$siteplugins = $mstba_prefix . 'siteplugins';						// third level: plugins (site only)
	$addnewgroup = $mstba_prefix . 'addnewgroup';					// sub level: add new group ("hook" place)
		$addnew_plugin = $mstba_prefix . 'addnew_plugin';					// third level: add new plugin
		$addnew_theme = $mstba_prefix . 'addnew_theme';						// third level: add new theme
	$network_addsite = $mstba_prefix . 'network_addsite';					// third level: add new site (network)
	$view_site = $mstba_prefix . 'view_site';						// sub level: view site (site)
	$resources_getinvolved = $mstba_prefix . 'resources_getinvolved';		// third level: resources - get involved


	/**
	 * Display additional network-specific items, load only for Multisite installs.
	 *
	 * @since 1.0.0
	 */
	if ( is_multisite() ) {

		/** Include code part with Multisite items */
		require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-items-multisite.php' );

	}  // end if is_multisite check


	/**
	 * Display additional site-specific items (as sub level items on subsite ? item)
	 *
	 * @since 1.0.0
	 */
		/** Site Group: Main Entry */
		if ( defined( 'MSTBA_DISPLAY_SITE_GROUP' ) && MSTBA_DISPLAY_SITE_GROUP ) {

			$wp_admin_bar->add_group( array(
				'parent' => 'site-name',
				'id'     => $sitegroup,
			) );

			$wp_admin_bar->remove_node( 'plugins' );

		}  // end if constant check

		/** Include code part with site group items */
		require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-items-site-group.php' );
		require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-items-manage-content.php' );


	/** "Plugins" items only for non-Multisite installs! */
	if ( ! is_multisite() && current_user_can( 'activate_plugins' ) ) {

		/** Include code part with site plugins items */
		require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-items-site-plugins.php' );

	}  // end if plugins check


	/**
	 * Display additional site-specific "New Content/ Add New" items (as sub level items on subsite ? item)
	 *
	 * @since 1.3.0
	 */
		/** Show only if "Site Group" is not hidden */
		if ( defined( 'MSTBA_DISPLAY_SITE_GROUP' ) && MSTBA_DISPLAY_SITE_GROUP ) {

			$wp_admin_bar->add_group( array(
				'parent' => 'new-content',
				'id'     => $addnewgroup,
			) );

		}  // end if constant check

		/** Plugin Installer */
		$mstba_tb_items[ 'addnew_plugin' ] = array(
			'parent' => $addnewgroup,
			'title'  => __( 'Install Plugin', 'multisite-toolbar-additions' ),
			'href'   => esc_url( network_admin_url( 'plugin-install.php?tab=featured' ) ),
		);

			$mstba_tb_items[ 'addnew_plugin_search' ] = array(
				'parent' => $addnew_plugin,
				'title'  => __( 'Search Plugin Directory', 'multisite-toolbar-additions' ),
				'href'   => esc_url( network_admin_url( 'plugin-install.php?tab=recommended' ) ),
			);

			$mstba_tb_items[ 'addnew_plugin_upload' ] = array(
				'parent' => $addnew_plugin,
				'title'  => __( 'Upload ZIP file', 'multisite-toolbar-additions' ),
				'href'   => esc_url( network_admin_url( 'plugin-install.php?tab=upload' ) ),
			);

			$mstba_tb_items[ 'addnew_plugin_faves' ] = array(
				'parent' => $addnew_plugin,
				'title'  => __( 'Install Favorites', 'multisite-toolbar-additions' ),
				'href'   => esc_url( network_admin_url( 'plugin-install.php?tab=favorites' ) ),
			);

		/** Theme Installer */
		$mstba_tb_items[ 'addnew_theme' ] = array(
			'parent' => $addnewgroup,
			'title'  => __( 'Install Theme', 'multisite-toolbar-additions' ),
			'href'   => ddw_mstba_theme_install_link(),
		);

			$mstba_tb_items[ 'addnew_theme_search' ] = array(
				'parent' => $addnew_theme,
				'title'  => __( 'Search Theme Directory', 'multisite-toolbar-additions' ),
				'href'   => esc_url( network_admin_url( 'theme-install.php' ) ),	//ddw_mstba_theme_upload_link(),
			);

			$mstba_tb_items[ 'addnew_theme_upload' ] = array(
				'parent' => $addnew_theme,
				'title'  => __( 'Upload ZIP file', 'multisite-toolbar-additions' ),
				'href'   => esc_url( network_admin_url( 'theme-install.php?tab=mstba-upload' ) ),	//ddw_mstba_theme_upload_link(),
			);

			$mstba_tb_items[ 'addnew_theme_newest' ] = array(
				'parent' => $addnew_theme,
				'title'  => __( 'Newest Themes', 'multisite-toolbar-additions' ),
				'href'   => esc_url( network_admin_url( 'theme-install.php?browse=new' ) ),
			);

			$mstba_tb_items[ 'addnew_theme_favorites' ] = array(
				'parent' => $addnew_theme,
				'title'  => __( 'Install Favorites', 'multisite-toolbar-additions' ),
				'href'   => esc_url( network_admin_url( 'theme-install.php?browse=favorites' ) ),
			);

	/** Site Extend Group: Main Entry */
	if ( defined( 'MSTBA_DISPLAY_SITE_EXTEND_GROUP' ) && MSTBA_DISPLAY_SITE_EXTEND_GROUP ) {

		$wp_admin_bar->add_group( array(
			'parent' => 'site-name',
			'id'     => $siteextgroup,
		) );

		/** Action Hook 'mstba_custom_site_items' - allows for hooking in other site-specific items */
		do_action( 'mstba_custom_site_items' );

	}  // end if constant check


	/** Include code part with plugin support items */
	require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-plugins.php' );


	/** Action Hook 'mstba_custom_plugin_items' - allows for hooking in other plugin items */
	do_action( 'mstba_custom_plugin_items' );


	/** Include various external resources items */
	if ( defined( 'MSTBA_DISPLAY_RESOURCES' ) && MSTBA_DISPLAY_RESOURCES ) {

		/** Include code part with resources items */
		require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-items-resources.php' );

	}  // end if constant check


	/** Allow menu items to be filtered, but pass in parent menu item IDs */
	$mstba_tb_items = (array) apply_filters( 'mstba_filter_menu_items', $mstba_tb_items,
									$networkplugins,
									$networkthemes,
									$networkextgroup,
										$networkext_wppiwik,
										$networkext_codesnippets,
										$networkext_msrobotstxt,
										$networkext_wpmudomainmapping,
										$networkext_wpmigratedbpro,
										$networkext_wpmsar,
									$siteextgroup,
										$siteext_wppiwik,
										$siteext_relevanssi,
										$siteext_codesnippets,
										$siteext_msrobotstxt,
										$siteext_wpmigratedbpro,
										$siteext_stream,
									$sitegroup,
										$widgets,
										$navmenus,
											$navmenugroup,
										$mcbase,
										$medialibrary,
										$editthemes,
										$siteplugins,
									$addnewgroup,
										$addnew_plugin,
										$addnew_theme,
									$view_site,
									$resources_getinvolved
	);  // end of array


	/** Loop through the menu items */
	foreach ( $mstba_tb_items as $mstba_menu_id => $mstba_tb_item ) {
		
		/** Add in the item ID */
		$mstba_tb_item[ 'id' ] = $mstba_prefix . $mstba_menu_id;

		/** Add meta target to each item where it's not already set, so links open in new window/tab */
		if ( ! isset( $mstba_tb_item[ 'meta' ][ 'target' ] ) ) {

			$mstba_tb_item[ 'meta' ][ 'target' ] = '';
		}

		/** Add class to links that open up in a new window/tab */
		if ( '_blank' === $mstba_tb_item[ 'meta' ][ 'target' ] ) {

			if ( ! isset( $mstba_tb_item[ 'meta' ][ 'class' ] ) ) {

				$mstba_tb_item[ 'meta' ][ 'class' ] = '';

			}  // end if

			$mstba_tb_item[ 'meta' ][ 'class' ] .= $mstba_prefix . 'mstba-new-tab';

		}  // end if target check

		/** Add menu items */
		$wp_admin_bar->add_node( $mstba_tb_item );

	}  // end foreach menu items

}  // end function


add_action( 'wp_before_admin_bar_render', 'ddw_mstba_toolbar_subsite_items' );
/**
 * Adding subsite items within "My Sites/[Site Name]"
 *
 * @since 1.0.0
 *
 * @uses $blog To get Site ID.
 * @uses WP_Admin_Bar::remove_node()
 * @uses WP_Admin_Bar::add_node()
 * @uses get_admin_url()
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_toolbar_subsite_items() {

	global $wp_admin_bar;

	/**
	 * Required WordPress cabability to display new toolbar bar entries
	 * Only showing items if toolbar / admin bar is activated and super admin user is logged in!
	 *
	 * @since 1.0.0
	 */
	if ( ! is_super_admin()
		|| ! is_user_logged_in()
		|| ! is_admin_bar_showing()
		|| ! ( defined( 'MSTBA_DISPLAY_SUBSITE_ITEMS' ) && MSTBA_DISPLAY_SUBSITE_ITEMS )	// allows for custom disabling
	) {

		return;

	}  // end if

	/** Adding new items for each subsite */
	foreach ( (array) $wp_admin_bar->user->blogs as $blog ) {

		/** Get ID of subsite/blog */
		$mstba_blog_menu_id = 'blog-' . $blog->userblog_id;

		/** Remove original "Visit Site" menu item (only to re-add later on as last item!) */
		$wp_admin_bar->remove_node( $mstba_blog_menu_id . '-v' );

		/** Site > Dashboard > Settings */
		$wp_admin_bar->add_node( array(
			'parent' => $mstba_blog_menu_id . '-d',
			'id'     => $mstba_blog_menu_id . '-mstba_site_settings_old',
			'title'  => __( 'Site Settings', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'options-general.php' ),
		) );

		/** Site > Widgets */
		$wp_admin_bar->add_node( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_widgets',
			'title'  => __( 'Site Widgets', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'widgets.php' ),
		) );

		/** Site > Menus */
		$wp_admin_bar->add_node( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_menus',
			'title'  => __( 'Site Menus', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'nav-menus.php' ),
		) );

			$wp_admin_bar->add_node( array(
				'parent' => $mstba_blog_menu_id . '-mstba_site_menus',
				'id'     => $mstba_blog_menu_id . '-mstba_site_menu_add',
				'title'  => __( 'Add new Menu', 'multisite-toolbar-additions' ),
				'href'   => get_admin_url( $blog->userblog_id, 'nav-menus.php?action=edit&menu=0' ),
			) );

			/** Add "Menu Locations" item for WordPress 3.6+ */
			if ( function_exists( 'get_attached_media' ) ) {
				$wp_admin_bar->add_node( array(
					'parent' => $mstba_blog_menu_id . '-mstba_site_menus',
					'id'     => $mstba_blog_menu_id . '-mstba_site_menu_locations',
					'title'  => __( 'Menu Locations', 'multisite-toolbar-additions' ),
					'href'   => get_admin_url( $blog->userblog_id, 'nav-menus.php?action=locations' ),
				) );
			}

		/** Site > Plugins */
		$wp_admin_bar->add_node( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_plugins',
			'title'  => __( 'Site Plugins', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'plugins.php' ),
		) );

		/** Site > Themes */
		$wp_admin_bar->add_node( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_themes',
			'title'  => __( 'Site Themes', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'themes.php' ),
		) );

			// $mstba_current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ];
			$wp_admin_bar->add_node( array(
				'parent' => $mstba_blog_menu_id . '-mstba_site_themes',
				'id'     => $mstba_blog_menu_id . '-mstba_site_customizer',
				'title'  => __( 'Theme Customizer', 'multisite-toolbar-additions' ),
				'href'   => get_admin_url( $blog->userblog_id, 'customize.php' ),	// is_admin() ? get_admin_url( $blog->userblog_id, 'customize.php' ) : add_query_arg( 'url', urlencode( $mstba_current_url ), wp_customize_url() ),
				'meta'   => array(
					'class'  => ! is_admin() ? 'hide-if-no-customize' : '',
				)
			) );

		/** Site > Settings */
		$wp_admin_bar->add_node( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_settings',
			'title'  => __( 'Site Settings', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'options-general.php' ),
		) );

		/** Site > Tools */
		$wp_admin_bar->add_node( array(
			'parent' => $mstba_blog_menu_id,
			'id'     => $mstba_blog_menu_id . '-mstba_site_tools',
			'title'  => __( 'Site Tools', 'multisite-toolbar-additions' ),
			'href'   => get_admin_url( $blog->userblog_id, 'tools.php' ),
		) );

		/** Re-add "Visit Site" item as the last one - and opening in blank window/tab */
		$wp_admin_bar->add_node( array(  
			'parent' => $mstba_blog_menu_id,  
			'id'     => $mstba_blog_menu_id . '-v',  
			'title'  => __( 'Visit Site', 'multisite-toolbar-additions' ),  
			'href'   => get_home_url( $blog->userblog_id, '/' ),  
			'meta'   => array( 'target' => '_blank' ),
		) );

	}  // end foreach

}  // end function


/**
 * Helper function for custom deactivation of ddw_mstba_network_new_content_helper() items.
 *
 * @since 1.4.0
 *
 * @return bool 
 */
function ddw_mstba_network_new_content_filter() {

	return (bool) apply_filters( 'mstba_filter_display_network_new_content', '__return_true' );

}  // end function


add_action( 'init', 'ddw_mstba_network_new_content_helper' );
/**
 * Add 'new-content' area within Network admin only for Network specific items.
 *
 * @since 1.4.0
 */
function ddw_mstba_network_new_content_helper() {

	/** Only load the additions for Network admin area and if Toolbar is active */
	if ( is_network_admin()
		&& is_super_admin()
		&& is_user_logged_in()
		&& is_admin_bar_showing()
		&& ( defined( 'MSTBA_DISPLAY_NETWORK_ITEMS' ) && MSTBA_DISPLAY_NETWORK_ITEMS )	// custom disabling
		&& ddw_mstba_network_new_content_filter()	// allows for custom disabling
	) {

		/** Include code part with plugin support items */
		require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-network-new-content.php' );

	}  // end if is_network_admin() plus Toolbar checks

}  // end function


add_action( 'wp_head', 'ddw_mstba_admin_style' );
add_action( 'admin_head', 'ddw_mstba_admin_style' );
/**
 * Add the styles for new WordPress Toolbar / Admin Bar entry
 * 
 * @since 1.3.0
 *
 * @uses is_admin_bar_showing()
 * @uses is_user_logged_in()
 * @uses MSTBA_DISPLAY_NETWORK_EXTEND_GROUP Our helper constant.
 */
function ddw_mstba_admin_style() {

	/** No styles if admin bar is disabled or user is not logged in or items are disabled via constant */
	if ( ! is_admin_bar_showing()
		|| ! is_user_logged_in()
		|| ( defined( 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP' ) && ! MSTBA_DISPLAY_NETWORK_EXTEND_GROUP )
	) {
		return;
	}

	?>
		<style type="text/css">
			#wpadminbar #wp-admin-bar-my-sites-super-admin.ab-submenu {
				border-top: 0 none !important;
			}
		</style>
	<?php

}  // end function


/**
  * Plugin Support: DevKit Pro (Premium, by DPlugins)
  * @since 3.1.0
  */
if ( defined( 'DPDEVKIT_URL' ) ) {
	require_once MSTBA_PLUGIN_DIR . 'includes/plugin-support/mstba-plugins-devkitpro.php';
}

/**
  * Plugin Support: Git Updater (free/Premium, by Andy Fragen)
  * @since 3.1.0
  */
if ( class_exists( '\Fragen\Git_Updater\Plugin' ) ) {
	require_once MSTBA_PLUGIN_DIR . 'includes/plugin-support/mstba-plugins-gitupdater.php';
}