# Compatibility checks

[Deutsch](VERIFICATION-de.md)

For single WordPress sites and Multisite networks. Both have been supported since 2012.

Version 4.2.1 adds a targeted Updater 2.2.1 adoption. The actual installable package passed updater, lifecycle and Library-bridge regressions on WordPress 7.1.3 single-site and Multisite installations under PHP 8.2.29 and 8.4.5. Tests cover an older 2.2.0 adapter loading first, the new adapter loading first, versioned-cache cleanup and native bulk updates from the published 4.2.0 package with settings and activation retained. The embedded Library, host translations and artwork are unchanged. Plugin Check 2.1.0 produced exactly the same 58 individually assessed findings as the 4.2.0 baseline, with no new findings; the runtime runner was initialized early. This targeted patch check does not repeat the entire platform matrix described below.

Version 4.2.0 was checked from its actual installable ZIP on isolated WordPress 6.7.10, 6.9.10, 7.0.7 and 7.1.3 installations with SQLite, using PHP 8.2.29 and 8.4.5. Multisite coverage uses WordPress 7.1.3. All 50 package test runs passed, covering menu protection, positioning, upload inspection, update-candidate validation, Library shortcuts and host translations.

Native updates from the published 4.1.0 package retained settings, unrelated data and single-site/network activation. Additional tests cover the Admin Tools and debug-viewer contracts, lifecycle cleanup and menu previews. English/German settings and preview screens, documentation dialogs, ten browser conflict cases and invalid-nonce rejection were checked. The actual package was inspected for required files, local assets and exact embedded-component hashes.

Official Plugin Check 2.1.0 was run in static and available runtime modes. Remaining findings were assessed individually for the GitHub distribution and embedded components; findings are not suppressed, and this does not represent an error-free report or a security guarantee.

These tests do not certify every third-party integration, MySQL/MariaDB environment, persistent object cache, FTP/SSH installer, Multinetwork setup or screen-reader combination. Premium tool interfaces were not independently retested under real licenses. ZIP metadata previews are not malware scans or compatibility guarantees. User-owned WordPress menus remain separate from plugin settings.
