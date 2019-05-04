<?php
/**
 * "Plugins" items only for non-Multisite installs!
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Site: Plugins
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
 * "Plugins" items only for non-Multisite installs!
 *
 * @since 1.4.0
 */
	$mstba_tb_items[ 'siteplugins' ] = array(
		'parent' => $sitegroup,
		'title'  => _x( 'Plugins', 'Translators: Site plugins', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'plugins.php' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x( 'Plugins', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
		)
	);

		if ( current_user_can( 'update_plugins' ) ) {

			$mstba_tb_items[ 'siteplugins-updateable' ] = array(
				'parent' => $siteplugins,
				'title'  => __( 'Updateable', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'plugins.php?plugin_status=upgrade' ),
				'meta'   => array(
					'target' => '',
					'title'  => _x( 'Updateable Only', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
				)
			);

		}

		$mstba_tb_items[ 'siteplugins-active' ] = array(
			'parent' => $siteplugins,
			'title'  => __( 'Active', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'plugins.php?plugin_status=active' ),
			'meta'   => array(
				'target' => '',
				'title'  => _x( 'Active Only', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteplugins-recently' ] = array(
			'parent' => $siteplugins,
			'title'  => __( 'Recently Activated', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'plugins.php?plugin_status=recently_activated' ),
			'meta'   => array(
				'target' => '',
				'title'  => _x( 'Recently Activated Only', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteplugins-inactive' ] = array(
			'parent' => $siteplugins,
			'title'  => __( 'Inactive', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'plugins.php?plugin_status=inactive' ),
			'meta'   => array(
				'target' => '',
				'title'  => _x( 'Inactive Only', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteplugins-all' ] = array(
			'parent' => $siteplugins,
			'title'  => __( 'All Installed', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'plugins.php?plugin_status=all' ),
			'meta'   => array(
				'target' => '',
				'title'  => _x( 'All Installed - Active and Inactive', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
			)
		);

		/** MU Plugins (Must Use) and DropIns */
		if ( ! is_multisite() || ( is_network_admin() && current_user_can( 'manage_network_plugins' ) ) ) {

			if ( apply_filters( 'show_advanced_plugins', true, 'mustuse' ) ) {

				$mstba_tb_items[ 'siteplugins-mustuse' ] = array(
					'parent' => $siteplugins,
					'title'  => __( 'Must Use (MU)', 'multisite-toolbar-additions' ),
					'href'   => network_admin_url( 'plugins.php?plugin_status=mustuse' ),
					'meta'   => array(
						'target' => '',
						'title'  => _x( 'Must Use - MU Plugins', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
					)
				);

			}

			if ( apply_filters( 'show_advanced_plugins', true, 'dropins' ) ) {

				$mstba_tb_items[ 'siteplugins-dropins' ] = array(
					'parent' => $siteplugins,
					'title'  => __( 'Drop-ins', 'multisite-toolbar-additions' ),
					'href'   => network_admin_url( 'plugins.php?plugin_status=dropins' ),
					'meta'   => array(
						'target' => '',
						'title'  => _x( 'Drop-ins - Special Plugins', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
					)
				);

			}

		}  // end if
