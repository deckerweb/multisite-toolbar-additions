<?php
/**
 * Additional "Widgets" items, provided by supported plugins.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Widgets Items
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013-2025, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 *
 * @since      1.5.0
 */

 /**
 * Prevent direct access to this file.
 *
 * @since 1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * List items from supported plugins under "Widgets" toolbar item.
 *
 * @since 1.5.0
 */

	/** Widget Customizer - core feature sindce WP 3.9+ */
	if ( function_exists( 'doing_action' ) ) {

		$mstba_tb_items[ 'widgets-customizer' ] = array(
			'parent' => is_admin() ? $widgets : 'widgets',
			'title'  => __( 'Widgets Customizer', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'customize.php?widget-customizer=open' ),
		);

	}  // end if


	/**
	 * Genesis Simple Sidebars (free, by StudioPress/ Copyblogger Media LLC)
	 *
	 * @since 1.5.0
	 */
	if ( defined( 'SS_SETTINGS_FIELD' ) && ( basename( get_template_directory() ) == 'genesis' ) && current_user_can( 'edit_theme_options' ) ) {

		$mstba_tb_items[ 'widgets-plggenesissimplesidebars' ] = array(
			'parent' => is_admin() ? $widgets : 'widgets',
			'title'  => __( 'Genesis Simple Sidebars', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=simple-sidebars' ),
		);

	}  // end if Genesis Simple Sidebars


	/**
	 * Go Sidebar Wizard (premium, by Granth)
	 *
	 * @since 1.4.0
	 */
	if ( defined( 'GW_GO_SBWIZARD_VER' ) && current_user_can( 'edit_pages' ) ) {

		$mstba_tb_items[ 'widgets-plggosbwizard' ] = array(
			'parent' => is_admin() ? $widgets : 'widgets',
			'title'  => __( 'Go Sidebar Wizard', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=go-sbwizard' ),
		);

		$mstba_tb_items[ 'widgets-plggosbwizard-sidebars' ] = array(
			'parent' => is_admin() ? $widgets : 'widgets',
			'title'  => __( 'Custom Sidebars', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=go-sbwizard-custom-sidebars' ),
		);

	}  // end if Go Sidebar Wizard


	/**
	 * Widget Settings Importer/Exporter (free, by Kevin Langley, Sean McCafferty, Mark Parolisi)
	 *
	 * @since 1.4.0
	 */
	if ( class_exists( 'Widget_Data' ) && current_user_can( 'administrator' ) ) {

		$mstba_tb_items[ 'widgets-plgwdata-export' ] = array(
			'parent' => is_admin() ? $widgets : 'widgets',
			'title'  => __( 'Widget Settings Export', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'tools.php?page=widget-settings-export' ),
		);

		$mstba_tb_items[ 'widgets-plgwdata-import' ] = array(
			'parent' => is_admin() ? $widgets : 'widgets',
			'title'  => __( 'Widget Settings Import', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'tools.php?page=widget-settings-import' ),
		);

	}  // end if Widget Settings Importer/Exporter


	/**
	 * Restrict Widgets (free, by Digital Factory)
	 *
	 * @since 1.4.0
	 */
	if ( class_exists( 'RestrictWidgets' ) && current_user_can( 'manage_widgets' ) ) {

		$mstba_tb_items[ 'widgets-plgrestrictw' ] = array(
			'parent' => is_admin() ? $widgets : 'widgets',
			'title'  => __( 'Restrict Widgets', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'widgets.php' ) . '#widgets-options',
		);

	}  // end if Restrict Widgets
