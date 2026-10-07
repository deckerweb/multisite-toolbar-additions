# FAQ by topic

[English](FAQ-English.md) · [Deutsch](FAQ-Deutsch.md) · [Home](Home.md)

## Getting started

### Is Multisite required?

No. The plugin works on individual WordPress sites and Multisite networks. Network shortcuts appear only where applicable.

### Where are the settings?

Single site: Settings → Toolbar Additions. Network activation: Network Admin → Settings → Toolbar Additions. With site-only activation in Multisite, a super administrator uses the active website’s Settings → Toolbar Additions; settings still apply to the network.

### How do I select my toolbar menu?

Create a normal navigation menu and select its source site and menu in the settings. Network activation defaults to the main website; site-only activation defaults to the active website. Activate the plugin on the source website or across the network so that shared-menu protection can run. The legacy mstba_menu location remains a fallback.

## Your toolbar menu

### What is the default menu title?

The name of the selected WordPress menu. Leave the custom label empty to keep this automatic title.

### Can I change position and visibility?

Yes: first, last, before or after a selected toolbar item, or on the right. Choose frontend, admin or both, and the permitted audience. If an anchor is missing, the menu falls back to the end.

### What does menu depth mean?

One child level includes direct children; two includes their children too. Zero means all available levels. The configurable limit is ten child levels.

### Why is my menu missing on the frontend?

WordPress must display its toolbar for the current user. Also check the plugin switch, audience, frontend visibility, source site and selected menu. The plugin does not force the toolbar on for visitors.

### Can I use my personal toolbar preference?

Yes. The plugin respects WordPress’s user-profile preference for displaying the toolbar on the frontend. It does not enable the frontend toolbar for someone who has hidden it. Menu source, position and shortcut configuration remain site/network settings.

## Multisite and permissions

### Can ordinary site admins edit a shared menu?

The toolbar audience and permission to edit its source menu are separate. Shared Multisite source menus are protected against unauthorized admin, REST and Customizer changes.

## Installation shortcuts

### Which upload shortcuts are enabled by default?

Plugin ZIP submenu and the + New plugin entry are enabled. Theme ZIP submenu and the + New theme entry are disabled. Each has a separate switch.

### Where are the + New additions placed?

Plugin and theme additions are moved to the end of the + New group, including after late-registered content types. WordPress capabilities still determine availability.

### How does Theme ZIP upload work?

The plugin provides an upload page with the native WordPress form and installer. In Multisite installation occurs in Network Admin and requires the appropriate network privileges. It does not replace ZIP validation or WordPress security checks.

## Library and updates

### What is the deckerweb Plugin Library?

A shared installer tab for approved deckerweb plugins. Library 0.6.0 checks package hashes and dependencies, separates installation from activation and uses one elected runtime across participating hosts. The offline catalog includes a preparation preview; online catalog updates are optional and off by default. In Multisite, network-activate a participating host to make the Library available in Network Admin.

### Does the library contact GitHub on every page?

No. Its bundled catalog and artwork work locally. Package downloads contact their declared hosts when requested. Optional online catalog retrieval is disabled by default and uses caching and backoff when enabled.

### How do plugin updates work?

The bundled deckerweb Updater 2.1.0 checks this fixed public repository and caches release metadata. WordPress controls individual, bulk and automatic updates. The plugin does not enable automatic updates. Packages must match the offered version, plugin identity and platform requirements before replacing the installed copy.

## Your data

### What happens when I deactivate or uninstall?

Deactivation keeps all settings and WordPress menus. Uninstall clears this plugin’s update cache. Toolbar settings are retained unless the deletion option is enabled for that site or network. On physical removal every network’s own choice is respected. Shared Library cleanup runs only after its last installed host is removed, including inactive hosts; its own deletion option is separate. Installed plugins, navigation menus and foreign content remain untouched.

## Compatibility and troubleshooting

### Which versions are supported?

WordPress 6.7 or newer and PHP 8.2 or newer. Local integration checks use PHP 8.4; CI also checks PHP 8.2. No PHP 7 compatibility is declared.

### Will my 3.x menu survive the upgrade?

Yes: existing navigation menus remain in WordPress. The legacy mstba_menu location is still recognized. Review the new settings and optional shortcuts after the first upgrade. Keep a backup before replacing a major version.

### Why are some shortcuts absent?

Shortcuts depend on permissions, installed integrations, Multisite context and theme capabilities. Block themes offer the Site Editor; classic themes offer their applicable customization screens. File editor links are opt-in and respect WordPress restrictions.

### How does performance scale with large networks?

Menu data is reused within the request, sites are bounded by the configurable subsite limit, and frontend assets load only when needed. There is no full-network scan on every page. Exact speed still depends on your WordPress installation and other plugins.

## Support and security

### How do I report a problem?

For ordinary questions and bugs, use GitHub Issues or Discussions. For suspected vulnerabilities, use the repository’s private security report form; see SECURITY.md. Include plugin, Library, WordPress and PHP versions plus redacted reproduction steps. Never include credentials or private content.
