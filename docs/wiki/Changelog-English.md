# Changelog

[English](Changelog-English.md) · [Deutsch](Changelog-Deutsch.md)

### 4.1.0 · 2026-10-07

- **New:** Dedicated plugin and theme ZIP upload pages include drag-and-drop, package previews and explicit installation confirmation. Active Leitstand uploaders are reused without duplicate pages.
- **New:** Preview menu structure, grouping and child levels without saving; see effective settings, active uploaders and explanations for missing menu sources or toolbar reference items.
- **Improved:** A sticky save bar keeps saving accessible and warns before discarding unsaved changes. The group-label field is larger.
- **Improved:** Both ZIP admin submenu links are enabled by default; the previous hidden Theme submenu default transitions once. Later explicit choices remain respected. The separate Theme addition under New remains off by default.
- **Improved:** Plugins and Themes appear consecutively in the website toolbar menu, including Multisite. Site-only activation is supported with super-administrator-managed network settings.
- **Improved:** Update shared components to Library 0.6.0 and Updater 2.1.0, with informal/formal German host translations and readable local release history.
- **Fixed:** Recognize plugin/theme ZIP type mismatches and link to the correct uploader. New theme packages preview correctly before their first installation.
- **Fixed:** Validate candidate identity, version and requirements in bulk updates; require authenticated POST requests when saving settings.
- **Fixed:** Keep toolbar features available when an embedded component is incomplete; safely ignore malformed integration entries and preserve last-position ordering after late toolbar additions.
- **Fixed:** Refresh local CSS and JavaScript when package contents change, including same-version replacements.
- **Misc:** Deactivation preserves data. Uninstall clears own update caches; deleting toolbar settings remains optional and off by default. WordPress menus and other plugin data are retained.
- **Misc:** Clarify support for single WordPress sites and Multisite networks throughout the documentation.

### 4.0.0 · 2026-10-01

- **New:** Configure the source menu, audience, frontend/admin visibility, position, grouping and child levels.
- **New:** Plugin and Theme shortcuts have separate switches; Plugins are enabled and Themes disabled by default.
- **New:** Upload theme ZIPs through a dedicated page using the WordPress installer, including network installation.
- **New:** The bundled deckerweb Library 0.2.0 offers approved plugins with package and dependency checks.
- **Improved:** Menu data is reused per request; additional website shortcuts are limited for large networks.
- **Improved:** Plugin and Theme entries appear last under New; an empty group label follows the WordPress menu name.
- **Improved:** Local documentation, update artwork and a shared footer are available in English and German.
- **Fixed:** Shared menus are protected from unauthorized classic, REST and Customizer changes; menu output and settings are validated.
- **Fixed:** Cached WordPress update offers retain the plugin’s own icons.
- **Misc:** Requires WordPress 6.7 and PHP 8.2. German informal and formal language resources are included.

### 3.1.0 · 2025-04-03

- **New:** The toolbar remains available in the fullscreen block editor.
- **New:** Git Updater and DevKit Pro shortcuts are supported; Git Updater can install and update this plugin.
- **Improved:** German language resources include native PHP translation catalogs.

### 3.0.0 · 2025-03

- **Improved:** Administration shortcuts use a smaller set of current integrations.
- **Misc:** The restricted website-administrator menu, obsolete integrations and the former recommendations library were removed; the shared super-administrator menu remains.
- **Misc:** Distribution moved from WordPress.org to direct ZIP installation and GitHub.

### 2.0.1 · 2019-09-23

- **Improved:** The recommendations library 1.5.0 caches data to reduce repeated requests.

### 2.0.0 · 2019-05-04

- **New:** Dedicated plugin/theme ZIP upload pages and installer shortcuts are available.
- **New:** Site Health includes plugin diagnostics on WordPress 5.2 or newer.
- **New:** A DECKERWEB plugin newsletter is available.
- **Improved:** Recommendations library 1.4.0 and German Du/Sie translations were updated.

### 1.9.4 · 2018-11-03

- **Improved:** Recommendations library 1.2.0 improves installer styles and Dark Mode compatibility.

### 1.9.3 · 2018-10-01

- **New:** A Facebook group provides community support for DECKERWEB plugins.
- **Improved:** Recommendations library 1.1.0 improves upload areas and plugin cards, including visible version numbers.
- **Improved:** German translations were updated.

### 1.9.2 · 2018-09-08

- **New:** Plugin update information appears on the installed Plugins overview.
- **Improved:** Recommendations and German translations were updated.
- **Fixed:** Super-administrator links, administration styles and a translation domain were corrected.

### 1.9.1 · 2018-08-22

- **New:** German informal/formal language packs, Composer metadata and a GitHub readme are included.
- **Fixed:** A fatal error in network administration was corrected.
- **Misc:** Support for the discontinued Quick Cache plugin was removed.

### 1.9.0 · 2018-04-01

- **Improved:** Security, administration links, translations and plugin artwork were updated; dead links were removed.

### 1.7.0 · 2014-03-04

- **New:** Editable menus, a restricted website-administrator menu and network plugin/theme editor shortcuts are available.
- **New:** Shared menus are protected from ordinary administrator edits; Stream, Snitch and WPMS Admin Reports shortcuts are supported.
- **Improved:** WP Migrate DB Pro integration and German translations were updated; obsolete pre-3.8 styling was removed.
- **Fixed:** Duplicate network Plugin/Theme entries were corrected.

### 1.6.1 · 2013-12-08

- **Fixed:** A Multisite function availability check was corrected.

### 1.6.0 · 2013-12-07

- **New:** Smart Security Tools and Better WP Security shortcuts are supported.
- **Improved:** Network New Content, Quick Cache integration and German translations were updated.
- **Fixed:** Website view links and duplicate network Plugin/Theme entries were corrected.

### 1.5.0 · 2013-11-21

- **New:** Website dashboards link to the plugin installer; Genesis Simple Sidebars and Smart Tabber Widget are supported.
- **Improved:** MP6 administration styling, integrations and German translations were updated.
- **Fixed:** Menu Locations and Google PageSpeed links and constant checks were corrected.
- **Misc:** Multisite activation became network-only.

### 1.4.0 · 2013-05-07

- **New:** Custom menu priority, Widgets/Menus/Customizer links, network New Content and single-site Plugin links are available.
- **New:** Website view links include Pingdom and Google PageSpeed tools.
- **New:** Additional integrations: Smart Options Optimizer, Simple System Info, Hide My WP, Widget Settings Importer/Exporter, Tabify Edit Screen, Restrict Widgets, P3, Blog Copier, NS Cloner, Codestyling Localization, WP Migrate DB, Multisite Robots.txt Manager, Domain Mapping and Go Sidebar Wizard.
- **Improved:** Existing integrations, loading performance, German translations and help were updated.

### 1.3.0 · 2013-03-21

- **New:** Plugin and Theme install/upload/search shortcuts appear under New; Smart Cleanup Tools, Smart Admin Tweaks and Optimize Database after Deleting Revisions are supported.
- **Improved:** Network navigation, Snapshot storage links, BackWPup 3.x integration and German translations were updated.

### 1.2.0 · 2012-11-27

- **New:** Snapshot, Ultimate Branding and Login Security Solution are supported; Network Admin links to the main website dashboard.
- **Improved:** German translations were updated.

### 1.1.1 · 2012-10-05

- **Fixed:** The Multisite Language Switcher settings link was corrected.

### 1.1.0 · 2012-09-18

- **New:** Integrations include User Management Tools, Network Mass Email, Organizational Message Notifier, Multisite Language Switcher, Code Snippets, Code With WP Code Snippets, BackWPup, Toolbox Modules and Relevanssi.
- **New:** Custom toolbar menus support CSS classes.
- **Improved:** Integration code loads only when needed; translations were updated and screenshots moved outside the plugin package.
- **Misc:** Three-part version numbers are used from this release onward.

### 1.0.0 · 2012-08-28

- **New:** Initial release with four Multisite and seven website integrations.
