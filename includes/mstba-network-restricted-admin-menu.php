<?php
/**
 * Additional Toolbar menu for administrators (of sub sites) but only editable
 *    by super admins.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Custom Menus
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2018, David Decker - DECKERWEB
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


/**
 * Helper function to return filterable hook priority for the super admin nav menu.
 *
 * @since  1.7.0
 *
 * @return int Hook priority for restricted admin nav menu.
 */
function ddw_mstba_restricted_admin_menu_hook_priority() {

	/**
	 * Our default value for priority: '9999' (value was always the default of this plugin).
	 * This way it will be the last item of the left section of the toolbar.
	 * Customizeable via filter hook 'mstba_filter_super_admin_nav_menu_priority'.
	 */
	$mstba_restricted_admin_nav_menu_priority = 9999;

	/** Make function output filterable */
	return apply_filters(
		'mstba_filter_restricted_admin_nav_menu_priority',
		absint( $mstba_restricted_admin_nav_menu_priority )
	);

}  // end function


add_action( 'init', 'ddw_mstba_restricted_admin_menu_init', 20 );
/**
 * Setup a custom nav menu intended towards site admins (and editable by super
 *    admins only).
 *
 * @since 1.7.0
 *
 * @uses  is_super_admin()
 * @uses  register_nav_menu()
 * @uses  ddw_mstba_string_restricted_admin_menu_location()
 * @uses  current_user_can()
 * @uses  ddw_mstba_restricted_admin_menu_cap()
 * @uses  ddw_mstba_restricted_admin_menu_hook_priority()
 */
function ddw_mstba_restricted_admin_menu_init() {

	/** Bail early if no support */
	if ( defined( 'MSTBA_RESRICTED_ADMIN_NAV_MENU' ) && ! MSTBA_RESRICTED_ADMIN_NAV_MENU ) {

		return;

	}  // end if

	/** Only register & add additional toolbar menu for super admins */
	if ( is_super_admin() ) {

		/** Register the menu */
		register_nav_menu( 'mstba_restricted_admin_menu', ddw_mstba_string_restricted_admin_menu_location( FALSE ) );

	}  // end if

	/** Add menu logic/ structure etc. */
	if ( current_user_can( ddw_mstba_restricted_admin_menu_cap() ) /*|| current_user_can( 'administrator' )*/ ) {

		add_action(
			'admin_bar_menu',
			'ddw_mstba_build_restricted_admin_menu',
			ddw_mstba_restricted_admin_menu_hook_priority()
		);

	}  // end if

}  // end function


/**
 * Build the custom menu for the toolbar and hook it in.
 *
 * @since  1.7.0
 *
 * @uses   has_nav_menu() To check if menu is registered.
 * @uses   get_nav_menu_locations() To get menu locations.
 * @uses   wp_get_nav_menu_object() To get menu object.
 * @uses   wp_get_nav_menu_items() To get menu args.
 *
 * @param  obj $wp_admin_bar
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_build_restricted_admin_menu( $wp_admin_bar ) {

	global $wp_admin_bar;
	
	/** Set unique menu slug */
	$mstba_menu_name = 'mstba_restricted_admin_menu';

	/** Only add menu items if location exists and an actual menu is applied to it */
	if ( has_nav_menu( 'mstba_restricted_admin_menu' ) ) {

		if ( ( $mstba_menu_locations = get_nav_menu_locations() )
			&& isset( $mstba_menu_locations[ $mstba_menu_name ] )
		) {

			$mstba_menu_locations = get_nav_menu_locations();
			$mstba_menu           = wp_get_nav_menu_object( $mstba_menu_locations[ $mstba_menu_name ] );
			$mstba_menu_items     = (array) wp_get_nav_menu_items( $mstba_menu->term_id );

			foreach( $mstba_menu_items as $mstba_menu_item ) {

				/** Retrieve the args from the custom menu */
				$mstba_menu_args = array(
					'id'    => 'mstba_admin_' . $mstba_menu_item->ID,
					'title' => $mstba_menu_item->title,
					'href'  => esc_url_raw( $mstba_menu_item->url ),
					'meta'  => array(
						'target' => $mstba_menu_item->target,
						'title'  => $mstba_menu_item->attr_title,
            			'class'  => 'mstba siteadmins ' . implode( ' ', $mstba_menu_item->classes ),
            		)
            	);  // end of array

				/** Check for parent menu items to allow for threaded menus */
				if ( $mstba_menu_item->menu_item_parent ) {

					$mstba_menu_args[ 'parent' ] = 'mstba_admin_' . $mstba_menu_item->menu_item_parent;

				}  // end if

				/** Only hook items if the menu is setup for our menu location */
				if ( $mstba_menu_item ) {

					$wp_admin_bar->add_node( $mstba_menu_args );

				}  // end if

				unset( $mstba_menu_args );

			}  // end foreach

		}  // end if menu location check

	}  // end if check if a 'mstba_menu' menu exists

}  // end function
