# Fragen nach Themen

[English](FAQ-English.md) · [Deutsch](FAQ-Deutsch.md) · [Home](Home.md)

## Einstieg

### Ist Multisite erforderlich?

Nein. Das Plugin funktioniert auf einzelnen WordPress-Websites und in Multisite-Netzwerken. Netzwerk-Verknüpfungen erscheinen nur dort, wo sie sinnvoll sind.

### Wo finde ich die Einstellungen?

Einzelinstallation: Einstellungen → Toolbar-Erweiterungen. Netzwerkaktivierung: Netzwerkverwaltung → Einstellungen → Toolbar-Erweiterungen. Bei Einzelaktivierung in Multisite verwendet ein Super-Administrator Einstellungen → Toolbar-Erweiterungen auf der aktiven Website; die Einstellungen gelten weiterhin für das Netzwerk.

### Wie wähle ich das Toolbar-Menü?

Erstelle ein normales Navigationsmenü und wähle Quellwebsite und Menü in den Einstellungen. Netzwerkaktivierung verwendet standardmäßig die Haupt-Website; Einzelaktivierung die aktive Website. Aktiviere das Plugin auf der Quellwebsite oder netzwerkweit, damit der Schutz des gemeinsamen Menüs greifen kann. Die alte Menüposition mstba_menu bleibt als Rückfalllösung erhalten.

## Dein Toolbar-Menü

### Wie lautet der Standardtitel?

Wie der Name des ausgewählten WordPress-Menüs. Ein leeres eigenes Titelfeld behält diesen automatischen Namen bei.

### Kann ich Position und Sichtbarkeit ändern?

Ja: zuerst, zuletzt, vor oder nach einem Toolbar-Eintrag oder rechts. Wähle Frontend, Admin oder beide und die zugelassenen Benutzer. Fehlt der Bezugseintrag, erscheint das Menü am Ende.

### Was bedeutet Menütiefe?

Eine Kindebene umfasst direkte Untereinträge; zwei zusätzlich deren Kinder. Null bedeutet alle verfügbaren Ebenen. Einstellbar sind bis zu zehn Kindebenen.

### Warum fehlt mein Menü im Frontend?

WordPress muss die Toolbar für den aktuellen Benutzer anzeigen. Prüfe außerdem Aktivierung, Benutzerkreis, Frontend-Sichtbarkeit, Quell-Website und Menü. Das Plugin erzwingt keine Toolbar für Besucher.

### Gilt meine persönliche Toolbar-Einstellung?

Ja. Das Plugin berücksichtigt die WordPress-Profiloption zur Anzeige der Toolbar im Frontend. Wer sie ausgeblendet hat, erhält keine erzwungene Frontend-Toolbar. Menüquelle, Position und Verknüpfungen bleiben Website-/Netzwerkeinstellungen.

### Speichert die Menüvorschau Änderungen?

Nein. Ohne JavaScript zeigt sie die gespeicherten Einstellungen. Mit JavaScript aktualisiert eine Änderung an den Menüfeldern eine signierte, schreibfreie Vorschau noch nicht gespeicherter Werte. Erst Änderungen speichern sichert die Einstellungen. Vorschau-Einträge führen nicht zu den verlinkten Zielen. Die Vorschau zeigt bis zu 200 Einträge, ohne das tatsächliche Toolbar-Menü zu begrenzen. Die Prüfung des Bezugseintrags gilt für die aktuelle Seite, nicht für sämtliche Frontend- oder Adminansichten.

## Multisite und Berechtigungen

### Dürfen Website-Administratoren das gemeinsame Menü bearbeiten?

Die Sichtbarkeit des Menüs und die Berechtigung zur Bearbeitung der Quelle sind getrennt. Gemeinsame Multisite-Quellmenüs werden vor unberechtigten Änderungen im Admin, per REST und im Customizer geschützt.

## Installationsverknüpfungen

### Welche Upload-Verknüpfungen sind standardmäßig aktiv?

Plugin-ZIP- und Theme-ZIP-Admin-Untermenüs sind aktiv. Der frühere ausgeschaltete Theme-Untermenü-Standard wird einmalig ersetzt; beim nächsten Speichern wird dieser Übergang vermerkt, danach bleibt ein ausdrücklich ausgeschalteter Schalter erhalten. Unter + Neu bleibt Plugin aktiv und Theme deaktiviert. Jeder Eintrag besitzt einen eigenen Schalter. Themes steht im Website-Toolbar-Menü direkt unter Plugins, auch in Multisite.

### Wo stehen die Ergänzungen unter + Neu?

Plugin und Theme stehen am Ende der Gruppe + Neu, auch nach spät registrierten Inhaltstypen. WordPress-Berechtigungen bestimmen weiterhin ihre Verfügbarkeit.

### Wie funktionieren die Plugin- und Theme-ZIP-Uploader?

Ist Leitstand aktiv und sein Uploader für dich verfügbar, führen Toolbar und Adminmenü zu dessen Seiten; doppelte Upload-Seiten werden vermieden. Sonst stellt dieses Plugin eigene Seiten mit Drag-and-drop, Größenprüfung und temporärer Metadatenvorschau bereit. Installation und Ersetzen übernimmt WordPress. Ohne JavaScript funktioniert der native Upload direkt. Die Vorschau ist keine Schadsoftwareprüfung oder Kompatibilitätsgarantie. Sie verwendet keinen Leitstand-Nutzungsindex. In Multisite gelten gemeinsame Dateien für sämtliche Websites und Netzwerke; nur entsprechend berechtigte Benutzer können installieren. Leitstand-Benutzerausschlüsse werden berücksichtigt. Die Schalter dieses Plugins steuern seine eigenen Menüverknüpfungen, nicht bereits vorhandene Leitstand-Einträge.

## Library und Updates

### Was ist die deckerweb Plugin Library?

Ein gemeinsamer Installer-Reiter für freigegebene deckerweb Plugins. Library 0.6.0 prüft Paketprüfsummen und Abhängigkeiten, trennt Installation von Aktivierung und verwendet eine gemeinsam gewählte Laufzeit für teilnehmende Plugins. Der Offline-Katalog enthält eine Vorbereitungsvorschau; Online-Katalogupdates sind optional und standardmäßig aus. In Multisite muss ein teilnehmender Host netzwerkweit aktiviert sein, damit die Library in der Netzwerkverwaltung verfügbar ist.

### Kontaktiert die Library auf jeder Seite GitHub?

Nein. Mitgelieferter Katalog und Grafiken funktionieren lokal. Angeforderte Paket-Downloads kontaktieren die festgelegten Hosts. Der optionale Online-Katalog ist standardmäßig deaktiviert und verwendet Cache und Wiederholungsabstände.

### Wie funktionieren Plugin-Updates?

Der mitgelieferte deckerweb Updater 2.1.0 prüft dieses festgelegte öffentliche Repository und speichert Release-Metadaten zwischen. WordPress steuert einzelne, gemeinsame und automatische Updates. Das Plugin aktiviert keine automatischen Updates. Pakete müssen vor dem Austausch Angebotsversion, Plugin-Identität und Plattformanforderungen erfüllen.

## Deine Daten

### Was passiert bei Deaktivierung oder Deinstallation?

Deaktivierung erhält alle Einstellungen und WordPress-Menüs. Deinstallation leert den Updatecache dieses Plugins. Toolbar-Einstellungen bleiben erhalten, sofern die Löschoption für die jeweilige Website oder das Netzwerk nicht aktiviert wurde. Bei physischer Entfernung wird die eigene Entscheidung jedes Netzwerks berücksichtigt. Die gemeinsame Library wird erst beim letzten installierten Host bereinigt, auch deaktivierte Hosts zählen; ihre Löschoption ist unabhängig. Installierte Plugins, Navigationsmenüs und fremde Inhalte bleiben erhalten.

## Kompatibilität und Fehlersuche

### Welche Versionen werden unterstützt?

WordPress ab 6.7 und PHP ab 8.2. Lokale Integrationsprüfungen verwenden PHP 8.4; CI prüft zusätzlich PHP 8.2. PHP-7-Kompatibilität wird nicht zugesichert.

### Bleibt mein 3.x-Menü beim Upgrade erhalten?

Ja: bestehende Navigationsmenüs bleiben in WordPress. Die alte Menüposition mstba_menu wird weiterhin erkannt. Prüfe nach dem ersten Upgrade neue Einstellungen und optionale Verknüpfungen. Sichere die Installation vor einem großen Versionswechsel.

### Warum fehlen manche Verknüpfungen?

Verknüpfungen hängen von Rechten, aktiven Integrationen, Multisite-Kontext und Theme-Funktionen ab. Block-Themes bieten den Website-Editor, klassische Themes ihre passenden Anpassungsseiten. Datei-Editoren sind optional und beachten WordPress-Einschränkungen.

### Wie skaliert das Plugin in großen Netzwerken?

Menüdaten werden innerhalb einer Anfrage wiederverwendet, Websites durch das konfigurierbare Limit begrenzt und Frontend-Dateien nur bei Bedarf geladen. Es gibt keine vollständige Netzwerk-Abfrage auf jeder Seite. Die tatsächliche Geschwindigkeit hängt auch von WordPress und anderen Plugins ab.

## Hilfe und Sicherheit

### Wie melde ich einen Fehler?

Für gewöhnliche Fragen und Fehler nutze GitHub Issues oder Discussions. Vermutete Sicherheitslücken melde über das private Sicherheitsformular des Repositorys; siehe SECURITY.md. Nenne Plugin-, Library-, WordPress- und PHP-Version sowie bereinigte Schritte zur Reproduktion. Keine Zugangsdaten oder privaten Inhalte mitsenden.
