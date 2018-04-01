<?php
/**
 * Display links to active plugins/extensions settings' pages: Code Snippets.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.1.0
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
 * Code Snippets (free, by Shea Bunge)
 *
 * @since 1.1.0
 *
 * @uses  current_user_can()
 */
/** If plugin is network activated, display stuff in 'network_admin' */
if ( current_user_can( 'manage_network_snippets' ) ) {

	$mstba_tb_items[ 'networkext_codesnippets' ] = array(
		'parent' => $networkextgroup,
		'title'  => __( 'Network Code Snippets', 'multisite-toolbar-additions' ),
		'href'   => network_admin_url( 'admin.php?page=snippets' ),
		'meta'   => array(
			'target' => '',
			'title'  => __( 'Network Code Snippets', 'multisite-toolbar-additions' )
		)
	);

	/** Check for snippets network install capability */
	if ( current_user_can( 'install_network_snippets' ) ) {

		$mstba_tb_items[ 'networkext_codesnippets_add' ] = array(
			'parent' => $networkext_codesnippets,
			'title'  => __( 'Add new Snippet', 'multisite-toolbar-additions' ),
			'href'   => network_admin_url( 'admin.php?page=snippet' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Add new Snippet', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'networkext_codesnippets_import' ] = array(
			'parent' => $networkext_codesnippets,
			'title'  => __( 'Import', 'multisite-toolbar-additions' ),
			'href'   => ! function_exists( 'cs_uninstall' ) ? network_admin_url( 'admin.php?page=import-code-snippets' ) : network_admin_url( 'admin.php?page=import-snippets' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Import', 'multisite-toolbar-additions' )
			)
		);

		/** Also, hook into 'new-content' section */
		if ( is_network_admin() ) {

			$mstba_tb_items[ 'networkext_newcontent_codesnippet' ] = array(
				'parent' => 'new-content',
				'title'  => __( 'Code Snippet', 'multisite-toolbar-additions' ),
				'href'   => network_admin_url( 'admin.php?page=snippet' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Add new Code Snippet', 'multisite-toolbar-additions' )
				)
			);

		}  // end-if is_network_admin() check

	}  // end-if cap check

}  // end-if multisite check

/** Otherwise, if plugin is only site activated, display stuff in a sub site admin */
if ( current_user_can( 'manage_snippets' ) ) {

	$mstba_tb_items[ 'siteext_codesnippets' ] = array(
		'parent' => $siteextgroup,
		'title'  => $mstba_multisite_check . __( 'Code Snippets', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'admin.php?page=snippets' ),
		'meta'   => array(
			'target' => '',
			'title'  => $mstba_multisite_check . __( 'Code Snippets', 'multisite-toolbar-additions' )
		)
	);

	/** Check for snippets site install capability */
	if ( current_user_can( 'install_snippets' ) ) {

		$mstba_tb_items[ 'siteext_codesnippets_add' ] = array(
			'parent' => $siteext_codesnippets,
			'title'  => __( 'Add new Snippet', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'admin.php?page=snippet' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Add new Snippet', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_codesnippets_import' ] = array(
			'parent' => $siteext_codesnippets,
			'title'  => __( 'Import', 'multisite-toolbar-additions' ),
			'href'   => ! function_exists( 'cs_uninstall' ) ? admin_url( 'admin.php?import=code-snippets' ) : admin_url( 'admin.php?page=import-snippets' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Import', 'multisite-toolbar-additions' )
			)
		);

		/** Also, hook into 'new-content' section */
		if ( ! is_network_admin() ) {

			$mstba_tb_items[ 'siteext_newcontent_codesnippet' ] = array(
				'parent' => 'new-content',
				'title'  => __( 'Code Snippet', 'multisite-toolbar-additions' ),
				'href'   => admin_url( 'admin.php?page=snippet' ),
				'meta'   => array(
					'target' => '',
					'title'  => __( 'Add new Code Snippet', 'multisite-toolbar-additions' )
				)
			);

		}  // end-if !is_network_admin() check

	}  // end-if cap check

}  // end-if ! multisite check