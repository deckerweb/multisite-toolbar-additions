# Kompatibilitätsprüfungen

[English](VERIFICATION.md)

Für einzelne WordPress-Websites und Multisite-Netzwerke. Beide werden seit 2012 unterstützt.

Version 4.2.1 übernimmt gezielt Updater 2.2.1. Das tatsächliche installierbare Paket bestand Updater-, Lifecycle- und Library-Anbindungstests auf WordPress 7.1.3 als Single Site und Multisite unter PHP 8.2.29 und 8.4.5. Geprüft sind die Ladereihenfolgen mit einem älteren 2.2.0-Adapter, versionsbezogene Cache-Bereinigung und native Sammelupdates aus dem veröffentlichten 4.2.0-Paket mit erhaltenen Einstellungen und Aktivierungsarten. Eingebettete Library, Host-Übersetzungen und Grafiken bleiben unverändert. Plugin Check 2.1.0 liefert exakt dieselben 58 einzeln bewerteten Befunde wie die 4.2.0-Baseline, ohne neue Befunde; der Laufzeitprüfer wurde früh initialisiert. Diese gezielte Patchprüfung wiederholt nicht die gesamte unten beschriebene Plattformmatrix.

Version 4.2.0 wurde aus dem tatsächlichen installierbaren ZIP auf getrennten WordPress-Testinstallationen mit 6.7.10, 6.9.10, 7.0.7 und 7.1.3 sowie SQLite unter PHP 8.2.29 und 8.4.5 geprüft. Die Multisite-Prüfung verwendet WordPress 7.1.3. Alle 50 Paket-Testläufe bestanden; sie umfassen Menüschutz, Positionierung, Upload-Prüfung, Updatepaketprüfung, Library-Verknüpfungen und Host-Übersetzungen.

Native Updates aus dem veröffentlichten 4.1.0-Paket erhielten Einstellungen, fremde Daten sowie Einzel-/Netzwerkaktivierung. Zusätzliche Prüfungen erfassen Admin-Werkzeuge und Debug-Viewer-Schnittstellen, Datenbereinigung und Menüvorschauen. Englische/deutsche Einstellungs- und Vorschauseiten, Dokumentationsdialoge, zehn Browser-Konfliktfälle und die Ablehnung ungültiger Nonces wurden geprüft. Benötigte Dateien, lokale Ressourcen und exakte Komponenten-Hashes wurden am tatsächlichen Paket kontrolliert.

Offizielles Plugin Check 2.1.0 lief statisch und in den verfügbaren Laufzeitmodi. Verbleibende Befunde wurden für GitHub-Vertrieb und eingebettete Komponenten einzeln bewertet. Meldungen werden nicht unterdrückt; daraus folgt weder ein meldungsfreier Prüfbericht noch eine Sicherheitsgarantie.

Diese Prüfungen zertifizieren nicht jede Fremdplugin-Integration, MySQL-/MariaDB-Umgebung, jeden persistenten Objektcache, FTP-/SSH-Installer, Multinetwork-Aufbau oder jede Screenreader-Kombination. Premium-Oberflächen wurden nicht erneut unabhängig mit echten Lizenzen geprüft. ZIP-Metadatenvorschauen sind keine Schadsoftwareprüfung oder Kompatibilitätsgarantie. WordPress-Menüs bleiben getrennt von den Plugin-Einstellungen.
