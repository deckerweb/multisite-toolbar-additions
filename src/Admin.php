<?php
/**
 * Multisite Toolbar Additions.
 * Copyright © 2012–2026 David Decker – DECKERWEB.
 * SPDX-License-Identifier: GPL-2.0-or-later
 */
namespace Deckerweb\MultisiteToolbar;

defined( 'ABSPATH' ) || exit;

/** Native WordPress UI, one authenticated save route for both installation types. */
final class Admin {
	private $settings;
	private $hook;
	private $upload_hook;
	/**
	 * Store the services used by this instance without persistent writes.
	 *
	 * @param Settings $settings Current site/network setting service.
	 * @return void No value; output or hooks are updated as described.
	 */
	public function __construct( Settings $settings ) { $this->settings = $settings; }
	/**
	 * Register settings, upload pages, scoped assets and diagnostics hooks.
	 *
	 * @return void No value; output or hooks are updated as described.
	 */
	public function register() {
		add_action( 'admin_menu', [ $this, 'page' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'assets' ] );
		add_action( 'network_admin_menu', [ $this, 'page' ] );
		add_action( 'admin_menu', [ $this, 'sidebar' ], 100 );
		add_action( 'admin_menu', [ $this, 'uploads' ], 110 );
		add_action( 'network_admin_menu', [ $this, 'uploads' ], 110 );
		add_action( 'wp_ajax_mstba_menu_preview', [ MenuPreview::class, 'action' ] );
		add_action( 'admin_post_mstba_save', [ $this, 'save' ] );
		add_filter( 'plugin_action_links_' . plugin_basename( MSTBA_PLUGIN_FILE ), [ $this, 'links' ] );
		add_filter( 'network_admin_plugin_action_links_' . plugin_basename( MSTBA_PLUGIN_FILE ), [ $this, 'links' ] );
		add_filter( 'debug_information', [ $this, 'debug' ] );
		add_filter( 'admin_body_class', [ $this, 'upload_view' ] );
	}
	/**
	 * Enable the native theme upload view only for an authorized installer screen.
	 *
	 * @param string $classes Existing administration body classes.
	 * @return string Result described above; unrelated hook values remain unchanged.
	 */
	public function upload_view( $classes ) {
		if ( 'theme-install.php' === ( $GLOBALS['pagenow'] ?? '' ) && isset( $_GET['upload'] ) && current_user_can( 'install_themes' ) ) {
			$classes .= ' show-upload-view';
		}
		return $classes;
	}
	/**
	 * Return the settings URL for network or site activation.
	 *
	 * @return string Result described above; unrelated hook values remain unchanged.
	 */
	public static function url() { return Settings::network_active() ? network_admin_url( 'settings.php?page=mstba' ) : admin_url( 'options-general.php?page=mstba' ); }
	/**
	 * Register one authorized settings page in its active administration scope.
	 *
	 * @return void No value; output or hooks are updated as described.
	 */
	public function page() {
		if ( Settings::network_active() && ! is_network_admin() ) { return; }
		$this->hook = add_submenu_page( Settings::network_active() ? 'settings.php' : 'options-general.php', __( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' ), __( 'Toolbar Additions', 'multisite-toolbar-additions' ), Settings::capability(), 'mstba', [ $this, 'render' ] );
	}
	/**
	 * Enqueue settings and footer resources only on this settings screen.
	 *
	 * @param string $hook Current administration screen hook suffix.
	 * @return void No value; output or hooks are updated as described.
	 */
	public function assets( $hook ) {
		if ( ( $this->hook && $hook === $this->hook ) || ( $this->upload_hook && $hook === $this->upload_hook ) ) {
			wp_enqueue_script( 'mstba-settings', plugins_url( 'assets/settings.js', MSTBA_PLUGIN_FILE ), [], MSTBA_PLUGIN_VERSION, true );
			wp_localize_script( 'mstba-settings', 'mstbaMenuPreview', MenuPreview::config() );
			wp_enqueue_script( 'mstba-admin-footer', plugins_url( 'assets/deckerweb-footer.js', MSTBA_PLUGIN_FILE ), [], '1.0.0', true );
			wp_enqueue_style( 'mstba-admin-footer', plugins_url( 'assets/deckerweb-footer.css', MSTBA_PLUGIN_FILE ), [], '1.0.0' );
			wp_enqueue_style( 'mstba-settings', plugins_url( 'assets/settings.css', MSTBA_PLUGIN_FILE ), [ 'mstba-admin-footer' ], MSTBA_PLUGIN_VERSION );
		}
	}
	/**
	 * Add network administration destinations for super administrators.
	 *
	 * @return void No value; output or hooks are updated as described.
	 */
	public function sidebar() {
		if ( ! $this->settings->get( 'network_links' ) || ! is_multisite() || ! is_super_admin() || is_network_admin() ) { return; }
		add_submenu_page( 'plugins.php', __( 'Network Plugins', 'multisite-toolbar-additions' ), __( 'Network Plugins', 'multisite-toolbar-additions' ), 'manage_network_plugins', network_admin_url( 'plugins.php' ) );
		add_submenu_page( 'plugins.php', __( 'Install Plugin', 'multisite-toolbar-additions' ), __( 'Install Plugin', 'multisite-toolbar-additions' ), 'install_plugins', network_admin_url( 'plugin-install.php' ) );
		add_submenu_page( 'themes.php', __( 'Network Themes', 'multisite-toolbar-additions' ), __( 'Network Themes', 'multisite-toolbar-additions' ), 'manage_network_themes', network_admin_url( 'themes.php' ) );
	}
	/**
	 * Return a plugin or theme upload destination, targeting the network in Multisite.
	 *
	 * @param string $type Upload type: plugin or theme.
	 * @return string Result described above; unrelated hook values remain unchanged.
	 */
	public static function upload_url( $type ) {
		return Uploads::url( $type );
	}
	/**
	 * Register upload navigation through the shared provider resolver.
	 *
	 * @return void
	 */
	public function uploads() { Uploads::menu( $this->settings ); }
	/**
	 * Keep the existing theme callback available for integrations.
	 *
	 * @return void
	 */
	public function theme_upload() { Uploads::screen( 'theme' ); }

	/**
	 * Prepend the settings action link for authorized administrators.
	 *
	 * @param array $links Existing plugin action links.
	 * @return array Result described above; unrelated hook values remain unchanged.
	 */
	public function links( $links ) {
		if ( current_user_can( Settings::capability() ) ) {
			array_unshift( $links, '<a href="' . esc_url( self::url() ) . '">' . esc_html__( 'Settings', 'multisite-toolbar-additions' ) . '</a>' );
		}
		return $links;
	}
	/**
	 * Validate a POST form, capability and nonce; save values and redirect.
	 *
	 * @return void No value; output or hooks are updated as described.
	 */
	public function save() {
		if ( 'POST' !== ( $_SERVER['REQUEST_METHOD'] ?? '' ) ) { wp_die( esc_html__( 'Use the settings form to save changes.', 'multisite-toolbar-additions' ), '', [ 'response' => 405 ] ); }
		if ( ! current_user_can( Settings::capability() ) ) { wp_die( esc_html__( 'You cannot change toolbar settings.', 'multisite-toolbar-additions' ), '', [ 'response' => 403 ] ); }
		check_admin_referer( 'mstba_save' );
		$values = $this->settings->sanitize( isset( $_POST['mstba'] ) ? wp_unslash( $_POST['mstba'] ) : [] );
		if ( is_wp_error( $values ) ) { wp_die( esc_html( $values->get_error_message() ), '', [ 'response' => 400, 'back_link' => true ] ); }
		$this->settings->save( $values );
		wp_safe_redirect( add_query_arg( 'saved', '1', self::url() ) );
		exit;
	}
	/**
	 * Print one escaped checkbox using the current setting.
	 *
	 * @param string $key Allowlisted setting key.
	 * @param string $label Translated label; escaped on output.
	 * @return void No value; output or hooks are updated as described.
	 */
	private function checkbox( $key, $label ) {
		echo '<p class="mstba-checkbox"><label><input type="checkbox" name="mstba[' . esc_attr( $key ) . ']" value="1" ' . checked( $this->settings->get( $key ), true, false ) . '> ' . esc_html( $label ) . '</label></p>';
	}
	/**
	 * Print escaped selectable values for one setting.
	 *
	 * @param string $key Allowlisted setting key.
	 * @param array $options Allowed values mapped to translated labels.
	 * @return void No value; output or hooks are updated as described.
	 */
	private function select( $key, array $options ) {
		echo '<select id="mstba-' . esc_attr( $key ) . '" name="mstba[' . esc_attr( $key ) . ']">';
		foreach ( $options as $value => $label ) { echo '<option value="' . esc_attr( $value ) . '" ' . selected( $this->settings->get( $key ), $value, false ) . '>' . esc_html( $label ) . '</option>'; }
		echo '</select>';
	}
	/**
	 * Print a labeled table row and invoke its field renderer.
	 *
	 * @param string $key Allowlisted setting key.
	 * @param string $label Translated label; escaped on output.
	 * @param callable $field Field renderer invoked inside the table cell.
	 * @return void No value; output or hooks are updated as described.
	 */
	private function row( $key, $label, callable $field ) {
		echo '<tr id="mstba-row-' . esc_attr( $key ) . '"><th scope="row"><label for="mstba-' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th><td>';
		$field(); echo '</td></tr>';
	}
	/**
	 * Print settings for a valid source site, with authenticated save controls.
	 *
	 * @return void No value; output or hooks are updated as described.
	 */
	public function render() {
		if ( ! current_user_can( Settings::capability() ) ) { return; }
		$source = $this->settings->source();
		if ( is_multisite() ) {
			$requested = $_GET['source_id'] ?? 0;
			if ( ! is_scalar( $requested ) || ! absint( $requested ) ) { $requested = $_GET['source'] ?? $source; }
			if ( is_scalar( $requested ) ) { $source = absint( $requested ) ?: get_main_site_id(); }
		}
		if ( is_multisite() ) {
			$site = get_site( $source );
			if ( ( ! $site || (int) $site->network_id !== get_current_network_id() || $site->deleted || $site->archived || $site->spam ) && $source !== $this->settings->source() ) {
				echo '<div class="wrap"><h1>' . esc_html__( 'Toolbar Additions', 'multisite-toolbar-additions' ) . '</h1><p>' . esc_html__( 'Choose an active website in this network.', 'multisite-toolbar-additions' ) . '</p><a href="' . esc_url( self::url() ) . '">' . esc_html__( 'Back to settings', 'multisite-toolbar-additions' ) . '</a></div>'; return;
			}
		}
		$valid_source = ! is_multisite() || ( $site && (int) $site->network_id === get_current_network_id() && ! $site->deleted && ! $site->archived && ! $site->spam );
		$menus = $valid_source ? MenuRepository::on_site( $source, /** Print the escaped field for this settings row using its captured allowed values.
 * @return void No return value.
 */
static function () { return wp_get_nav_menus(); } ) : [];
		$edit_url = get_admin_url( $valid_source ? $source : get_current_blog_id(), 'nav-menus.php' );
		echo '<div class="wrap mstba-settings">';
		PageChrome::header();
		if ( is_multisite() && ! Settings::network_active() ) { echo '<div class="notice notice-info inline"><p>' . esc_html__( 'This site-only activation manages network toolbar settings from this website. Network-activate this plugin to use its Library in Network Admin.', 'multisite-toolbar-additions' ) . '</p></div>'; }
		if ( isset( $_GET['saved'] ) ) { echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__( 'Settings saved.', 'multisite-toolbar-additions' ) . '</p></div>'; }
		echo '<p>' . esc_html__( 'Use a WordPress menu as your toolbar. Its source is independent of the active theme.', 'multisite-toolbar-additions' ) . '</p>';
		echo '<p><a class="button" href="#mstba-preview">' . esc_html__( 'Menu preview and effective settings', 'multisite-toolbar-additions' ) . '</a></p>';
		if ( is_multisite() ) {
			$sites = get_sites( [ 'network_id' => get_current_network_id(), 'number' => 101, 'deleted' => 0, 'archived' => 0, 'spam' => 0 ] );
			$large = count( $sites ) > 100;
			$sites = array_slice( $sites, 0, 100 );
			$choices = [];
			foreach ( $sites as $site ) { $choices[ $site->blog_id ] = $site->domain . $site->path; }
			if ( ! isset( $choices[ $source ] ) ) { $site = get_site( $source ); $choices[ $source ] = $valid_source ? $site->domain . $site->path : sprintf( __( 'Unavailable website #%d', 'multisite-toolbar-additions' ), $source ); }
			echo '<form method="get" action="' . esc_url( ( Settings::network_active() ? network_admin_url( 'settings.php' ) : admin_url( 'options-general.php' ) ) ) . '"><input type="hidden" name="page" value="mstba"><label for="mstba-source">' . esc_html__( 'Source website', 'multisite-toolbar-additions' ) . '</label> <select id="mstba-source" name="source">';
			foreach ( $choices as $id => $label ) { echo '<option value="' . esc_attr( $id ) . '" ' . selected( $source, $id, false ) . '>' . esc_html( $label ) . '</option>'; }
			echo '</select>';
			if ( $large ) { echo ' <label for="mstba-source-id">' . esc_html__( 'Other website ID', 'multisite-toolbar-additions' ) . '</label> <input id="mstba-source-id" name="source_id" type="number" min="1" class="small-text">'; }
			echo ' <button class="button">' . esc_html__( 'Load menus', 'multisite-toolbar-additions' ) . '</button><p class="description">' . esc_html__( 'Choose a source website, then load its menus. Loading does not save your settings.', 'multisite-toolbar-additions' ) . '</p></form>';
		}
		echo '<div class="mstba-sticky-save"><div><strong>' . esc_html__( 'Toolbar settings', 'multisite-toolbar-additions' ) . '</strong><span id="mstba-unsaved-status" role="status" aria-live="polite">' . esc_html__( 'All changes saved', 'multisite-toolbar-additions' ) . '</span></div><div class="mstba-save-actions"><button type="submit" form="mstba-settings-form" class="button button-primary" id="mstba-top-save">' . esc_html__( 'Save all changes', 'multisite-toolbar-additions' ) . '</button><button type="button" class="button" id="mstba-reload" hidden>' . esc_html__( 'Reload page', 'multisite-toolbar-additions' ) . '</button></div></div>';
		echo '<form id="mstba-settings-form" data-source-changed="' . ( $source !== $this->settings->source() ? '1' : '0' ) . '" method="post" action="' . esc_url( admin_url( 'admin-post.php' ) ) . '"><input type="hidden" name="action" value="mstba_save"><input type="hidden" name="mstba[source_site]" value="' . esc_attr( $source ) . '">';
		wp_nonce_field( 'mstba_save' );
		echo '<section class="mstba-panel" id="mstba-menu-panel"><h2>' . esc_html__( 'Your toolbar menu', 'multisite-toolbar-additions' ) . '</h2>';
		$this->checkbox( 'enabled', __( 'Show the custom toolbar menu', 'multisite-toolbar-additions' ) );
		echo '<table class="form-table" role="presentation">';
		$this->row( 'menu_id', __( 'WordPress menu', 'multisite-toolbar-additions' ), /** Print the escaped field for this settings row using its captured allowed values.
 * @return void No return value.
 */
function () use ( $menus, $edit_url, $source ) {
			echo '<select id="mstba-menu_id" name="mstba[menu_id]"><option value="0">' . esc_html__( 'Use the existing toolbar menu location', 'multisite-toolbar-additions' ) . '</option>';
			foreach ( $menus as $menu ) { echo '<option value="' . esc_attr( $menu->term_id ) . '" ' . selected( $source === $this->settings->source() ? $this->settings->get( 'menu_id' ) : 0, $menu->term_id, false ) . '>' . esc_html( $menu->name ) . '</option>'; }
			echo '</select> <a class="button" href="' . esc_url( $edit_url ) . '">' . esc_html__( 'Create or edit menus', 'multisite-toolbar-additions' ) . '</a><p class="description">' . esc_html__( 'Choose a menu directly to keep it through theme changes. The location option is provided for upgrades from 3.x.', 'multisite-toolbar-additions' ) . '</p>';
		} );
		$this->row( 'context', __( 'Show in', 'multisite-toolbar-additions' ), /** Print the escaped field for this settings row using its captured allowed values.
 * @return void No return value.
 */
function () { $this->select( 'context', [ 'both' => __( 'Frontend and administration', 'multisite-toolbar-additions' ), 'frontend' => __( 'Frontend only', 'multisite-toolbar-additions' ), 'admin' => __( 'Administration only', 'multisite-toolbar-additions' ) ] ); } );
		if ( is_multisite() ) {
			$this->row( 'audience', __( 'Visible to', 'multisite-toolbar-additions' ), /** Print the escaped field for this settings row using its captured allowed values.
 * @return void No return value.
 */
function () { $this->select( 'audience', [ 'administrators' => __( 'Super administrators only', 'multisite-toolbar-additions' ), 'site_administrators' => __( 'Super administrators and website administrators', 'multisite-toolbar-additions' ) ] ); echo '<p class="description">' . esc_html__( 'Visibility grants no permission to linked pages. Only super administrators may edit the shared toolbar menu.', 'multisite-toolbar-additions' ) . '</p>'; } );
		}
		$this->row( 'position', __( 'Position', 'multisite-toolbar-additions' ), /** Print the escaped field for this settings row using its captured allowed values.
 * @return void No return value.
 */
function () { $this->select( 'position', [ 'first' => __( 'First on the left', 'multisite-toolbar-additions' ), 'last' => __( 'Last on the left', 'multisite-toolbar-additions' ), 'before' => __( 'Before the following item', 'multisite-toolbar-additions' ), 'after' => __( 'After the following item', 'multisite-toolbar-additions' ), 'right' => __( 'On the right, beside the account menu', 'multisite-toolbar-additions' ) ] ); } );
		$this->row( 'anchor', __( 'Reference item', 'multisite-toolbar-additions' ), /** Print the escaped field for this settings row using its captured allowed values.
 * @return void No return value.
 */
function () { $this->select( 'anchor', [ 'wp-logo' => __( 'WordPress logo', 'multisite-toolbar-additions' ), 'my-sites' => __( 'My Sites', 'multisite-toolbar-additions' ), 'site-name' => __( 'Website name', 'multisite-toolbar-additions' ), 'updates' => __( 'Updates', 'multisite-toolbar-additions' ), 'new-content' => __( 'New content', 'multisite-toolbar-additions' ), 'comments' => __( 'Comments', 'multisite-toolbar-additions' ) ] ); echo '<p class="description">' . esc_html__( 'Used for before/after positions. If the item is absent, your menu appears last on the left.', 'multisite-toolbar-additions' ) . '</p>'; } );
		$this->row( 'child_depth', __( 'Child levels', 'multisite-toolbar-additions' ), /** Print the escaped field for this settings row using its captured allowed values.
 * @return void No return value.
 */
function () {
			$options = [ 0 => __( 'All levels', 'multisite-toolbar-additions' ) ];
			for ( $i = 1; $i <= 10; ++$i ) { $options[ $i ] = sprintf( _n( '%d child level', '%d child levels', $i, 'multisite-toolbar-additions' ), $i ); }
			$this->select( 'child_depth', $options );
			echo '<p class="description">' . esc_html__( 'Counted from the original menu root. One means root entries plus their direct children. Grouping does not change this limit.', 'multisite-toolbar-additions' ) . '</p>';
		} );
		$this->row( 'layout', __( 'Layout', 'multisite-toolbar-additions' ), /** Print the escaped field for this settings row using its captured allowed values.
 * @return void No return value.
 */
function () { $this->select( 'layout', [ 'original' => __( 'Each root item in the toolbar', 'multisite-toolbar-additions' ), 'grouped' => __( 'Everything under one toolbar item', 'multisite-toolbar-additions' ) ] ); } );
		$this->row( 'label', __( 'Group label', 'multisite-toolbar-additions' ), /** Print the escaped field for this settings row using its captured allowed values.
 * @return void No return value.
 */
function () { echo '<input class="regular-text" id="mstba-label" name="mstba[label]" maxlength="80" value="' . esc_attr( $this->settings->get( 'label' ) ) . '"><p class="description">' . esc_html__( 'Leave empty to use the selected menu’s name. A custom label overrides it.', 'multisite-toolbar-additions' ) . '</p>'; } );
		echo '</table></section><section class="mstba-panel" id="mstba-shortcuts-panel"><h2>' . esc_html__( 'Useful shortcuts', 'multisite-toolbar-additions' ) . '</h2><p>' . esc_html__( 'Shortcuts are shown only to administrators with permission for the destination.', 'multisite-toolbar-additions' ) . '</p>';
		foreach ( [ 'new_plugins' => __( 'Show Plugins under New in the toolbar', 'multisite-toolbar-additions' ), 'new_themes' => __( 'Show Themes under New in the toolbar', 'multisite-toolbar-additions' ), 'plugin_zip_submenu' => __( 'Show the plugin ZIP upload submenu', 'multisite-toolbar-additions' ), 'theme_zip_submenu' => __( 'Show the theme ZIP upload submenu', 'multisite-toolbar-additions' ), 'network_links' => __( 'Network administration and network New menu', 'multisite-toolbar-additions' ), 'site_links' => __( 'Website administration, content types and Site Health', 'multisite-toolbar-additions' ), 'subsite_links' => __( 'Shortcuts for websites under My Sites', 'multisite-toolbar-additions' ), 'menu_edit_links' => __( 'Quick links to edit WordPress menus', 'multisite-toolbar-additions' ), 'integrations' => __( 'Detected plugin integrations', 'multisite-toolbar-additions' ), 'resources' => __( 'WordPress developer resources', 'multisite-toolbar-additions' ), 'file_editors' => __( 'Theme and plugin file editor shortcuts', 'multisite-toolbar-additions' ), 'fullscreen' => __( 'Keep the toolbar visible in the fullscreen block editor', 'multisite-toolbar-additions' ) ] as $key => $label ) { if ( ! is_multisite() && in_array( $key, [ 'network_links', 'subsite_links' ], true ) ) { continue; } $this->checkbox( $key, $label ); }
		if ( is_multisite() ) {
		echo '<p><label for="mstba-subsite_limit">' . esc_html__( 'Maximum websites with extra shortcuts', 'multisite-toolbar-additions' ) . '</label> <input id="mstba-subsite_limit" type="number" min="1" max="100" name="mstba[subsite_limit]" value="' . esc_attr( $this->settings->get( 'subsite_limit' ) ) . '"></p><p class="description">' . esc_html__( 'Only websites already present in the toolbar are extended. Additional websites keep their normal WordPress links. File editors stay subject to WordPress security restrictions.', 'multisite-toolbar-additions' ) . '</p>';
		}
		echo '</section><section class="mstba-panel" id="mstba-data-panel"><h2>' . esc_html__( 'Stored data', 'multisite-toolbar-additions' ) . '</h2>';
		$this->checkbox( 'delete_data', __( 'Delete this plugin’s settings when uninstalling', 'multisite-toolbar-additions' ) );
		echo '<p class="description">' . esc_html__( 'Off by default. Deactivation keeps your data. Uninstall always clears this plugin’s update cache. This option deletes toolbar settings for this site or network; WordPress menus, installed plugins and shared Library data are not deleted by it.', 'multisite-toolbar-additions' ) . '</p></section><p class="description">' . esc_html__( 'Use Save all changes in the bar above to apply your settings.', 'multisite-toolbar-additions' ) . '</p></form>';
		MenuPreview::render( $this->settings );
		PageChrome::footer();
		echo '</div>';
	}
	/**
	 * Add version and numeric settings diagnostics without secrets or content.
	 *
	 * @param array $info Existing Site Health debug information.
	 * @return array Result described above; unrelated hook values remain unchanged.
	 */
	public function debug( $info ) {
		$info['mstba'] = [ 'label' => 'Multisite Toolbar Additions', 'fields' => [
			'version' => [ 'label' => __( 'Version', 'multisite-toolbar-additions' ), 'value' => MSTBA_PLUGIN_VERSION ],
			'source' => [ 'label' => __( 'Source website', 'multisite-toolbar-additions' ), 'value' => $this->settings->source() ],
			'menu' => [ 'label' => __( 'Menu ID', 'multisite-toolbar-additions' ), 'value' => (int) $this->settings->get( 'menu_id' ) ],
			'context' => [ 'label' => __( 'Show in', 'multisite-toolbar-additions' ), 'value' => $this->settings->get( 'context' ) ],
		] ]; return $info;
	}
}
