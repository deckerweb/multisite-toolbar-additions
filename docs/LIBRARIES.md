# Shared components

[English](LIBRARIES.md) · [Deutsch](LIBRARIES-de.md)

For single WordPress sites and Multisite networks. Both have been supported since 2012.

## deckerweb Library 1.1.0

Pinned unchanged runtime from [deckerweb-plugin-library, v1.1.0](https://github.com/deckerweb/deckerweb-plugin-library/tree/v1.1.0/lib), GPL-2.0-or-later, David Decker. The highest compatible host is elected under bootstrap protocol 2. Local catalogs/icons work without requests. Online mode is optional and initially disabled; the prefilled source is the public raw GitHub catalog. Shared settings belong to the network in Multisite. A participating network-activated host is needed to serve the catalog and settings inside Network Admin. Host translations take precedence; Library messages merge into that host domain.

Installation checks capabilities, nonce, dependencies, identity, archive safety and SHA-256 before normalization. Activation is separate. Library install records and caches are shared and retained while another host is installed, even inactive. Host removal uses the shared protocol-three cleanup, preserving data while another active or inactive host is installed. No other installed host is modified here.

## deckerweb Updater 2.2.0

Pinned official runtime, copied byte-for-byte from the stable release. Source: [official runtime](https://github.com/deckerweb/deckerweb-updater/blob/v2.2.0/runtime/deckerweb-github-release-updater-v2.php), GPL-2.0-or-later, David Decker. Public repository mode only; no token is needed or collected. Host-owned translations and artwork are supplied after init. The first loaded V2 class is shared; an older class remains compatible with the existing public constructor but lacks the new translation callback. Update those older host copies for fully localized component errors.

The host validates candidate identity, offered version and WordPress/PHP requirements before replacement, including the Core bulk path. Automatic updates remain controlled by WordPress. The optional Library bridge uses approved metadata and package checksums while its online catalog is enabled. With online mode disabled, normal direct GitHub checks remain available. The host retains its candidate validation.

## Footer and release history

The structured footer retains API v1 and coexists with an older Footer class. The changelog renderer is derived from the public Advanced Scripts QuickNav [shared renderer](https://github.com/deckerweb/advanced-scripts-quicknav), David Decker, GPL-2.0-or-later. Both print escaped local documents; recent history has seven releases, full history remains in the Wiki. Assets are scoped to the plugin settings page.

## Network traffic

WordPress update checks send repository requests to api.github.com; explicit downloads use GitHub’s package hosts. Optional catalog retrieval uses raw.githubusercontent.com. IP address and normal HTTP metadata are visible to these hosts; no site content, user list or credentials are transmitted by this public host. No telemetry, remote fonts or star-count requests are added.
