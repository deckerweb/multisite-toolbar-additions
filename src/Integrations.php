<?php
/**
 * Multisite Toolbar Additions.
 * Copyright (c) 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Compact registry: loaded only for eligible users when integrations are enabled. */
final class Integrations {
	public function render( $bar ) {
		$site = $bar->get_node( 'site-name' ) ? 'site-name' : false;
		$network = $bar->get_node( 'network-admin' ) ? 'network-admin' : false;
		$links = [];
		if ( class_exists( 'Code_Snippets' ) || function_exists( 'Code_Snippets\\code_snippets' ) ) {
			$links[] = [ 'codesnippets', __( 'Code Snippets', 'multisite-toolbar-additions' ), 'admin.php?page=snippets', 'manage_snippets', false ];
			$links[] = [ 'network-codesnippets', __( 'Network Code Snippets', 'multisite-toolbar-additions' ), 'admin.php?page=snippets', 'manage_network_snippets', true ];
			$links[] = [ 'snippet-add', __( 'Add Snippet', 'multisite-toolbar-additions' ), 'admin.php?page=snippet', 'install_snippets', false ];
			$links[] = [ 'network-snippet-add', __( 'Add Network Snippet', 'multisite-toolbar-additions' ), 'admin.php?page=snippet', 'install_network_snippets', true ];
		}
		if ( function_exists( '_relevanssi_install' ) || defined( 'RELEVANSSI_VERSION' ) ) {
			$premium = defined( 'RELEVANSSI_PREMIUM' ) && RELEVANSSI_PREMIUM;
			$path = $premium ? 'relevanssi-premium/relevanssi.php' : 'relevanssi/relevanssi.php';
			$links[] = [ 'relevanssi', 'Relevanssi', 'options-general.php?page=' . $path, 'manage_options', false ];
			if ( 'on' === get_option( 'relevanssi_log_queries' ) ) { $links[] = [ 'relevanssi-searches', __( 'User Searches', 'multisite-toolbar-additions' ), 'index.php?page=' . $path, 'manage_options', false ]; }
		}
		if ( class_exists( 'WP_Stream' ) || class_exists( 'WP_Stream\\Plugin' ) ) {
			$links[] = [ 'stream', __( 'Activity Streams', 'multisite-toolbar-additions' ), 'admin.php?page=wp_stream', 'view_stream', false ];
			$links[] = [ 'stream-settings', __( 'Stream Settings', 'multisite-toolbar-additions' ), 'admin.php?page=wp_stream_settings', 'manage_options', false ];
		}
		if ( class_exists( 'WP_Migrate_DB' ) || function_exists( 'wp_migrate_db_pro_init' ) ) {
			$links[] = [ 'migrate', __( 'Migrate Database', 'multisite-toolbar-additions' ), 'tools.php?page=' . ( function_exists( 'wp_migrate_db_pro_init' ) ? 'wp-migrate-db-pro' : 'wp-migrate-db' ), 'manage_options', false ];
			if ( function_exists( 'wp_migrate_db_pro_init' ) ) { $links[] = [ 'network-migrate', __( 'Migrate Database', 'multisite-toolbar-additions' ), 'settings.php?page=wp-migrate-db-pro', 'manage_network_options', true ]; }
		}
		if ( defined( 'MSLS_PLUGIN_VERSION' ) || defined( 'MSLS_VERSION' ) ) { $links[] = [ 'msls', 'Multisite Language Switcher', 'options-general.php?page=MslsAdmin', 'manage_options', false ]; }
		if ( function_exists( 'wlcms_check_for_login' ) ) { $links[] = [ 'white-label', 'White Label CMS', 'options-general.php?page=wlcms-plugin.php', 'manage_options', false ]; }
		if ( class_exists( 'wp_piwik' ) ) {
			$links[] = [ 'piwik', 'WP-Piwik', 'index.php?page=wp-piwik_stats', 'wp-piwik_read_stats', false ];
			$links[] = [ 'network-piwik', 'WP-Piwik', 'settings.php?page=wp-piwik/wp-piwik.php&tab=piwik', 'manage_network_options', true ];
		}
		if ( class_exists( '\Fragen\Git_Updater\Plugin' ) ) {
			$network_mode = is_multisite();
			$path = ( $network_mode ? 'settings.php' : 'options-general.php' ) . '?page=git-updater';
			$links[] = [ 'gitupdater', 'Git Updater', $path, $network_mode ? 'manage_network_options' : 'manage_options', $network_mode ];
			$links[] = [ 'gitupdater-plugin', __( 'Install via Git Updater', 'multisite-toolbar-additions' ), $path . '&tab=git_updater_install_plugin', 'install_plugins', $network_mode ];
			$links[] = [ 'gitupdater-theme', __( 'Install Theme via Git Updater', 'multisite-toolbar-additions' ), $path . '&tab=git_updater_install_theme', 'install_themes', $network_mode ];
		}
		if ( defined( 'DPDEVKIT_URL' ) ) { $links[] = [ 'devkit', 'DevKit Pro', 'admin.php?page=devkit', 'install_plugins', false ]; }
		if ( class_exists( 'TablePress' ) ) { $links[] = [ 'tablepress', 'TablePress', 'admin.php?page=tablepress', 'tablepress_edit_tables', false ]; }
		// Retain opt-in-by-detection destinations for existing installations of older plugins.
		if ( function_exists( 'dm_text_domain' ) ) { $links[] = [ 'domain-mapping', 'Domain Mapping', 'settings.php?page=dm_domains_admin', 'manage_network_options', true ]; }
		if ( class_exists( 'msrtm_robots_txt' ) || class_exists( 'display_robots' ) ) {
			$modern = class_exists( 'msrtm_robots_txt' );
			$links[] = [ 'robots', 'Multisite Robots.txt', 'settings.php?page=' . ( $modern ? 'msrtm-network.php&tab=settings' : 'ms_robotstxt.php&tab=robotstxt_settings' ), 'manage_network_options', true ];
			$links[] = [ 'site-robots', 'Multisite Robots.txt', 'options-general.php?page=' . ( $modern ? 'msrtm-website.php&tab=settings' : 'ms_robotstxt.php&tab=robotstxt_settings' ), 'manage_options', false ];
		}
		if ( defined( 'MCMVC_REQUIRED_WP_VERSION' ) ) { $links[] = [ 'reports', 'Network Reports', 'admin.php?page=wpms_admin_reports', 'manage_network', false ]; }
		if ( defined( 'SS_SETTINGS_FIELD' ) && 'genesis' === basename( get_template_directory() ) ) { $links[] = [ 'sidebars', 'Genesis Simple Sidebars', 'admin.php?page=simple-sidebars', 'edit_theme_options', false ]; }
		if ( defined( 'GW_GO_SBWIZARD_VER' ) ) { $links[] = [ 'sidebar-wizard', 'Go Sidebar Wizard', 'admin.php?page=go-sbwizard', 'edit_pages', false ]; }
		if ( class_exists( 'Widget_Data' ) ) {
			$links[] = [ 'widget-export', __( 'Export Widgets', 'multisite-toolbar-additions' ), 'tools.php?page=widget-settings-export', 'edit_theme_options', false ];
			$links[] = [ 'widget-import', __( 'Import Widgets', 'multisite-toolbar-additions' ), 'tools.php?page=widget-settings-import', 'edit_theme_options', false ];
		}
		if ( class_exists( 'RestrictWidgets' ) ) { $links[] = [ 'restrict-widgets', 'Restrict Widgets', 'widgets.php#widgets-options', 'manage_widgets', false ]; }
		$links = apply_filters( 'mstba_integration_links', $links );
		foreach ( $links as [ $id, $label, $path, $cap, $is_network ] ) {
			$parent = $is_network ? $network : $site;
			if ( ! $parent || ! current_user_can( $cap ) ) { continue; }
			$group = $is_network ? 'ddw-mstba-networkextgroup' : 'ddw-mstba-siteextgroup';
			$constant = $is_network ? 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP' : 'MSTBA_DISPLAY_SITE_EXTEND_GROUP';
			if ( defined( $constant ) && ! constant( $constant ) ) { continue; }
			if ( ! $bar->get_node( $group ) ) { $bar->add_group( [ 'id' => $group, 'parent' => $parent ] ); }
			$bar->add_node( [ 'id' => 'ddw-mstba-' . sanitize_key( $id ), 'parent' => $group, 'title' => esc_html( $label ), 'href' => esc_url( $is_network ? network_admin_url( $path ) : admin_url( $path ) ) ] );
		}
		if ( $site && ( ! defined( 'MSTBA_DISPLAY_SITE_EXTEND_GROUP' ) || MSTBA_DISPLAY_SITE_EXTEND_GROUP ) ) {
			$bar->add_group( [ 'id' => 'ddw-mstba-siteextgroup', 'parent' => $site ] );
			do_action( 'mstba_custom_site_items', $bar );
		}
		if ( $network && ( ! defined( 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP' ) || MSTBA_DISPLAY_NETWORK_EXTEND_GROUP ) ) { $bar->add_group( [ 'id' => 'ddw-mstba-networkextgroup', 'parent' => $network ] ); do_action( 'mstba_custom_network_items', $bar ); }
		do_action( 'mstba_custom_plugin_items', $bar );
	}
}
