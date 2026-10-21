# Stored data and lifecycle

[English](DATA.md) · [Deutsch](DATA-de.md)

For single WordPress sites and Multisite networks. Both have been supported since 2012.

Toolbar configuration is stored in mstba_settings: one regular option on single sites, one option per network in Multisite. A source menu remains ordinary WordPress menu content. Theme locations remain ordinary theme data. The plugin schedules no cron events and creates no tables. New websites inherit their network configuration without initialization writes.

Deactivation preserves data. Uninstall clears only this plugin’s repository metadata cache, ddw_ghru_ plus the first 24 hexadecimal characters of its repository URL’s MD5. Toolbar settings are retained by default. The delete_data switch is off initially and affects that site/network only; physical removal respects each network’s choice. Menus, themes, installed plugins and content are never deleted.

The shared Library has independent settings and delete_settings preference. See its [data inventory](https://github.com/deckerweb/deckerweb-plugin-library/blob/v1.1.0/docs/DATA.md). Temporary caches and tracked download leftovers are cleaned only after the last installed Library host is removed. Inactive installed hosts still count. This host never uses its own deletion preference to delete Library data. No broad data export/import is added for the small flat configuration; existing stored values and legacy constants remain compatible.

Menu previews are read-only authenticated requests. They store no draft or menu content. The upload_menu_defaults marker inside mstba_settings records the approved one-time change to the visible Theme ZIP submenu default on the next settings save; public reads do not write it. Later explicit submenu choices remain effective.
