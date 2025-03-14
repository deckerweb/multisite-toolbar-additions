<?php
/**
 * Display links to active plugins/extensions settings' pages: Smart CRON Tools.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.4.1
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
 * Smart CRON Tools (premium, by Smart Plugins/ Milan Petrovic)
 *
 * @since 1.4.1
 *
 * @uses  is_multisite()
 * @uses  current_user_can()
 */
/** Multisite check */
if ( is_multisite() && current_user_can( 'manage_network' ) ) {

	/** List the network menu items */
	$mstba_tb_items[ 'networkext_smartcrontools' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Smart CRON Tools', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=smart-cron-tools' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Smart CRON Tools - List of Jobs',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'networkext_smartcrontools_schedules' ] = array(
			'parent' => $networkext_smartcrontools,
			'title'  => __( 'Schedules', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=smart-cron-tools&tab=schedules' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Schedules', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcrontools_about' ] = array(
			'parent' => $networkext_smartcrontools,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=smart-cron-tools&tab=about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcrontools_support' ] = array(
			'parent' => $networkext_smartcrontools,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => esc_url( 'http://forum.smartplugins.info/forums/forum/smart/smart-cron-tools/' ),
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end if is_multisite() & cap check

if ( current_user_can( 'activate_plugins' ) ) {

	/** List the (site) menu items */
	$mstba_tb_items[ 'siteext_smartcrontools' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Smart CRON Tools', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=smart-cron-tools&tab=jobs' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Smart CRON Tools - List of Jobs',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'siteext_smartcrontools_schedules' ] = array(
			'parent' => $siteext_smartcrontools,
			'title'  => __( 'Schedules', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-cron-tools&tab=schedules' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Schedules', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcrontools_about' ] = array(
			'parent' => $siteext_smartcrontools,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-cron-tools&tab=about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcrontools_support' ] = array(
			'parent' => $siteext_smartcrontools,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => esc_url( 'http://forum.smartplugins.info/forums/forum/smart/smart-cron-tools/' ),
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end if cap check