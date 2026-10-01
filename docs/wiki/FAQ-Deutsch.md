# Häufige Fragen

[Documentation](./Deutsch.md) · [Home](./Home.md)

## Ist Multisite erforderlich?

Nein. Das Plugin funktioniert auf einzelnen WordPress-Websites und in Multisite-Netzwerken. Netzwerk-Verknüpfungen erscheinen nur dort, wo sie sinnvoll sind.

## Wo finde ich die Einstellungen?

Einzelinstallation: Einstellungen → Toolbar Additions. Multisite: Netzwerkverwaltung → Einstellungen → Toolbar Additions; netzwerkweite Änderungen benötigen einen Super-Administrator.

## Wie wähle ich das Toolbar-Menü?

Erstelle ein normales Navigationsmenü und wähle dessen Quell-Website und Menü in den Einstellungen. Standardquelle ist die Haupt-Website des Netzwerks. Die bisherige Menüposition mstba_menu bleibt als Rückfalllösung erhalten.

## Wie lautet der Standardtitel?

Wie der Name des ausgewählten WordPress-Menüs. Ein leeres eigenes Titelfeld behält diesen automatischen Namen bei.

## Kann ich Position und Sichtbarkeit ändern?

Ja: zuerst, zuletzt, vor oder nach einem Toolbar-Eintrag oder rechts. Wähle Frontend, Admin oder beide und die zugelassenen Benutzer. Fehlt der Bezugseintrag, erscheint das Menü am Ende.

## Was bedeutet Menütiefe?

Eine Kindebene umfasst direkte Untereinträge; zwei zusätzlich deren Kinder. Null bedeutet alle verfügbaren Ebenen. Einstellbar sind bis zu zehn Kindebenen.

## Warum fehlt mein Menü im Frontend?

WordPress muss die Toolbar für den aktuellen Benutzer anzeigen. Prüfe außerdem Aktivierung, Benutzerkreis, Frontend-Sichtbarkeit, Quell-Website und Menü. Das Plugin erzwingt keine Toolbar für Besucher.

## Dürfen Website-Administratoren das gemeinsame Menü bearbeiten?

Die Sichtbarkeit des Menüs und die Berechtigung zur Bearbeitung der Quelle sind getrennt. Gemeinsame Multisite-Quellmenüs werden vor unberechtigten Änderungen im Admin, per REST und im Customizer geschützt.

## Welche Upload-Verknüpfungen sind standardmäßig aktiv?

Plugin-ZIP-Untermenü und Plugin-Eintrag unter + Neu sind aktiv. Theme-ZIP-Untermenü und Theme-Eintrag unter + Neu sind deaktiviert. Jeder Eintrag besitzt einen eigenen Schalter.

## Wo stehen die Ergänzungen unter + Neu?

Plugin und Theme stehen am Ende der Gruppe + Neu, auch nach spät registrierten Inhaltstypen. WordPress-Berechtigungen bestimmen weiterhin ihre Verfügbarkeit.

## Wie funktioniert Theme-ZIP hochladen?

Das Plugin stellt eine Upload-Seite mit dem nativen WordPress-Formular und Installer bereit. In Multisite erfolgt die Installation in der Netzwerkverwaltung mit den entsprechenden Rechten. ZIP-Prüfungen und Sicherheitsprüfungen von WordPress bleiben erhalten.

## Was ist die deckerweb Plugin Library?

Ein gemeinsamer Installer-Reiter für kuratierte deckerweb Plugins. Standardmäßig nutzt er einen mitgelieferten Katalog, prüft SHA-256 und Voraussetzungen und trennt Installation von Aktivierung. Mehrere teilnehmende Plugins verwenden eine gemeinsam gewählte Library-Instanz.

## Kontaktiert die Library auf jeder Seite GitHub?

Nein. Mitgelieferter Katalog und Grafiken funktionieren lokal. Angeforderte Paket-Downloads kontaktieren die festgelegten Hosts. Der optionale Online-Katalog ist standardmäßig deaktiviert und verwendet Cache und Wiederholungsabstände.

## Wie funktionieren Plugin-Updates?

GitHub Release Updater V2 prüft dieses festgelegte öffentliche Repository und speichert Metadaten zwischen. Stabile Releases benötigen ein installierbares multisite-toolbar-additions-VERSION.zip. Bestehende WordPress-Einstellungen bestimmen automatische Updates; das Plugin aktiviert sie nicht selbst.

## Welche Versionen werden unterstützt?

WordPress ab 6.7 und PHP ab 8.2. Lokale Integrationsprüfungen verwenden PHP 8.4; CI prüft zusätzlich PHP 8.2. PHP-7-Kompatibilität wird nicht zugesichert.

## Bleibt mein 3.x-Menü beim Upgrade erhalten?

Ja: bestehende Navigationsmenüs bleiben in WordPress. Die alte Menüposition mstba_menu wird weiterhin erkannt. Prüfe nach dem ersten Upgrade neue Einstellungen und optionale Verknüpfungen. Sichere die Installation vor einem großen Versionswechsel.

## Warum fehlen manche Verknüpfungen?

Verknüpfungen hängen von Rechten, aktiven Integrationen, Multisite-Kontext und Theme-Funktionen ab. Block-Themes bieten den Website-Editor, klassische Themes ihre passenden Anpassungsseiten. Datei-Editoren sind optional und beachten WordPress-Einschränkungen.

## Wie skaliert das Plugin in großen Netzwerken?

Menüdaten werden innerhalb einer Anfrage wiederverwendet, Websites durch das konfigurierbare Limit begrenzt und Frontend-Dateien nur bei Bedarf geladen. Es gibt keine vollständige Netzwerk-Abfrage auf jeder Seite. Die tatsächliche Geschwindigkeit hängt auch von WordPress und anderen Plugins ab.

## Wie melde ich einen Fehler?

Nutze GitHub Issues mit WordPress-/PHP-Versionen, Einzelinstallation oder Multisite, relevanten Einstellungen und Schritten zur Reproduktion. Entferne private URLs und Zugangsdaten aus Berichten.
