<?php

// includes/plugin-support/mstba-plugins-gitupdater

/**
 * Prevent direct access to this file.
 *
 * @since 3.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_mstba_items_devkitpro', 100 );
/**
 * Items for Plugin: DevKit Pro (Premium, by DPlugins)
 *
 * @since 3.1.0
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_mstba_items_devkitpro( $admin_bar ) {

	/** For Plugins */
	if ( current_user_can( 'install_plugins' ) ) {
		$admin_bar->add_node(
			array(
				'id'     => 'devkit-install-plugin',
				'parent' => 'ddw-mstba-addnew_plugin',
				'title'  => esc_html__( 'via DevKit', 'multisite-toolbar-additions' ),
				'href'   => esc_url( admin_url( 'admin.php?page=devkit' ) ),
			)
		);
	}  // end if
	
	/** For Themes */
	if ( current_user_can( 'install_themes' ) ) {
		$admin_bar->add_node(
			array(
				'id'     => 'devkit-install-theme',
				'parent' => 'ddw-mstba-addnew_theme',
				'title'  => esc_html__( 'via DevKit', 'multisite-toolbar-additions' ),
				'href'   => esc_url( admin_url( 'admin.php?page=devkit' ) ),
			)
		);
	}  // end if

}  // end function


add_action( 'admin_menu', 'ddw_mstba_plugins_submenu_devkitpro', 100 );
/**
 * Add Git Updater quick-jump submenu under "Plugins".
 *
 * @since 3.1.0
 */
function ddw_mstba_plugins_submenu_devkitpro() {
	
	if ( ! current_user_can( 'activate_plugins' ) ) return;	
	
	add_submenu_page(
		'plugins.php',
		esc_html__( 'via DevKit', 'multisite-toolbar-additions' ),
		esc_html__( 'via DevKit', 'multisite-toolbar-additions' ),
		'activate_plugins',
		esc_url( admin_url( 'admin.php?page=devkit' ) )
	);
	
}  // end function