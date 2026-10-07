# Guide

[English](English.md) · [Deutsch](Deutsch.md) · [FAQ by topic](FAQ-English.md) · [Home](Home.md)

**For single WordPress sites and Multisite networks. Both have been supported since 2012.**

Put your WordPress menu in the toolbar, alongside practical administration shortcuts. Part of the QuickNav family.

I created Multisite Toolbar Additions in 2012 for my own needs. Since then, it has been part of every personal and client WordPress installation I manage, and it remains one of my favorite everyday helper plugins.



## Installation and first steps

Requires WordPress 6.7+ and PHP 8.2+. Install the released ZIP via Plugins → Add New → Upload Plugin. Open Settings → Toolbar Additions. For Multisite network activation, use Network Admin → Settings → Toolbar Additions. Site-only activation uses the active site’s settings page and still requires a super administrator for network settings. The optional catalog installer needs PHP ZipArchive. Review custom 3.x snippets before a major upgrade.

## Your WordPress menu

Select a source site and menu independently of your theme. Keep root entries separate or group them under the menu’s name. A custom label is optional.

## Position, visibility and depth

Choose first/last, before/after a reference item or the right side. Show the menu on the frontend, in administration or both. Choose one to ten child levels, or all. Missing references fall back to the end.

## Upload shortcuts

Plugins and Themes appear consecutively in the website toolbar menu, including Multisite. Additions under New remain last and have independent switches: Plugins on, Themes off. Both ZIP admin submenu links default to on. Upload links use active Leitstand pages or dedicated local pages with drag-and-drop and bounded metadata previews; WordPress performs installation.

## Multisite administration

Use one network-wide menu source with optional viewing by website administrators. Shared menus remain editable only by super administrators. Destination permissions still apply; website expansion is bounded.

## Shared components

Library 0.6.0 offers curated plugins with prerequisite/hash checks and optional online catalog updates. Updater 2.1.0 uses normal WordPress updates. Assets are local; no telemetry is collected.

## Menu preview and diagnostics

Inspect the menu structure with the selected depth and grouping without saving. A compact overview explains visibility, positioning and active uploader providers. Missing sources and page-specific missing toolbar anchors are explained.

## Data and permissions

Deactivation keeps all settings and WordPress menus. Uninstall clears this plugin’s update cache. Toolbar settings are retained unless the deletion option is enabled for that site or network. On physical removal every network’s own choice is respected. Shared Library cleanup runs only after its last installed host is removed, including inactive hosts; its own deletion option is separate. Installed plugins, navigation menus and foreign content remain untouched.

The toolbar audience and permission to edit its source menu are separate. Shared Multisite source menus are protected against unauthorized admin, REST and Customizer changes.
