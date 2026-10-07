# Gemeinsame Komponenten

[English](LIBRARIES.md) · [Deutsch](LIBRARIES-de.md)

Für einzelne WordPress-Websites und Multisite-Netzwerke. Beide werden seit 2012 unterstützt.

## deckerweb Library 0.6.0

Unveränderte Laufzeit aus [deckerweb-plugin-library, v0.6.0](https://github.com/deckerweb/deckerweb-plugin-library/tree/v0.6.0/lib), GPL-2.0-or-later, David Decker. Bootstrap-Protokoll 2 wählt den höchsten kompatiblen Host. Lokale Kataloge/Icons benötigen keine Abfrage. Online ist optional und anfangs deaktiviert; die voreingestellte Quelle ist der öffentliche Raw-GitHub-Katalog. Gemeinsame Einstellungen gehören in Multisite zum Netzwerk. Ein netzwerkweit aktivierter teilnehmender Host wird benötigt, um Katalog und Einstellungen in der Netzwerkverwaltung bereitzustellen. Host-Übersetzungen haben Vorrang; Library-Texte werden in dieselbe Host-Textdomain geladen.

Installation prüft Berechtigungen, Nonce, Abhängigkeiten, Identität, Archivschutz und SHA-256 vor der Normalisierung. Aktivierung ist getrennt. Installationsregister und Caches sind gemeinsam und bleiben erhalten, solange ein anderer Host installiert ist, auch deaktiviert. Ältere 0.6.0-Kopien sollten gemeinsam ersetzt werden, weil gleichversionierte Kopien nach einem festen Host-Kriterium ausgewählt werden. Andere installierte Hosts werden hier nicht verändert.

## deckerweb Updater 2.1.0

Offizielle Laufzeit mit reinen Dokumentationsergänzungen; ausführbare PHP-Tokens sind unverändert. Quelle: [offizielle Laufzeit](https://github.com/deckerweb/deckerweb-updater/blob/v2.1.0/runtime/deckerweb-github-release-updater-v2.php), GPL-2.0-or-later, David Decker. Nur öffentlicher Repository-Modus; es wird kein Token benötigt oder erhoben. Host-Übersetzungen und Grafiken werden nach init übergeben. Die zuerst geladene V2-Klasse wird gemeinsam verwendet; eine ältere Klasse bleibt mit dem öffentlichen Konstruktor kompatibel, besitzt aber keinen neuen Übersetzungs-Callback. Für vollständig lokalisierte Komponentenfehler müssen ältere Host-Kopien aktualisiert werden.

Der Host prüft vor dem Austausch Paketidentität, Angebotsversion und WordPress-/PHP-Anforderungen, auch im Core-Sammelupdatepfad. Automatische Updates steuert weiterhin WordPress. Der optionale Katalog-Provider-Patch ist nicht Bestandteil des offiziellen Release 2.1.0 und wird nicht auf diese festgelegte Engine angewendet; der bestehende Host-Updater behält seinen Metadatenweg.

## Footer und Änderungsverlauf

Der strukturierte Footer behält API v1 und arbeitet neben einer älteren Footer-Klasse. Der Changelog-Renderer basiert auf dem öffentlichen Advanced Scripts QuickNav [gemeinsamen Renderer](https://github.com/deckerweb/advanced-scripts-quicknav), David Decker, GPL-2.0-or-later. Beide geben abgesicherte lokale Dokumente aus; der aktuelle Verlauf umfasst sieben Versionen, die vollständige Historie bleibt im Wiki. Assets werden nur auf der Plugin-Einstellungsseite geladen.

## Externe Verbindungen

WordPress-Updateprüfungen senden Repository-Abfragen an api.github.com; ausdrücklich angeforderte Downloads verwenden GitHubs Pakethosts. Der optionale Katalog verwendet raw.githubusercontent.com. Diese Hosts sehen IP-Adresse und normale HTTP-Metadaten; dieser öffentliche Host übermittelt keine Website-Inhalte, Benutzerlisten oder Zugangsdaten. Keine Telemetrie, externen Schriften oder Sternzahl-Abfragen.
