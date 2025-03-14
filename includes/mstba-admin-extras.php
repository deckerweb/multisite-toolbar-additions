<?php
/**
 * Helper functions for the admin - plugin links and help tabs.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Admin
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2018, David Decker - DECKERWEB
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
			'url_snippets',
			esc_html_x( 'Code Snippets', 'Plugins page listing', 'multisite-toolbar-additions' ),
			'dashicons-before dashicons-editor-code'
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

	/** Further help content */
	echo $mstba_space_helper . '<p><h4 style="font-size: 1.1em;">' . __( 'Important plugin links:', 'multisite-toolbar-additions' ) . '</h4>' .

		'<a class="button" href="' . esc_url( $mstba_info[ 'url_plugin' ] ) . '" target="_new" title="' . esc_html__( 'Plugin website', 'multisite-toolbar-additions' ) . '">' . __( 'Plugin website', 'multisite-toolbar-additions' ) . '</a>' .

		'&nbsp;&nbsp;<a class="button" href="' . esc_url( $mstba_info[ 'url_snippets' ] ) . '" target="_new" title="' . esc_html__( 'Code Snippets for Customization', 'multisite-toolbar-additions' ) . '">' . __( 'Code Snippets', 'multisite-toolbar-additions' ) . '</a>' .

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
		|| ( defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) && ! MSTBA_SUPER_ADMIN_NAV_MENU )
	) {
		return;
	}

	$super_menu = ( defined( 'MSTBA_SUPER_ADMIN_NAV_MENU' ) && MSTBA_SUPER_ADMIN_NAV_MENU ) ? TRUE : FALSE;

	$output = sprintf(
		'<br />&nbsp;<p>' . __( 'The following menu locations above are only for Super Admins.', 'multisite-toolbar-additions' ) . ' ' . __( 'This is provided by the plugin %s.', 'multisite-toolbar-additions' ) . '</p>',
		'<em>' . __( 'Multisite Toolbar Additions', 'multisite-toolbar-additions' ) . '</em>'
	);

	$output .= sprintf(
		'<p>%s%s</p>',
		'&rarr; ' . ddw_mstba_string_super_admin_menu_location()
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
 * @since 3.0.0 Removed restricted Admin Menu feature
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