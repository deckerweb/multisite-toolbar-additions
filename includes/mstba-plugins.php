<?php
/**
 * Display links to active plugins/extensions settings' pages
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2025, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 *
 * @since      1.0.0
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
 * Helper variable.
 *
 * @since 1.1.0
 */
$mstba_multisite_check = is_multisite() ? _x( 'Site', 'Translators: For sitewide code snippets', 'multisite-toolbar-additions' ) . ' ' : '';


/**
 * Network Extend Group - hooking in network-aware plugin items
 *
 * @since 1.0.0
 */
	 
	/**
	 * WP-Piwik (free, by Andr&eacute; Br&auml;kling)
	 *
	 * @since 1.0.0
	 */
	if ( class_exists( 'wp_piwik' ) && current_user_can( 'wp-piwik_read_stats' ) ) {

		/** Include code part for WP-Piwik plugin support */
		require_once( MSTBA_PLUGIN_DIR . 'includes/plugin-support/mstba-plugins-wppiwik.php' );

	}  // end if WP-Piwik


	/**
	 * Code Snippets (free, by Shea Bunge)
	 * @since 1.1.0
	 */
	if ( class_exists( 'Code_Snippets' )
		&& ( current_user_can( 'manage_snippets' ) || current_user_can( 'manage_network_snippets' ) )
	) {

		/** Include code part for Code Snippets plugin support */
		require_once( MSTBA_PLUGIN_DIR . 'includes/plugin-support/mstba-plugins-codesnippets.php' );

	}  // end if Code Snippets


	/**
	 * WordPress MU Domain Mapping (free, by Donncha O Caoimh, Ron Rennick, Automatic Inc.)
	 * @since 1.4.0
	 */
	if ( is_multisite() && function_exists( 'dm_text_domain' ) && current_user_can( 'manage_options' ) ) {

		/** Include code part for WP MU Domain Mapping plugin support */
		require_once( MSTBA_PLUGIN_DIR . 'includes/plugin-support/mstba-plugins-wpmudomainmapping.php' );

	}  // end if Multisite Robots.txt Manager


	/**
	 * Multisite Robots.txt Manager (free, by tribalNerd)
	 * Note: Currently versions 0.4.x and former 0.3.x are supported.
	 * @since 1.4.0
	 */
	if ( is_multisite()
		&& ( class_exists( 'msrtm_robots_txt' ) || class_exists( 'display_robots' ) )
		&& current_user_can( 'manage_options' )
	) {
	
		/** Include code part for MS Robots.txt Manager plugin support */
		require_once( MSTBA_PLUGIN_DIR . 'includes/plugin-support/mstba-plugins-msrobotstxt.php' );
	
	}  // end if Multisite Robots.txt Manager
	
	
	/**
	 * WP Migrate DB Pro (premium, by Delicious Brains (Brad Touesnard & Chris Aprea))
	 * @since 1.4.0
	 */
	if ( function_exists( 'wp_migrate_db_pro_init' ) ) {

		/** Include code part for WP Migrate DB Pro support */
		require_once( MSTBA_PLUGIN_DIR . 'includes/plugin-support/mstba-plugins-wpmigratedbpro.php' );

	}  // end if WP Migrate DB Pro


/**
 * Site Extend Group - hooking in (site-specific, non network-aware) plugin items.
 *
 * @since 1.0.0
 */

	/**
	 * Stream (free, by X-Team)
	 * @since 1.7.0
	 */
	if ( class_exists( 'WP_Stream' )
		&& ( current_user_can( 'manage_options' ) || current_user_can( 'view_stream' ) )
	) {
	
		/** Include code part for Stream plugin support */
		require_once( MSTBA_PLUGIN_DIR . 'includes/plugin-support/mstba-plugins-stream.php' );
	
	}  // end if Stream
 
 
	/**
	 * Relevanssi & Relevanssi Premium (free & premium, by Mikko Saari, www.relevanssi.com)
	 * @since 1.1.0
	 */
	if ( function_exists( '_relevanssi_install' ) && current_user_can( 'manage_options' ) ) {

		$mstba_tb_items[ 'siteext_relevanssi' ] = array(
			'parent' => $siteextgroup,
			'title'  => RELEVANSSI_PREMIUM ? __( 'Relevanssi Premium', 'multisite-toolbar-additions' ) : __( 'Relevanssi', 'multisite-toolbar-additions' ),
			'href'   => RELEVANSSI_PREMIUM ? admin_url( 'options-general.php?page=relevanssi-premium/relevanssi.php' ) : admin_url( 'options-general.php?page=relevanssi/relevanssi.php' ),
		);

		/** Display menu item only if option is true */
		if ( 'on' == get_option( 'relevanssi_log_queries' ) ) {

			$mstba_tb_items[ 'siteext_relevanssi_searches' ] = array(
				'parent' => $siteext_relevanssi,
				'title'  => __( 'User Searches', 'multisite-toolbar-additions' ),
				'href'   => RELEVANSSI_PREMIUM ? admin_url( 'index.php?page=relevanssi-premium/relevanssi.php' ) : admin_url( 'index.php?page=relevanssi/relevanssi.php' ),
			);

		}  // end if relevanssi option check

	}  // end if Relevanssi


	/**
	 * Multisite Language Switcher (free, by Dennis Ploetner)
	 * @since 1.0.0
	 */
	if ( defined( 'MSLS_PLUGIN_VERSION' ) && current_user_can( 'manage_options' ) ) {

		$mstba_tb_items[ 'siteext_mslangswitcher' ] = array(
			'parent' => $siteextgroup,
			'title'  => __( 'Multisite Language Switcher', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=MslsAdmin' ),
		);

	}  // end if Multisite Language Switcher


	/**
	 * White Label CMS (free, by www.videousermanuals.com)
	 * @since 1.1.0
	 */
	if ( function_exists( 'wlcms_check_for_login' ) && current_user_can( 'manage_options' ) ) {

		$mstba_tb_items[ 'siteext_whitelabelcms' ] = array(
			'parent' => $siteextgroup,
			'title'  => __( 'White Label CMS', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=wlcms-plugin.php' ),
		);

	}  // end if White Label CMS


	/**
	 * WordPress Multisite Admin Reports (free, by Joe Motacek)
	 * @since 1.7.0
	 */
	if ( is_multisite()
		&& defined( 'MCMVC_REQUIRED_WP_VERSION' )
		&& current_user_can( 'manage_network' )
	) {
	
		/** Include code part for WPMS Admin Reports plugin support */
		require_once( MSTBA_PLUGIN_DIR . 'includes/plugin-support/mstba-plugins-wpmsadminreports.php' );
	
	}  // end if WPMS Admin Reports
	
	
	/**
	 * WP Migrate DB (free, by Brad Touesnard)
	 * @since 1.4.0
	 */
	if ( class_exists( 'WP_Migrate_DB' ) && current_user_can( 'update_core' ) ) {

		$mstba_tb_items[ 'siteext_wpmigratedb' ] = array(
			'parent' => $siteextgroup,
			'title'  => __( 'Migrate Database', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'tools.php?page=wp-migrate-db' ),
		);

	}  // end if WP Migrate DB