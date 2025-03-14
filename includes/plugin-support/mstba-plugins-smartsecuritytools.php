<?php
/**
 * Display links to active plugins/extensions settings' pages: Smart Security Tools.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.5.1
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.5.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Smart Security Tools 1.0+ (premium, by Smart Plugins/ Milan Petrovic)
 *
 * @since 1.5.1
 *
 * @uses  is_multisite()
 * @uses  current_user_can()
 */
/** Multisite check */
if ( is_multisite() && current_user_can( 'manage_network' ) ) {

	/** List the network menu items */
	$mstba_tb_items[ 'networkext_smartsecuritytools' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Smart Network Security', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=smart-security-tools-front' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Smart Network Security Tools',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);


		if ( class_exists( 'ssect_lma_loader' ) ) {

			$mstba_tb_items[ 'networkext_smartsecuritytools_aolive' ] = array(
				'parent' => $networkext_smartsecuritytools,
				'title'  => __( 'Live Monitor', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'admin.php?page=smart-security-tools-addon-live' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Live Monitor', 'multisite-toolbar-additions' )
				)
			);

		}  // end if

		$mstba_tb_items[ 'networkext_smartsecuritytools_sucuri' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'Sucuri Scanner', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-sucuri' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Sucuri Scanner', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartsecuritytools_advisor' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'Security Advisor', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-advisor' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Security Advisor', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartsecuritytools_tweaks' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'General Tweaks', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-tweaks' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'General Tweaks', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartsecuritytools_htaccess' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( '.htaccess Tweaks', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-htaccess' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( '.htaccess Tweaks', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartsecuritytools_tools' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'Various Tools', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-tools' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Various Tools', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartsecuritytools_logs' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'View Logs', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-logs' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'View Logs', 'multisite-toolbar-additions' )
			)
		);

			$mstba_tb_items[ 'networkext_smartsecuritytools_log_analyzing' ] = array(
				'parent' => $networkext_smartsecuritytools_logs,
				'title'  => __( 'Log Analyzing', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'admin.php?page=smart-security-tools-analyze' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Log Analyzing', 'multisite-toolbar-additions' )
				)
			);

			$mstba_tb_items[ 'networkext_smartsecuritytools_banned_ips' ] = array(
				'parent' => $networkext_smartsecuritytools_logs,
				'title'  => __( 'Banned IPs', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'admin.php?page=smart-security-tools-banned-ips' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Banned IPs', 'multisite-toolbar-additions' )
				)
			);

		$mstba_tb_items[ 'networkext_smartsecuritytools_settings' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-settings' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Settings', 'multisite-toolbar-additions' )
			)
		);

			if ( class_exists( 'ssect_lma_loader' ) ) {

				$mstba_tb_items[ 'networkext_smartsecuritytools_settings_aolive' ] = array(
					'parent' => $networkext_smartsecuritytools_settings,
					'title'  => __( 'Live Monitor', 'multisite-toolbar-additions' ),
					'href'   => network_admin_url( 'admin.php?page=smart-security-tools-addon-live-monitor' ),
					'meta'   => array(
						'target' => '',
						'title'  => __( 'Live Monitor', 'multisite-toolbar-additions' )
					)
				);

			}  // end if

			if ( class_exists( 'ssect_lla_loader' ) ) {

				$mstba_tb_items[ 'networkext_smartsecuritytools_settings_aologinlimit' ] = array(
					'parent' => $networkext_smartsecuritytools_settings,
					'title'  => __( 'Login Limit', 'multisite-toolbar-additions' ),
					'href'   => network_admin_url( 'admin.php?page=smart-security-tools-addon-login-limit' ),
					'meta'   => array(
						'target' => '',
						'title'  => __( 'Login Limit', 'multisite-toolbar-additions' )
					)
				);

			}  // end if

		$mstba_tb_items[ 'networkext_smartsecuritytools_importexport' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-impexp' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartsecuritytools_addons' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'Add-Ons', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-addons' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Add-Ons', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartsecuritytools_about' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=smart-security-tools-about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_smartsecuritytools_support' ] = array(
			'parent' => $networkext_smartsecuritytools,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => 'http://forum.smartplugins.info/forums/forum/smart/smart-security-tools/',
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end if is_multisite() & cap check

/** Within Multisite but for sub site admin areas: */
if ( current_user_can( 'activate_plugins' ) ) {

	/** List the (site) menu items */
	$mstba_tb_items[ 'siteext_smartsecuritytools' ] = array(
		'parent' => $siteextgroup,
		'title'  => __( 'Smart Site Security', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=smart-security-tools-front' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Smart Site Security Tools',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		if ( class_exists( 'ssect_lma_loader' ) ) {

			$mstba_tb_items[ 'siteext_smartsecuritytools_aolive' ] = array(
				'parent' => $siteext_smartsecuritytools,
				'title'  => __( 'Live Monitor', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-addon-live' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Live Monitor', 'multisite-toolbar-additions' )
				)
			);

		}  // end if

		if ( smart_ssect_core()->settings[ 'blog_allow_sucuri' ] ) {

			$mstba_tb_items[ 'siteext_smartsecuritytools_sucuri' ] = array(
				'parent' => $siteext_smartsecuritytools,
				'title'  => __( 'Sucuri Scanner', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-sucuri' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Sucuri Scanner', 'multisite-toolbar-additions' )
				)
			);

		}  // end if

		if ( smart_ssect_core()->settings[ 'blog_allow_sucuri' ] ) {

			$mstba_tb_items[ 'siteext_smartsecuritytools_virustotal' ] = array(
				'parent' => $siteext_smartsecuritytools,
				'title'  => __( 'VirusTotal Scanner', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-virustotal' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'VirusTotal Scanner', 'multisite-toolbar-additions' )
				)
			);

		}  // end if

		if ( ! is_multisite() ) {

			$mstba_tb_items[ 'siteext_smartsecuritytools_advisor' ] = array(
				'parent' => $siteext_smartsecuritytools,
				'title'  => __( 'Security Advisor', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-advisor' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Security Advisor', 'multisite-toolbar-additions' )
				)
			);

			$mstba_tb_items[ 'siteext_smartsecuritytools_tweaks' ] = array(
				'parent' => $siteext_smartsecuritytools,
				'title'  => __( 'General Tweaks', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-tweaks' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'General Tweaks', 'multisite-toolbar-additions' )
				)
			);

			$mstba_tb_items[ 'siteext_smartsecuritytools_htaccess' ] = array(
				'parent' => $siteext_smartsecuritytools,
				'title'  => __( '.htaccess Tweaks', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-htaccess' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( '.htaccess Tweaks', 'multisite-toolbar-additions' )
				)
			);

			$mstba_tb_items[ 'siteext_smartsecuritytools_tools' ] = array(
				'parent' => $siteext_smartsecuritytools,
				'title'  => __( 'Various Tools', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-tools' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Various Tools', 'multisite-toolbar-additions' )
				)
			);

		}  // end if

		$mstba_tb_items[ 'siteext_smartsecuritytools_logs' ] = array(
			'parent' => $siteext_smartsecuritytools,
			'title'  => __( 'View Logs', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-security-tools-logs' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'View Logs', 'multisite-toolbar-additions' )
			)
		);

			$mstba_tb_items[ 'siteext_smartsecuritytools_log_analyzing' ] = array(
				'parent' => $siteext_smartsecuritytools_logs,
				'title'  => __( 'Log Analyzing', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-analyze' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Log Analyzing', 'multisite-toolbar-additions' )
				)
			);

			$mstba_tb_items[ 'siteext_smartsecuritytools_banned_ips' ] = array(
				'parent' => $siteext_smartsecuritytools_logs,
				'title'  => __( 'Banned IPs', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-banned-ips' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Banned IPs', 'multisite-toolbar-additions' )
				)
			);

		$mstba_tb_items[ 'siteext_smartsecuritytools_settings' ] = array(
			'parent' => $siteext_smartsecuritytools,
			'title'  => __( 'Settings', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-security-tools-settings' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Settings', 'multisite-toolbar-additions' )
			)
		);

			if ( class_exists( 'ssect_lma_loader' ) ) {

				$mstba_tb_items[ 'siteext_smartsecuritytools_settings_aolive' ] = array(
					'parent' => $siteext_smartsecuritytools,
					'title'  => __( 'Live Monitor', 'multisite-toolbar-additions' ),
					'href'   => admin_url( 'admin.php?page=smart-security-tools-addon-live-monitor' ),
					'meta'   => array(
						'target' => '',
						'title'  => __( 'Live Monitor', 'multisite-toolbar-additions' )
					)
				);
			}

			if ( class_exists( 'ssect_lla_loader' ) ) {

				$mstba_tb_items[ 'siteext_smartsecuritytools_settings_aologinlimit' ] = array(
					'parent' => $siteext_smartsecuritytools,
					'title'  => __( 'Login Limit', 'multisite-toolbar-additions' ),
					'href'   => admin_url( 'admin.php?page=smart-security-tools-addon-login-limit' ),
					'meta'   => array(
						'target' => '',
						'title'  => __( 'Login Limit', 'multisite-toolbar-additions' )
					)
				);
			}

		if ( ! is_multisite() ) {

			$mstba_tb_items[ 'siteext_smartsecuritytools_importexport' ] = array(
				'parent' => $siteext_smartsecuritytools,
				'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-impexp' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Import/ Export', 'multisite-toolbar-additions' )
				)
			);

			$mstba_tb_items[ 'siteext_smartsecuritytools_addons' ] = array(
				'parent' => $siteext_smartsecuritytools,
				'title'  => __( 'Add-Ons', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=smart-security-tools-addons' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Add-Ons', 'multisite-toolbar-additions' )
				)
			);

		}  // end if

		$mstba_tb_items[ 'siteext_smartsecuritytools_about' ] = array(
			'parent' => $siteext_smartsecuritytools,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=smart-security-tools-about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smartsecuritytools_support' ] = array(
			'parent' => $siteext_smartsecuritytools,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => 'http://forum.smartplugins.info/forums/forum/smart/smart-security-tools/',
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);

}  // end if cap check