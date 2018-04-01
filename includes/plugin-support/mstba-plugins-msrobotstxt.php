<?php
/**
 * Display links to active plugins/extensions settings' pages: Multisite Robots.txt Manager.
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
 * Multisite Robots.txt Manager (free, by tribalNerd)
 *
 * @since 1.4.0
 *
 * @param $mstba_msrtm_settings_slug
 * @param $mstba_msrtm_tab_slug
 * @param $mstba_msrtm_site_slug
 */
if ( class_exists( 'msrtm_robots_txt' ) ) {

	$mstba_msrtm_settings_slug = 'msrtm-network.php';
	$mstba_msrtm_tab_slug      = '';
	$mstba_msrtm_site_slug     = 'msrtm-website.php';

} elseif ( class_exists( 'display_robots' ) ) {

	$mstba_msrtm_settings_slug = 'ms_robotstxt.php';
	$mstba_msrtm_tab_slug      = 'robotstxt_';
	$mstba_msrtm_site_slug     = 'ms_robotstxt.php';

}

	/**
	 * List the Network aware menu items.
	 *
	 * @since 1.4.0
	 */
	$mstba_tb_items[ 'networkext_msrobotstxt' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Multisite Robots.txt Manager', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?tab=' . $mstba_msrtm_tab_slug . 'settings&page=' .$mstba_msrtm_settings_slug . '' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Multisite Robots.txt Manager',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'networkext_msrobotstxt_presets' ] = array(
			'parent' => $networkext_msrobotstxt,
			'title'  => __( 'Presets/ Examples', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?tab=' . $mstba_msrtm_tab_slug . 'presets&page=' .$mstba_msrtm_settings_slug . '' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Presets/ Examples', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_msrobotstxt_help' ] = array(
			'parent' => $networkext_msrobotstxt,
			'title'  => __( 'Help/ How to Use', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?tab=' . $mstba_msrtm_tab_slug . 'help&page=' .$mstba_msrtm_settings_slug . '' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Help/ How to Use', 'multisite-toolbar-additions' )
			)
		);

	/**
	 * List the Site aware menu items.
	 *
	 * @since 1.4.0
	 */
	$mstba_tb_items[ 'siteext_msrobotstxt' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Site Robots.txt Manager', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?tab=' . $mstba_msrtm_tab_slug . 'settings&page=' . $mstba_msrtm_site_slug . '' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Multisite Robots.txt Manager',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'siteext_msrobotstxt_presets' ] = array(
			'parent' => $siteext_msrobotstxt,
			'title'  => __( 'Presets/ Examples', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?tab=' . $mstba_msrtm_tab_slug . 'presets&page=' . $mstba_msrtm_site_slug . '' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Presets/ Examples', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_msrobotstxt_help' ] = array(
			'parent' => $siteext_msrobotstxt,
			'title'  => __( 'Help/ How to Use', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?tab=' . $mstba_msrtm_tab_slug . 'help&page=' . $mstba_msrtm_site_slug . '' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Help/ How to Use', 'multisite-toolbar-additions' )
			)
		);