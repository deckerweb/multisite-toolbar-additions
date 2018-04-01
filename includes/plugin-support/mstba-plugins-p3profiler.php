<?php
/**
 * Display links to active plugins/extensions settings' pages: P3 (Plugin Performance Profiler).
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
 * P3 (Plugin Performance Profiler) (free, by GoDaddy.com)
 *
 * @since 1.4.0
 */
$mstba_tb_items[ 'siteext_p3profiler' ] = array(
	'parent' => $siteextgroup,
	'title'  => __( 'P3 Plugin Profiler', 'multisite-toolbar-additions' ),
	'href'   => admin_url( 'tools.php?page=p3-profiler' ),
	'meta'   => array(
		'target' => '',
		'title'  => _x(
			'P3 Plugin Performance Profiler',
			'Translators: For the tooltip',
			'multisite-toolbar-additions'
		)
	)
);

	$mstba_tb_items[ 'siteext_p3profiler_current' ] = array(
		'parent' => $siteext_p3profiler,
		'title'  => __( 'Current Scan', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'tools.php?page=p3-profiler&p3_action=current-scan' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Current Scan', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_p3profiler_history' ] = array(
		'parent' => $siteext_p3profiler,
		'title'  => __( 'History', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'tools.php?page=p3-profiler&p3_action=list-scans' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'History', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_p3profiler_help' ] = array(
		'parent' => $siteext_p3profiler,
		'title'  => __( 'Help/ FAQ', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'tools.php?page=p3-profiler&p3_action=help' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Help/ FAQ', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_p3profiler_support' ] = array(
		'parent' => $siteext_p3profiler,
		'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
		'href'   => 'http://wordpress.org/support/plugin/p3-profiler',
		'meta'   => array(
			'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
		)
	);