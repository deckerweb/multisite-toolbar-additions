<?php
/**
 * Resources items - located under the WordPress logo on the far left...,
 *    mostly in the external link group there :).
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Resources
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2013-2025, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
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
 * Resources group (WordPress logo)
 *
 * @since 1.4.0
 */
	/** Coding Standards - Handbooks (sub levels of "Documentation") */
	$mstba_tb_items[ 'resources_codingstandards_php' ] = array(
		'parent' => 'documentation',
		'title'  => __( 'PHP Coding Standards', 'multisite-toolbar-additions' ),
		'href'   => 'https://make.wordpress.org/core/handbook/coding-standards/php/',
	);

	$mstba_tb_items[ 'resources_codingstandards_css' ] = array(
		'parent' => 'documentation',
		'title'  => __( 'CSS Coding Standards', 'multisite-toolbar-additions' ),
		'href'   => 'https://make.wordpress.org/core/handbook/coding-standards/css/',
	);

	$mstba_tb_items[ 'resources_codingstandards_javascript' ] = array(
		'parent' => 'documentation',
		'title'  => __( 'JavaScript Coding Standards', 'multisite-toolbar-additions' ),
		'href'   => 'https://make.wordpress.org/core/handbook/coding-standards/javascript/',
	);

	$mstba_tb_items[ 'resources_codingstandards_html' ] = array(
		'parent' => 'documentation',
		'title'  => __( 'HTML Coding Standards', 'multisite-toolbar-additions' ),
		'href'   => 'https://make.wordpress.org/core/handbook/coding-standards/html/',
	);


	/** Get Involved - "Make WordPress" */
	$mstba_tb_items[ 'resources_getinvolved' ] = array(
		'parent' => 'wp-logo-external',
		'title'  => __( 'Get Involved', 'multisite-toolbar-additions' ),
		'href'   => 'https://make.wordpress.org/',
	);

		$mstba_tb_items[ 'resources_getinvolved_core' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Core Development Updates', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/core/',
		);

		$mstba_tb_items[ 'resources_getinvolved_coretrac' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Core Components Development', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/core/components/',
		);

		$mstba_tb_items[ 'resources_getinvolved_plugins' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Plugin Development', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/plugins/',
		);

		$mstba_tb_items[ 'resources_getinvolved_themes' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Theme Development', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/themes/',
		);

		$mstba_tb_items[ 'resources_getinvolved_translations' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Translations/ L10n', 'multisite-toolbar-additions' ),
			'href'   => 'https://translate.wordpress.org/projects',
		);

		$mstba_tb_items[ 'resources_getinvolved_polyglots' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Polyglots/ i18n', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/polyglots/',
		);

		$mstba_tb_items[ 'resources_getinvolved_glotpress' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'GlotPress', 'multisite-toolbar-additions' ),
			'href'   => 'http://blog.glotpress.org/',
		);

		$mstba_tb_items[ 'resources_getinvolved_mobile' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Mobile Apps', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/mobile/',
		);

		$mstba_tb_items[ 'resources_getinvolved_uidesign' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'UI Design', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/ui/',
		);

		$mstba_tb_items[ 'resources_getinvolved_accessibility' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Accessibility', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/accessibility/',
		);

		$mstba_tb_items[ 'resources_getinvolved_support' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Help supporting', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/support/',
		);

		$mstba_tb_items[ 'resources_getinvolved_meta' ] = array(
			'parent' => $resources_getinvolved,
			'title'  => __( 'Help Make WordPress.org', 'multisite-toolbar-additions' ),
			'href'   => 'https://make.wordpress.org/meta/',
		);

	/** WordPress Answers at StackExchange */
	$mstba_tb_items[ 'resources_wpse' ] = array(
		'parent' => 'wp-logo-external',
		'title'  => __( 'WordPress Answers (SE)', 'multisite-toolbar-additions' ),
		'href'   => 'http://wordpress.stackexchange.com/',
	);
