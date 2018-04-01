<?php
/**
 * Display links to active plugins/extensions settings' pages: Smart Tabber Widget.
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Plugin/Extension Support
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


/**
 * Smart Tabber Widget (premium, by Smart Plugins/ Milan Petrovic)
 *
 * @since 1.4.1
 */
	/** List the (site) menu items */
	$mstba_tb_items[ 'siteext_smarttabberwidget' ] = array(
		'parent' => is_admin() ? $widgets : 'widgets',
		'title'  => __( 'Smart Tabber Widget', 'multisite-toolbar-additions' ),
		'href'   => admin_url( 'options-general.php?page=smart-tabber-widget&tab=settings' ),
		'meta'   => array(
			'target' => '',
			'title'  => _x(
				'Smart Tabber Widget - Settings',
				'Translators: For the tooltip',
				'multisite-toolbar-additions'
			)
		)
	);

		$mstba_tb_items[ 'siteext_smarttabberwidget_stylebuilder' ] = array(
			'parent' => $siteext_smarttabberwidget,
			'title'  => __( 'Style Builder', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-tabber-widget&tab=styles' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Style Builder', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smarttabberwidget_addstyle' ] = array(
			'parent' => $siteext_smarttabberwidget,
			'title'  => __( 'Create new Style', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-tabber-widget&tab=styles&task=new&job=0' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Create new Style', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smarttabberwidget_exportimport' ] = array(
			'parent' => $siteext_smarttabberwidget,
			'title'  => __( 'Export/ Import', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-tabber-widget&tab=impexp' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'Export/ Import', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smarttabberwidget_about' ] = array(
			'parent' => $siteext_smarttabberwidget,
			'title'  => __( 'About', 'multisite-toolbar-additions' ),
			'href'   => admin_url( 'options-general.php?page=smart-tabber-widget&tab=about' ),
			'meta'   => array(
				'target' => '',
				'title'  => __( 'About', 'multisite-toolbar-additions' )
			)
		);

		$mstba_tb_items[ 'siteext_smarttabberwidget_support' ] = array(
			'parent' => $siteext_smarttabberwidget,
			'title'  => __( 'Support Forum', 'multisite-toolbar-additions' ),
			'href'   => esc_url( 'http://forum.smartplugins.info/forums/forum/smart/smart-tabber-widget/' ),
			'meta'   => array(
				'title' => __( 'Support Forum', 'multisite-toolbar-additions' )
			)
		);