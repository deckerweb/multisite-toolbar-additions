<?php
/**
 * Display links to active plugins/extensions settings' pages: Simple System Info.
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
 * Simple System Info (premium, by Smart Plugins/ Milan Petrovic)
 *
 * @since 1.4.0
 *
 * @uses  is_multisite()
 * @uses  current_user_can()
 */
/** Multisite check */
if ( is_multisite() && current_user_can( 'manage_network' ) ) {

	/** List the network menu items */
	$mstba_tb_items[ 'networkext_simplesystinfo' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Network System Info', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'index.php?page=simple-system-info' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Network System Info - Overview',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'networkext_simplesystinfo_wordpress' ] = array(
			'parent' => $networkext_simplesystinfo,
			'title'  => __( 'WordPress', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'index.php?page=simple-system-info&tab=wordpress' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'WordPress Install Info', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_simplesystinfo_database' ] = array(
			'parent' => $networkext_simplesystinfo,
			'title'  => __( 'Database', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'index.php?page=simple-system-info&tab=database' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Database', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_simplesystinfo_php' ] = array(
			'parent' => $networkext_simplesystinfo,
			'title'  => __( 'PHP Info', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'index.php?page=simple-system-info&tab=phpinfo' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'PHP Info', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_simplesystinfo_mysql' ] = array(
			'parent' => $networkext_simplesystinfo,
			'title'  => __( 'MySQL Info', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'index.php?page=simple-system-info&tab=mysqlinfo' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'MySQL Info', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_simplesystinfo_about' ] = array(
			'parent' => $networkext_simplesystinfo,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'index.php?page=simple-system-info&tab=about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_simplesystinfo_support' ] = array(
			'parent' => $networkext_simplesystinfo,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => 'http://forum.smartplugins.info/forums/forum/simple/simple-system-info/',
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end-if is_multisite() & cap check

if ( current_user_can( 'activate_plugins' ) ) {

	/** List the (site) menu items */
	$mstba_tb_items[ 'siteext_simplesystinfo' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Site System Info', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'index.php?page=simple-system-info' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Site System Info - Overview',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'siteext_simplesystinfo_wordpress' ] = array(
			'parent' => $siteext_simplesystinfo,
			'title'  => __( 'WordPress', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'index.php?page=simple-system-info&tab=wordpress' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'WordPress Install Info', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_simplesystinfo_database' ] = array(
			'parent' => $siteext_simplesystinfo,
			'title'  => __( 'Database', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'index.php?page=simple-system-info&tab=database' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Database', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_simplesystinfo_php' ] = array(
			'parent' => $siteext_simplesystinfo,
			'title'  => __( 'PHP Info', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'index.php?page=simple-system-info&tab=phpinfo' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'PHP Info', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_simplesystinfo_mysql' ] = array(
			'parent' => $siteext_simplesystinfo,
			'title'  => __( 'MySQL Info', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'index.php?page=simple-system-info&tab=mysqlinfo' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'MySQL Info', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_simplesystinfo_about' ] = array(
			'parent' => $siteext_simplesystinfo,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'index.php?page=simple-system-info&tab=about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_simplesystinfo_support' ] = array(
			'parent' => $siteext_simplesystinfo,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => 'http://forum.smartplugins.info/forums/forum/simple/simple-system-info/',
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end-if cap check