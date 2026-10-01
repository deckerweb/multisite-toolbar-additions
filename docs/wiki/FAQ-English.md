# Frequently Asked Questions

[Documentation](./English.md) · [Home](./Home.md)

## Is Multisite required?

No. The plugin works on individual WordPress sites and Multisite networks. Network shortcuts appear only where applicable.

## Where are the settings?

On a single site: Settings → Toolbar Additions. In Multisite: Network Admin → Settings → Toolbar Additions; network-wide changes require a super administrator.

## How do I select my toolbar menu?

Create a normal navigation menu, then select its source site and menu in the plugin settings. The source defaults to the network main site. An unassigned legacy mstba_menu location remains a fallback.

## What is the default menu title?

The name of the selected WordPress menu. Leave the custom label empty to keep this automatic title.

## Can I change position and visibility?

Yes: first, last, before or after a selected toolbar item, or on the right. Choose frontend, admin or both, and the permitted audience. If an anchor is missing, the menu falls back to the end.

## What does menu depth mean?

One child level includes direct children; two includes their children too. Zero means all available levels. The configurable limit is ten child levels.

## Why is my menu missing on the frontend?

WordPress must display its toolbar for the current user. Also check the plugin switch, audience, frontend visibility, source site and selected menu. The plugin does not force the toolbar on for visitors.

## Can ordinary site admins edit a shared menu?

The toolbar audience and permission to edit its source menu are separate. Shared Multisite source menus are protected against unauthorized admin, REST and Customizer changes.

## Which upload shortcuts are enabled by default?

Plugin ZIP submenu and the + New plugin entry are enabled. Theme ZIP submenu and the + New theme entry are disabled. Each has a separate switch.

## Where are the + New additions placed?

Plugin and theme additions are moved to the end of the + New group, including after late-registered content types. WordPress capabilities still determine availability.

## How does Theme ZIP upload work?

The plugin provides an upload page with the native WordPress form and installer. In Multisite installation occurs in Network Admin and requires the appropriate network privileges. It does not replace ZIP validation or WordPress security checks.

## What is the deckerweb Plugin Library?

A shared installer tab for curated deckerweb plugins. It uses a bundled catalog by default, checks package SHA-256 and requirements, and keeps installation separate from activation. Several participating plugins share one elected library runtime.

## Does the library contact GitHub on every page?

No. Its bundled catalog and artwork work locally. Package downloads contact their declared hosts when requested. Optional online catalog retrieval is disabled by default and uses caching and backoff when enabled.

## How do plugin updates work?

GitHub Release Updater V2 checks this fixed public repository and caches metadata. Stable releases need an installable multisite-toolbar-additions-VERSION.zip asset. Existing WordPress update controls decide whether an offered update runs automatically; the plugin does not enable automatic updates itself.

## Which versions are supported?

WordPress 6.7 or newer and PHP 8.2 or newer. Local integration checks use PHP 8.4; CI also checks PHP 8.2. No PHP 7 compatibility is declared.

## Will my 3.x menu survive the upgrade?

Yes: existing navigation menus remain in WordPress. The legacy mstba_menu location is still recognized. Review the new settings and optional shortcuts after the first upgrade. Keep a backup before replacing a major version.

## Why are some shortcuts absent?

Shortcuts depend on permissions, installed integrations, Multisite context and theme capabilities. Block themes offer the Site Editor; classic themes offer their applicable customization screens. File editor links are opt-in and respect WordPress restrictions.

## How does performance scale with large networks?

Menu data is reused within the request, sites are bounded by the configurable subsite limit, and frontend assets load only when needed. There is no full-network scan on every page. Exact speed still depends on your WordPress installation and other plugins.

## How do I report a problem?

Use GitHub Issues with WordPress/PHP versions, single-site or Multisite context, relevant settings and reproduction steps. Remove private URLs and credentials from reports.
