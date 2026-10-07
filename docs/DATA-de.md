# Gespeicherte Daten und Lebenszyklus

[English](DATA.md) · [Deutsch](DATA-de.md)

Für einzelne WordPress-Websites und Multisite-Netzwerke. Beide werden seit 2012 unterstützt.

Die Toolbar-Konfiguration liegt in mstba_settings: eine normale Option auf Einzel-Websites, eine Option je Netzwerk in Multisite. Quellmenüs bleiben gewöhnliche WordPress-Menüinhalte. Theme-Menüpositionen bleiben gewöhnliche Theme-Daten. Das Plugin plant keine Cronereignisse und erstellt keine Tabellen. Neue Websites verwenden ihre Netzwerkkonfiguration ohne Initialisierungsschreibzugriffe.

Deaktivierung erhält Daten. Deinstallation leert nur den Repository-Metadatencache dieses Plugins: ddw_ghru_ plus die ersten 24 Hexadezimalzeichen des MD5 der Repository-URL. Toolbar-Einstellungen bleiben standardmäßig erhalten. delete_data ist anfangs aus und betrifft nur die jeweilige Website bzw. das Netzwerk; physische Entfernung berücksichtigt die Entscheidung jedes Netzwerks. Menüs, Themes, installierte Plugins und Inhalte werden niemals gelöscht.

Die gemeinsame Library besitzt unabhängige Einstellungen und die Löschpräferenz delete_settings. Siehe ihr [Dateninventar](https://github.com/deckerweb/deckerweb-plugin-library/blob/v0.6.0/docs/DATA-de.md). Temporäre Caches und registrierte Downloadreste werden erst beim letzten installierten Library-Host bereinigt. Deaktivierte installierte Hosts zählen weiterhin. Dieser Host verwendet seine eigene Löschpräferenz niemals zum Löschen von Library-Daten. Für die kleine flache Konfiguration wird kein umfangreicher Datenexport/-import ergänzt; vorhandene Werte und alte Konstanten bleiben kompatibel.

Menüvorschauen sind authentifizierte, schreibfreie Anfragen. Sie speichern keine Entwürfe oder Menüinhalte. Der Marker upload_menu_defaults innerhalb von mstba_settings vermerkt beim nächsten Speichern die freigegebene einmalige Änderung zum sichtbaren Theme-ZIP-Untermenü-Standard; öffentliche Lesezugriffe schreiben ihn nicht. Spätere ausdrücklich gewählte Untermenü-Schalter bleiben wirksam.
