<?php
/**
 * Display additional site-specific items - manage content (Multisite & non-Multisite installs).
 *
 * @package    Multisite Toolbar Additions
 * @subpackage Site: Manage Content
 * @author     David Decker - DECKERWEB
 * @copyright  Copyright (c) 2012-2018, David Decker - DECKERWEB
 * @license    https://opensource.org/licenses/GPL-2.0 GPL-2.0+
 * @link       https://github.com/deckerweb/multisite-toolbar-additions
 * @link       https://deckerweb.de/twitter
 *
 * @since      1.7.1
 */

 /**
 * Prevent direct access to this file.
 *
 * @since 1.7.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Sorry, you are not allowed to access this file directly.' );
}


/**
 * Additional "default" post types for our "manage content" section.
 *
 * @since  1.7.1
 *
 * @return array $post_types Array of post type IDs plus their label strings.
 */
function ddw_mstba_manage_content_default_post_types() {

	/** Helper strings */
	$string_landingpages = __( 'Landing Pages', 'multisite-toolbar-additions' );
	$string_products     = __( 'Products', 'multisite-toolbar-additions' );
	$string_portfolio    = __( 'Portfolio Items', 'multisite-toolbar-additions' );
	$string_events       = __( 'Events', 'multisite-toolbar-additions' );
	$string_downloads    = __( 'Downloads', 'multisite-toolbar-additions' );
	$string_galleries    = __( 'Galleries', 'multisite-toolbar-additions' );
	$string_persons      = __( 'Persons', 'multisite-toolbar-additions' );
	$string_sermons      = __( 'Sermons', 'multisite-toolbar-additions' );

	/** Array of post types & labels */
	$post_types = apply_filters(
		'mstba_filter_manage_content_default_post_types',
		array(

			/** Content */
			'news' => array(
				'label' => __( 'News', 'multisite-toolbar-additions' ),
			),
			'document' => array(
				'label' => __( 'Documents', 'multisite-toolbar-additions' ),
			),
			'landing_page' => array(
				'label' => $string_landingpages,
			),
			'landing-page' => array(
				'label' => $string_landingpages,
			),

			/** Products */
			'product' => array(
				'label' => $string_products,
			),
			'wpsc-product' => array(
				'label' => $string_products,
			),
			'shopp_product' => array(
				'label' => $string_products,
			),

			/** Portfolio stuff */
			'portfolio' => array(
				'label' => $string_portfolio,
			),
			'portfolio_item' => array(
				'label' => $string_portfolio,
			),
			'project' => array(
				'label' => __( 'Projects', 'multisite-toolbar-additions' ),
			),

			/** Events */
			'event' => array(
				'label' => $string_events,
			),
			'rhcevents' => array(
				'label' => $string_events,
			),
			'tribe_events' => array(
				'label' => $string_events,
			),
			'sc_event' => array(
				'label' => $string_events,
			),
			'ctc_event' => array(
				'label' => $string_events,
			),
			'ajde_event' => array(
				'label' => $string_events,
			),

			/** Download managers */
			'download' => array(
				'label' => $string_downloads,
			),
			'dedo_download' => array(
				'label' => $string_downloads,
			),
			'dlm-download' => array(
				'label' => $string_downloads,
			),

			/** Galleries/ Sliders */
			'soliloquy' => array(
				'label' => __( 'Sliders', 'multisite-toolbar-additions' ),
			),

			'envira' => array(
				'label' => $string_galleries,
			),

			'maxgallery' => array(
				'label' => $string_galleries,
			),

			'mg_items' => array(
				'label' => __( 'Media Grid Items', 'multisite-toolbar-additions' ),
			),

			'gg_galleries' => array(
				'label' => $string_galleries,
			),

			/** Media files */
			'ctc_sermon' => array(
				'label' => $string_sermons,
			),

			/** Other stuff */
			'team-member' => array(
				'label' => $string_persons,
			),
			'ctc_person' => array(
				'label' => $string_persons,
			),
			'aeprofiles' => array(
				'label' => $string_persons,
			),

			/** Listings */
			'listing' => array(
				'label' => __( 'Listings', 'multisite-toolbar-additions' ),
			),

			'job_listing' => array(
				'label' => __( 'Job Listings', 'multisite-toolbar-additions' ),
			),

			'resume' => array(
				'label' => __( 'Resumes', 'multisite-toolbar-additions' ),
			),

			'tablepress' => array(
				'label'     => __( 'Tables', 'multisite-toolbar-additions' ),
				'no_cpt'    => 'yes',
				'admin_url' => admin_url( 'admin.php?page=tablepress' ),
			),

			'contentbox' => array(
				'label'     => __( 'Content Boxes', 'multisite-toolbar-additions' ),
			),

		)  // end array
	);

	/** Return array */
	return $post_types;

}  // end function


add_action( 'admin_bar_menu', 'ddw_mstba_manage_content_popular_post_types', 100 );
/**
 * Add our list of additional "manage content" post types to this Toolbar
 *    section - dynamically, based on active post types.
 *
 * @since  1.7.1
 *
 * @uses   ddw_mstba_manage_content_default_post_types()
 * @uses   post_type_exists()
 *
 * @global $GLOBALS[ 'wp_admin_bar' ]
 */
function ddw_mstba_manage_content_popular_post_types() {

	foreach ( (array) ddw_mstba_manage_content_default_post_types() as $post_type => $cpt_value ) {

		if ( post_type_exists( $post_type )
			|| ( isset( $cpt_value[ 'no_cpt' ] ) && 'yes' === $cpt_value[ 'no_cpt' ] )
		) {

			$edit_label = sprintf(
				__( 'Edit %s', 'multisite-toolbar-additions' ),
				$cpt_value[ 'label' ]
			);

			/** Add Toolbar sub item(s) */
			$GLOBALS[ 'wp_admin_bar' ]->add_node( array(  
				'parent' => 'ddw-mstba-mcbase',  
				'id'     => 'edit-' . $post_type,  
				'title'  => $edit_label,  
				'href'   => ( ! isset( $cpt_value[ 'admin_url' ] ) ) ? admin_url( 'edit.php?post_type=' . $post_type . '' ) : $cpt_value[ 'admin_url' ],  
				'meta'   => array(
					'target' => '',
					'title'  => $edit_label
				)
			) );

		}  // end if

	}  // end foreach

}  // end function
