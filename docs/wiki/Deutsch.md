# Multisite Toolbar Additions — Anleitung

**Viele Sites. Ein Handgriff.**

## Inhalt

[Installation](#installation) · [Toolbar-Menü](#toolbar-menü) · [Position und Tiefe](#position-und-tiefe) · [Berechtigungen](#berechtigungen) · [Schnellzugriffe und Uploads](#schnellzugriffe-und-uploads) · [deckerweb Library](#deckerweb-library) · [Updates](#updates) · [Umstieg](#umstieg) · [Fehlerbehebung](#fehlerbehebung)

## Installation

Voraussetzung: WordPress 6.7+ und PHP 8.2+. Die installierbare Release-ZIP über Plugins → Installieren → Plugin hochladen installieren. In Multisite den Netzwerk-Installer verwenden und netzwerkweit aktivieren. Installation, Dateisystem-Sperren und Aktivierungsrechte bleiben unter WordPress-Kontrolle. Der Library-Installer benötigt zusätzlich PHP ZipArchive; die Toolbar selbst nicht.

Auf Einzel-Websites Einstellungen → Toolbar Additions öffnen, in Multisite Netzwerkverwaltung → Einstellungen → Toolbar Additions. Einstellungen gelten zentral pro Netzwerk. Nach Änderungen speichern. Die Library hat eine eigene gemeinsame Seite Einstellungen → deckerweb Library.

## Toolbar-Menü

Ein bestehendes WordPress-Navigationsmenü direkt auswählen. In Multisite eine aktive Quell-Website wählen, ihre Menüs laden, ein Menü auswählen und speichern. Das Laden alleine speichert noch nichts. Eine direkte Menüauswahl bleibt bei Theme-Wechseln erhalten. Die frühere Toolbar-Menüposition dient nur dem Umstieg.

Nur Frontend, nur Verwaltung oder beides wählen. Haupteinträge einzeln anzeigen oder unter einer Überschrift gruppieren. Eine leere Gruppenbeschriftung übernimmt automatisch den WordPress-Menünamen; eigene Beschriftungen haben Vorrang. Leere oder fehlende Menüs erzeugen keine Toolbar-Einträge. Menüdaten werden nur im passenden Benutzer-/Anzeigekontext geladen.

## Position und Tiefe

Positionen: links zuerst/zuletzt, vor/nach einem bekannten WordPress-Bezugspunkt oder rechts beim Benutzerkonto. Fehlt ein Bezugspunkt, erscheint das Menü links zuletzt. Die Positionierung verwendet öffentliche Toolbar-Einträge unmittelbar vor der Ausgabe.

Alle oder eine bis zehn Kindebenen wählen. Eine Kindebene zeigt ursprüngliche Haupteinträge und deren direkte Kinder. Die zusätzliche Gruppenüberschrift verbraucht keine Ebene. Zyklen, verwaiste Einträge und doppelte IDs werden sicher übersprungen. Auf kleinen Bildschirmen öffnen sich verschachtelte Menüs innerhalb des Dropdowns.

## Berechtigungen

Standardzielgruppe: Administratoren auf Einzel-Websites, Super-Administratoren in Multisite. Website-Administratoren können optional das gemeinsame Menü sehen. Sichtbarkeit vergibt keine Zielseiten-Rechte. Gemeinsame Quellmenüs dürfen in geschützten klassischen/JSON-, REST- und Customizer-Abläufen nur Super-Administratoren bearbeiten. Normale Website-Menüs bleiben bearbeitbar. Vertrauenswürdiger PHP-Code mit direkten Speicherzugriffen liegt außerhalb dieser Berechtigungsebene.

Speichern prüft passende Rechte und WordPress-Nonce. Installations-/Uploadlinks benötigen native Installationsrechte; Website-Administratoren erhalten keine Netzwerk-Installationsrechte. Datei-Editoren sind standardmäßig aus und beachten WordPress-Sperren.

## Schnellzugriffe und Uploads

Vier unabhängige Schalter:

| Erweiterung | Standard |
| --- | --- |
| Plugins unter + Neu | An |
| Themes unter + Neu | Aus |
| Untermenü Plugin-ZIP hochladen | An |
| Untermenü Theme-ZIP hochladen | Aus |

Plugin-/Theme-Einträge stehen am Schluss von + Neu. Der Plugin-Upload verwendet den normalen Installer. Die eigene Theme-ZIP-Seite unter Design nutzt das abgesicherte WordPress-Formular und die native Installation/Aktualisierung. In Multisite führen Website-Links zur Netzwerkverwaltung. Ein ausgeblendeter Untermenüpunkt sperrt keinen ansonsten erlaubten Toolbar-Uploadlink.

Weitere Schalter steuern Netzwerk-/Website-Verwaltung, zusätzliche Unterseiten-Links unter Meine Websites, Menübearbeitung, erkannte Plugin-Integrationen, Entwickler-Ressourcen und die Toolbar im Vollbild-Editor. Unterseiten-Limit: standardmäßig 25, einstellbar von eins bis 100. Nur bereits vorhandene Toolbar-Websites werden erweitert. Block-Themes erhalten Site-Editor-Links; klassische Themes passende Customizer-/Widgets-Links. Fehlende oder inaktive Integrationen fügen keine Links hinzu.

## deckerweb Library

Der zusätzliche Tab deckerweb unter Plugins → Installieren zeigt freigegebene GitHub-Releases. WordPress.org bleibt die Standardansicht. Ein Einführungshinweis erscheint einmal pro Administrator; der Katalog lässt sich in den gemeinsamen Library-Einstellungen ausblenden.

Library 0.2.0 enthält neun ausgewählte Plugins, lokale Icons und GitHub-Star-Momentaufnahmen vom 1. Oktober 2026. Stars sind keine Bewertungssterne und werden nicht je Seitenaufruf abgefragt. Der mitgelieferte Katalog funktioniert offline und erzeugt keine Kataloganfragen. Optionale Online-Aktualisierungen sind aus, bis ausdrücklich ein zulässiger eigener HTTPS-Endpunkt konfiguriert wird.

Installieren und Aktivieren sind getrennte Aktionen. Beide prüfen Rechte/Nonces, Freigabe und Voraussetzungen. ZIPs werden per SHA-256 und Archivprüfung validiert, bevor WordPress installiert. Vorhandene Plugin-Verzeichnisse werden nicht überschrieben. Builder-Voraussetzungen werden vor der Installation erklärt. Ausblenden stoppt nicht Updates/Abhängigkeitsprüfungen bereits verwalteter Plugins. Mehrere eingebettete Hosts starten die Library nur einmal.

Dieser GitHub-Build enthält einen externen Installer und ist keine WordPress.org-Verzeichnisversion.

## Updates

Der mitgelieferte DECKERWEB GitHub Release Updater V2 bietet stabile öffentliche Releases im normalen WordPress-Updatesystem an. Kein Token und kein zusätzlicher Updater erforderlich. Automatische Updates werden nicht für dich eingeschaltet. Erfolgreiche Metadaten werden 30 Minuten gespeichert; Fehler zehn Minuten. Anfragen verwenden geprüfte HTTPS-Verbindungen, sechs Sekunden Zeitlimit und eine begrenzte Antwortgröße.

Vor dem Austausch muss das Paket die passende Plugin-Identität, angebotene Version und kompatible WordPress-/PHP-Anforderungen besitzen. Die Vorbereitung nutzt WordPress-Dateisystemfunktionen. V2 ergänzt fehlende Icons zwischengespeicherter Update-Angebote, ohne andere Plugins zu ändern. Plugin-Details zeigen lokale deutsche/englische Grafiken.

## Umstieg

Version 4 ist ein großer Neuaufbau. Nützliche Toolbar-/Menüfunktionen bleiben; veraltete/dekorative/Affiliate-Linkbäume sowie umfassende alte globale Funktionen und positionsbasierte Filter wurden entfernt. Ausgewählte Konstanten/Aktionen und die alte Menüposition bleiben. Eigene Snippets vorher anhand von docs/MIGRATION-4.0.md prüfen. Die gemeinsame Menüquelle ist standardmäßig die Netzwerk-Hauptwebsite, sofern nichts anderes eingestellt wird.

Menüs und gespeicherte Einstellungen bleiben beim Löschen erhalten. Deaktivieren entfernt die laufenden Toolbar-/Oberflächen-Erweiterungen, ohne WordPress-Menüs zu löschen. Eigene Integrationen zuerst mit Sicherung in einer Testinstallation prüfen.

## Fehlerbehebung

Menü fehlt: Zielgruppe, Toolbar-Sichtbarkeit, Anzeigeort, Quell-Website, ausgewähltes Menü und alte Menüposition prüfen. Falsche Position: Ist der Bezugspunkt tatsächlich vorhanden? Unerwartete Tiefe: Es wird ab der ursprünglichen Menüwurzel gezählt. Uploadlinks fehlen: vier Schalter und WordPress-Installationssperren prüfen.

Library-Installation gesperrt: angezeigte Voraussetzung, PHP-ZIP-Anforderung oder Paketfehler beachten; bestehende Verzeichnisse werden nicht ersetzt. Kein Update: veröffentlichtes stabiles Release, Cache-Zeit, PHP-/WordPress-Anforderungen und GitHub-Erreichbarkeit prüfen. FTP-/SSH-Dateisysteme und einzelne kommerzielle Plugins können vom Hoster bzw. ihrer Laufzeit abhängen.

Für Support Plugin-/WordPress-/PHP-Versionen, Einzel-/Multisite-Kontext, Einstellungen und reproduzierbare Schritte nennen. Keine Zugangsdaten oder privaten URLs veröffentlichen. Website-Zustand → Bericht enthält einen Abschnitt für Toolbar Additions.

[FAQ](FAQ-Deutsch.md) · [Changelog](Changelog-Deutsch.md)

© 2012–2026 David Decker – DECKERWEB · GPL-2.0-or-later
