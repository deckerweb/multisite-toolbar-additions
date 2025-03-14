<?php
/**
 * Display links to active plugins/extensions settings' pages: WP Super Cache.
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
 * WP Super Cache (free, by Donncha O Caoimh)
 *
 * @since 1.0.0
 *
 * @uses  is_super_admin()
 * @uses  is_plugin_active_for_network()
 * @uses  current_user_can()
 */
/** If plugin is network activated, display stuff in 'network_admin' */
if ( is_super_admin()
	&& (
			function_exists( 'is_plugin_active_for_network' )
			&& is_plugin_active_for_network( 'wp-super-cache/wp-cache.php' )
		)
) {

	$mstba_tb_items[ 'networkext_wpsupercache' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'WP Super Cache', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=wpsupercache&tab=easy' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'WP Super Cache', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpsupercache_settings' ] = array(
		'parent' => $networkext_wpsupercache,
		'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=wpsupercache&tab=settings' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Settings', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpsupercache_cdn' ] = array(
		'parent' => $networkext_wpsupercache,
		'title'  => __( 'CDN', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=wpsupercache&tab=cdn' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'CDN (Content Delivery Network)',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

	$mstba_tb_items[ 'networkext_wpsupercache_contents' ] = array(
		'parent' => $networkext_wpsupercache,
		'title'  => __( 'Contents', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=wpsupercache&tab=contents' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Contents', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpsupercache_preload' ] = array(
		'parent' => $networkext_wpsupercache,
		'title'  => __( 'Preload', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=wpsupercache&tab=preload' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Preload', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpsupercache_plugins' ] = array(
		'parent' => $networkext_wpsupercache,
		'title'  => __( 'Plugins', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=wpsupercache&tab=plugins' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Plugins', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpsupercache_debug' ] = array(
		'parent' => $networkext_wpsupercache,
		'title'  => __( 'Debug', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=wpsupercache&tab=debug' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Debug', 'multisite-toolbar-additions' )
		)
	);

}  // end-if multisite check

	/** Otherwise, if plugin is only site activated, display stuff in a sub site admin */
elseif ( current_user_can( 'administrator' )
		&& (
				function_exists( 'is_plugin_active_for_network' )
				&& ! is_plugin_active_for_network( 'wp-super-cache/wp-cache.php' )
			)
) {

	$mstba_tb_items[ 'siteext_wpsupercache' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'WP Super Cache', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=wpsupercache' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'WP Super Cache', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_wpsupercache_settings' ] = array(
		'parent' => $siteext_wpsupercache,
		'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=wpsupercache&tab=settings' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Settings', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_wpsupercache_cdn' ] = array(
		'parent' => $siteext_wpsupercache,
		'title'  => __( 'CDN', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=wpsupercache&tab=cdn' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'CDN (Content Delivery Network)',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

	$mstba_tb_items[ 'siteext_wpsupercache_contents' ] = array(
		'parent' => $siteext_wpsupercache,
		'title'  => __( 'Contents', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=wpsupercache&tab=contents' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Contents', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_wpsupercache_preload' ] = array(
		'parent' => $siteext_wpsupercache,
		'title'  => __( 'Preload', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=wpsupercache&tab=preload' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Preload', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_wpsupercache_plugins' ] = array(
		'parent' => $siteext_wpsupercache,
		'title'  => __( 'Plugins', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=wpsupercache&tab=plugins' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Plugins', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_wpsupercache_debug' ] = array(
		'parent' => $siteext_wpsupercache,
		'title'  => __( 'Debug', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=wpsupercache&tab=debug' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Debug', 'multisite-toolbar-additions' )
		)
	);

}  // end-if ! multisite check