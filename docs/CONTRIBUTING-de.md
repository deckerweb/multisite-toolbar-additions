# Dokumentation und Übersetzungen pflegen

[English](CONTRIBUTING.md)

Für einzelne WordPress-Websites und Multisite-Netzwerke. Beide werden seit 2012 unterstützt.

Öffentliche zweisprachige Inhalte liegen in content.json; python3 tools/documents.py erzeugt daraus Readmes, Themen-FAQ und Änderungsverlauf. Sprachtexte liegen in languages/messages.json; python3 tools/languages.py und anschließend php tools/languages.php /pfad/zum/isolierten/wp-load.php erzeugen die Sprachdateien. Die gemeinsame Library-Laufzeit und ihr Manifest bleiben gemeinsam festgelegt; keinen ungeprüften Provider-Patch mit dem offiziellen Updater vermischen.

Tests nur mit isolierten Installationen ausführen. tests/unit.php ausführen, anschließend integration.php, updater.php, library.php, lifecycle.php und compliance.php mit dem Pfad zur Testinstallation. Das tatsächliche Testarchiv mit tools/package.py AUSGABE --validation prüfen. Veröffentlichung benötigt einen eigenen ausdrücklichen Auftrag; ein lokales Release-Paket autorisiert keine Veröffentlichung.
