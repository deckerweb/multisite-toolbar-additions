<?php
/**
 * Display links to active plugins/extensions settings' pages: Smart Cleanup Tools.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.3.0
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
 * Smart Cleanup Tools 4.0+ (premium, by Smart Plugins/ Milan Petrovic)
 *
 * @since 1.3.0
 *
 * @uses  is_multisite()
 * @uses  current_user_can()
 */
/** Multisite check */
if ( is_multisite() && current_user_can( 'manage_network' ) ) {

	/** List the network menu items */
	$mstba_tb_items[ 'networkext_smartcleanuptools' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Smart Network Cleanup', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=smart-cleanup-tools-front' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Smart Network Cleanup Tools',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'networkext_smartcleanuptools_cleanup' ] = array(
			'parent' => $networkext_smartcleanuptools,
			'title'  => __( 'Cleanup Tools', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-cleanup-tools-cleanup' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Cleanup Tools', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcleanuptools_reset' ] = array(
			'parent' => $networkext_smartcleanuptools,
			'title'  => __( 'Reset Tools', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-cleanup-tools-reset' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Reset Tools', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcleanuptools_scheduler' ] = array(
			'parent' => $networkext_smartcleanuptools,
			'title'  => __( 'Scheduler', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-cleanup-tools-scheduler' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Scheduler', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcleanuptools_statistics' ] = array(
			'parent' => $networkext_smartcleanuptools,
			'title'  => __( 'Statistics', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-cleanup-tools-statistics' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Statistics', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcleanuptools_logs' ] = array(
			'parent' => $networkext_smartcleanuptools,
			'title'  => __( 'View Logs', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-cleanup-tools-logs' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'View Logs', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcleanuptools_settings' ] = array(
			'parent' => $networkext_smartcleanuptools,
			'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-cleanup-tools-settings' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Settings', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcleanuptools_importexport' ] = array(
			'parent' => $networkext_smartcleanuptools,
			'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-cleanup-tools-impexp' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcleanuptools_about' ] = array(
			'parent' => $networkext_smartcleanuptools,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-cleanup-tools-about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartcleanuptools_support' ] = array(
			'parent' => $networkext_smartcleanuptools,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => 'http://forum.smartplugins.info/forums/forum/smart/smart-cleanup-tools/',
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end-if is_multisite() & cap check

if ( current_user_can( 'activate_plugins' ) ) {

	/** List the (site) menu items */
	$mstba_tb_items[ 'siteext_smartcleanuptools' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Smart Site Cleanup', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-front' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Smart Site Cleanup Tools',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'siteext_smartcleanuptools_cleanup' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'Cleanup Tools', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-cleanup' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Cleanup Tools', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcleanuptools_reset' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'Reset Tools', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-reset' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Reset Tools', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcleanuptools_removal' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'Removal Tools', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-removal' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Removal Tools', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcleanuptools_scheduler' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'Scheduler', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-scheduler' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Scheduler', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcleanuptools_statistics' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'Statistics', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-statistics' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Statistics', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcleanuptools_logs' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'View Logs', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-logs' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'View Logs', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcleanuptools_settings' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-settings' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Settings', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcleanuptools_importexport' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-impexp' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcleanuptools_about' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-cleanup-tools-about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartcleanuptools_support' ] = array(
			'parent' => $siteext_smartcleanuptools,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => 'http://forum.smartplugins.info/forums/forum/smart/smart-cleanup-tools/',
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end-if cap check