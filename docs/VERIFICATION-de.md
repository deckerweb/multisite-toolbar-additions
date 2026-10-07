# Kompatibilitätsprüfungen

[English](VERIFICATION.md)

Für einzelne WordPress-Websites und Multisite-Netzwerke. Beide werden seit 2012 unterstützt.

Version 4.1.0 wird auf getrennten WordPress-Testinstallationen mit 6.7 als Einzelinstallation und 7.1.2 als Multisite mit SQLite unter PHP 8.2.29 und 8.4.5 geprüft. Der Umfang umfasst Quellmenüschutz, Sichtbarkeit und Positionierung, Menüvorschauen, signiertes Speichern, Plugin-/Theme-Uploads samt Typhinweisen, Updatepaketprüfung, Datenhaltung/Lebenszyklus und englische/deutsche Host-Übersetzungen.

Desktop-/Mobil-Browserprüfungen erfassen Speichern und Verlustwarnungen, native Tastatur-Aufklappfunktionen, schreibfreie Vorschauen, Uploader-Bestätigung, Typverwechslungen und Übergabe an den WordPress-Installer. Paketprüfungen erfassen benötigte Dateien, Metadaten, Übersetzungen, lokale Ressourcen und Komponenten-Hashes. Die Browserprüfung fängt die abschließende Erweiterungsinstallation ab; native Paketaktualisierungen verwenden getrennte Testinstallationen.

Diese Prüfungen zertifizieren nicht jede Fremdplugin-Integration, MySQL-/MariaDB-Umgebung, jeden persistenten Objektcache, FTP-/SSH-Installer, Multinetwork-Aufbau oder jede Screenreader-Kombination. ZIP-Metadatenvorschauen sind keine Schadsoftwareprüfung oder Kompatibilitätsgarantie. WordPress-Menüs bleiben getrennt von den Plugin-Einstellungen.
