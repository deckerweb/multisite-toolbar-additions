<?php
/**
 * Display links to active plugins/extensions settings' pages: WordPress MU Domain Mapping.
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
 * WordPress MU Domain Mapping (free, by Donncha O Caoimh, Ron Rennick, Automatic Inc.)
 *
 * @since 1.4.0
 */
$mstba_tb_items[ 'networkext_wpmudomainmapping' ] = array(
	'parent' => $networkextgroup,
	'title'  => __( 'Domain Mapping', 'multisite-toolbar-additions' ),
	'href'   => network_admin_url( 'settings.php?page=dm_domains_admin' ),
	'meta'   => array(
		'target' => '',
		'title'  => __( 'Domain Mapping', 'multisite-toolbar-additions' )
	)
);

	$mstba_tb_items[ 'networkext_wpmudomainmapping_settings' ] = array(
		'parent' => $networkext_wpmudomainmapping,
		'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=dm_admin_page' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Settings', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_wpmudomainmapping_support' ] = array(
		'parent' => $networkext_wpmudomainmapping,
		'title'  => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' ),
		'href'   => 'http://wordpress.org/support/plugin/wordpress-mu-domain-mapping',
		'meta'   => array(
			'target' => '',
			'title'  => _x( 'Support', 'Translators: Toolbar item', 'multisite-toolbar-additions' )
		)
	);