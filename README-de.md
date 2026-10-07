# Multisite Toolbar Additions

![Multisite Toolbar Additions](assets-github/banner-de-1280x640.png)

## Kurzvorstellung

**Viele Sites. Ein Handgriff.**

Ein konfigurierbares WordPress-Menü in der Toolbar mit nützlichen Website- und Netzwerk-Verknüpfungen. Teil von QuickNav; für Einzel-Websites und Multisite-Netzwerke.

**Version 4.0.0 · WordPress 6.7+ · PHP 8.2+**

Noch nicht veröffentlichte Vorbereitung für 4.1.0 auf Grundlage von 4.0.0: gemeinsame Leitstand-Verlinkung, eigene Plugin-/Theme-ZIP-Seiten, schreibfreie Menüvorschau und Hinweise zu den wirksamen Einstellungen. Beide ZIP-Admin-Untermenüs sind jetzt standardmäßig aktiv; der Theme-Eintrag unter Neu bleibt optional und standardmäßig aus. Die veröffentlichte 4.0.0-ZIP bleibt unverändert. Die beim Scrollen erreichbare Speichern-Leiste zeigt ungespeicherte Änderungen und warnt vor dem Verlassen; die Toolbar-Vorschau steht jetzt vor der Übersicht der wirksamen Einstellungen. Upload-Seiten trennen jetzt Auswahl, Prüfung und Installation; eine Bestätigung schaltet die passende Installationsaktion unter dem Ergebnis frei. Der Uploader-Wechsel ist ein dezenter Textlink.

[English](README.md) · [Deutsch](README-de.md) · [Download](https://github.com/deckerweb/multisite-toolbar-additions/releases/latest) · [Fragen nach Themen](https://github.com/deckerweb/multisite-toolbar-additions/wiki/FAQ-Deutsch)

## Inhalt

[Auf einen Blick](#auf-einen-blick) · [Installation und erste Schritte](#installation-und-erste-schritte) · [Hauptfunktionen](#hauptfunktionen) · [FAQ](#faq) · [Changelog](#changelog) · [Über das Projekt](#über-das-projekt) · [Hilfe und Sicherheit](#hilfe-und-sicherheit) · [Lizenz und Herkunft](#lizenz-und-herkunft)

## Auf einen Blick

- Wähle Quellwebsite und Menü unabhängig vom Theme. Zeige Haupteinträge einzeln oder gruppiere sie unter dem Menünamen. Eine eigene Beschriftung ist optional.
- Wähle zuerst/zuletzt, vor/nach einem Bezugseintrag oder die rechte Seite. Zeige das Menü im Frontend, im Admin oder in beiden. Wähle eine bis zehn Kindebenen oder alle. Fehlt der Bezugseintrag, erscheint das Menü am Ende.
- Plugins und Themes stehen im Website-Toolbar-Menü direkt nacheinander, auch in Multisite. Ergänzungen unter Neu stehen am Ende und besitzen unabhängige Schalter: Plugins an, Themes aus. Beide ZIP-Admin-Untermenüs sind standardmäßig an. Upload-Links verwenden die aktiven Leitstand-Seiten oder eigene Seiten mit Drag-and-drop und begrenzter Metadatenvorschau; WordPress übernimmt die Installation.
- Nutze eine netzwerkweite Menüquelle mit optionaler Sichtbarkeit für Website-Administratoren. Gemeinsame Menüs dürfen nur Super-Administratoren bearbeiten. Zielseiten-Rechte gelten weiterhin; zusätzliche Website-Verknüpfungen sind begrenzt.
- Library 0.6.0 bietet kuratierte Plugins mit Voraussetzungs-/Prüfsummenprüfung und optionalen Online-Katalogupdates. Updater 2.1.0 nutzt normale WordPress-Updates. Assets sind lokal; es gibt keine Telemetrie.
- Prüfe die Menüstruktur mit ausgewählter Tiefe und Gruppierung ohne Speichern. Eine kompakte Übersicht erklärt Sichtbarkeit, Positionierung und verwendete Uploader. Fehlende Quellen und auf der aktuellen Seite fehlende Toolbar-Bezugseinträge werden erläutert.

## Installation und erste Schritte

Benötigt WordPress 6.7+ und PHP 8.2+. Installiere die veröffentlichte ZIP über Plugins → Installieren → Plugin hochladen. Öffne Einstellungen → Toolbar-Erweiterungen. Bei Netzwerkaktivierung verwende Netzwerkverwaltung → Einstellungen → Toolbar-Erweiterungen. Einzelaktivierung verwendet die Einstellungsseite der aktiven Website; Netzwerkeinstellungen benötigen weiterhin einen Super-Administrator. Der optionale Katalog-Installer benötigt PHP ZipArchive. Prüfe eigene 3.x-Snippets vor einem großen Upgrade.

## Hauptfunktionen

### Dein WordPress-Menü

Wähle Quellwebsite und Menü unabhängig vom Theme. Zeige Haupteinträge einzeln oder gruppiere sie unter dem Menünamen. Eine eigene Beschriftung ist optional.

### Position, Sichtbarkeit und Tiefe

Wähle zuerst/zuletzt, vor/nach einem Bezugseintrag oder die rechte Seite. Zeige das Menü im Frontend, im Admin oder in beiden. Wähle eine bis zehn Kindebenen oder alle. Fehlt der Bezugseintrag, erscheint das Menü am Ende.

### Upload-Verknüpfungen

Plugins und Themes stehen im Website-Toolbar-Menü direkt nacheinander, auch in Multisite. Ergänzungen unter Neu stehen am Ende und besitzen unabhängige Schalter: Plugins an, Themes aus. Beide ZIP-Admin-Untermenüs sind standardmäßig an. Upload-Links verwenden die aktiven Leitstand-Seiten oder eigene Seiten mit Drag-and-drop und begrenzter Metadatenvorschau; WordPress übernimmt die Installation.

### Multisite-Verwaltung

Nutze eine netzwerkweite Menüquelle mit optionaler Sichtbarkeit für Website-Administratoren. Gemeinsame Menüs dürfen nur Super-Administratoren bearbeiten. Zielseiten-Rechte gelten weiterhin; zusätzliche Website-Verknüpfungen sind begrenzt.

### Gemeinsame Komponenten

Library 0.6.0 bietet kuratierte Plugins mit Voraussetzungs-/Prüfsummenprüfung und optionalen Online-Katalogupdates. Updater 2.1.0 nutzt normale WordPress-Updates. Assets sind lokal; es gibt keine Telemetrie.

### Menüvorschau und Hinweise

Prüfe die Menüstruktur mit ausgewählter Tiefe und Gruppierung ohne Speichern. Eine kompakte Übersicht erklärt Sichtbarkeit, Positionierung und verwendete Uploader. Fehlende Quellen und auf der aktuellen Seite fehlende Toolbar-Bezugseinträge werden erläutert.

## FAQ

### Wie wähle ich das Toolbar-Menü?

Erstelle ein normales Navigationsmenü und wähle Quellwebsite und Menü in den Einstellungen. Netzwerkaktivierung verwendet standardmäßig die Haupt-Website; Einzelaktivierung die aktive Website. Aktiviere das Plugin auf der Quellwebsite oder netzwerkweit, damit der Schutz des gemeinsamen Menüs greifen kann. Die alte Menüposition mstba_menu bleibt als Rückfalllösung erhalten.

### Kann ich Position und Sichtbarkeit ändern?

Ja: zuerst, zuletzt, vor oder nach einem Toolbar-Eintrag oder rechts. Wähle Frontend, Admin oder beide und die zugelassenen Benutzer. Fehlt der Bezugseintrag, erscheint das Menü am Ende.

### Dürfen Website-Administratoren das gemeinsame Menü bearbeiten?

Die Sichtbarkeit des Menüs und die Berechtigung zur Bearbeitung der Quelle sind getrennt. Gemeinsame Multisite-Quellmenüs werden vor unberechtigten Änderungen im Admin, per REST und im Customizer geschützt.

### Welche Upload-Verknüpfungen sind standardmäßig aktiv?

Plugin-ZIP- und Theme-ZIP-Admin-Untermenüs sind aktiv. Der frühere ausgeschaltete Theme-Untermenü-Standard wird einmalig ersetzt; beim nächsten Speichern wird dieser Übergang vermerkt, danach bleibt ein ausdrücklich ausgeschalteter Schalter erhalten. Unter + Neu bleibt Plugin aktiv und Theme deaktiviert. Jeder Eintrag besitzt einen eigenen Schalter. Themes steht im Website-Toolbar-Menü direkt unter Plugins, auch in Multisite.

### Wie funktionieren Plugin-Updates?

Der mitgelieferte deckerweb Updater 2.1.0 prüft dieses festgelegte öffentliche Repository und speichert Release-Metadaten zwischen. WordPress steuert einzelne, gemeinsame und automatische Updates. Das Plugin aktiviert keine automatischen Updates. Pakete müssen vor dem Austausch Angebotsversion, Plugin-Identität und Plattformanforderungen erfüllen.

### Was passiert bei Deaktivierung oder Deinstallation?

Deaktivierung erhält alle Einstellungen und WordPress-Menüs. Deinstallation leert den Updatecache dieses Plugins. Toolbar-Einstellungen bleiben erhalten, sofern die Löschoption für die jeweilige Website oder das Netzwerk nicht aktiviert wurde. Bei physischer Entfernung wird die eigene Entscheidung jedes Netzwerks berücksichtigt. Die gemeinsame Library wird erst beim letzten installierten Host bereinigt, auch deaktivierte Hosts zählen; ihre Löschoption ist unabhängig. Installierte Plugins, Navigationsmenüs und fremde Inhalte bleiben erhalten.

### Kontaktiert die Library auf jeder Seite GitHub?

Nein. Mitgelieferter Katalog und Grafiken funktionieren lokal. Angeforderte Paket-Downloads kontaktieren die festgelegten Hosts. Der optionale Online-Katalog ist standardmäßig deaktiviert und verwendet Cache und Wiederholungsabstände.

[Fragen nach Themen](https://github.com/deckerweb/multisite-toolbar-additions/wiki/FAQ-Deutsch)

## Changelog

### Noch nicht veröffentlicht

- **Verbessert:** Aktualisiert die gemeinsame Library auf 0.6.0 und den Updater auf 2.1.0; verbessert die deutsche Dokumentation und den lesbaren lokalen Änderungsverlauf.
- **Behoben:** Prüft Updatepakete auch bei Sammelupdates und erhält vorhandene Daten bei Deaktivierung und standardmäßiger Deinstallation.
- **Sonstiges:** Einzelaktivierung ist in Multisite mit durch Super-Administratoren verwalteten Netzwerkeinstellungen verfügbar.

### 4.0.0 · 2026-10-01

- **Neu:** Menüquelle, Zielgruppe, Frontend-/Admin-Anzeige, Position, Gruppierung und Kindebenen sind einstellbar.
- **Neu:** Plugin- und Theme-Verknüpfungen haben getrennte Schalter; Plugins sind standardmäßig aktiviert, Themes deaktiviert.
- **Neu:** Theme-ZIPs lassen sich auf einer eigenen Seite mit dem WordPress-Installer auch netzwerkweit installieren.
- **Neu:** Die mitgelieferte deckerweb Library 0.2.0 bietet freigegebene Plugins mit Paket- und Abhängigkeitsprüfung.
- **Verbessert:** Menüdaten werden pro Anfrage wiederverwendet; zusätzliche Website-Verknüpfungen sind für große Netzwerke begrenzt.
- **Verbessert:** Plugin- und Theme-Einträge stehen unter Neu am Ende; eine leere Gruppenbeschriftung übernimmt den WordPress-Menünamen.
- **Verbessert:** Lokale Dokumentation, Update-Grafiken und ein gemeinsamer Footer sind auf Englisch und Deutsch verfügbar.
- **Behoben:** Gemeinsame Menüs sind gegen unberechtigte Änderungen im klassischen Admin, per REST und im Customizer geschützt; Menüausgaben und Einstellungen werden geprüft.
- **Behoben:** Zwischengespeicherte WordPress-Updateangebote behalten die eigenen Plugin-Icons.
- **Sonstiges:** Benötigt WordPress 6.7 und PHP 8.2. Deutsche Sprachdateien mit Du- und Sie-Anrede sind enthalten.

### 3.1.0 · 2025-04-03

- **Neu:** Die Toolbar bleibt im Vollbildmodus des Block-Editors verfügbar.
- **Neu:** Verknüpfungen für Git Updater und DevKit Pro werden unterstützt; Git Updater kann dieses Plugin installieren und aktualisieren.
- **Verbessert:** Deutsche Sprachdateien enthalten native PHP-Übersetzungskataloge.

### 3.0.0 · 2025-03

- **Verbessert:** Die Verwaltungsverknüpfungen verwenden eine kleinere Auswahl aktueller Integrationen.
- **Sonstiges:** Das eingeschränkte Website-Administrator-Menü, veraltete Integrationen und die frühere Empfehlungs-Library wurden entfernt; das gemeinsame Super-Administrator-Menü bleibt erhalten.
- **Sonstiges:** Der Vertrieb wechselte von WordPress.org zur direkten ZIP-Installation und GitHub.

### 2.0.1 · 2019-09-23

- **Verbessert:** Die Empfehlungs-Library 1.5.0 speichert Daten zwischen und vermeidet wiederholte Abfragen.

### 2.0.0 · 2019-05-04

- **Neu:** Eigene Plugin-/Theme-ZIP-Seiten und Installer-Verknüpfungen sind verfügbar.
- **Neu:** Der Website-Zustand enthält Plugin-Diagnosen unter WordPress ab 5.2.
- **Neu:** Ein Newsletter für DECKERWEB Plugins ist verfügbar.
- **Verbessert:** Die Empfehlungs-Library 1.4.0 und deutsche Du-/Sie-Übersetzungen wurden aktualisiert.

### 1.9.4 · 2018-11-03

- **Verbessert:** Die Empfehlungs-Library 1.2.0 verbessert die Installer-Darstellung und Dark-Mode-Kompatibilität.

### 1.9.3 · 2018-10-01

- **Neu:** Eine Facebook-Gruppe bietet Unterstützung für DECKERWEB Plugins.
- **Verbessert:** Die Empfehlungs-Library 1.1.0 verbessert Upload-Bereiche und Plugin-Karten einschließlich sichtbarer Versionsnummern.
- **Verbessert:** Deutsche Übersetzungen wurden aktualisiert.

[Vollständiger Verlauf](docs/CHANGELOG-de.md)

## Über das Projekt

David Decker entwickelt und pflegt dieses Plugin seit 2012. Die Serie QuickNav erleichtert die tägliche WordPress-Verwaltung. Der gewachsene Pluginname bleibt erhalten.

## Hilfe und Sicherheit

[Issues](https://github.com/deckerweb/multisite-toolbar-additions/issues) · [Discussions](https://github.com/deckerweb/multisite-toolbar-additions/discussions) · [Sicherheitsmeldungen](SECURITY-de.md)

[Ko-fi](https://ko-fi.com/deckerweb) · [Buy Me a Coffee](https://buymeacoffee.com/daveshine) · [PayPal](https://paypal.me/deckerweb)

## Lizenz und Herkunft

© 2012–2026 David Decker – DECKERWEB. [GPL v2 or later](LICENSE).

Library und Updater: David Decker, GPL-2.0-or-later. Footer und Änderungsverlauf basieren auf den öffentlichen deckerweb Referenzplugins. Launch-Rail-Grafiken: David Decker, GPL-2.0-or-later; lokale Systemschriften. Quellen und Komponentenstände: [Gemeinsame Komponenten](docs/LIBRARIES-de.md).
