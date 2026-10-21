=== Multisite Toolbar Additions ===
Contributors: ddecker
Donate link: https://paypal.me/deckerweb
Tags: toolbar, admin bar, multisite, navigation
Requires at least: 6.7
Tested up to: 7.1
Requires PHP: 8.2
Stable tag: 4.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WordPress-Menüs und Verwaltungsverknüpfungen in der Toolbar.

== Description ==

**Für einzelne WordPress-Websites und Multisite-Netzwerke. Beide werden seit 2012 unterstützt.**

Dein WordPress-Menü in der Toolbar – ergänzt um praktische Schnellzugriffe für die Verwaltung. Teil der QuickNav-Serie.

Multisite Toolbar Additions habe ich 2012 für meinen eigenen Bedarf entwickelt. Seitdem gehört es zu jeder meiner privaten und Kundeninstallationen und ist bis heute eines meiner liebsten Helferplugins für den WordPress-Alltag.



* Wähle Quellwebsite und Menü unabhängig vom Theme. Zeige Haupteinträge einzeln oder gruppiere sie unter dem Menünamen. Eine eigene Beschriftung ist optional.
* Wähle zuerst/zuletzt, vor/nach einem Bezugseintrag oder die rechte Seite. Zeige das Menü im Frontend, im Admin oder in beiden. Wähle eine bis zehn Kindebenen oder alle. Fehlt der Bezugseintrag, erscheint das Menü am Ende.
* Plugins und Themes stehen im Website-Toolbar-Menü direkt nacheinander, auch in Multisite. Ergänzungen unter Neu stehen am Ende und besitzen unabhängige Schalter: Plugins an, Themes aus. Beide ZIP-Admin-Untermenüs sind standardmäßig an. Upload-Links verwenden die verfügbaren gemeinsamen Upload-Seiten oder eigene Seiten mit Drag-and-drop und begrenzter Metadatenvorschau; WordPress übernimmt die Installation.
* Nutze eine netzwerkweite Menüquelle mit optionaler Sichtbarkeit für Website-Administratoren. Gemeinsame Menüs dürfen nur Super-Administratoren bearbeiten. Zielseiten-Rechte gelten weiterhin; zusätzliche Website-Verknüpfungen sind begrenzt.
* Library 1.1.0 bietet kuratierte Plugins mit Voraussetzungs-/Prüfsummenprüfung und optionalen Online-Katalogupdates. Updater 2.2.0 nutzt normale WordPress-Updates. Assets sind lokal; es gibt keine Telemetrie.
* Prüfe die Menüstruktur mit ausgewählter Tiefe und Gruppierung ohne Speichern. Eine kompakte Übersicht erklärt Sichtbarkeit, Positionierung und verwendete Uploader. Fehlende Quellen und auf der aktuellen Seite fehlende Toolbar-Bezugseinträge werden erläutert.
* Aktives DevKit Pro, WP Debug Toolkit und WP Admin Cleaner erscheinen in einer kompakten Gruppe unter dem Website-Eintrag der Toolbar. Geprüfte Modul- und Einstellungslinks sind nur für Administratoren und Super-Administratoren sichtbar. Zugriffsbeschränkungen der Plugins bleiben erhalten. Die Gruppe lässt sich unter dem Website-Eintrag oder rechts mit einem von drei eigenen Icons platzieren. Ihr Name ist anpassbar. WP Debug Toolkit öffnet zuerst seinen eingerichteten Debug Viewer mit dem konfigurierten Slug; die Plugin-Einstellungen bleiben direkt erreichbar.
* Der deckerweb Katalog erscheint bei Verfügbarkeit unter Neu und Toolbar-Einstellungen. Library-Einstellungen bleiben auch bei ausgeblendetem Katalog erreichbar. Multisite-Verknüpfungen benötigen einen netzwerkaktiven Host und passende Berechtigungen.

== Installation ==

Benötigt WordPress 6.7+ und PHP 8.2+. Installiere die veröffentlichte ZIP über Plugins → Installieren → Plugin hochladen. Öffne Einstellungen → Toolbar-Erweiterungen. Bei Netzwerkaktivierung verwende Netzwerkverwaltung → Einstellungen → Toolbar-Erweiterungen. Einzelaktivierung verwendet die Einstellungsseite der aktiven Website; Netzwerkeinstellungen benötigen weiterhin einen Super-Administrator. Der optionale Katalog-Installer benötigt PHP ZipArchive. Prüfe eigene 3.x-Snippets vor einem großen Upgrade.

== Frequently Asked Questions ==

= Ist Multisite erforderlich? =

Nein. Einzelne WordPress-Websites und Multisite-Netzwerke werden beide seit der ersten Veröffentlichung 2012 unterstützt. Auch auf einer einzelnen Website sind das konfigurierbare Toolbar-Menü, Plugin-/Theme-ZIP-Uploader, Menüvorschau und Einstellungen nutzbar. In Multisite kommen Netzwerkverwaltung und gemeinsame Menüs hinzu.

= Wie wähle ich das Toolbar-Menü? =

Erstelle ein normales Navigationsmenü und wähle Quellwebsite und Menü in den Einstellungen. Netzwerkaktivierung verwendet standardmäßig die Haupt-Website; Einzelaktivierung die aktive Website. Aktiviere das Plugin auf der Quellwebsite oder netzwerkweit, damit der Schutz des gemeinsamen Menüs greifen kann. Die alte Menüposition mstba_menu bleibt als Rückfalllösung erhalten.

= Kann ich Position und Sichtbarkeit ändern? =

Ja: zuerst, zuletzt, vor oder nach einem Toolbar-Eintrag oder rechts. Wähle Frontend, Admin oder beide und die zugelassenen Benutzer. Fehlt der Bezugseintrag, erscheint das Menü am Ende.

= Dürfen Website-Administratoren das gemeinsame Menü bearbeiten? =

Die Sichtbarkeit des Menüs und die Berechtigung zur Bearbeitung der Quelle sind getrennt. Gemeinsame Multisite-Quellmenüs werden vor unberechtigten Änderungen im Admin, per REST und im Customizer geschützt.

= Welche Upload-Verknüpfungen sind standardmäßig aktiv? =

Plugin-ZIP- und Theme-ZIP-Admin-Untermenüs sind aktiv. Der frühere ausgeschaltete Theme-Untermenü-Standard wird einmalig ersetzt; beim nächsten Speichern wird dieser Übergang vermerkt, danach bleibt ein ausdrücklich ausgeschalteter Schalter erhalten. Unter + Neu bleibt Plugin aktiv und Theme deaktiviert. Jeder Eintrag besitzt einen eigenen Schalter. Themes steht im Website-Toolbar-Menü direkt unter Plugins, auch in Multisite.

= Wie funktionieren Plugin-Updates? =

Der mitgelieferte deckerweb Updater 2.2.0 prüft dieses festgelegte öffentliche Repository und speichert Release-Metadaten zwischen. WordPress steuert einzelne, gemeinsame und automatische Updates. Das Plugin aktiviert keine automatischen Updates. Pakete müssen vor dem Austausch Angebotsversion, Plugin-Identität und Plattformanforderungen erfüllen.

= Was passiert bei Deaktivierung oder Deinstallation? =

Deaktivierung erhält alle Einstellungen und WordPress-Menüs. Deinstallation leert den Updatecache dieses Plugins. Toolbar-Einstellungen bleiben erhalten, sofern die Löschoption für die jeweilige Website oder das Netzwerk nicht aktiviert wurde. Bei physischer Entfernung wird die eigene Entscheidung jedes Netzwerks berücksichtigt. Die gemeinsame Library wird erst beim letzten installierten Host bereinigt, auch deaktivierte Hosts zählen; ihre Löschoption ist unabhängig. Installierte Plugins, Navigationsmenüs und fremde Inhalte bleiben erhalten.

Fragen nach Themen: https://github.com/deckerweb/multisite-toolbar-additions/wiki/FAQ-Deutsch

== Changelog ==

= 4.2.0 · 2026-10-21 =

* Neu: Eine kompakte Gruppe Admin-Werkzeuge verlinkt aktives DevKit Pro, WP Debug Toolkit und WP Admin Cleaner mit geprüften Modul-/Tab-Zielen und Zugriff nur für Administratoren. Position, Name und Icon für die rechte Position sind einstellbar.
* Neu: Der deckerweb Plugin-Katalog ist unter Neu und Toolbar-Einstellungen erreichbar; verfügbare Library-Einstellungen sind ebenfalls verlinkt. Ausgeblendete Kataloge und Benutzerrechte bleiben berücksichtigt.
* Verbessert: Library 1.1.0 und Updater 2.2.0 bieten gemeinsame Katalogsteuerung, geprüfte Katalogupdates und klarere Hinweise bei aktivem Git Updater. Online-Katalogabfragen bleiben optional und standardmäßig aus.
* Verbessert: Aktualisierte lokale Grafiken und verständlichere, übersetzte Verwaltungsdokumentation. WordPress 6.7 und PHP 8.2 bleiben die Mindestanforderungen.
* Behoben: Doku- und Changelog-Dialoge bleiben geschlossen auch bei kollidierenden Admin-Stilen unsichtbar; das Schließen funktioniert auch ohne den Dokument-Controller.
* Behoben: Einstellungen und Vorschauanfragen prüfen eingehende Werte direkt bei der Übernahme; Vorschau- und Dokumentausgaben sind auf erlaubtes HTML begrenzt. Bestehende Toolbar-Einstellungen und WordPress-Menüs bleiben erhalten.

= 4.1.0 · 2026-10-07 =

* Neu: Eigene Plugin- und Theme-ZIP-Seiten bieten Drag-and-drop, Paketvorschau und ausdrückliche Installationsbestätigung. Verfügbare gemeinsame Uploader werden ohne doppelte Seiten verwendet.
* Neu: Menüstruktur, Gruppierung und Kindebenen lassen sich ohne Speichern prüfen; die Übersicht zeigt wirksame Einstellungen, verwendete Uploader und Hinweise zu fehlenden Menüquellen oder Toolbar-Bezugseinträgen.
* Verbessert: Eine beim Scrollen erreichbare Speichern-Leiste warnt vor dem Verlust ungespeicherter Änderungen. Das Feld für die gemeinsame Menübeschriftung ist größer.
* Verbessert: Beide ZIP-Admin-Untermenüs sind standardmäßig aktiv; der bisher ausgeschaltete Theme-Untermenü-Standard wird einmalig ersetzt. Spätere ausdrückliche Schalterentscheidungen bleiben erhalten. Der separate Theme-Eintrag unter Neu bleibt standardmäßig aus.
* Verbessert: Plugins und Themes stehen im Website-Toolbar-Menü direkt nacheinander, auch in Multisite. Einzelaktivierung wird mit durch Super-Administratoren verwalteten Netzwerkeinstellungen unterstützt.
* Verbessert: Gemeinsame Komponenten auf Library 0.6.0 und Updater 2.1.0 aktualisiert, mit deutschen Du-/Sie-Übersetzungen und lesbarem lokalem Änderungsverlauf.
* Behoben: Vertauschte Plugin-/Theme-ZIPs werden mit einem Hinweis zum passenden Uploader erkannt. Neue Theme-Pakete können vor ihrer ersten Installation korrekt angezeigt werden.
* Behoben: Identität, Version und Anforderungen von Updatepaketen werden auch bei Sammelupdates geprüft; das Speichern erfordert authentifizierte POST-Anfragen.
* Behoben: Toolbar-Funktionen bleiben bei unvollständigen gemeinsamen Komponenten verfügbar; fehlerhafte Integrationseinträge werden sicher übersprungen und die letzte Position bleibt auch nach späten Toolbar-Ergänzungen erhalten.
* Behoben: Lokale CSS- und JavaScript-Dateien werden bei geänderten Paketinhalten neu geladen, auch beim Austausch derselben Version.
* Sonstiges: Deaktivierung erhält Daten. Deinstallation leert eigene Update-Caches; das Löschen der Toolbar-Einstellungen bleibt optional und standardmäßig aus. WordPress-Menüs und Daten anderer Plugins bleiben erhalten.
* Sonstiges: Unterstützung für einzelne WordPress-Websites und Multisite-Netzwerke in der gesamten Dokumentation deutlicher herausgestellt.

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

== Upgrade Notice ==

= 4.2.0 =
Admin-Werkzeuge und Library-Verknüpfungen ergänzt; gemeinsame Komponenten und Dialoge aktualisiert. Einstellungen und WordPress-Menüs bleiben erhalten. WordPress 6.7/PHP 8.2 weiterhin erforderlich.

== Credits ==

David Decker – DECKERWEB, GPL-2.0-or-later.
https://github.com/deckerweb/multisite-toolbar-additions/blob/master/docs/LIBRARIES-de.md
