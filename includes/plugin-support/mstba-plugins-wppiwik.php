<?php
/**
 * Display links to active plugins/extensions settings' pages: WP-Piwik.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
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


/**
 * WP-Piwik (free, by Andr&eacute; Br&auml;kling)
 *
 * @since 1.0.0
 *
 * @uses  is_plugin_active_for_network()
 * @uses  current_user_can()
 * @uses  get_option()
 * @uses  network_admin_url()
 * @uses  admin_url()
 */
/** If plugin is network activated - in Multisite */
if ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'wp-piwik/wp-piwik.php' ) ) {

	$mstba_wppiwik_type = 'settings';
	$mstba_wppiwik_aurl_slug = network_admin_url( 'settings.php?page=wp-piwik/wp-piwik.php&tab=piwik' );

	/** Add view statistics item */
	$mstba_tb_items[ 'networkext_wppiwik' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'WP-Piwik Statistics', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'index.php?page=wp-piwik_stats' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'WP-Piwik Statistics', 'multisite-toolbar-additions' )
		)
	);

	/** Add the settings items */
	if ( current_user_can( 'manage_sites' ) ) {

		$mstba_tb_items[ 'networkext_wppiwik_settings' ] = array(
			'parent' => $networkext_wppiwik,
			'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=wp-piwik/wp-piwik.php&tab=piwik' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Settings', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_wppiwik_tracking' ] = array(
			'parent' => $networkext_wppiwik,
			'title'  => __( 'Tracking Settings', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=wp-piwik/wp-piwik.php&tab=tracking' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Tracking Settings', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_wppiwik_views' ] = array(
			'parent' => $networkext_wppiwik,
			'title'  => __( 'Views Settings', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=wp-piwik/wp-piwik.php&tab=views' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Views Settings', 'multisite-toolbar-additions' )
			)
		);

	}  // end-if cap check

	/** Add support item */
	$mstba_tb_items[ 'networkext_wppiwik_support' ] = array(
		'parent' => $networkext_wppiwik,
		'title'  => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=wp-piwik/wp-piwik.php&tab=support' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' )
		)
	);

}  // end-if multisite check

elseif ( ! is_plugin_active_for_network( 'wp-piwik/wp-piwik.php' ) ) {

	$mstba_wppiwik_aurl_slug = admin_url( 'options-general.php?page=wp-piwik/wp-piwik.php&tab=piwik' );

	/** Add view statistics item */
	$mstba_tb_items[ 'siteext_wppiwik' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'WP-Piwik Statistics', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'index.php?page=wp-piwik_stats' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'WP-Piwik Statistics', 'multisite-toolbar-additions' )
		)
	);

	/** Add the settings items */
	if ( current_user_can( 'activate_plugins' ) ) {

		$mstba_tb_items[ 'siteext_wppiwik_settings' ] = array(
			'parent' => $siteext_wppiwik,
			'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=wp-piwik/wp-piwik.php&tab=piwik' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Settings', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_wppiwik_tracking' ] = array(
			'parent' => $siteext_wppiwik,
			'title'  => __( 'Tracking Settings', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=wp-piwik/wp-piwik.php&tab=tracking' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Tracking Settings', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_wppiwik_views' ] = array(
			'parent' => $siteext_wppiwik,
			'title'  => __( 'Views Settings', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=wp-piwik/wp-piwik.php&tab=views' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Views Settings', 'multisite-toolbar-additions' )
			)
		);

	}  // end-if cap check

	/** Add support item */
	$mstba_tb_items[ 'siteext_wppiwik_support' ] = array(
		'parent' => $siteext_wppiwik,
		'title'  => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=wp-piwik/wp-piwik.php&tab=support' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' )
		)
	);

}  // end-if ! multisite check

/** Add settings item below stats view in toolbar */
if ( current_user_can( 'activate_plugins' ) && get_option( 'wp-piwik_global-settings', 'toolbar' ) ) {

	$mstba_tb_items[ 'ext_wppiwik_settings' ] = array(
		'parent' => 'wp-piwik_stats',
		'title'  => __( 'WP-Piwik Settings', 'multisite-toolbar-additions' ),
		'href'   => $mstba_wppiwik_aurl_slug,
		'meta'   => array(
			'target' => '',
			'title'  => __( 'WP-Piwik Settings', 'multisite-toolbar-additions' )
		)
	);

}  // end-if