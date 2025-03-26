<?php
/**
 * Display links to active plugins/extensions settings' pages: Stream.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2014-2025, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 *
 * @since      1.7.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.7.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Stream (free, by X-Team)
 *
 * @since 1.7.0
 */
$mstba_tb_items[ 'siteext_stream' ] = array(
	'parent' => $siteextgroup,
	'title'  => __( 'Activity Streams', 'multisite-toolbar-additions' ),
	'href'   => admin_url( 'admin.php?page=wp_stream' ),
);

	$mstba_tb_items[ 'siteext_stream_view' ] = array(
		'parent' => $siteext_stream,
		'title'  => __( 'View Streams', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=wp_stream' ),
	);

	$mstba_tb_items[ 'siteext_stream_settings' ] = array(
		'parent' => $siteext_stream,
		'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=wp_stream_settings' ),
	);

	$mstba_tb_items[ 'siteext_stream_exclude' ] = array(
		'parent' => $siteext_stream,
		'title'  => __( 'Exclude Options', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=wp_stream_settings&tab=exclude' ),
	);

	$mstba_tb_items[ 'siteext_stream_extensions' ] = array(
		'parent' => $siteext_stream,
		'title'  => __( 'Extensions', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=wp_stream_extensions' ),
	);

	$mstba_tb_items[ 'siteext_stream_membership' ] = array(
		'parent' => $siteext_stream,
		'title'  => __( 'Premium Membership &amp; Support', 'multisite-toolbar-additions' ),
		'href'   => ddw_mstba_affwp( 'wp-stream.com/#extensions', '7', FALSE, TRUE ),
	);

	$mstba_tb_items[ 'siteext_stream_development' ] = array(
		'parent' => $siteext_stream,
		'title'  => __( 'Development', 'multisite-toolbar-additions' ),
		'href'   => 'https://github.com/x-team/wp-stream',
	);

	$mstba_tb_items[ 'siteext_stream_support' ] = array(
		'parent' => $siteext_stream,
		'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
		'href'   => 'http://wordpress.org/support/plugin/stream',
	);