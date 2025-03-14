<?php
/**
 * Display links to active plugins/extensions settings' pages: Hide My WP.
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
 * Hide My WP (premium, by Hassan Jahangiri)
 *
 * @since 1.4.0
 *
 * @uses  is_super_admin()
 * @uses  is_plugin_active_for_network()
 */
/** If plugin is network activated, display stuff in 'network_admin' */
if ( is_super_admin()
	&& ( function_exists( 'is_plugin_active_for_network' ) && is_plugin_active_for_network( 'hide_my_wp/hide-my-wp.php' ) )
) {

	$mstba_tb_items[ 'networkext_hidemywp' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Hide My WP', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=hide_my_wp#start' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Hide My WP - Security & Branding Settings',
				'Translators: For the tooltip', 'multisite-toolbar-additions'
			)
		)
	);

	$mstba_tb_items[ 'networkext_hidemywp_general' ] = array(
		'parent' => $networkext_hidemywp,
		'title'  => __( 'General Settings', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=hide_my_wp#general' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'General Settings', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'networkext_hidemywp_permalinks' ] = array(
		'parent' => $networkext_hidemywp,
		'title'  => __( 'Permalinks & URLs', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=hide_my_wp#permalink' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Permalinks & URLs', 'multisite-toolbar-additions' )
		)
	);

}  // end-if multisite check

	/** Otherwise, if plugin is only site activated, display stuff in a sub site admin */
else {

	$mstba_tb_items[ 'siteext_hidemywp' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Hide My WP', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=hide_my_wp#start' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Hide My WP - Security & Branding Settings',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

	$mstba_tb_items[ 'siteext_hidemywp_general' ] = array(
		'parent' => $siteext_hidemywp,
		'title'  => __( 'General Settings', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=hide_my_wp#general' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'General Settings', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'siteext_hidemywp_permalinks' ] = array(
		'parent' => $siteext_hidemywp,
		'title'  => __( 'Permalinks & URLs', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=hide_my_wp#permalink' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Permalinks & URLs', 'multisite-toolbar-additions' )
		)
	);

}  // end-if ! multisite check