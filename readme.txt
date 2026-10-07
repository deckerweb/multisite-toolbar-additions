=== Multisite Toolbar Additions ===
Contributors: ddecker
Donate link: https://paypal.me/deckerweb
Tags: toolbar, admin bar, multisite, navigation
Requires at least: 6.7
Tested up to: 7.1
Requires PHP: 8.2
Stable tag: 4.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WordPress menus and useful administration shortcuts in the toolbar.

== Description ==

A configurable WordPress menu in the toolbar, with useful website and network shortcuts. Part of QuickNav; available on individual sites and Multisite networks.

Unpublished preparation for 4.1.0 based on 4.0.0: shared Leitstand uploader routing and own plugin/theme ZIP pages with drag-and-drop and metadata preview. The released 4.0.0 ZIP is unchanged.

* Select a source site and menu independently of your theme. Keep root entries separate or group them under the menu’s name. A custom label is optional.
* Choose first/last, before/after a reference item or the right side. Show the menu on the frontend, in administration or both. Choose one to ten child levels, or all. Missing references fall back to the end.
* Plugin and Theme additions appear last under New. Each addition and ZIP submenu has its own switch: Plugins on, Themes off. Upload links use active Leitstand pages or dedicated local plugin/theme pages with drag-and-drop and bounded metadata previews; WordPress performs installation.
* Use one network-wide menu source with optional viewing by website administrators. Shared menus remain editable only by super administrators. Destination permissions still apply; website expansion is bounded.
* Library 0.6.0 offers curated plugins with prerequisite/hash checks and optional online catalog updates. Updater 2.1.0 uses normal WordPress updates. Assets are local; no telemetry is collected.

== Installation ==

Requires WordPress 6.7+ and PHP 8.2+. Install the released ZIP via Plugins → Add New → Upload Plugin. Open Settings → Toolbar Additions. For Multisite network activation, use Network Admin → Settings → Toolbar Additions. Site-only activation uses the active site’s settings page and still requires a super administrator for network settings. The optional catalog installer needs PHP ZipArchive. Review custom 3.x snippets before a major upgrade.

== Frequently Asked Questions ==

= How do I select my toolbar menu? =

Create a normal navigation menu and select its source site and menu in the settings. Network activation defaults to the main website; site-only activation defaults to the active website. Activate the plugin on the source website or across the network so that shared-menu protection can run. The legacy mstba_menu location remains a fallback.

= Can I change position and visibility? =

Yes: first, last, before or after a selected toolbar item, or on the right. Choose frontend, admin or both, and the permitted audience. If an anchor is missing, the menu falls back to the end.

= Can ordinary site admins edit a shared menu? =

The toolbar audience and permission to edit its source menu are separate. Shared Multisite source menus are protected against unauthorized admin, REST and Customizer changes.

= Which upload shortcuts are enabled by default? =

Plugin ZIP submenu and the + New plugin entry are enabled. Theme ZIP submenu and the + New theme entry are disabled. Each has a separate switch.

= How do plugin updates work? =

The bundled deckerweb Updater 2.1.0 checks this fixed public repository and caches release metadata. WordPress controls individual, bulk and automatic updates. The plugin does not enable automatic updates. Packages must match the offered version, plugin identity and platform requirements before replacing the installed copy.

= What happens when I deactivate or uninstall? =

Deactivation keeps all settings and WordPress menus. Uninstall clears this plugin’s update cache. Toolbar settings are retained unless the deletion option is enabled for that site or network. On physical removal every network’s own choice is respected. Shared Library cleanup runs only after its last installed host is removed, including inactive hosts; its own deletion option is separate. Installed plugins, navigation menus and foreign content remain untouched.

= Does the library contact GitHub on every page? =

No. Its bundled catalog and artwork work locally. Package downloads contact their declared hosts when requested. Optional online catalog retrieval is disabled by default and uses caching and backoff when enabled.

FAQ by topic: https://github.com/deckerweb/multisite-toolbar-additions/wiki/FAQ-English

== Changelog ==

= 4.0.0 · 2026-10-01 =

* New: Configure the source menu, audience, frontend/admin visibility, position, grouping and child levels.
* New: Plugin and Theme shortcuts have separate switches; Plugins are enabled and Themes disabled by default.
* New: Upload theme ZIPs through a dedicated page using the WordPress installer, including network installation.
* New: The bundled deckerweb Library 0.2.0 offers approved plugins with package and dependency checks.
* Improved: Menu data is reused per request; additional website shortcuts are limited for large networks.
* Improved: Plugin and Theme entries appear last under New; an empty group label follows the WordPress menu name.
* Improved: Local documentation, update artwork and a shared footer are available in English and German.
* Fixed: Shared menus are protected from unauthorized classic, REST and Customizer changes; menu output and settings are validated.
* Fixed: Cached WordPress update offers retain the plugin’s own icons.
* Misc: Requires WordPress 6.7 and PHP 8.2. German informal and formal language resources are included.

= 3.1.0 · 2025-04-03 =

* New: The toolbar remains available in the fullscreen block editor.
* New: Git Updater and DevKit Pro shortcuts are supported; Git Updater can install and update this plugin.
* Improved: German language resources include native PHP translation catalogs.

= 3.0.0 · 2025-03 =

* Improved: Administration shortcuts use a smaller set of current integrations.
* Misc: The restricted website-administrator menu, obsolete integrations and the former recommendations library were removed; the shared super-administrator menu remains.
* Misc: Distribution moved from WordPress.org to direct ZIP installation and GitHub.

= 2.0.1 · 2019-09-23 =

* Improved: The recommendations library 1.5.0 caches data to reduce repeated requests.

= 2.0.0 · 2019-05-04 =

* New: Dedicated plugin/theme ZIP upload pages and installer shortcuts are available.
* New: Site Health includes plugin diagnostics on WordPress 5.2 or newer.
* New: A DECKERWEB plugin newsletter is available.
* Improved: Recommendations library 1.4.0 and German Du/Sie translations were updated.

= 1.9.4 · 2018-11-03 =

* Improved: Recommendations library 1.2.0 improves installer styles and Dark Mode compatibility.

= 1.9.3 · 2018-10-01 =

* New: A Facebook group provides community support for DECKERWEB plugins.
* Improved: Recommendations library 1.1.0 improves upload areas and plugin cards, including visible version numbers.
* Improved: German translations were updated.

== Upgrade Notice ==

= 4.0.0 =
Requires WordPress 6.7/PHP 8.2. Review custom 3.x snippets; WordPress menus are retained.

== Credits ==

David Decker – DECKERWEB, GPL-2.0-or-later.
https://github.com/deckerweb/multisite-toolbar-additions/blob/master/docs/LIBRARIES.md
