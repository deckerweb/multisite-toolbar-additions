<?php
/**
 * Display links to active plugins/extensions settings' pages: WP Migrate DB Pro.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.4.0
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
 * WP Migrate DB Pro (premium, by Delicious Brains (Brad Touesnard & Chris Aprea))
 *
 * @since 1.4.0
 */
/** If plugin is network activated, display stuff in 'network_admin' */
if ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'wp-migrate-db-pro/wp-migrate-db-pro.php' )
	&& current_user_can( 'manage_network_options' )
) {

	$mstba_tb_items[ 'networkext_wpmigratedbpro' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Migrate Database Pro', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=wp-migrate-db-pro#migrate' ),
		'meta'   => array(
			'class'  => 'js-action-link migrate',
			'target' => '',
			'title'  => __( 'Migrate Database Pro', 'multisite-toolbar-additions' )
		)
	);

		$mstba_tb_items[ 'networkext_wpmigratedbpro_settings' ] = array(
			'parent' => $networkext_wpmigratedbpro,
			'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=wp-migrate-db-pro#settings' ),
			'meta'   => array(
				'class'  => 'js-action-link settings',
				'target' => '',
				'title'  => __( 'Settings', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_wpmigratedbpro_addons' ] = array(
			'parent' => $networkext_wpmigratedbpro,
			'title'  => __( 'Add-Ons', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=wp-migrate-db-pro#addons' ),
			'meta'   => array(
				'class'  => 'js-action-link addons',
				'target' => '',
				'title'  => __( 'Add-Ons', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_wpmigratedbpro_help' ] = array(
			'parent' => $networkext_wpmigratedbpro,
			'title'  => __( 'Help (Inline)', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=wp-migrate-db-pro#help' ),
			'meta'   => array(
				'class'  => 'js-action-link help',
				'target' => '',
				'title'  => __( 'Help (Inline)', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_wpmigratedbpro_support' ] = array(
			'parent' => $networkext_wpmigratedbpro,
			'title'  => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' ),
			'href'   => 'http://deliciousbrains.com/wp-migrate-db-pro/support/',
			'meta'   => array(
				'title' => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' )
			)
		);

}  // end-if multisite check

	/** Otherwise, if plugin is only site activated, display stuff in a sub site admin */
elseif ( current_user_can( 'update_core' ) ) {

	$mstba_tb_items[ 'siteext_wpmigratedbpro' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Migrate Database Pro', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'tools.php?page=wp-migrate-db-pro#migrate' ),
		'meta'   => array(
			'class'  => 'js-action-link migrate',
			'target' => '',
			'title'  => __( 'Migrate Database Pro', 'multisite-toolbar-additions' )
		)
	);

		$mstba_tb_items[ 'siteext_wpmigratedbpro_settings' ] = array(
			'parent' => $siteext_wpmigratedbpro,
			'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'tools.php?page=wp-migrate-db-pro#settings' ),
			'meta'   => array(
				'class'  => 'js-action-link settings',
				'target' => '',
				'title'  => __( 'Settings', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_wpmigratedbpro_addons' ] = array(
			'parent' => $siteext_wpmigratedbpro,
			'title'  => __( 'Add-Ons', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'tools.php?page=wp-migrate-db-pro#addons' ),
			'meta'   => array(
				'class'  => 'js-action-link addons',
				'target' => '',
				'title'  => __( 'Add-Ons', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_wpmigratedbpro_help' ] = array(
			'parent' => $siteext_wpmigratedbpro,
			'title'  => __( 'Help (Inline)', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'tools.php?page=wp-migrate-db-pro#help' ),
			'meta'   => array(
				'class'  => 'js-action-link help',
				'target' => '',
				'title'  => __( 'Help (Inline)', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_wpmigratedbpro_support' ] = array(
			'parent' => $siteext_wpmigratedbpro,
			'title'  => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' ),
			'href'   => 'http://deliciousbrains.com/wp-migrate-db-pro/support/',
			'meta'   => array(
				'title' => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' )
			)
		);

}  // end-if ! multisite check