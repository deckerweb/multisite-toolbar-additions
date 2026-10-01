# Verification scope — 4.0.0

Local checks use PHP 8.4.5 and the official WordPress SQLite adapter:

- 12 hierarchy/site-switching checks, including a 10,000-node chain, cycles/orphans, depth bounds and exception restoration.
- 55 integration checks on WordPress 6.7 Single Site; 75 on WordPress 7.1.2 Multisite.
- 24 GitHub Updater V2 checks per installation: mocked metadata, asset selection, cached artwork, scope/HTTPS limits and candidate identity/version/platform validation.
- 14 Plugin Library 0.2.0 integration checks per installation: actual bootstrap/election, capabilities, local defaults, disabled discovery, catalog identity/digest/origin validation and complete footer history.
- PHP/JavaScript syntax and ZIP integrity checks; the installable package is tested separately from the development tree.
- Nine authenticated HTTP checks cover settings save, nonce rejection, invalid menu rejection, stored position, editor access denial and native theme upload view.

The integration suite covers toolbar placement and fallback, context/audience, grouping/depth, escaping, cross-site restoration, query reuse, settings validation, shared-menu capabilities, classic forms, REST and Customizer gates, bounded site expansion, block/classic theme shortcuts, ZIP upload rights/nonce/destination, independent toggles and late + New ordering.

The German settings design and local footer dialogs were previously checked in the browser, including Escape/focus return and a 390 px viewport without horizontal overflow. Own artwork and localized update metadata are checked. Assets are local and scoped to applicable screens.

GitHub release automation runs syntax and dependency-free checks on PHP 8.2 and 8.4 before publishing the installable ZIP, source ZIP and SHA256SUMS. See the actual Actions run for its outcome.

## Limits

SQLite checks are not a MySQL/MariaDB benchmark. The isolated 10,000-node timing does not measure a complete WordPress request. Production persistent caches, all editor/theme layouts, actual third-party integration products, FTP/SSH installations and a complete update against a live production website have not been tested here. Library integration tests do not repeat its separate full installer validation suite. First test a major-version upgrade on staging and review custom 3.x snippets against the migration guide.
