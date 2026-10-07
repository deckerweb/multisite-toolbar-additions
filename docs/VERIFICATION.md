# Compatibility checks

[Deutsch](VERIFICATION-de.md)

For single WordPress sites and Multisite networks. Both have been supported since 2012.

Version 4.1.0 is checked on disposable WordPress 6.7 single-site and 7.1.2 Multisite installations with SQLite, using PHP 8.2.29 and 8.4.5. Coverage includes source-menu protection, visibility and positioning, menu previews, signed settings saves, plugin/theme uploads and type guidance, update-candidate validation, lifecycle/data scopes and host-owned English/German translations.

Desktop/mobile browser checks cover saving and unsaved-change warnings, native keyboard disclosures, read-only previews, uploader confirmation, type mismatches and native-installer handoff. Package inspection includes required files, metadata, translations, local assets and embedded-component hashes. Browser tests intercept final extension installation; native package-upgrade checks use separate disposable installations.

These tests do not certify every third-party integration, MySQL/MariaDB environment, persistent object cache, FTP/SSH installer, Multinetwork setup or screen-reader combination. ZIP metadata previews are not malware scans or compatibility guarantees. User-owned WordPress menus remain separate from plugin settings.
