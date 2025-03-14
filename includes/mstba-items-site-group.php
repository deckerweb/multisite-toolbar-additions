<?php
/**
 * Display additional site-specific items - global (Multisite & non-Multisite installs).
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Site: Group
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
 * Display additional site-specific items (as sub level items on subsite ? item)
 *
 * @since 1.0.0
 */
	/** Add Widgets & Nav Menu items only within wp-admin */
	if ( is_admin() ) {

		$mstba_tb_items[ 'widgets' ] = array(
			'parent' => $sitegroup,
			'title'  => __( 'Widgets', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'widgets.php' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Widgets', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'navmenus' ] = array(
			'parent' => $sitegroup,
			'title'  => __( 'Nav Menus', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'nav-menus.php' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Nav Menus', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'mcbase' ] = array(
			'parent' => $sitegroup,
			'title'  => __( 'Manage Content', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'edit.php?post_type=page' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Manage Content', 'multisite-toolbar-additions' )
			)
		);

	}  // end if is_admin() check

	$mstba_tb_items[ 'navmenus-add' ] = array(
		'parent' => is_admin() ? $navmenus : 'menus',
		'title'  => __( 'Add new Menu', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'nav-menus.php?action=edit&menu=0' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Add new Menu', 'multisite-toolbar-additions' )
		)
	);

	if ( ! is_network_admin() ) {

		$mstba_tb_items[ 'new-navmenu' ] = array(
			'parent' => 'new-content',
			'title'  => __( 'Nav Menu', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'nav-menus.php?action=edit&menu=0' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Add new Nav Menu', 'multisite-toolbar-additions' )
			)
		);

	}  // end if

	$mstba_tb_items[ 'navmenus-locations' ] = array(
		'parent' => is_admin() ? $navmenus : 'menus',
		'title'  => __( 'Menu Locations', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'nav-menus.php?action=locations' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x( 'Menu Locations', 'Translators: For the tooltip', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'edit-pages' ] = array(
		'parent' => is_admin() ? $mcbase : $sitegroup,
		'title'  => __( 'Edit Pages', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'edit.php?post_type=page' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Edit Pages', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'edit-posts' ] = array(
		'parent' => is_admin() ? $mcbase : $sitegroup,
		'title'  => __( 'Edit Posts', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'edit.php' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Edit Posts', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'medialibrary' ] = array(
		'parent' => is_admin() ? $mcbase : $sitegroup,
		'title'  => __( 'Media Library', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'upload.php' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Media Library', 'multisite-toolbar-additions' )
		)
	);

		$mstba_tb_items[ 'media-new' ] = array(
			'parent' => $medialibrary,
			'title'  => __( 'Upload File(s)', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'media-new.php' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Upload File(s)', 'multisite-toolbar-additions' )
			)
		);


	/** Subsite-specific: Theme Editor */
	if ( !( defined( 'DISALLOW_FILE_EDIT' ) && DISALLOW_FILE_EDIT ) && current_user_can( 'edit_themes' ) ) {

		$mstba_tb_items[ 'editthemes' ] = array(
			'parent' => ! is_admin() ? 'themes' : $sitegroup,
			'title'  => __( 'Theme Editor', 'multisite-toolbar-additions' ),
			'href'   => is_multisite() ? network_admin_url( 'theme-editor.php?file=style.css&amp;theme=' . get_stylesheet() ) : admin_url( 'theme-editor.php?file=style.css&amp;theme=' . get_stylesheet() ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Theme Editor', 'multisite-toolbar-additions' )
			)
		);

		if ( is_admin() ) {

			$mstba_tb_items[ 'editthemes-customize' ] = array(
				'parent' => $editthemes,
				'title'  => __( 'Customizer', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'customize.php' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Customizer', 'multisite-toolbar-additions' )
				)
			);

		}  // end if

	} elseif ( is_admin() ) {

		/** If Theme Editor is disabled, just display the Theme Customizer item */
		$mstba_tb_items[ 'editthemes' ] = array(
			'parent' => $sitegroup,
			'title'  => __( 'Theme Customizer', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'customize.php' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Theme Customizer', 'multisite-toolbar-additions' )
			)
		);

	}  // end if cap/ is_admin() check

	/** Check for custom background support */
	if ( current_theme_supports( 'custom-background' ) ) {

		$mstba_tb_items[ 'editthemes-background' ] = array(
			'parent' =>  ! is_admin() ? 'themes' : $editthemes,
			'title'  => __( 'Custom Background', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'themes.php?page=custom-background' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Custom Background', 'multisite-toolbar-additions' )
			)
		);

	}  // end if

	/** Check for custom header support */
	if ( current_theme_supports( 'custom-header' ) ) {

		$mstba_tb_items[ 'editthemes-header' ] = array(
			'parent' => ! is_admin() ? 'themes' : $editthemes,
			'title'  => __( 'Custom Header', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'themes.php?page=custom-header' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Custom Header', 'multisite-toolbar-additions' )
			)
		);

	}  // end if


	/** Special external tools - Site-specific */
	$mstba_tb_items[ 'view_site_pingdom' ] = array(
		'parent' => is_network_admin() ? 'ddw-mstba-main-site-view' : ( is_admin() ? $view_site : 'dashboard' ),
		'title'  => __( 'Pingdom Tools', 'multisite-toolbar-additions' ),
		'href'   => 'https://tools.pingdom.com/',	//esc_url( 'http://tools.pingdom.com/fpt/#!/' . home_url( '/' ) ),
		'meta'   => array(
			'title' => __( 'Pingdom Tools - Check Your URL', 'multisite-toolbar-additions' )
		)
	);

	$mstba_tb_items[ 'view_site_googlepagespeed' ] = array(
		'parent' => is_network_admin() ? 'ddw-mstba-main-site-view' : ( is_admin() ? $view_site : 'dashboard' ),
		'title'  => __( 'Google Page Speed', 'multisite-toolbar-additions' ),
		'href'   => esc_url( 'https://developers.google.com/speed/pagespeed/insights/?url=' . home_url( '/' ) ),
		'meta'   => array(
			'title' => __( 'Google Page Speed', 'multisite-toolbar-additions' )
		)
	);


/**
 * Include additional "Widgets" items, provided by supported plugins.
 *
 * @since 1.5.0
 */
if ( defined( 'MSTBA_DISPLAY_SITE_GROUP' ) && MSTBA_DISPLAY_SITE_GROUP ) {

	/** Include code part with Widgets support items (plugins) */
	require_once( MSTBA_PLUGIN_DIR . 'includes/mstba-items-widgets.php' );

}  // end if
