<?php
/**
 * Multisite Toolbar Additions.
 * Copyright (c) 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Build only permitted destinations; leave Core's existing nodes intact. */
final class Shortcuts {
	private $settings;
	public function __construct( Settings $settings ) { $this->settings = $settings; }
	public function register() {
		add_action( 'admin_bar_menu', [ $this, 'render' ], 100 );
		add_action( 'wp_before_admin_bar_render', [ $this, 'new_last' ], PHP_INT_MAX );
	}
	public function new_last() {
		global $wp_admin_bar;
		if ( ! $wp_admin_bar ) { return; }
		foreach ( [ 'ddw-mstba-addnew_plugin', 'ddw-mstba-addnew_theme' ] as $id ) {
			$node = $wp_admin_bar->get_node( $id );
			if ( $node ) { $wp_admin_bar->remove_node( $id ); $wp_admin_bar->add_node( (array) $node ); }
		}
	}
	private function link( $bar, $id, $parent, $title, $url, $cap = 'manage_options', $external = false ) {
		if ( ! current_user_can( $cap ) || ( $parent && ! $bar->get_node( $parent ) ) ) { return; }
		$bar->add_node( [ 'id' => 'ddw-mstba-' . $id, 'parent' => $parent, 'title' => esc_html( $title ), 'href' => esc_url( $url ), 'meta' => $external ? [ 'target' => '_blank', 'rel' => 'noopener noreferrer' ] : [] ] );
	}
	public function render( $bar ) {
		if ( ! is_user_logged_in() || ! is_admin_bar_showing() || ( is_multisite() ? ! is_super_admin() : ! current_user_can( 'manage_options' ) ) ) { return; }
		if ( is_multisite() && $this->settings->get( 'network_links' ) ) { $this->network( $bar ); }
		if ( $this->settings->get( 'site_links' ) ) { $this->site( $bar ); }
		if ( is_multisite() && $this->settings->get( 'subsite_links' ) ) { $this->subsites( $bar ); }
		if ( $this->settings->get( 'integrations' ) ) { ( new Integrations() )->render( $bar ); }
		$this->new_items( $bar );
		if ( $this->settings->get( 'resources' ) ) { $this->resources( $bar ); }
	}
	private function network( $bar ) {
		if ( ! $bar->get_node( 'network-admin' ) ) { return; }
		foreach ( [
			[ 'network-settings', 'network-admin-d', __( 'Network Settings', 'multisite-toolbar-additions' ), 'settings.php', 'manage_network_options' ],
			[ 'network-updatecheck', 'network-admin-d', __( 'Check for Updates', 'multisite-toolbar-additions' ), 'update-core.php', 'update_core' ],
			[ 'network-updatesites', 'network-admin-d', __( 'Upgrade Network', 'multisite-toolbar-additions' ), 'upgrade.php', 'upgrade_network' ],
			[ 'network_addsite', 'network-admin-s', __( 'Add Site', 'multisite-toolbar-additions' ), 'site-new.php', 'create_sites' ],
			[ 'network-adduser', 'network-admin-u', __( 'Add User', 'multisite-toolbar-additions' ), 'user-new.php', 'create_users' ],
			[ 'network-superadmins', 'network-admin-u', __( 'Super Admins', 'multisite-toolbar-additions' ), 'users.php?role=super', 'manage_network_users' ],
			[ 'networkplugins', 'network-admin', __( 'Network Plugins', 'multisite-toolbar-additions' ), 'plugins.php', 'manage_network_plugins' ],
			[ 'networkthemes', 'network-admin', __( 'Network Themes', 'multisite-toolbar-additions' ), 'themes.php', 'manage_network_themes' ],
		] as [ $id, $parent, $label, $path, $cap ] ) { $this->link( $bar, $id, $parent, $label, network_admin_url( $path ), $cap ); }
		$this->installers( $bar, 'ddw-mstba-networkplugins', 'ddw-mstba-networkthemes', 'network-' );
		if ( is_network_admin() && (bool) apply_filters( 'mstba_filter_display_network_new_content', true ) ) {
			if ( ! $bar->get_node( 'new-content' ) ) {
				$bar->add_node( [ 'id' => 'new-content', 'title' => '<span class="ab-icon" aria-hidden="true"></span><span class="ab-label">' . esc_html__( 'New (Network)', 'multisite-toolbar-additions' ) . '</span>', 'href' => network_admin_url( 'site-new.php' ) ] );
			}
			$this->link( $bar, 'new-site', 'new-content', __( 'Website', 'multisite-toolbar-additions' ), network_admin_url( 'site-new.php' ), 'create_sites' );
			$this->link( $bar, 'new-user', 'new-content', __( 'User (Network)', 'multisite-toolbar-additions' ), network_admin_url( 'user-new.php' ), 'create_users' );
		}
		if ( $bar->get_node( 'site-name' ) ) {
			$this->link( $bar, 'main-site-dashboard', 'site-name', __( 'Dashboard', 'multisite-toolbar-additions' ), admin_url(), 'read' );
		}
		$this->link( $bar, 'settings', 'network-admin', __( 'Toolbar Settings', 'multisite-toolbar-additions' ), Admin::url(), Settings::capability() );
	}
	private function installers( $bar, $plugins, $themes, $prefix = '' ) {
		foreach ( [ [ $plugins, 'plugin', 'install_plugins' ], [ $themes, 'theme', 'install_themes' ] ] as [ $parent, $type, $cap ] ) {
			$this->link( $bar, $prefix . $type . '-search', $parent, __( 'Search Directory', 'multisite-toolbar-additions' ), network_admin_url( $type . '-install.php' ), $cap );
			$this->link( $bar, $prefix . $type . '-upload', $parent, __( 'Upload ZIP', 'multisite-toolbar-additions' ), Admin::upload_url( $type ), $cap );
			$this->link( $bar, $prefix . $type . '-favorites', $parent, __( 'Favorites', 'multisite-toolbar-additions' ), network_admin_url( $type . '-install.php?' . ( 'theme' === $type ? 'browse' : 'tab' ) . '=favorites' ), $cap );
		}
	}
	private function site( $bar ) {
		if ( ! $bar->get_node( 'site-name' ) ) { return; }
		$root = 'ddw-mstba-sitegroup';
		$bar->add_group( [ 'id' => $root, 'parent' => 'site-name' ] );
		$this->link( $bar, 'mcbase', $root, __( 'Manage Content', 'multisite-toolbar-additions' ), admin_url( 'edit.php' ), 'edit_posts' );
		// Sites can register arbitrary content types; respect each type's capability and UI visibility.
		foreach ( get_post_types( [ 'show_ui' => true ], 'objects' ) as $type ) {
			if ( in_array( $type->name, [ 'attachment', 'wp_navigation', 'wp_block', 'wp_template', 'wp_template_part', 'wp_global_styles', 'nav_menu_item' ], true ) ) { continue; }
			$parent = $bar->get_node( 'ddw-mstba-mcbase' ) ? 'ddw-mstba-mcbase' : $root;
			$this->link( $bar, 'edit-' . $type->name, $parent, $type->labels->name, add_query_arg( 'post_type', $type->name, admin_url( 'edit.php' ) ), $type->cap->edit_posts );
		}
		$this->link( $bar, 'medialibrary', $root, __( 'Media Library', 'multisite-toolbar-additions' ), admin_url( 'upload.php' ), 'upload_files' );
		$this->link( $bar, 'media-list', 'ddw-mstba-medialibrary', __( 'Media Listing', 'multisite-toolbar-additions' ), admin_url( 'upload.php?mode=list' ), 'upload_files' );
		$this->link( $bar, 'media-new', 'ddw-mstba-medialibrary', __( 'Upload Files', 'multisite-toolbar-additions' ), admin_url( 'media-new.php' ), 'upload_files' );
		if ( wp_is_block_theme() ) {
			$this->link( $bar, 'site-editor', $root, __( 'Site Editor', 'multisite-toolbar-additions' ), admin_url( 'site-editor.php' ), 'edit_theme_options' );
		} else {
			$this->link( $bar, 'customizer', $root, __( 'Customizer', 'multisite-toolbar-additions' ), admin_url( 'customize.php' ), 'customize' );
			if ( current_theme_supports( 'widgets' ) ) {
				$this->link( $bar, 'widgets', $root, __( 'Widgets', 'multisite-toolbar-additions' ), admin_url( 'widgets.php' ), 'edit_theme_options' );
				$this->link( $bar, 'widgets-customizer', 'ddw-mstba-widgets', __( 'Widgets Customizer', 'multisite-toolbar-additions' ), admin_url( 'customize.php?autofocus[panel]=widgets' ), 'customize' );
			}
			foreach ( [ 'custom-background' => __( 'Custom Background', 'multisite-toolbar-additions' ), 'custom-header' => __( 'Custom Header', 'multisite-toolbar-additions' ) ] as $feature => $label ) {
				if ( current_theme_supports( $feature ) ) { $this->link( $bar, $feature, 'ddw-mstba-customizer', $label, admin_url( 'themes.php?page=' . $feature ), 'edit_theme_options' ); }
			}
		}
		$this->link( $bar, 'navmenus', $root, __( 'WordPress Menus', 'multisite-toolbar-additions' ), admin_url( 'nav-menus.php' ), 'edit_theme_options' );
		$this->link( $bar, 'navmenus-add', 'ddw-mstba-navmenus', __( 'Add Menu', 'multisite-toolbar-additions' ), admin_url( 'nav-menus.php?action=edit&menu=0' ), 'edit_theme_options' );
		if ( ! wp_is_block_theme() ) { $this->link( $bar, 'navmenus-locations', 'ddw-mstba-navmenus', __( 'Menu Locations', 'multisite-toolbar-additions' ), admin_url( 'nav-menus.php?action=locations' ), 'edit_theme_options' ); }
		if ( $this->settings->get( 'menu_edit_links' ) && current_user_can( 'edit_theme_options' ) ) {
			foreach ( wp_get_nav_menus() as $menu ) { $this->link( $bar, 'edit-menu-' . $menu->term_id, 'ddw-mstba-navmenus', $menu->name, add_query_arg( [ 'action' => 'edit', 'menu' => $menu->term_id ], admin_url( 'nav-menus.php' ) ), 'edit_theme_options' ); }
			$this->link( $bar, 'edit-toolbar-menu', 'ddw-mstba-navmenus', __( 'Shared Toolbar Menu', 'multisite-toolbar-additions' ), get_admin_url( $this->settings->source(), 'nav-menus.php' ) );
		}
		$this->link( $bar, 'site-health', $root, __( 'Site Health', 'multisite-toolbar-additions' ), admin_url( 'site-health.php' ), 'view_site_health_checks' );
		$this->link( $bar, 'site-health-info', 'ddw-mstba-site-health', __( 'Debug Information', 'multisite-toolbar-additions' ), admin_url( 'site-health.php?tab=debug' ), 'view_site_health_checks' );
		$this->link( $bar, 'tools', $root, __( 'Tools', 'multisite-toolbar-additions' ), admin_url( 'tools.php' ) );
		$this->link( $bar, 'export', 'ddw-mstba-tools', __( 'Export', 'multisite-toolbar-additions' ), admin_url( 'export.php' ), 'export' );
		$this->link( $bar, 'import', 'ddw-mstba-tools', __( 'Import', 'multisite-toolbar-additions' ), admin_url( 'import.php' ), 'import' );
		$this->link( $bar, 'settings', $root, __( 'Toolbar Settings', 'multisite-toolbar-additions' ), Admin::url(), Settings::capability() );
		if ( ! is_multisite() ) {
			$this->link( $bar, 'siteplugins', $root, __( 'Plugins', 'multisite-toolbar-additions' ), admin_url( 'plugins.php' ), 'activate_plugins' );
			$this->link( $bar, 'sitethemes', $root, __( 'Themes', 'multisite-toolbar-additions' ), admin_url( 'themes.php' ), 'switch_themes' );
			$this->installers( $bar, 'ddw-mstba-siteplugins', 'ddw-mstba-sitethemes' );
		}
		if ( $this->settings->get( 'file_editors' ) ) {
			$this->link( $bar, 'editthemes', $root, __( 'Theme File Editor', 'multisite-toolbar-additions' ), network_admin_url( 'theme-editor.php' ), 'edit_themes' );
			$this->link( $bar, 'editplugins', $root, __( 'Plugin File Editor', 'multisite-toolbar-additions' ), network_admin_url( 'plugin-editor.php' ), 'edit_plugins' );
		}
	}
	private function new_items( $bar ) {
		foreach ( [ 'addnew_plugin' => [ 'plugin', 'install_plugins', __( 'Install Plugin', 'multisite-toolbar-additions' ) ], 'addnew_theme' => [ 'theme', 'install_themes', __( 'Install Theme', 'multisite-toolbar-additions' ) ] ] as $id => [ $type, $cap, $label ] ) {
			if ( ! $this->settings->get( 'new_' . ( 'plugin' === $type ? 'plugins' : 'themes' ) ) ) { continue; }
			$this->link( $bar, $id, 'new-content', $label, network_admin_url( $type . '-install.php' ), $cap );
			$this->link( $bar, $id . '-upload', 'ddw-mstba-' . $id, __( 'Upload ZIP', 'multisite-toolbar-additions' ), Admin::upload_url( $type ), $cap );
		}
	}

	private function subsites( $bar ) {
		$count = 0;
		foreach ( (array) $bar->get_nodes() as $node ) {
			if ( ! preg_match( '/^blog-(\d+)$/', $node->id, $match ) ) { continue; }
			if ( ++$count > (int) $this->settings->get( 'subsite_limit' ) ) { break; }
			$id = (int) $match[1];
			// Resolve theme and capabilities in the destination site, then always restore context.
			MenuRepository::on_site( $id, function () use ( $bar, $node, $id ) {
				foreach ( [
					[ 'settings', 'options-general.php', __( 'Site Settings', 'multisite-toolbar-additions' ), 'manage_options' ],
					[ 'plugins', 'plugins.php', __( 'Site Plugins', 'multisite-toolbar-additions' ), 'activate_plugins' ],
					[ 'themes', 'themes.php', __( 'Site Themes', 'multisite-toolbar-additions' ), 'switch_themes' ],
					[ 'menus', 'nav-menus.php', __( 'WordPress Menus', 'multisite-toolbar-additions' ), 'edit_theme_options' ],
					[ 'tools', 'tools.php', __( 'Site Tools', 'multisite-toolbar-additions' ), 'manage_options' ],
				] as [ $suffix, $path, $label, $cap ] ) { $this->link( $bar, 'blog-' . $id . '-' . $suffix, $node->id, $label, admin_url( $path ), $cap ); }
				if ( wp_is_block_theme() ) { $this->link( $bar, 'blog-' . $id . '-editor', $node->id, __( 'Site Editor', 'multisite-toolbar-additions' ), admin_url( 'site-editor.php' ), 'edit_theme_options' ); }
				else {
					$this->link( $bar, 'blog-' . $id . '-customizer', $node->id, __( 'Customizer', 'multisite-toolbar-additions' ), admin_url( 'customize.php' ), 'customize' );
					if ( current_theme_supports( 'widgets' ) ) { $this->link( $bar, 'blog-' . $id . '-widgets', $node->id, __( 'Widgets', 'multisite-toolbar-additions' ), admin_url( 'widgets.php' ), 'edit_theme_options' ); }
				}
			} );
		}
	}
	private function resources( $bar ) {
		$parent = $bar->get_node( 'wp-logo-external' ) ? 'wp-logo-external' : '';
		if ( ! $parent ) { return; }
		$this->link( $bar, 'resources', $parent, __( 'Developer Resources', 'multisite-toolbar-additions' ), 'https://developer.wordpress.org/', 'manage_options', true );
		foreach ( [
			'plugins' => [ __( 'Plugin Handbook', 'multisite-toolbar-additions' ), 'https://developer.wordpress.org/plugins/' ],
			'themes' => [ __( 'Theme Handbook', 'multisite-toolbar-additions' ), 'https://developer.wordpress.org/themes/' ],
			'blocks' => [ __( 'Block Editor Handbook', 'multisite-toolbar-additions' ), 'https://developer.wordpress.org/block-editor/' ],
			'standards' => [ __( 'Coding Standards', 'multisite-toolbar-additions' ), 'https://developer.wordpress.org/coding-standards/' ],
			'contribute' => [ __( 'Get Involved', 'multisite-toolbar-additions' ), 'https://make.wordpress.org/' ],
		] as $id => [ $label, $url ] ) { $this->link( $bar, 'resources-' . $id, 'ddw-mstba-resources', $label, $url, 'manage_options', true ); }
	}
}
