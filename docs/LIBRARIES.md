# Shared DECKERWEB libraries

## GitHub Release Updater, API V2

`includes/deckerweb-github-release-updater-v2.php` is copied unchanged from the latest Brand Admin Schemes main branch (release 0.16.3, checked 2026-10-01). Its versioned namespace allows several deckerweb plugins to coexist. `src/GitHubUpdates.php` supplies this repository, localized artwork, bounded HTTPS metadata requests and candidate-package identity/version/requirements checks. V2 also refreshes cached update icons without discarding unrelated update offers.

Successful metadata is cached for 30 minutes, failures for ten minutes. The plugin does not enable automatic updates. Release assets are named `multisite-toolbar-additions-VERSION.zip`; source archives are separate. Tests use mocked metadata and candidate packages rather than a live production update installation.

## Plugin Library 0.2.0

`includes/deckerweb-plugin-library/` is an unchanged copy of the new deckerweb Plugin Library 0.2.0 distribution supplied in the local deckerweb library project on 2026-10-01. The main plugin registers its host before `plugins_loaded`; the shared bootstrap elects the highest compatible registered library version. Library preferences are shared across participating plugins.

The default catalog is local. Optional online catalog retrieval is disabled by default. Installation requires rights, a nonce, approved catalog identity, valid requirements, package SHA-256 and ZIP checks. Activation is a separate action. The installer does not replace existing plugin directories. Catalog updates preserve plugins' own Update URI/updater behavior. Its bundled catalog pins public releases, so a newer catalog is needed to offer newly released plugin versions.

## Admin Footer, API V1

`includes/deckerweb-admin-footer-v1.php`, `assets/deckerweb-footer.css` and `assets/deckerweb-footer.js` form the reusable footer extracted from the established Daily Scripture/Brand Admin Schemes layout. The versioned class escapes configuration and document content. `src/PageChrome.php` supplies the identity and translated labels. The complete packaged English/German changelog opens locally; documentation opens locally with a GitHub guide fallback. Dialogs support Escape, backdrop dismissal and focus return. Assets load only on the plugin settings screen.

## Documentation

All four readmes describe the current stable version. `docs/CHANGELOG.md`, its German counterpart and the WordPress text equivalents retain the full release history. Current entries use `New:`, `Improved:`, `Fixed:` and `Misc:` prefixes. The `docs/wiki/` pages provide English/German guides, FAQ and changelog on GitHub; they can also be imported into the repository Wiki.
