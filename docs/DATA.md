# Stored data and lifecycle

[English](DATA.md) · [Deutsch](DATA-de.md)

Toolbar configuration is stored in mstba_settings: one regular option on single sites, one option per network in Multisite. A source menu remains ordinary WordPress menu content. Theme locations remain ordinary theme data. The plugin schedules no cron events and creates no tables. New websites inherit their network configuration without initialization writes.

Deactivation preserves data. Uninstall clears only this plugin’s repository metadata cache, ddw_ghru_ plus the first 24 hexadecimal characters of its repository URL’s MD5. Toolbar settings are retained by default. The delete_data switch is off initially and affects that site/network only; physical removal respects each network’s choice. Menus, themes, installed plugins and content are never deleted.

The shared Library has independent settings and delete_settings preference. See its [data inventory](https://github.com/deckerweb/deckerweb-plugin-library/blob/v0.6.0/docs/DATA.md). Temporary caches and tracked download leftovers are cleaned only after the last installed Library host is removed. Inactive installed hosts still count. This host never uses its own deletion preference to delete Library data. No broad data export/import is added for the small flat configuration; existing stored values and legacy constants remain compatible.
