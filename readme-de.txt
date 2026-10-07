=== Multisite Toolbar Additions ===
Contributors: ddecker
Donate link: https://paypal.me/deckerweb
Tags: toolbar, admin bar, multisite, navigation
Requires at least: 6.7
Tested up to: 7.1
Requires PHP: 8.2
Stable tag: 4.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WordPress-Menüs und Verwaltungsverknüpfungen in der Toolbar.

== Description ==

Ein konfigurierbares WordPress-Menü in der Toolbar mit nützlichen Website- und Netzwerk-Verknüpfungen. Teil von QuickNav; für Einzel-Websites und Multisite-Netzwerke.

Noch nicht veröffentlichte Vorbereitung für 4.1.0 auf Grundlage von 4.0.0: gemeinsame Leitstand-Verlinkung und eigene Plugin-/Theme-ZIP-Seiten mit Drag-and-drop und Metadatenvorschau. Die veröffentlichte 4.0.0-ZIP bleibt unverändert.

* Wähle Quellwebsite und Menü unabhängig vom Theme. Zeige Haupteinträge einzeln oder gruppiere sie unter dem Menünamen. Eine eigene Beschriftung ist optional.
* Wähle zuerst/zuletzt, vor/nach einem Bezugseintrag oder die rechte Seite. Zeige das Menü im Frontend, im Admin oder in beiden. Wähle eine bis zehn Kindebenen oder alle. Fehlt der Bezugseintrag, erscheint das Menü am Ende.
* Plugin und Theme stehen unter Neu am Ende. Jeder Eintrag und jedes ZIP-Untermenü hat einen eigenen Schalter: Plugins an, Themes aus. Upload-Links verwenden die aktiven Leitstand-Seiten oder eigene Plugin-/Theme-Seiten mit Drag-and-drop und begrenzter Metadatenvorschau; WordPress übernimmt die Installation.
* Nutze eine netzwerkweite Menüquelle mit optionaler Sichtbarkeit für Website-Administratoren. Gemeinsame Menüs dürfen nur Super-Administratoren bearbeiten. Zielseiten-Rechte gelten weiterhin; zusätzliche Website-Verknüpfungen sind begrenzt.
* Library 0.6.0 bietet kuratierte Plugins mit Voraussetzungs-/Prüfsummenprüfung und optionalen Online-Katalogupdates. Updater 2.1.0 nutzt normale WordPress-Updates. Assets sind lokal; es gibt keine Telemetrie.

== Installation ==

Benötigt WordPress 6.7+ und PHP 8.2+. Installiere die veröffentlichte ZIP über Plugins → Installieren → Plugin hochladen. Öffne Einstellungen → Toolbar-Erweiterungen. Bei Netzwerkaktivierung verwende Netzwerkverwaltung → Einstellungen → Toolbar-Erweiterungen. Einzelaktivierung verwendet die Einstellungsseite der aktiven Website; Netzwerkeinstellungen benötigen weiterhin einen Super-Administrator. Der optionale Katalog-Installer benötigt PHP ZipArchive. Prüfe eigene 3.x-Snippets vor einem großen Upgrade.

== Frequently Asked Questions ==

= Wie wähle ich das Toolbar-Menü? =

Erstelle ein normales Navigationsmenü und wähle Quellwebsite und Menü in den Einstellungen. Netzwerkaktivierung verwendet standardmäßig die Haupt-Website; Einzelaktivierung die aktive Website. Aktiviere das Plugin auf der Quellwebsite oder netzwerkweit, damit der Schutz des gemeinsamen Menüs greifen kann. Die alte Menüposition mstba_menu bleibt als Rückfalllösung erhalten.

= Kann ich Position und Sichtbarkeit ändern? =

Ja: zuerst, zuletzt, vor oder nach einem Toolbar-Eintrag oder rechts. Wähle Frontend, Admin oder beide und die zugelassenen Benutzer. Fehlt der Bezugseintrag, erscheint das Menü am Ende.

= Dürfen Website-Administratoren das gemeinsame Menü bearbeiten? =

Die Sichtbarkeit des Menüs und die Berechtigung zur Bearbeitung der Quelle sind getrennt. Gemeinsame Multisite-Quellmenüs werden vor unberechtigten Änderungen im Admin, per REST und im Customizer geschützt.

= Welche Upload-Verknüpfungen sind standardmäßig aktiv? =

Plugin-ZIP-Untermenü und Plugin-Eintrag unter + Neu sind aktiv. Theme-ZIP-Untermenü und Theme-Eintrag unter + Neu sind deaktiviert. Jeder Eintrag besitzt einen eigenen Schalter.

= Wie funktionieren Plugin-Updates? =

Der mitgelieferte deckerweb Updater 2.1.0 prüft dieses festgelegte öffentliche Repository und speichert Release-Metadaten zwischen. WordPress steuert einzelne, gemeinsame und automatische Updates. Das Plugin aktiviert keine automatischen Updates. Pakete müssen vor dem Austausch Angebotsversion, Plugin-Identität und Plattformanforderungen erfüllen.

= Was passiert bei Deaktivierung oder Deinstallation? =

Deaktivierung erhält alle Einstellungen und WordPress-Menüs. Deinstallation leert den Updatecache dieses Plugins. Toolbar-Einstellungen bleiben erhalten, sofern die Löschoption für die jeweilige Website oder das Netzwerk nicht aktiviert wurde. Bei physischer Entfernung wird die eigene Entscheidung jedes Netzwerks berücksichtigt. Die gemeinsame Library wird erst beim letzten installierten Host bereinigt, auch deaktivierte Hosts zählen; ihre Löschoption ist unabhängig. Installierte Plugins, Navigationsmenüs und fremde Inhalte bleiben erhalten.

= Kontaktiert die Library auf jeder Seite GitHub? =

Nein. Mitgelieferter Katalog und Grafiken funktionieren lokal. Angeforderte Paket-Downloads kontaktieren die festgelegten Hosts. Der optionale Online-Katalog ist standardmäßig deaktiviert und verwendet Cache und Wiederholungsabstände.

Fragen nach Themen: https://github.com/deckerweb/multisite-toolbar-additions/wiki/FAQ-Deutsch

== Changelog ==

= 4.0.0 · 2026-10-01 =

* Neu: Menüquelle, Zielgruppe, Frontend-/Admin-Anzeige, Position, Gruppierung und Kindebenen sind einstellbar.
* Neu: Plugin- und Theme-Verknüpfungen haben getrennte Schalter; Plugins sind standardmäßig aktiviert, Themes deaktiviert.
* Neu: Theme-ZIPs lassen sich auf einer eigenen Seite mit dem WordPress-Installer auch netzwerkweit installieren.
* Neu: Die mitgelieferte deckerweb Library 0.2.0 bietet freigegebene Plugins mit Paket- und Abhängigkeitsprüfung.
* Verbessert: Menüdaten werden pro Anfrage wiederverwendet; zusätzliche Website-Verknüpfungen sind für große Netzwerke begrenzt.
* Verbessert: Plugin- und Theme-Einträge stehen unter Neu am Ende; eine leere Gruppenbeschriftung übernimmt den WordPress-Menünamen.
* Verbessert: Lokale Dokumentation, Update-Grafiken und ein gemeinsamer Footer sind auf Englisch und Deutsch verfügbar.
* Behoben: Gemeinsame Menüs sind gegen unberechtigte Änderungen im klassischen Admin, per REST und im Customizer geschützt; Menüausgaben und Einstellungen werden geprüft.
* Behoben: Zwischengespeicherte WordPress-Updateangebote behalten die eigenen Plugin-Icons.
* Sonstiges: Benötigt WordPress 6.7 und PHP 8.2. Deutsche Sprachdateien mit Du- und Sie-Anrede sind enthalten.

= 3.1.0 · 2025-04-03 =

* Neu: Die Toolbar bleibt im Vollbildmodus des Block-Editors verfügbar.
* Neu: Verknüpfungen für Git Updater und DevKit Pro werden unterstützt; Git Updater kann dieses Plugin installieren und aktualisieren.
* Verbessert: Deutsche Sprachdateien enthalten native PHP-Übersetzungskataloge.

= 3.0.0 · 2025-03 =

* Verbessert: Die Verwaltungsverknüpfungen verwenden eine kleinere Auswahl aktueller Integrationen.
* Sonstiges: Das eingeschränkte Website-Administrator-Menü, veraltete Integrationen und die frühere Empfehlungs-Library wurden entfernt; das gemeinsame Super-Administrator-Menü bleibt erhalten.
* Sonstiges: Der Vertrieb wechselte von WordPress.org zur direkten ZIP-Installation und GitHub.

= 2.0.1 · 2019-09-23 =

* Verbessert: Die Empfehlungs-Library 1.5.0 speichert Daten zwischen und vermeidet wiederholte Abfragen.

= 2.0.0 · 2019-05-04 =

* Neu: Eigene Plugin-/Theme-ZIP-Seiten und Installer-Verknüpfungen sind verfügbar.
* Neu: Der Website-Zustand enthält Plugin-Diagnosen unter WordPress ab 5.2.
* Neu: Ein Newsletter für DECKERWEB Plugins ist verfügbar.
* Verbessert: Die Empfehlungs-Library 1.4.0 und deutsche Du-/Sie-Übersetzungen wurden aktualisiert.

= 1.9.4 · 2018-11-03 =

* Verbessert: Die Empfehlungs-Library 1.2.0 verbessert die Installer-Darstellung und Dark-Mode-Kompatibilität.

= 1.9.3 · 2018-10-01 =

* Neu: Eine Facebook-Gruppe bietet Unterstützung für DECKERWEB Plugins.
* Verbessert: Die Empfehlungs-Library 1.1.0 verbessert Upload-Bereiche und Plugin-Karten einschließlich sichtbarer Versionsnummern.
* Verbessert: Deutsche Übersetzungen wurden aktualisiert.

== Upgrade Notice ==

= 4.0.0 =
WordPress 6.7/PHP 8.2 erforderlich. Eigene 3.x-Snippets prüfen; WordPress-Menüs bleiben erhalten.

== Credits ==

David Decker – DECKERWEB, GPL-2.0-or-later.
https://github.com/deckerweb/multisite-toolbar-additions/blob/master/docs/LIBRARIES-de.md
