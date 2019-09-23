<?php
/**
 * Helper functions for the admin - plugin links and help tabs.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Admin
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
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
 * Remove unethical Jetpack search results Ads as no one needs these anyway.
 *   Additionally remove other promotions and Ads from Jetpack.
 *
 * @link https://wptavern.com/jetpack-7-1-adds-feature-suggestions-to-plugin-search-results#comment-284531
 *
 * @since 2.0.1
 */
add_filter( 'jetpack_show_promotions', '__return_false', 20 );
add_filter( 'can_display_jetpack_manage_notice', '__return_false', 20 );
add_filter( 'jetpack_just_in_time_msgs', '__return_false', 20 );


/**
 * Remove unethical WooCommerce Ads injections.
 *
 * @since 2.0.1
 */
add_filter( 'woocommerce_allow_marketplace_suggestions', '__return_false' );


/**
 * Add "Custom Menu" link to plugin page.
 *
 * @since 1.0.0
 * @since 1.9.2 Improvements and tweaks.
 * @since 2.0.1 Overall code improvements.
 *
 * @param array $action_links (Default) Array of plugin action links.
 * @return array Modified array of plugin action links.
 */
function ddw_mstba_custom_menu_link( $action_links = [] ) {

	$mstba_links = array();

	/** Add link only if user can edit theme options */
	if ( current_user_can( 'edit_theme_options' ) ) {

		/** Menus Page link */
		$mstba_links[ 'mstba-menu' ] = sprintf(
			'<a href="%1$s" title="%2$s"><span class="dashicons-before dashicons-menu"></span> %3$s</a>',
			esc_url( admin_url( 'nav-menus.php' ) ),
			esc_html__( 'Setup a custom Toolbar menu', 'multisite-toolbar-additions' ),
			esc_attr__( 'Custom Menu', 'multisite-toolbar-additions' )
		);

		/** Network Admin link */
		$mstba_network_link = '';

		if ( is_multisite() && ! is_network_admin() ) {

			$mstba_links[ 'network-admin' ] = sprintf(
				'<a href="%1$s" title="%2$s"><span class="dashicons-before dashicons-admin-network"></span> %3$s</a>',
				esc_url( network_admin_url() ),
				esc_html__( 'Go to the Network Admin', 'multisite-toolbar-additions' ),
				esc_attr__( 'Network Admin', 'multisite-toolbar-additions' )
			);

		}  // end if

		/** Display plugin settings links */
		return apply_filters(
			'mstba_filter_settings_page_link',
			array_merge( $mstba_links, $action_links ),
			$mstba_links 		// additional param
		);

	}  // end if cap check

}  // end function


add_filter( 'plugin_row_meta', 'ddw_mstba_plugin_links', 10, 2 );
/**
 * Add various support links to plugin page.
 *
 * @since 1.0.0
 * @since 1.9.1 Improvements and partly refactoring.
 *
 * @uses ddw_mstba_get_info_link()
 *
 * @param array  $mstba_links (Default) Array of plugin meta links
 * @param string $mstba_file  URL of base plugin file
 * @return array  $mstba_links Array of plugin link strings to build HTML markup.
 */
function ddw_mstba_plugin_links( $mstba_links, $mstba_file ) {

	/** Capability check */
	if ( ! current_user_can( 'install_plugins' ) ) {
		return $mstba_links;
	}

	/** List additional links only for this plugin */
	if ( $mstba_file === MSTBA_PLUGIN_BASEDIR . 'multisite-toolbar-additions.php' ) {

		/* translators: Plugins page listing */
		$mstba_links[] = ddw_mstba_get_info_link(
			'url_wporg_faq',
			esc_html_x( 'FAQ', 'Plugins page listing', 'multisite-toolbar-additions' ),
			'dashicons-before dashicons-editor-help'
		);

		/* translators: Plugins page listing */
		$mstba_links[] = ddw_mstba_get_info_link(
			'url_wporg_forum',
			esc_html_x( 'Support', 'Plugins page listing', 'multisite-toolbar-additions' ),
			'dashicons-before dashicons-sos'
		);

		/* translators: Plugins page listing */
		$mstba_links[] = ddw_mstba_get_info_link(
			'url_snippets',
			esc_html_x( 'Code Snippets', 'Plugins page listing', 'multisite-toolbar-additions' ),
			'dashicons-before dashicons-editor-code'
		);

		/* translators: Plugins page listing */
		$mstba_links[] = ddw_mstba_get_info_link(
			'url_fb_group',
			esc_html_x( 'Facebook Group', 'Plugins page listing', 'multisite-toolbar-additions' ),
			'dashicons-before dashicons-facebook'
		);

		/* translators: Plugins page listing */
		$mstba_links[] = ddw_mstba_get_info_link(
			'url_translate',
			esc_html_x( 'Translations', 'Plugins page listing', 'multisite-toolbar-additions' ),
			'dashicons-before dashicons-translation'
		);

		/* translators: Plugins page listing */
		$mstba_links[] = ddw_mstba_get_info_link(
			'url_donate',
			esc_html_x( 'Donate', 'Plugins page listing', 'multisite-toolbar-additions' ),
			'button dashicons-before dashicons-thumbs-up'
		);

		/* translators: Plugins page listing */
		$mstba_links[] = ddw_mstba_get_info_link(
			'url_newsletter',
			esc_html_x( 'Join our Newsletter', 'Plugins page listing', 'multisite-toolbar-additions' ),
			'button-primary dashicons-before dashicons-awards'
		);

	}  // end if plugin links

	/** Output the links */
	return apply_filters(
		'mstba_filter_plugin_links',
		$mstba_links
	);

}  // end function


add_action( 'admin_enqueue_scripts', 'ddw_mstba_inline_styles_plugins_page', 20 );
/**
 * Add additional inline styles on the admin Plugins page.
 *
 * @since 1.9.1
 * @since 2.0.1 Splitted into function; using wp_add_inline_style() from Core.
 *
 * @uses wp_add_inline_style()
 *
 * @global string $GLOBALS[ 'pagenow' ]
 */
function ddw_mstba_inline_styles_plugins_page() {

	/** Bail early if not on plugins.php admin page */
	if ( 'plugins.php' !== $GLOBALS[ 'pagenow' ] ) {
		return;
	}

	$mstba_file = MSTBA_PLUGIN_BASEDIR . 'multisite-toolbar-additions.php';

    /**
     * For WordPress Admin Area
     *   Style handle: 'wp-admin' (WordPress Core)
     */
    $inline_css = sprintf(
    	'
        tr[data-plugin="%s"] .plugin-version-author-uri a.dashicons-before:before {
			font-size: 17px;
			margin-right: 2px;
			opacity: .85;
			vertical-align: sub;
		}

		.mstba-update-message p:before,
		.update-message.notice p:empty,
		.update-message.updating-message > p,
		.update-message.notice-success > p,
		.update-message.notice-error > p {
			display: none !important;
		}',
		$mstba_file
	);

    wp_add_inline_style( 'wp-admin', $inline_css );

}  // end function


add_action( 'admin_head-nav-menus.php', 'ddw_mstba_widgets_help_content', 15 );
/**
 * Create and display plugin help tab content.
 *
 *   Load it after core help tabs on Menus admin page.
 *   Some plugin menu instructions for super_admins plus general plugin info.
 *
 * @since 1.0.0
 * @since 1.9.2 Added subtle CSS styling.
 *
 * @uses WP_Screen::add_help_tab()
 *
 * @global mixed $GLOBALS[ 'mstba_widgets_screen' ]
 */
function ddw_mstba_widgets_help_content() {

	$GLOBALS[ 'mstba_widgets_screen' ] = get_current_screen();

	/** Display help tabs only for WordPress 3.3 or higher */
	if ( ! $GLOBALS[ 'mstba_widgets_screen' ]
		|| ! is_super_admin()
	) {
		return;
	}

	/** Add the new help tab */
	$GLOBALS[ 'mstba_widgets_screen' ]->add_help_tab(
		array(
			'id'       => 'mstba-menus-help',
			'title'    => __( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' ),
			'callback' => apply_filters( 'mstba_help_tab', 'ddw_mstba_help_tab_content' ),
		)
	);

	/** Some subtle CSS styling additions ... ;-) */
	?>
		<style type='text/css'>
			/** Dashicons commons */
			#tab-link-mstba-menus-help a:before {
				display: inline-block;
				-webkit-font-smoothing: antialiased;
				font-family: 'dashicons';
				font-weight: 400;
				vertical-align: top;
			}

			/** Our help tab */
			#tab-link-mstba-menus-help a:before {
				clear: left;
				content: "\f106";
				float: left;
				margin: 1px 5px 25px -3px;
			}
			#tab-panel-mstba-menus-help .dashicons-before:before {
				vertical-align: bottom;
			}

			/** Help tab content */
			.mstba-help-version {
				opacity: .6;
			}
		</style>
	<?php

}  // end function


/**
 * Create and display plugin help tab content.
 *
 * @since 1.0.0
 *
 * @uses ddw_mstba_info_values() To get some strings of info values.
 */
function ddw_mstba_help_tab_content() {

	$mstba_info = (array) ddw_mstba_info_values();

	$mstba_space_helper = '<div style="height: 10px;"></div>';

	/** Content: Multisite Toolbar Additions plugin */
	echo '<h3>' . __( 'Plugin', 'multisite-toolbar-additions' ) . ': ' . __( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' ) . ' <small class="mstba-help-version">v' . MSTBA_PLUGIN_VERSION . '</small></h3>';

	/** Super Admin menu help */
	if ( defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) && MSTBA_SUPER_ADMIN_NAV_MENU ) {

		ddw_mstba_help_content_super_admin_menu();

	}  // end if
	
	/** Restricted Site Admin menu help */
	if ( is_multisite() && ( defined( 'MSTBA_RESRICTED_ADMIN_NAV_MENU' ) && MSTBA_RESRICTED_ADMIN_NAV_MENU ) ) {

		echo $mstba_space_helper;
		
		ddw_mstba_help_content_resctricted_admin_menu();

	}  // end if

	/** Further help content */
	echo $mstba_space_helper . '<p><strong>' . __( 'Other, recommended Multisite &amp; Toolbar plugins:', 'multisite-toolbar-additions' ) . '</strong></strong>' .
		'<blockquote><p>&raquo; <a href="' . esc_url( $mstba_info[ 'url_ddw_series' ] ) . '" target="_new" title="David Decker ' . __( 'Toolbar plugin series', 'multisite-toolbar-additions' ) . ' ...">' . __( 'My Toolbar plugin series', 'multisite-toolbar-additions' ) . ' (David Decker, DECKERWEB.de)</a>' .
		'<br />&raquo; <a href="' . esc_url( $mstba_info[ 'url_wporg_more' ] ) . '" target="_new" title="' . __( 'More plugins at WordPress.org', 'multisite-toolbar-additions' ) . ' ...">' . __( 'More plugins at WordPress.org', 'multisite-toolbar-additions' ) . '</a></p></blockquote>';

	echo $mstba_space_helper . '<p><h4 style="font-size: 1.1em;">' . __( 'Important plugin links:', 'multisite-toolbar-additions' ) . '</h4>' .

		'<a class="button" href="' . esc_url( $mstba_info[ 'url_plugin' ] ) . '" target="_new" title="' . esc_html__( 'Plugin website', 'multisite-toolbar-additions' ) . '">' . __( 'Plugin website', 'multisite-toolbar-additions' ) . '</a>' .

		'&nbsp;&nbsp;<a class="button" href="' . esc_url( $mstba_info[ 'url_wporg_faq' ] ) . '" target="_new" title="' . esc_html_x( 'FAQ', 'Translators: help tab info', 'multisite-toolbar-additions' ) . '">' . _x( 'FAQ', 'Translators: help tab info', 'multisite-toolbar-additions' ) . '</a>' .

		'&nbsp;&nbsp;<a class="button" href="' . esc_url( $mstba_info[ 'url_wporg_forum' ] ) . '" target="_new" title="' . esc_html_x( 'Support', 'Translators: help tab info', 'multisite-toolbar-additions' ) . '">' . _x( 'Support', 'Translators: help tab info', 'multisite-toolbar-additions' ) . '</a>' .

		'&nbsp;&nbsp;<a class="button" href="' . esc_url( $mstba_info[ 'url_snippets' ] ) . '" target="_new" title="' . esc_html__( 'Code Snippets for Customization', 'multisite-toolbar-additions' ) . '">' . __( 'Code Snippets', 'multisite-toolbar-additions' ) . '</a>' .

		'&nbsp;&nbsp;<a class="button" href="' . esc_url( $mstba_info[ 'url_fb_group' ] ) . '" target="_new" title="' . esc_html__( 'Facebook Group', 'multisite-toolbar-additions' ) . '">' . __( 'Facebook Group', 'multisite-toolbar-additions' ) . '</a>' .

		'&nbsp;&nbsp;<a class="button" href="' . esc_url( $mstba_info[ 'url_translate' ] ) . '" target="_new" title="' . esc_html__( 'Translations', 'multisite-toolbar-additions' ) . '">' . __( 'Translations', 'multisite-toolbar-additions' ) . '</a>' .

		'&nbsp;&nbsp;<a class="button" href="' . esc_url( $mstba_info[ 'url_donate' ] ) . '" target="_new" title="' . esc_html__( 'Donate', 'multisite-toolbar-additions' ) . '"><strong>' . __( 'Donate', 'multisite-toolbar-additions' ) . '</strong></a></p>';

	echo sprintf(
		'<p><a href="%1$s" target="_blank" rel="nofollow noopener noreferrer" title="%2$s">%2$s</a> &#x000A9; %3$s <a href="%4$s" target="_blank" rel="noopener noreferrer" title="%5$s">%5$s</a></p>',
		esc_url( $mstba_info[ 'url_license' ] ),
		esc_attr( $mstba_info[ 'license' ] ),
		ddw_mstba_coding_years(),
		esc_url( $mstba_info[ 'author_uri' ] ),
		esc_html( $mstba_info[ 'author' ] )
	);

}  // end function


/**
 * Help content part: for super admin menu.
 *
 * @since 1.0.0
 */
function ddw_mstba_help_content_super_admin_menu() {

	echo '<h4 style="font-size: 1.1em;">' . sprintf(
			__( 'Special custom menu for %s', 'multisite-toolbar-additions' ),
			'<em>' . __( 'Super Admins', 'multisite-toolbar-additions' ) . '</em>'
		) . ':</h4>';

	echo '<blockquote><p>' . __( 'All menu items via a Custom Menu here - and at all other places in the Toolbar (a.k.a. Admin Bar) - are only visible and accessable for Super Admins. That means in a Multisite Environment all Admins who can manage the Network. In regular WordPress (single) installs these are users with the Administrator user role.', 'multisite-toolbar-additions' ) . '</p></blockquote>' .
	'<blockquote><p><strong>' . __( 'Added Menu Location by the plugin - only for Super Admins:', 'multisite-toolbar-additions' ) . ' "' . __( 'Multisite Toolbar Menu', 'multisite-toolbar-additions' ) . '" &mdash; <em>' . __( 'How to use it?', 'multisite-toolbar-additions' ) . '</em></strong></p></blockquote>' .
	'<blockquote><ul>' . 
		'<li>' . sprintf( __( 'Create a new menu, set a name like %s', 'multisite-toolbar-additions' ), '<code>Super Admin Toolbar</code>' ) . '</li>' .
		'<li>' . __( 'Setup your links, might mostly be custom links, or any other...', 'multisite-toolbar-additions' ) . '</li>' .
		'<li>' . __( 'Save the new menu to the plugin\'s menu location. That\'s it :)', 'multisite-toolbar-additions' ) . '</li>' .
	'<ul></blockquote>' .
	'<blockquote><p><em>' . __( 'Please note:', 'multisite-toolbar-additions' ) . '</em> ' . __( 'Every parent item = one main toolbar entry! So best would be to only use one parent item and set all other items as children.', 'multisite-toolbar-additions' ) . ' (<a href="https://www.dropbox.com/s/7u83c0g5ehk4ozq/screenshot-5.png" target="_new">' . __( 'See also this screenshot.', 'multisite-toolbar-additions' ) . '</a>)' .
		'<br />' . __( 'Also, only Super Admins can edit this menu, all other users/ roles will be blocked!', 'multisite-toolbar-additions' ) . '</p></blockquote>';

}  // end function


/**
 * Help content part: for restricted site admin menu.
 *
 * @since 1.0.0
 */
function ddw_mstba_help_content_resctricted_admin_menu() {

	echo '<h4 style="font-size: 1.1em;">' . sprintf(
			__( 'In Multisite: Special restricted custom menu for %s', 'multisite-toolbar-additions' ),
			'<em>' . __( 'Site Admins', 'multisite-toolbar-additions' ) . '</em>'
		) . ':</h4>';

	echo '<blockquote><p>' . __( 'This custom menu is almost identical to the custom menu for Super Admins (see above), with two differences', 'multisite-toolbar-additions' ) . ':</p></blockquote>';

	echo '<blockquote><ul>' .
			'<li>' . __( 'Only Super Admins can setup and edit this menu', 'multisite-toolbar-additions' ) . '</li>' .
			'<li>' . __( 'Site Admins can see this menu but are not able to edit it', 'multisite-toolbar-additions' ) . '</li>' .
		'<ul></blockquote>';

}  // end function


add_action( 'after_menu_locations_table', 'ddw_mstba_help_info_menu_locations' );
/**
 * Help info content on "Menu Locations" tab on nav-menus.php.
 *
 * @since 1.7.0
 *
 * @uses ddw_mstba_string_super_admin_menu_location()
 * @uses ddw_mstba_string_restricted_admin_menu_location()
 */
function ddw_mstba_help_info_menu_locations() {

	/** Bail early if no Super Admin */
	if ( ! is_super_admin()
		|| (
			( defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) && ! MSTBA_SUPER_ADMIN_NAV_MENU )
				&& ( defined( 'MSTBA_RESRICTED_ADMIN_NAV_MENU' ) && ! MSTBA_RESRICTED_ADMIN_NAV_MENU )
			)
	) {
		return;
	}

	$super_menu = ( defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) && MSTBA_SUPER_ADMIN_NAV_MENU ) ? TRUE : FALSE;
	$admin_menu = ( is_multisite() && ( defined( 'MSTBA_RESRICTED_ADMIN_NAV_MENU' ) && MSTBA_RESRICTED_ADMIN_NAV_MENU ) ) ? TRUE : FALSE;

	$output = sprintf(
		'<br />&nbsp;<p>' . __( '%s only for Super Admins.', 'multisite-toolbar-additions' ) . ' ' . __( 'This is provided by the plugin %s.', 'multisite-toolbar-additions' ) . '</p>',
		( $super_menu && $admin_menu ) ? _x( 'The following menu locations above are', 'plural (in Multisite)', 'multisite-toolbar-additions' ) : _x( 'The following menu location above is', 'singular (non-Multisite)', 'multisite-toolbar-additions' ),
		'<em>' . __( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' ) . '</em>'
	);

	$output .= sprintf(
		'<p>%s%s</p>',
		'&rarr; ' . ddw_mstba_string_super_admin_menu_location(),
		( $admin_menu ) ? '<br />&rarr; ' . ddw_mstba_string_restricted_admin_menu_location() : ''
	);

	$output .= sprintf(
		'<p class="description">%s</p>',
		__( 'See help tab on top right corner for more usage instructions.', 'multisite-toolbar-additions' )
	);

	echo $output;

}  // end function


add_filter( 'debug_information', 'ddw_mstba_site_health_add_debug_info', 9 );
/**
 * Add additional plugin related info to the Site Health Debug Info section.
 *   (Only relevant for WordPress 5.2 or higher)
 *
 * @link https://make.wordpress.org/core/2019/04/25/site-health-check-in-5-2/
 *
 * @since 2.0.0
 *
 * @param array $debug_info Array holding all Debug Info items.
 * @return array Modified array of Debug Info.
 */
function ddw_mstba_site_health_add_debug_info( $debug_info ) {

	$string_undefined = esc_html_x( 'Undefined', 'Site Health Debug info', 'multisite-toolbar-additions' );
	$string_enabled   = esc_html_x( 'Enabled', 'Site Health Debug info', 'multisite-toolbar-additions' );
	$string_disabled  = esc_html_x( 'Disabled', 'Site Health Debug info', 'multisite-toolbar-additions' );

	/** Add our Debug info */
	$debug_info[ 'multisite-toolbar-additions' ] = array(
		'label'  => esc_html__( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' ) . ' (' . esc_html__( 'Plugin', 'multisite-toolbar-additions' ) . ')',
		'fields' => array(

			/** Various values */
			'mstba_plugin_version' => array(
				'label' => __( 'Plugin version', 'multisite-toolbar-additions' ),
				'value' => MSTBA_PLUGIN_VERSION,
			),
			'mstba_install_type' => array(
				'label' => __( 'WordPress Install Type', 'multisite-toolbar-additions' ),
				'value' => ( is_multisite() ? esc_html__( 'Multisite install', 'multisite-toolbar-additions' ) : esc_html__( 'Single Site install', 'multisite-toolbar-additions' ) ),
			),

			/** Multisite Toolbar Additions constants */
			'MSTBA_DISPLAY_NETWORK_ITEMS' => array(
				'label' => 'MSTBA_DISPLAY_NETWORK_ITEMS',
				'value' => ( ! defined( 'MSTBA_DISPLAY_NETWORK_ITEMS' ) ? $string_undefined : ( MSTBA_DISPLAY_NETWORK_ITEMS ? $string_enabled : $string_disabled ) ),
			),
			'MSTBA_DISPLAY_SUBSITE_ITEMS' => array(
				'label' => 'MSTBA_DISPLAY_SUBSITE_ITEMS',
				'value' => ( ! defined( 'MSTBA_DISPLAY_SUBSITE_ITEMS' ) ? $string_undefined : ( MSTBA_DISPLAY_SUBSITE_ITEMS ? $string_enabled : $string_disabled ) ),
			),
			'MSTBA_SUPER_ADMIN_NAV_MENU' => array(
				'label' => 'MSTBA_SUPER_ADMIN_NAV_MENU',
				'value' => ( ! defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) ? $string_undefined : ( MSTBA_SUPER_ADMIN_NAV_MENU ? $string_enabled : $string_disabled ) ),
			),
			'MSTBA_RESRICTED_ADMIN_NAV_MENU' => array(
				'label' => 'MSTBA_RESRICTED_ADMIN_NAV_MENU',
				'value' => ( ! defined( 'MSTBA_RESRICTED_ADMIN_NAV_MENU' ) ? $string_undefined : ( MSTBA_RESRICTED_ADMIN_NAV_MENU ? $string_enabled : $string_disabled ) ),
			),
			'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP' => array(
				'label' => 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP',
				'value' => ( ! defined( 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP' ) ? $string_undefined : ( MSTBA_DISPLAY_NETWORK_EXTEND_GROUP ? $string_enabled : $string_disabled ) ),
			),
			'MSTBA_DISPLAY_SITE_EXTEND_GROUP' => array(
				'label' => 'MSTBA_DISPLAY_SITE_EXTEND_GROUP',
				'value' => ( ! defined( 'MSTBA_DISPLAY_SITE_EXTEND_GROUP' ) ? $string_undefined : ( MSTBA_DISPLAY_SITE_EXTEND_GROUP ? $string_enabled : $string_disabled ) ),
			),
			'MSTBA_DISPLAY_SITE_GROUP' => array(
				'label' => 'MSTBA_DISPLAY_SITE_GROUP',
				'value' => ( ! defined( 'MSTBA_DISPLAY_SITE_GROUP' ) ? $string_undefined : ( MSTBA_DISPLAY_SITE_GROUP ? $string_enabled : $string_disabled ) ),
			),
			'MSTBA_DISPLAY_RESOURCES' => array(
				'label' => 'MSTBA_DISPLAY_RESOURCES',
				'value' => ( ! defined( 'MSTBA_DISPLAY_RESOURCES' ) ? $string_undefined : ( MSTBA_DISPLAY_RESOURCES ? $string_enabled : $string_disabled ) ),
			),
			'MSTBA_DISPLAY_LIST_EDIT_MENUS' => array(
				'label' => 'MSTBA_DISPLAY_LIST_EDIT_MENUS',
				'value' => ( ! defined( 'MSTBA_DISPLAY_LIST_EDIT_MENUS' ) ? $string_undefined : ( MSTBA_DISPLAY_LIST_EDIT_MENUS ? $string_enabled : $string_disabled ) ),
			),

		),  // end array
	);

	/** Return modified Debug Info array */
	return $debug_info;

}  // end function


if ( ! function_exists( 'ddw_wp_site_health_remove_percentage' ) ) :

	add_action( 'admin_head', 'ddw_wp_site_health_remove_percentage', 100 );
	/**
	 * Remove the "Percentage Progress" display in Site Health feature as this will
	 *   get users obsessed with fullfilling a 100% where there are non-problems!
	 *
	 * @link https://make.wordpress.org/core/2019/04/25/site-health-check-in-5-2/
	 *
	 * @since 2.0.0
	 */
	function ddw_wp_site_health_remove_percentage() {

		/** Bail early if not on WP 5.2+ */
		if ( version_compare( $GLOBALS[ 'wp_version' ], '5.2-beta', '<' ) ) {
			return;
		}

		?>
			<style type="text/css">
				.site-health-progress {
					display: none;
				}
			</style>
		<?php

	}  // end function

endif;


if ( ! function_exists( 'ddw_genesis_tweak_plugins_submenu' ) && defined( 'PARENT_THEME_VERSION' ) ) :

	add_action( 'admin_menu', 'ddw_genesis_tweak_plugins_submenu', 11 );
	/**
	 * Add Genesis submenu redirecting to "genesis" plugin search within the
	 *   WordPress.org Plugin Directory. For Genesis 2.10.0 or higher this
	 *   replaces the "Genesis Plugins" submenu which only lists plugins from
	 *   StudioPress - but there are many more from the community.
	 *
	 * @since 2.0.0
	 *
	 * @uses remove_submenu_page()
	 * @uses add_submenu_page()
	 */
	function ddw_genesis_tweak_plugins_submenu() {

		/** Remove the StudioPress plugins submenu */
		if ( class_exists( 'Genesis_Admin_Plugins' ) ) {
			remove_submenu_page( 'genesis', 'genesis-plugins' );
		}

		/** Add a Genesis community plugins submenu */
		add_submenu_page(
			'genesis',
			esc_html__( 'Genesis Plugins from the Plugin Directory', 'multisite-toolbar-additions' ),
			esc_html__( 'Genesis Plugins', 'multisite-toolbar-additions' ),
			'install_plugins',
			esc_url( network_admin_url( 'plugin-install.php?s=genesis&tab=search&type=term' ) )
		);

	}  // end function

endif;


add_action( 'in_plugin_update_message-' . MSTBA_PLUGIN_BASEDIR . 'multisite-toolbar-additions.php', 'ddw_mstba_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for regular single site installs, and for Multisite
 *         installs where the plugin is activated Network-wide.
 *
 * @since 1.9.2
 *
 * @param object $data
 * @param object $response
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_mstba_plugin_update_message( $data, $response ) {

	if ( isset( $data[ 'upgrade_notice' ] ) ) {

		printf(
			'<div class="update-message mstba-update-message">%s</div>',
			wpautop( $data[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function


add_action( 'after_plugin_row_wp-' . MSTBA_PLUGIN_BASEDIR . 'multisite-toolbar-additions.php', 'ddw_mstba_multisite_subsite_plugin_update_message', 10, 2 );
/**
 * On Plugins page add visible upgrade/update notice in the overview table.
 *   Note: This action fires for Multisite installs where the plugin is
 *         activated on a per site basis.
 *
 * @since 1.9.2
 *
 * @param string $file
 * @param object $plugin
 * @return string Echoed string and markup for the plugin's upgrade/update
 *                notice.
 */
function ddw_mstba_multisite_subsite_plugin_update_message( $file, $plugin ) {

	if ( is_multisite() && version_compare( $plugin[ 'Version' ], $plugin[ 'new_version' ], '<' ) ) {

		$wp_list_table = _get_list_table( 'WP_Plugins_List_Table' );

		printf(
			'<tr class="plugin-update-tr"><td colspan="%s" class="plugin-update update-message notice inline notice-warning notice-alt"><div class="update-message mstba-update-message"><h4 style="margin: 0; font-size: 14px;">%s</h4>%s</div></td></tr>',
			$wp_list_table->get_column_count(),
			$plugin[ 'Name' ],
			wpautop( $plugin[ 'upgrade_notice' ] )
		);

	}  // end if

}  // end function



/**
 * Optionally tweaking Plugin API results to make more useful recommendations to
 *   the user.
 *
 * @since 1.9.1
 */

add_filter( 'ddwlib_plir/filter/plugins', 'ddw_mstba_register_plugin_recommendations' );
/**
 * Register specific plugins for the class "DDWlib Plugin Installer
 *   Recommendations".
 *   Note: The top-level array keys are plugin slugs from the WordPress.org
 *         Plugin Directory.
 *
 * @since 1.9.1
 * @since 1.9.2 Improved for Multisite context.
 *
 * @param array $plugins Array holding all plugin recommendations, coming from
 *                        the class and the filter.
 * @return array Filtered and merged array of all plugin recommendations.
 */
function ddw_mstba_register_plugin_recommendations( array $plugins ) {
  
	/** Remove our own slug when we are already active :) */
	if ( isset( $plugins[ 'multisite-toolbar-additions' ] ) ) {
		$plugins[ 'multisite-toolbar-additions' ] = null;
	}

	/** When NOT in Multisite mode just return the core registered plugins */
	if ( ! is_multisite() ) {
		return $plugins;
	}

	/** In Multisite, add new keys, tweak existing */
	else {

		/** Register our additional plugin recommendations */
		$mstba_plugins = array(
			'multisite-post-duplicator' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
			'multisite-plugin-manager' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
			'multisite-enhancements' => array(
				'featured'    => 'no',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
			'wordpress-mu-domain-mapping' => array(
				'featured'    => 'no',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
			'multisite-language-switcher' => array(
				'featured'    => 'no',
				'recommended' => 'no',
				'popular'     => 'yes',
			),
			'multilingual-press' => array(
				'featured'    => 'no',
				'recommended' => 'no',
				'popular'     => 'yes',
			),
			'duplicator' => array(
				'featured'    => 'yes',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
			'multisite-clone-duplicator' => array(
				'featured'    => 'no',
				'recommended' => 'yes',
				'popular'     => 'yes',
			),
		);

		/** Tweak existing keys */
		$plugins[ 'updraftplus' ] = null;

		/** Merge with the existing recommendations and return */
		return array_merge( $plugins, $mstba_plugins );

	}  // end if

}  // end function

/** Optionally add string translations for the library */
if ( ! function_exists( 'ddwlib_plir_strings_plugin_installer' ) ) :

	add_filter( 'ddwlib_plir/filter/strings/plugin_installer', 'ddwlib_plir_strings_plugin_installer' );
	/**
	 * Optionally, make strings translateable for included library "DDWlib Plugin
	 *   Installer Recommendations".
	 *   Strings:
	 *    - "Newest" --> tab in plugin installer toolbar
	 *    - "Version:" --> label in plugin installer plugin card
	 *
	 * @since 1.9.3
	 * @since 2.0.0 Added new strings.
	 *
	 * @param array $strings Holds all filterable strings of the library.
	 * @return array Array of tweaked translateable strings.
	 */
	function ddwlib_plir_strings_plugin_installer( $strings ) {

		$strings[ 'newest' ] = _x(
			'Newest',
			'Plugin installer: Tab name in installer toolbar',
			'multisite-toolbar-additions'
		);

		$strings[ 'version' ] = _x(
			'Version:',
			'Plugin card: plugin version',
			'multisite-toolbar-additions'
		);

		$strings[ 'ddwplugins_tab' ] = _x(
			'deckerweb Plugins',
			'Plugin installer: Tab name in installer toolbar',
			'multisite-toolbar-additions'
		);

		$strings[ 'tab_title' ] = _x(
			'deckerweb Plugins',
			'Plugin installer: Page title',
			'multisite-toolbar-additions'
		);

		$strings[ 'tab_slogan' ] = __( 'Great helper tools for Site Builders to save time and get more productive', 'multisite-toolbar-additions' );

		$strings[ 'tab_info' ] = sprintf(
			__( 'You can use any of our free plugins or premium plugins from %s', 'multisite-toolbar-additions' ),
			'<a href="https://deckerweb-plugins.com/" target="_blank" rel="nofollow noopener noreferrer">' . $strings[ 'tab_title' ] . '</a>'
		);

		$strings[ 'tab_newsletter' ] = __( 'Join our Newsletter', 'multisite-toolbar-additions' );

		$strings[ 'tab_fbgroup' ] = __( 'Facebook User Group', 'multisite-toolbar-additions' );

		return $strings;

	}  // end function

endif;  // function check

/** Include class DDWlib Plugin Installer Recommendations */
require_once( MSTBA_PLUGIN_DIR . 'includes/ddwlib-plir/ddwlib-plugin-installer-recommendations.php' );
