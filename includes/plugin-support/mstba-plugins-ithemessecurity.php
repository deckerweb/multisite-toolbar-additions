<?php
/**
 * Display links to active plugins/extensions settings' pages: iThemes Security.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2014-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.7.1
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.7.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * iThemes Security (free, by iThemes)
 *
 * @since 1.7.1
 *
 * @uses  is_multisite()
 * @uses  current_user_can()
 */
/** Multisite check */
if ( is_multisite() ) {

	$mstba_itsec_pre_id      = 'networkext';
	$mstba_itsec_parent      = $networkext_ithemessecurity;
	$mstba_itsec_parentfirst = $networkextgroup;

} else {

	$mstba_itsec_pre_id      = 'siteext';
	$mstba_itsec_parent      = $siteext_ithemessecurity;
	$mstba_itsec_parentfirst = $siteextgroup;
	
}  // end-if multisite check

/** List the menu items */
$mstba_tb_items[ $mstba_itsec_pre_id . '_ithemessecurity' ] = array(
	'parent' => $mstba_itsec_parentfirst,
	'title'  => __( 'iThemes Security', 'multisite-toolbar-additions' ),
	'href'   => network_admin_url( 'admin.php?page=itsec' ),
	'meta'   => array(
		'target' => '',
		'title'  => _x(
			'iThemes Security - Dashboard',
			'Translators: For the tooltip',
			'multisite-toolbar-additions'
		)
	)
);

	$mstba_tb_items[ $mstba_itsec_pre_id . '_itsec_settings' ] = array(
		'parent' => $mstba_itsec_parent,
		'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=toplevel_page_itsec_settings' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Settings', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_itsec_pre_id . '_itsec_advanced' ] = array(
		'parent' => $mstba_itsec_parent,
		'title'  => __( 'Advanced', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=toplevel_page_itsec_advanced' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Advanced', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_itsec_pre_id . '_itsec_backups' ] = array(
		'parent' => $mstba_itsec_parent,
		'title'  => __( 'Backups', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=toplevel_page_itsec_backups' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Simple Basic Backups',
				'Translators: for the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

	$mstba_tb_items[ $mstba_itsec_pre_id . '_itsec_logs' ] = array(
		'parent' => $mstba_itsec_parent,
		'title'  => __( 'Logs', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=toplevel_page_itsec_logs' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Logs', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ $mstba_itsec_pre_id . '_itsec_help' ] = array(
		'parent' => $mstba_itsec_parent,
		'title'  => __( 'Help', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=toplevel_page_itsec_help' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Help', 'multisite-toolbar-additions' )
		)
	);