<?php
/**
 * Display links to active plugins/extensions settings' pages: Smart Admin Tweaks.
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
 * Smart Admin Tweaks (premium, by Smart Plugins/ Milan Petrovic)
 *
 * @since 1.3.0
 *
 * @uses  is_multisite()
 * @uses  current_user_can()
 */
/** Multisite check */
if ( is_multisite() && current_user_can( 'manage_network' ) ) {

	/** List the network menu items */
	$mstba_tb_items[ 'networkext_smartadmintweaks' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Smart Network Tweaks', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'settings.php?page=smart-admin-tweaks' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Smart Network Admin Tweaks',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'networkext_smartadmintweaks_updates' ] = array(
			'parent' => $networkext_smartadmintweaks,
			'title'  => __( 'Updates Control', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=smart-admin-tweaks&tab=updates' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Updates Control', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartadmintweaks_global' ] = array(
			'parent' => $networkext_smartadmintweaks,
			'title'  => __( 'Global Settings', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=smart-admin-tweaks&tab=global' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Global Settings', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartadmintweaks_networkadmin' ] = array(
			'parent' => $networkext_smartadmintweaks,
			'title'  => __( 'Network Admin', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=smart-admin-tweaks&tab=network' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Network Admin', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartadmintweaks_importexport' ] = array(
			'parent' => $networkext_smartadmintweaks,
			'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=smart-admin-tweaks&tab=impexp' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartadmintweaks_about' ] = array(
			'parent' => $networkext_smartadmintweaks,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'settings.php?page=smart-admin-tweaks&tab=about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartadmintweaks_support' ] = array(
			'parent' => $networkext_smartadmintweaks,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => 'http://forum.smartplugins.info/forums/forum/smart/smart-admin-tweaks/',
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end-if is_multisite() & cap check

if ( current_user_can( 'activate_plugins' ) ) {

	/** List the (site) menu items */
	$mstba_tb_items[ 'siteext_smartadmintweaks' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Smart Admin Tweaks', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Smart Site Admin Tweaks',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		/** Only include for non-Multisite installs */
		if ( ! is_multisite() ) {

			$mstba_tb_items[ 'siteext_smartadmintweaks_updates' ] = array(
				'parent' => $siteext_smartadmintweaks,
				'title'  => __( 'Updates Control', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=updates' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Updates Control', 'multisite-toolbar-additions' )
				)
			);

			$mstba_tb_items[ 'siteext_smartadmintweaks_global' ] = array(
				'parent' => $siteext_smartadmintweaks,
				'title'  => __( 'Global Tweaks', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=global' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Global Tweaks', 'multisite-toolbar-additions' )
				)
			);

		}  // end if is_multisite() check

		$mstba_tb_items[ 'siteext_smartadmintweaks_site' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'General Tweaks', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=tweaks' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'General Tweaks', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartadmintweaks_adminbar' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'Toolbar', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=adminbar' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Toolbar', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartadmintweaks_admin' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'Site Admin', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=admin' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Site Admin', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartadmintweaks_rewriter' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'Rewriter', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=rewriter' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Rewriter', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartadmintweaks_media' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'Media', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=media' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Media', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartadmintweaks_posts' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'Posts', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=posts' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Posts', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartadmintweaks_header' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'Header', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=header' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Header', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartadmintweaks_importexport' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=impexp' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartadmintweaks_about' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-admin-tweaks&tab=about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartadmintweaks_support' ] = array(
			'parent' => $siteext_smartadmintweaks,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => 'http://forum.smartplugins.info/forums/forum/smart/smart-admin-tweaks/',
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end-if cap check