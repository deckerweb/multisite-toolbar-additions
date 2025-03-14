<?php
/**
 * Display additional network-specific items, load only for Multisite installs.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Multisite
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
 * @since 1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'wp_before_admin_bar_render', 'ddw_mstba_remove_network_items' );
/**
 * Remove default network 'Themes' and 'Plugins' items, as these are not
 *    controllable for our translations.
 *
 * @since  1.5.1
 *
 * @uses   is_network_admin()
 * @uses   WP_Admin_Bar::remove_node()
 *
 * @global obj $GLOBALS[ 'wp_admin_bar' ]
 */
function ddw_mstba_remove_network_items() {

	/** Remove unwanted/ unneeded toolbar item */
	$GLOBALS[ 'wp_admin_bar' ]->remove_node( 'network-admin-t' );
	$GLOBALS[ 'wp_admin_bar' ]->remove_node( 'network-admin-p' );

}  // end function


/**
 * Display additional network-specific items, load only for Multisite installs.
 *
 * @since 1.0.0
 */
	/** Sites > Dashboard > Settings */
	$mstba_tb_items[ 'network-settings' ] = array(
		'parent' => 'network-admin-d',
		'title'  => __( 'Network Settings', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Network Settings', 'multisite-toolbar-additions' )
		)
	);

		/** Sites > Dashboard > Check for Updates */
		$mstba_tb_items[ 'network-updatecheck' ] = array(
			'parent' => 'network-admin-d',
			'title'  => __( 'Check for Updates', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'update-core.php' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Check for Updates', 'multisite-toolbar-additions' )
			)
		);

		/** Sites > Dashboard > Update Sites */
		$mstba_tb_items[ 'network-updatesites' ] = array(
			'parent' => 'network-admin-d',
			'title'  => __( 'Updates all Sites', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'upgrade.php' ),
			'meta'   => array(
				'target' => '',
				'title'  => _x( 'Updates all Sites', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
			)
		);

	/** Sites > Add Site */
	$mstba_tb_items[ 'network_addsite' ] = array(
		'parent' => 'network-admin-s',
		'title'  => __( 'Add Site', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'site-new.php' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Add Site', 'multisite-toolbar-additions' )
		)
	);

	/** Users > Add User */
	$mstba_tb_items[ 'network-adduser' ] = array(
		'parent' => 'network-admin-u',
		'title'  => __( 'Add User', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'user-new.php' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Add User', 'multisite-toolbar-additions' )
		)
	);

	/** Users > Super Admins */
	$mstba_tb_items[ 'network-superadmins' ] = array(
		'parent' => 'network-admin-u',
		'title'  => __( 'Super Admins', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'users.php?role=super' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Super Admins', 'multisite-toolbar-additions' )
		)
	);

	/** Manage Network > Network wide plugins */
	$mstba_tb_items[ 'networkplugins' ] = array(
		'parent' => 'network-admin',
		'title'  => __( 'Network Plugins', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'plugins.php' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Network Plugins', 'multisite-toolbar-additions' )
		)
	);

		/** Manage Network > Network wide plugins > Install: Search */
		$mstba_tb_items[ 'networkplugins-install' ] = array(
			'parent' => $networkplugins,
			'title'  => __( 'Install Plugins: Search', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'plugin-install.php?tab=dashboard' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Install Plugins - Search on WordPress.org', 'multisite-toolbar-additions' )
			)
		);

		/** Manage Network > Network wide plugins > Install: ZIP upload */
		$mstba_tb_items[ 'networkplugins-installupload' ] = array(
			'parent' => $networkplugins,
			'title'  => __( 'Install Plugins: Upload', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'plugin-install.php?tab=upload' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Install Plugins - Upload ZIP file', 'multisite-toolbar-additions' )
			)
		);

		/** Manage Network > Network wide plugins > Install: Favorites */
		$mstba_tb_items[ 'networkplugins-installfaves' ] = array(
			'parent' => $networkplugins,
			'title'  => __( 'Install Plugins: Favorites', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'plugin-install.php?tab=favorites' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Install Plugins - Favorites (via WordPress.org)', 'multisite-toolbar-additions' )
			)
		);

	/** Manage Network > Network wide themes */
	$mstba_tb_items[ 'networkthemes' ] = array(
		'parent' => 'network-admin',
		'title'  => __( 'Network Themes', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'themes.php' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Network Themes', 'multisite-toolbar-additions' )
		)
	);

		/** Manage Network > Network wide themes > Install: Search */
		$mstba_tb_items[ 'networkthemes-install' ] = array(
			'parent' => $networkthemes,
			'title'  => __( 'Install Themes: Search', 'multisite-toolbar-additions' ),
			'href'   => ddw_mstba_theme_install_link(),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Install Themes - Search on WordPress.org', 'multisite-toolbar-additions' )
			)
		);

		/** Manage Network > Network wide themes > Install: ZIP upload */
		$mstba_tb_items[ 'networkthemes-installupload' ] = array(
			'parent' => $networkthemes,
			'title'  => __( 'Install Themes: Upload', 'multisite-toolbar-additions' ),
			'href'   => ddw_mstba_theme_upload_link(),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Install Themes - Upload ZIP file', 'multisite-toolbar-additions' )
			)
		);

	/** Manage Network > Network Theme Editor */
	if ( !( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT ) && current_user_can( 'edit_themes' ) ) {

		$mstba_tb_items[ 'network-themeeditor' ] = array(
			'parent' => 'network-admin',
			'title'  => __( 'Network Theme Editor', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'theme-editor.php' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Network Theme Editor', 'multisite-toolbar-additions' )
			)
		);

	}  // end-if cap check

	/** Network Extend Group: Main Entry */
	if ( defined( 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP' ) && MSTBA_DISPLAY_NETWORK_EXTEND_GROUP ) {
		$wp_admin_bar->add_group( array(
			'parent' => 'my-sites-super-admin',
			'id'     => $networkextgroup,
		) );

		/** Action Hook 'mstba_custom_network_items' - allows for hooking in other network-specific items */
		do_action( 'mstba_custom_network_items' );

	}  // end-if constant check


	/** Manage Network > Visit Network (re-adding as last item!) - opening in a blank window/tab! */
	$mstba_tb_items[ 'network-visit' ] = array(
		'parent' => 'network-admin',
		'title'  => __( 'Visit Network', 'multisite-toolbar-additions' ),
		'href'   => network_home_url(),
		'meta'   => array(
			'target' => '_blank',
			'title'  => __( 'Visit Network', 'multisite-toolbar-additions' )
		)
	);
