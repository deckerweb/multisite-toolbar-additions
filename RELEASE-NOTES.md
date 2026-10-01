# Multisite Toolbar Additions 4.0.0

Many sites. One move.

A major rewrite with configurable toolbar menus, protected shared Multisite menus, dedicated ZIP upload links and independent Plugin/Theme defaults.

- **New:** Adds a settings page for menu source, context, audience, position, grouping and child depth.
- **New:** Adds independent Plugin/Theme switches for + New and ZIP upload sidebar entries, with plugin-on/theme-off defaults.
- **New:** Adds a dedicated theme ZIP upload page using WordPress’s signed installer, including Multisite network links.
- **New:** Bundles deckerweb Plugin Library 0.2.0: approved releases, local icons, dependency checks and optional catalog settings.
- **Improved:** Rebuilds the plugin around small classes, reuses menu data per request and bounds additional subsite shortcuts.
- **Improved:** Shows Plugin and Theme entries last under + New; an empty grouped label follows the WordPress menu name.
- **Improved:** Introduces Launch Rail artwork and a shared footer with localized documentation and a complete local changelog.
- **Fixed:** Validates settings capabilities/nonces and escapes menu output; protects shared menu edits across classic forms, REST and Customizer.
- **Fixed:** Restores icons on cached WordPress update offers through the shared DECKERWEB GitHub Release Updater V2.
- **Misc:** Requires WordPress 6.7 and PHP 8.2; includes German informal/formal translations and bilingual documentation.
- **Misc:** Keeps the 3.1.0/3.0.0/2.x changelog and older history available, while documenting breaking changes and removed obsolete links.

**Requirements:** WordPress 6.7+, PHP 8.2+. PHP ZipArchive is needed only for verified catalog installations.

**Upgrade note:** Review custom 3.x snippets against the migration guide. Existing WordPress navigation menus are retained; direct menu selection is recommended.

Install `multisite-toolbar-additions-4.0.0.zip`; the source archive is for development.

[English guide](https://github.com/deckerweb/multisite-toolbar-additions/blob/master/docs/wiki/English.md) · [Deutsche Anleitung](https://github.com/deckerweb/multisite-toolbar-additions/blob/master/docs/wiki/Deutsch.md) · [FAQ](https://github.com/deckerweb/multisite-toolbar-additions/blob/master/docs/wiki/FAQ-English.md)
