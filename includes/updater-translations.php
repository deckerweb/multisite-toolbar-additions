<?php
/** Copy into the host adapter and replace the multisite-toolbar-additions textdomain with its literal domain. */
defined( 'ABSPATH' ) || exit;
/**
 * Resolve an updater source string in the host textdomain.
 * @param string $message English updater message.
 * @return string Translated host message, or original source text.
 */
return static function ( string $message ): string {
    // Literal calls let the host's normal translation extractor collect every source string.
    switch ( $message ) {
        case 'Private mode must be boolean.':
            return __( 'Private mode must be boolean.', 'multisite-toolbar-additions' );
        case 'Invalid authentication provider.':
            return __( 'Invalid authentication provider.', 'multisite-toolbar-additions' );
        case 'The plugin must be installed in a stable slug directory.':
            return __( 'The plugin must be installed in a stable slug directory.', 'multisite-toolbar-additions' );
        case 'Invalid GitHub repository URL.':
            return __( 'Invalid GitHub repository URL.', 'multisite-toolbar-additions' );
        case 'The private update could not be authorized. Check the repository credentials and refresh updates.':
            return __( 'The private update could not be authorized. Check the repository credentials and refresh updates.', 'multisite-toolbar-additions' );
        case 'Could not create the update download file.':
            return __( 'Could not create the update download file.', 'multisite-toolbar-additions' );
        case 'The private update download failed. Check credentials and try again.':
            return __( 'The private update download failed. Check credentials and try again.', 'multisite-toolbar-additions' );
        case 'Could not access the update filesystem.':
            return __( 'Could not access the update filesystem.', 'multisite-toolbar-additions' );
        case 'GitHub release does not contain the plugin main file.':
            return __( 'GitHub release does not contain the plugin main file.', 'multisite-toolbar-additions' );
        case 'Could not prepare the GitHub release package.':
            return __( 'Could not prepare the GitHub release package.', 'multisite-toolbar-additions' );
        case 'See the release on GitHub.':
            return __( 'See the release on GitHub.', 'multisite-toolbar-additions' );
        case 'Git Updater is active. If a deckerweb installation or update fails, temporarily deactivate Git Updater and retry. Reactivate it afterwards if other plugins or themes need it. Only leave it disabled when those extensions have another reliable update provider.':
            return __( 'Git Updater is active. If a deckerweb installation or update fails, temporarily deactivate Git Updater and retry. Reactivate it afterwards if other plugins or themes need it. Only leave it disabled when those extensions have another reliable update provider.', 'multisite-toolbar-additions' );
        case 'Manage installed plugins':
            return __( 'Manage installed plugins', 'multisite-toolbar-additions' );
        case 'Dismiss this notice':
            return __( 'Dismiss this notice', 'multisite-toolbar-additions' );
        case 'Permission denied.':
            return __( 'Permission denied.', 'multisite-toolbar-additions' );
        case 'Public catalog callbacks require both providers and cannot be used in private mode.':
            return __( 'Public catalog callbacks require both providers and cannot be used in private mode.', 'multisite-toolbar-additions' );
        case 'The approved release could not be verified.':
            return __( 'The approved release could not be verified.', 'multisite-toolbar-additions' );
        case 'The approved release changed. Refresh updates first.':
            return __( 'The approved release changed. Refresh updates first.', 'multisite-toolbar-additions' );
        default:
            return $message;
    }
};
