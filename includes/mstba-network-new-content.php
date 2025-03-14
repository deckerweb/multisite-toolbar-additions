<?php
/**
 * Additional "Add New" section within Network admin area.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Network Items
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.4.0
 */

/**
 * Prevent direct access to this file.
 *
 * @since 1.4.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


add_action( 'wp_before_admin_bar_render', 'ddw_mstba_remove_members_item', 15 );
/**
 * Helper function in light of ddw_mstba_network_admin_new_content(),
 *    to remove unneeded duplication from third-party plugin "Members".
 *
 * @since 1.4.0
 *
 * @uses  is_network_admin()
 * @uses  WP_Admin_Bar::remove_node()
 */
function ddw_mstba_remove_members_item() {

	global $wp_admin_bar;

	$remove_nodes = apply_filters(
		'mstba_filter_remove_network_new_content_nodes',
		array(
			'members-new-role',			// Members Plugin (Justin Tadlock)
			'gravityforms-new-form',		// Gravity Forms
		)
	);

	/** Remove unneeded toolbar item */
	if ( is_network_admin() ) {

		foreach ( (array) $remove_nodes as $remove_node ) {

			//$wp_admin_bar->remove_node( 'members-new-role' );
			//$wp_admin_bar->remove_node( 'gravityforms-new-form' );
			$wp_admin_bar->remove_node( esc_attr( $remove_node ) );

		}  // end foreach

	}  // end if is_network_admin() check

}  // end function


/**
 * Helper function to return filterable hook priority for the super admin nav menu.
 *
 * @since  1.4.0
 *
 * @param  $mstba_network_admin_new_content_priority
 *
 * @return int Hook priority for Network admin 'new-content' section.
 */
function ddw_mstba_network_admin_new_content_priority() {

	/** Our default value */
	$mstba_network_admin_new_content_priority = 50;

	/** Make function output filterable */
	return apply_filters(
		'mstba_filter_network_admin_new_content_priority',
		absint( $mstba_network_admin_new_content_priority )
	);

}  // end function


add_action(
	'admin_bar_menu',
	'ddw_mstba_network_admin_new_content',
	ddw_mstba_network_admin_new_content_priority()
);
/**
 * Add an additional "Add New" section within Network admin area to hook in
 *    special Network-only items.
 *
 * @since  1.4.0
 *
 * @uses   ddw_mstba_network_admin_new_content_priority() For (optionally) setting the hook priority via filter.
 * @uses   WP_Admin_Bar::add_menu()
 * @uses   network_admin_url()
 *
 * @param  $mstba_network_new_title
 *
 * @global mixed $wp_admin_bar
 */
function ddw_mstba_network_admin_new_content() {

	global $wp_admin_bar;

	/** Setup visible title in the same way as regular (site) 'new-content' section; plus "(MS)" string */
	$mstba_network_new_title = sprintf(
		'<span class="ab-icon"></span><span class="ab-label">%s (%s)</span>',
		_x( 'New', 'Translators: Network admin bar menu group label', 'multisite-toolbar-additions' ),
		_x( 'MS', 'Translators: Additional mark for Multisite to differentiate from regular sites', 'multisite-toolbar-additions' )
	);

	/** Add main item "+ New" */
	$wp_admin_bar->add_menu( array(   
		'id'     => 'new-content',  
		'title'  => $mstba_network_new_title,  
		'href'   => network_admin_url( 'site-new.php' ),  
		'meta'   => array(
			'class'  => 'mstba-network-new-content',
			'target' => '',
			'title'  => _x( 'Add New - within Network', 'Translators: Network admin bar menu group label', 'multisite-toolbar-additions' )
		)
	) );

		/** Add more sub items */
		$wp_admin_bar->add_node( array(
			'parent' => 'new-content', 
			'id'     => 'new-content-site',  
			'title'  => __( 'Website', 'multisite-toolbar-additions' ),  
			'href'   => network_admin_url( 'site-new.php' ),  
			'meta'   => array(
				'target' => '',
				'title'  => _x( 'Website or Blog', 'Translators: add new site/ blog', 'multisite-toolbar-additions' )
			)
		) );

		$wp_admin_bar->add_node( array(
			'parent' => 'new-content', 
			'id'     => 'new-content-network-user',  
			'title'  => __( 'User (Network)', 'multisite-toolbar-additions' ),  
			'href'   => network_admin_url( 'user-new.php' ),  
			'meta'   => array(
				'target' => '',
				'title'  => _x( 'User in Network', 'Translators: add new user via network admin', 'multisite-toolbar-additions' )
			)
		) );

}  // end function
