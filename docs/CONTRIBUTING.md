# Maintaining documents and translations

[Deutsch](CONTRIBUTING-de.md)

Public bilingual content lives in content.json; run python3 tools/documents.py to regenerate readmes, topic FAQ and release history. Maintain language messages in languages/messages.json, run python3 tools/languages.py, then php tools/languages.php /path/to/disposable/wp-load.php. The shared Library runtime and its manifest stay pinned together; do not merge an unreviewed provider patch into the official updater.

Tests use disposable fixtures only. Run tests/unit.php, then integration.php, updater.php, library.php, lifecycle.php and compliance.php with the fixture wp-load.php path. Test the actual validation archive through tools/package.py OUTPUT --validation. Publication requires its own explicit instruction; the maintenance version marker does not create a release.
