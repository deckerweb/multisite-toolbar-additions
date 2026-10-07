<?php
/** Map shared updater messages to this plugin’s sole textdomain. */
defined( 'ABSPATH' ) || exit;
/**
 * Translate an English updater message when it is displayed, not in its cache.
 *
 * @param string $message English source string from the shared updater.
 * @return string Host translation or the unrecognized source message.
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
        default:
            return $message;
    }
};
