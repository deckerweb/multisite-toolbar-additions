<?php
/**
 * Additional "Nav Menu" items that are available, including special support for
 *    our extra menu locations for Super Admins and Site Admins.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Nav Menus Items
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2014-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.7.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.7.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'admin_bar_menu', 'ddw_mstba_list_edit_nav_menus', 500 );
/**
 * Add edit menu items for our custom toolbar menus.
 *
 * @since  1.7.0
 *
 * @uses   ddw_mstba_get_menu_id_from_menu_location()
 * @uses   wp_get_nav_menus()
 * @uses   is_admin()
 * @uses   is_super_admin()
 * @uses   is_multisite()
 *
 * @global mixed $GLOBALS[ 'wp_admin_bar' ]
 */
function ddw_mstba_list_edit_nav_menus() {

	/** Bail early if no support granted */
	if ( ( defined( 'MSTBA_DISPLAY_LIST_EDIT_MENUS' ) && ! MSTBA_DISPLAY_LIST_EDIT_MENUS )
		/*&& ! is_super_admin()*/
		|| ( is_multisite() && ! current_user_can( 'manage_network' ) )
	) {

		return;

	}  // end if

	/** Set default value */
	$navmenugroup = 'ddw-mstba-navmenugroup';

	/** Add sub group for site "Menus" item */
	$GLOBALS[ 'wp_admin_bar' ]->add_group( array(
		'parent' => is_admin() ? 'ddw-mstba-navmenus' : 'menus',
		'id'     => $navmenugroup
	) );

	$edit_menu_id_super_admin = ddw_mstba_get_menu_id_from_menu_location( 'mstba_menu' );
	$edit_menu_id_admin       = ddw_mstba_get_menu_id_from_menu_location( 'mstba_restricted_admin_menu' );

	$nav_menus = wp_get_nav_menus();

	foreach ( $nav_menus as $nav_menu ) {

		/** Check for menu + cap */
		if ( is_super_admin() /*current_user_can( 'edit_theme_options' )*/
			&& $edit_menu_id_super_admin != $nav_menu->term_id
			&& $edit_menu_id_admin != $nav_menu->term_id
		) {

			$GLOBALS[ 'wp_admin_bar' ]->add_node( array(
				'id'     => 'mstba-edit-menu-' . $nav_menu->term_id,
				'parent' => $navmenugroup,
				'title'  => __( 'Edit Menu:', 'multisite-toolbar-additions' ) . ' ' . esc_html( $nav_menu->name ),
				'href'   => admin_url( 'nav-menus.php?action=edit&menu=' . $nav_menu->term_id . '' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Edit Menu:', 'multisite-toolbar-additions' ) . ' ' . esc_html( $nav_menu->name )
				)
			) );

		}  // end if

	}  // end foreach

}  // end function


add_action( 'admin_bar_menu', 'ddw_mstba_edit_custom_toolbar_menus', 1000 );
/**
 * Add edit menu items for our custom toolbar menus.
 *
 * @since 1.7.0
 *
 * @uses  ddw_mstba_get_menu_id_from_menu_location()
 * @uses  get_term()
 * @uses  is_super_admin()
 * @uses  is_multisite()
 *
 * @global mixed $GLOBALS[ 'wp_admin_bar' ]
 */
function ddw_mstba_edit_custom_toolbar_menus() {

	/** Bail early if no super admin */
	if ( ! is_super_admin() ) {

		return;

	}  // end if

	/** Set default value */
	$admin_navmenugroup = 'ddw-mstba-admin_navmenugroup';

	/** Add sub group for site "Menus" item */
	$GLOBALS[ 'wp_admin_bar' ]->add_group( array(
		'parent' => is_admin() ? 'ddw-mstba-navmenus' : 'menus',
		'id'     => $admin_navmenugroup,
		'meta'   => array( 'class' => 'ab-sub-secondary' )
	) );

	/** Get menu IDs of our custom menus */
	$edit_menu_id_super_admin = ddw_mstba_get_menu_id_from_menu_location( 'mstba_menu' );
	$edit_menu_id_admin       = ddw_mstba_get_menu_id_from_menu_location( 'mstba_restricted_admin_menu' );

	$menu_obj_super_admin     = get_term( $edit_menu_id_super_admin, 'nav_menu' );
	$menu_obj_admin           = get_term( $edit_menu_id_admin, 'nav_menu' );

	/** Check for menu + cap */
	if ( ! empty( $edit_menu_id_super_admin ) ) {

		$GLOBALS[ 'wp_admin_bar' ]->add_node( array(
			'id'     => 'mstba-superadmin-menu',
			'parent' => $admin_navmenugroup,
			'title'  => __( 'Toolbar Menu:', 'multisite-toolbar-additions' ) . ' ' . esc_html( $menu_obj_super_admin->name ),
			'href'   => admin_url( 'nav-menus.php?action=edit&menu=' . $edit_menu_id_super_admin . '' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Edit Super Admin Toolbar Menu:', 'multisite-toolbar-additions' ) . ' ' . esc_html( $menu_obj_super_admin->name )
			)
		) );

	}  // end if

	/** Check for menu, cap + Multisite */
	if ( ! empty( $edit_menu_id_admin ) && is_multisite() ) {

		$GLOBALS[ 'wp_admin_bar' ]->add_node( array(
			'id'     => 'mstba-siteadmin-menu',
			'parent' => $admin_navmenugroup,
			'title'  => __( 'Toolbar Menu:', 'multisite-toolbar-additions' ) . ' ' . esc_html( $menu_obj_admin->name ),
			'href'   => admin_url( 'nav-menus.php?action=edit&menu=' . $edit_menu_id_admin . '' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Edit Site Admin Toolbar Menu:', 'multisite-toolbar-additions' ) . ' ' . esc_html( $menu_obj_admin->name )
			)
		) );

	}  // end if

}  // end function
