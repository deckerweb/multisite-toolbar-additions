<?php
/**
 * Display links to active plugins/extensions settings' pages: WordPress Multisite Admin Reports.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2014-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
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
 * WordPress Multisite Admin Reports (free, by Joe Motacek)
 *
 * @since 1.7.0
 */
$mstba_tb_items[ 'networkext_wpmsar' ] = array(
	'parent' => $networkextgroup,
	'title'  => __( 'Admin Reports', 'multisite-toolbar-additions' ),
	'href'   => admin_url( 'admin.php?page=wpms_admin_reports' ),
	'meta'   => array(
		'target' => '',
		'title'  => _x( 'Site Streams - Logged Activity', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
	)
);

	$mstba_tb_items[ 'networkext_wpmsar_overview' ] = array(
		'parent' => $networkext_wpmsar,
		'title'  => __( 'Statistics Overview', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=wpms_admin_reports' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Statistics Overview', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpmsar_site' ] = array(
		'parent' => $networkext_wpmsar,
		'title'  => __( 'Site Report', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=wpmsar_site_report' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Site Report', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpmsar_user' ] = array(
		'parent' => $networkext_wpmsar,
		'title'  => __( 'User Report', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=wpmsar_user_report' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'User Report', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpmsar_plugin' ] = array(
		'parent' => $networkext_wpmsar,
		'title'  => __( 'Plugin Report', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=wpmsar_plugin_report' ),
		'meta'   => array(
			'title'  => __( 'Plugin Report', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpmsar_development' ] = array(
		'parent' => $networkext_wpmsar,
		'title'  => __( 'Development', 'multisite-toolbar-additions' ),
		'href'   => 'https://github.com/cleanshooter/wpms_admin_reports',
		'meta'   => array(
			'title' => __( 'Development', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpmsar_support' ] = array(
		'parent' => $networkext_wpmsar,
		'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
		'href'   => 'http://wordpress.org/support/plugin/wpms-admin-reports',
		'meta'   => array(
			'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
		)
	);