<?php
/**
 * Display links to active plugins/extensions settings' pages: Better WP Security.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013-2018, David Decker - DECKERWEB
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
 * Better WP Security (free, by Chris Wiegman & iThemes)
 *
 * @since 1.6.0
 *
 * @uses  is_multisite()
 * @uses  current_user_can()
 */
/** Multisite check */
if ( is_multisite() ) {

	$mstba_bwps_pre_id      = 'networkext';
	$mstba_bwps_parent      = $networkext_betterwpsecurity;
	$mstba_bwps_parentfirst = $networkextgroup;

} else {

	$mstba_bwps_pre_id      = 'siteext';
	$mstba_bwps_parent      = $siteext_betterwpsecurity;
	$mstba_bwps_parentfirst = $siteextgroup;
	
}  // end-if multisite check

/** List the menu items */
$mstba_tb_items[ $mstba_bwps_pre_id . '_betterwpsecurity' ] = array(
	'parent' => $mstba_bwps_parentfirst,
	'title'  => __( 'Better WP Security', 'multisite-toolbar-additions' ),
	'href'   => network_admin_url( 'admin.php?page=better-wp-security' ),
	'meta'   => array(
		'target' => '',
		'title'  => _x(
			'Better WP Security - Dashboard',
			'Translators: For the tooltip',
			'multisite-toolbar-additions'
		)
	)
);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_adminuser' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'Admin User', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-adminuser' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Admin User', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_awaymode' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'Away Mode', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-awaymode' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Away Mode', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_banusers' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'Ban Users', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-banusers' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Ban Users', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_contentdirectory' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'Content Directory', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-contentdirectory' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Content Directory', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_dbbackup' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'Database Backup', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-databasebackup' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Database Backup', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_dbprefix' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'Database Prefix', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-databaseprefix' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Database Prefix', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_hidebackend' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'Hide Backend', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-hidebackend' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Hide Backend', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_detection' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'Intrusion Detection', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-intrusiondetection' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Intrusion Detection', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_loginlimits' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'Login Limits', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-loginlimits' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Login Limits', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_ssl' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'SSL/ HTTPS', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-ssl' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'SSL/ HTTPS', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_systemtweaks' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'System Tweaks', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-systemtweaks' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'System Tweaks', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_bwps_pre_id . '_bwps_viewlogs' ] = array(
		'parent' => $mstba_bwps_parent,
		'title'  => __( 'View Logs', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=better-wp-security-logs' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'View Logs', 'multisite-toolbar-additions' )
		)
	);