# Anleitung

[English](English.md) · [Deutsch](Deutsch.md) · [Fragen nach Themen](FAQ-Deutsch.md) · [Home](Home.md)

Ein konfigurierbares WordPress-Menü in der Toolbar mit nützlichen Website- und Netzwerk-Verknüpfungen. Teil von QuickNav; für Einzel-Websites und Multisite-Netzwerke.

Noch nicht veröffentlichte Vorbereitung für 4.1.0 auf Grundlage von 4.0.0: gemeinsame Leitstand-Verlinkung und eigene Plugin-/Theme-ZIP-Seiten mit Drag-and-drop und Metadatenvorschau. Die veröffentlichte 4.0.0-ZIP bleibt unverändert.

## Installation und erste Schritte

Benötigt WordPress 6.7+ und PHP 8.2+. Installiere die veröffentlichte ZIP über Plugins → Installieren → Plugin hochladen. Öffne Einstellungen → Toolbar-Erweiterungen. Bei Netzwerkaktivierung verwende Netzwerkverwaltung → Einstellungen → Toolbar-Erweiterungen. Einzelaktivierung verwendet die Einstellungsseite der aktiven Website; Netzwerkeinstellungen benötigen weiterhin einen Super-Administrator. Der optionale Katalog-Installer benötigt PHP ZipArchive. Prüfe eigene 3.x-Snippets vor einem großen Upgrade.

## Dein WordPress-Menü

Wähle Quellwebsite und Menü unabhängig vom Theme. Zeige Haupteinträge einzeln oder gruppiere sie unter dem Menünamen. Eine eigene Beschriftung ist optional.

## Position, Sichtbarkeit und Tiefe

Wähle zuerst/zuletzt, vor/nach einem Bezugseintrag oder die rechte Seite. Zeige das Menü im Frontend, im Admin oder in beiden. Wähle eine bis zehn Kindebenen oder alle. Fehlt der Bezugseintrag, erscheint das Menü am Ende.

## Upload-Verknüpfungen

Plugin und Theme stehen unter Neu am Ende. Jeder Eintrag und jedes ZIP-Untermenü hat einen eigenen Schalter: Plugins an, Themes aus. Upload-Links verwenden die aktiven Leitstand-Seiten oder eigene Plugin-/Theme-Seiten mit Drag-and-drop und begrenzter Metadatenvorschau; WordPress übernimmt die Installation.

## Multisite-Verwaltung

Nutze eine netzwerkweite Menüquelle mit optionaler Sichtbarkeit für Website-Administratoren. Gemeinsame Menüs dürfen nur Super-Administratoren bearbeiten. Zielseiten-Rechte gelten weiterhin; zusätzliche Website-Verknüpfungen sind begrenzt.

## Gemeinsame Komponenten

Library 0.6.0 bietet kuratierte Plugins mit Voraussetzungs-/Prüfsummenprüfung und optionalen Online-Katalogupdates. Updater 2.1.0 nutzt normale WordPress-Updates. Assets sind lokal; es gibt keine Telemetrie.

## Daten und Berechtigungen

Deaktivierung erhält alle Einstellungen und WordPress-Menüs. Deinstallation leert den Updatecache dieses Plugins. Toolbar-Einstellungen bleiben erhalten, sofern die Löschoption für die jeweilige Website oder das Netzwerk nicht aktiviert wurde. Bei physischer Entfernung wird die eigene Entscheidung jedes Netzwerks berücksichtigt. Die gemeinsame Library wird erst beim letzten installierten Host bereinigt, auch deaktivierte Hosts zählen; ihre Löschoption ist unabhängig. Installierte Plugins, Navigationsmenüs und fremde Inhalte bleiben erhalten.

Die Sichtbarkeit des Menüs und die Berechtigung zur Bearbeitung der Quelle sind getrennt. Gemeinsame Multisite-Quellmenüs werden vor unberechtigten Änderungen im Admin, per REST und im Customizer geschützt.
