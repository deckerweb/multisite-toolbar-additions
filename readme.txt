=== Multisite Toolbar Additions ===
Contributors: deckerweb
Tags: multisite, toolbar, admin-bar, navigation, network
Requires at least: 6.7
Requires PHP: 8.2
Stable tag: 4.0.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Many sites. One move.

== Description ==

A configurable WordPress toolbar menu and useful network/site shortcuts. Supports single sites and Multisite with centralized settings, independent menu source, placement, frontend/admin display, grouping and child depth.

* Direct WordPress menu selection, independent of theme locations; optional network-wide source website.
* First/last, before/after references or right-side position; frontend/admin/both; grouping and child depth.
* Shared Multisite menu protection; audience options with destination capabilities retained.
* Independent + New / ZIP submenu switches; Plugins on and Themes off by default.
* Dedicated theme ZIP page and network installation links; native WordPress upload handlers.
* Network/site/subsite shortcuts, detected integrations, Site Health and fullscreen editor toolbar.
* Bundled deckerweb Library 0.2.0 with nine approved releases and prerequisite/hash checks.
* DECKERWEB GitHub Updater V2, Launch Rail artwork and shared footer.

== Installation ==

Requires **WordPress 6.7+ and PHP 8.2+**. Install the release ZIP through Plugins → Add New → Upload Plugin. In Multisite use network activation. Open Settings → Toolbar Additions, or Network Admin → Settings → Toolbar Additions. The optional catalog installer additionally requires PHP ZipArchive. Test custom 3.x snippets before this major upgrade.

== Documentation ==

https://github.com/deckerweb/multisite-toolbar-additions/blob/master/docs/wiki/English.md



Requires WordPress 6.7+ and PHP 8.2+. Download the installable release ZIP, then use Plugins → Add New → Upload Plugin. In Multisite use the network installer and activate the plugin for the network. WordPress owns installation, file modification restrictions and activation rights. The embedded catalog installer additionally requires PHP ZipArchive; the toolbar itself does not.

Open Settings → Toolbar Additions on a single site. In Multisite use Network Admin → Settings → Toolbar Additions. Settings are shared across the network, not copied into individual sites. Save after making changes. The library has its own shared Settings → deckerweb Library page.

= Toolbar menu =

Choose an existing WordPress navigation menu directly. In Multisite select an active source website, load its menus, select a menu and save. Loading source menus alone does not save changes. Direct selection survives theme changes. The legacy toolbar menu location is only an upgrade fallback.

Select frontend only, administration only or both. Choose separate toolbar root items or group them under one heading. Leave the group label empty to follow the WordPress menu’s name automatically; a custom label overrides it. Empty/nonexistent menus produce no custom toolbar nodes. Menus are only loaded when the user/context can display them.

= Position and depth =

Available positions: first/last on the left, before/after a named Core reference item, or on the right by the account menu. If a reference is absent, the menu falls back to last on the left. Positioning uses public toolbar nodes and happens just before rendering.

Choose all levels or one to ten child levels. One child level means original root entries plus their direct children. The optional grouping heading does not consume a level. Cycles, orphaned entries and duplicate IDs are skipped safely. Mobile nested menus use inline expansion.

= Permissions =

The default audience is administrators on a single site and super administrators in Multisite. Optionally permit website administrators to view the shared menu. Visibility never grants destination permissions. Shared source menus are editable only by super administrators through protected classic/JSON, REST and Customizer flows. Ordinary site menus remain editable. Trusted PHP code using direct storage APIs is outside this capability boundary.

Settings saves require the appropriate capability and a WordPress nonce. Install/upload links require native installation capabilities; site administrators do not gain network installation rights. File editor links are off by default and respect WordPress restrictions.

= Shortcuts and uploads =

Four independent switches:

| Addition | Default |
| --- | --- |
| Plugins under + New | On |
| Themes under + New | Off |
| Plugin ZIP upload sidebar submenu | On |
| Theme ZIP upload sidebar submenu | Off |

Plugin/Theme entries appear at the end of + New. The plugin upload link uses the native installer. The dedicated theme upload page under Appearance uses WordPress’s signed form and Core install/update handling. In Multisite website dashboard links target network administration. Turning off a sidebar link does not disable an otherwise permitted toolbar upload link.

Other switches control network/site management, extra shortcuts below My Sites, menu editing, detected third-party integrations, developer resources and toolbar visibility in the fullscreen block editor. The subsite limit defaults to 25 and ranges from one to 100; only websites already in the toolbar are extended. Block themes receive Site Editor shortcuts; classic themes receive appropriate Customizer/Widgets links. Missing/inactive integrations add no links.

= deckerweb Library =

An additional deckerweb tab on Plugins → Add New shows approved GitHub releases. The ordinary WordPress.org view remains the default. One introduction is shown per administrator, and the catalog can be hidden in the shared Library settings.

Library 0.2.0 bundles nine selected plugins, local icons and GitHub-star snapshots dated 2026-10-01. Stars are not review ratings and are not fetched on every page load. The bundled catalog works offline and causes no catalog requests. Optional online catalog updates are off until explicitly configured with an allowed first-party HTTPS endpoint.

Install and activate are separate actions. Both require capabilities/nonces and recheck approval and prerequisites. Release ZIPs are SHA-256 checked and archives are validated before Core installs them. Existing plugin directories are not overwritten by catalog installation. Builder dependencies are explained before installation; hiding the catalog does not disable updates/dependency checks for already managed plugins. The library starts once even when several host plugins embed it.

This GitHub build includes the external catalog installer. It is not a WordPress.org directory distribution.

= Updates =

The bundled DECKERWEB GitHub Release Updater V2 offers stable public releases through the normal WordPress update system. No token or separate updater plugin is needed. It never enables automatic updates for you. Successful release metadata is cached for 30 minutes; failures back off ten minutes. Requests use verified HTTPS, a six-second timeout and a response limit.

Before replacing the plugin, the candidate must match the expected plugin identity and offered version and declare compatible WordPress/PHP requirements. Package preparation uses native filesystem handling. V2 also fills missing icons in cached update offers without changing other plugins. Local English/German artwork appears in plugin details.

= Migration =

Version 4 is a major rewrite. Useful toolbar/menu features remain; obsolete/decorative/affiliate trees and broad old global functions/positional filters were removed. Selected constants/actions and the legacy menu location remain. Review custom snippets against docs/MIGRATION-4.0.md before upgrading. The shared menu defaults to the network’s main site unless a different source is configured.

Menus and stored settings are retained on plugin deletion. Disabling the plugin removes its runtime toolbar/UI additions without deleting WordPress menus. Back up and test custom integrations on staging.

= Troubleshooting =

Menu absent: check audience, toolbar visibility, display context, source website, selected menu and assigned legacy location. Wrong position: check that the reference item actually exists. Unexpected depth: depth starts at the original menu root. Missing upload links: check the four switches and WordPress installation restrictions.

Library installation blocked: read the displayed prerequisite, PHP ZipArchive requirement or package error; catalog install never replaces an existing directory. No update: check the published stable version, cache interval, PHP/WordPress requirements and outbound GitHub access. FTP/SSH filesystem flows and individual commercial plugins can depend on hosting/runtime behavior.

For support include plugin/WordPress/PHP versions, single-site or Multisite context, selected settings and steps to reproduce. Do not post credentials or private URLs. Site Health → Info includes a Toolbar Additions section.


== FAQ ==

= Does it require Multisite? =
No. It supports single sites too.

= Can I choose the menu position and depth? =
Yes: left/right, before/after references, one to ten child levels or all.

= Does an empty group label follow the menu name? =
Yes. A custom label overrides the selected WordPress menu name.

= Who can edit the shared Multisite menu? =
Super administrators. Optional viewing by website administrators grants no extra rights.

= Which Plugin/Theme additions are on by default? =
Plugin entries are on, Theme entries off, independently for + New and ZIP submenus.

= Does the catalog make background requests? =
The bundled catalog works locally. Optional online catalog updates need explicit configuration. Installation downloads the selected GitHub release.

= How do updates work? =
Through normal WordPress plugin updates using the bundled deckerweb Updater V2. No extra plugin or token required.

== Changelog ==

= 4.0.0 — 2026-10-01 =
* New: Adds a settings page for menu source, context, audience, position, grouping and child depth.
* New: Adds independent Plugin/Theme switches for + New and ZIP upload sidebar entries, with plugin-on/theme-off defaults.
* New: Adds a dedicated theme ZIP upload page using WordPress’s signed installer, including Multisite network links.
* New: Bundles deckerweb Plugin Library 0.2.0: approved releases, local icons, dependency checks and optional catalog settings.
* Improved: Rebuilds the plugin around small classes, reuses menu data per request and bounds additional subsite shortcuts.
* Improved: Shows Plugin and Theme entries last under + New; an empty grouped label follows the WordPress menu name.
* Improved: Introduces Launch Rail artwork and a shared footer with localized documentation and a complete local changelog.
* Fixed: Validates settings capabilities/nonces and escapes menu output; protects shared menu edits across classic forms, REST and Customizer.
* Fixed: Restores icons on cached WordPress update offers through the shared DECKERWEB GitHub Release Updater V2.
* Misc: Requires WordPress 6.7 and PHP 8.2; includes German informal/formal translations and bilingual documentation.
* Misc: Keeps the 3.1.0/3.0.0/2.x changelog and older history available, while documenting breaking changes and removed obsolete links.

Full history: https://github.com/deckerweb/multisite-toolbar-additions/blob/master/docs/wiki/Changelog-English.md

== Credits ==

© 2012–2026 David Decker – DECKERWEB
https://github.com/deckerweb/multisite-toolbar-additions
