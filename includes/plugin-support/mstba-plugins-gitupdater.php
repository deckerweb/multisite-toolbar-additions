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


add_action( 'admin_bar_menu', 'ddw_mstba_items_git_updater', 100 );
/**
 * Items for Plugin: Git Updater (free/Premium, by Andy Fragen)
 *
 * @since 3.1.0
 *
 * @param object $admin_bar Object of Toolbar nodes.
 */
function ddw_mstba_items_git_updater( $admin_bar ) {

	/** For Plugins */
	if ( current_user_can( 'install_plugins' ) || current_user_can( 'upload_plugins' ) ) {
		$admin_bar->add_node(
			array(
				'id'     => 'gitup-install-plugin',
				'parent' => 'ddw-mstba-addnew_plugin',
				'title'  => esc_html__( 'via Git Updater', 'multisite-toolbar-additions' ),
				'href'   => is_multisite() ? esc_url( network_admin_url( 'settings.php?page=git-updater&tab=git_updater_install_plugin' ) ) : esc_url( admin_url( 'options-general.php?page=git-updater&tab=git_updater_install_plugin' ) ),
			)
		);
	
		$admin_bar->add_node(
			array(
				'id'     => 'gitup-gh-setup',
				'parent' => 'ddw-mstba-addnew_plugin',
				'title'  => esc_html__( 'Git Updater: GitHub Setup', 'multisite-toolbar-additions' ),
				'href'   => is_multisite() ? esc_url( network_admin_url( 'settings.php?page=git-updater&tab=git_updater_settings&subtab=github' ) ) : esc_url( admin_url( 'options-general.php?page=git-updater&tab=git_updater_settings&subtab=github' ) ),
			)
		);
		
		$admin_bar->add_node(
			array(
				'id'     => 'gitup-gh-additions',
				'parent' => 'ddw-mstba-addnew_plugin',
				'title'  => esc_html__( 'Git Updater: Additions', 'multisite-toolbar-additions' ),
				'href'   => is_multisite() ? esc_url( network_admin_url( 'settings.php?page=git-updater&tab=git_updater_additions' ) ) : esc_url( admin_url( 'options-general.php?page=git-updater&tab=git_updater_additions' ) ),
			)
		);
	}  // end if
	
	/** For Themes */
	if ( current_user_can( 'install_themes' ) || current_user_can( 'upload_themes' ) ) {
		$admin_bar->add_node(
			array(
				'id'     => 'gitup-install-theme',
				'parent' => 'ddw-mstba-addnew_theme',
				'title'  => esc_html__( 'via Git Updater', 'multisite-toolbar-additions' ),
				'href'   => is_multisite() ? esc_url( network_admin_url( 'settings.php?page=git-updater&tab=git_updater_install_theme' ) ) : esc_url( admin_url( 'options-general.php?page=git-updater&tab=git_updater_install_theme' ) ),
			)
		);
	}  // end if

}  // end function


add_action( 'admin_menu', 'ddw_mstba_plugins_submenu_gitupdater', 100 );
add_action( 'network_admin_menu', 'ddw_mstba_plugins_submenu_gitupdater', 100 );
/**
 * Add Git Updater quick-jump submenu under "Plugins".
 *
 * @since 3.1.0
 */
function ddw_mstba_plugins_submenu_gitupdater() {
	
	if ( ! current_user_can( 'activate_plugins' ) || ! current_user_can( 'install_plugins' ) || ! current_user_can( 'upload_plugins' ) ) return;	
	
	add_submenu_page(
		'plugins.php',
		esc_html__( 'via Git Updater', 'multisite-toolbar-additions' ),
		esc_html__( 'via Git Updater', 'multisite-toolbar-additions' ),
		'activate_plugins',
		is_multisite() ? esc_url( network_admin_url( 'settings.php?page=git-updater&tab=git_updater_settings&subtab=github' ) ) : esc_url( admin_url( 'options-general.php?page=git-updater&tab=git_updater_settings&subtab=github' ) )
	);
	
}  // end function