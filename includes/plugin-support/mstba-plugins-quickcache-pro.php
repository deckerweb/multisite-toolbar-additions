<?php
/**
 * Display links to active plugins/extensions settings' pages: Quick Cache 2013/Pro.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.6.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Quick Cache 2013/Pro (free & premium, by WebSharks, Inc.)
 *
 * @since 1.6.0
 *
 * @uses  is_multisite()
 */
/** For Multisite display stuff in 'network_admin' */
if ( is_multisite() ) {

	$mstba_tb_items[ 'networkext_quickcache' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Quick Cache Options', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=quick_cache' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Quick Cache Options', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_quickcache_updater' ] = array(
		'parent' => $networkext_quickcache,
		'title'  => __( 'Plugin Updater', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=quick_cache-update-sync' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Plugin Updater', 'multisite-toolbar-additions' )
		)
	);

}

	/** Otherwise, display stuff in a sub site admin */
else {

	$mstba_tb_items[ 'siteext_quickcache' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Quick Cache Options', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=quick_cache' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Quick Cache Options', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_quickcache_updater' ] = array(
		'parent' => $siteext_quickcache,
		'title'  => __( 'Plugin Updater', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=quick_cache-update-sync' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Plugin Updater', 'multisite-toolbar-additions' )
		)
	);

}  // end-if multisite check