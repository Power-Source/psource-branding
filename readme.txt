=== PSOURCE Toolkit ===
Contributors: DerN3rd (PSOURCE)
Author URI: https://github.com/Power-Source
Tags: classicpress-plugin, classicpress, white label classicpress, custom login page, login page customizer, whitelabel, customize system emails, customize default emails, rebrand, rebranding, coming soon page, maintenance mode, under construction page, coming soon template, login screen
Requires at least: 4.6
Tested up to: 6.8.1
ClassiPress: 2.7.0
Stable tag: 1.0.5
Requires PHP: 8.0.0
License: GPL v2 - http://www.gnu.org/licenses/old-licenses/gpl-2.0.html

White Label & Rebranding Deiner Anmeldeseite & ClassicPress-Dashboard. Passe System-E-Mails an und lasse ClassicPress mit CP Toolkit umbenennen.


== Description ==

Passe jeden Aspekt von ClassicPress an Deine Marke an, indem Du CP Toolkit verwendest, das einzige Premium- und 100% kostenlose White-Label-Plugin für ClassicPress. Verwandel Dein Dashboard, passe System-E-Mails (Standard-E-Mails) an, schalte den Wartungsmodus und die bald erscheinenden Zielseiten schnell um, ändere jeden Aspekt Deines Anmeldebildschirms, entferne oder ersetze Logos, erstelle Farbschemata und vieles mehr. PSToolkit bietet alles, um ClassicPress kostenlos umzubenennen, ohne Code zu berühren.**

Spare Zeit, beseitige Probleme mit der Plugin-Kompatibilität und verbessere die Sicherheit mit einem Plugin und ohne weitere Hack-Änderungen.

Selbst die besten ClassicPress-Theme-Builder verlassen das ClassicPress-Branding auf Deiner Webseite. CP Toolkit hilft Dir beim Rebranding!

In Deinem persönlichen Blog ist dies kein großes Problem, aber für ein kleines Unternehmen, eine Design- und Entwicklungsagentur oder eine professionelle Webseite ist ein fertiger Look mit einem vollständigen Markenpaket wichtig. Hier kommt PSToolkit ins Spiel! Verwandel Dein ClassicPress in Deine eigene White-Label-Lösung.

Mehr als 30 Module im CP Toolkit enthalten!


== Entwicklung ==

Regressionstests: npm install und npm test (Node.js 18+).
Hinweis: npm run sync:shared-ui und npm run build ersetzen assets/js/shared-ui.js aus der Shared-UI-Quelle. Der Select-Sicherheitsfix muss dort ebenfalls vorhanden sein; nach einem Sync Tests ausfuehren und das minifizierte Bundle aktualisieren.


== Changelog ==

= Unreleased =
* Security: Select-Labels werden als Text statt HTML eingefuegt; Farbwerte und Icon-Klassen werden ueber DOM-Setter gesetzt.
* Tests: DOM-Regressionstests fuer Shared-UI-Selects ergaenzt (npm install und npm test; Node.js 18+).
* Security: Exponentielles Regex-Backtracking im gebuendelten ACE-Tokenizer bei langen Backslash-Folgen in Zeichenklassen behoben.
* Tests: ACE-Tokenizer-Regressionstests mit npm test ausfuehrbar (Node.js 18+).

= 1.0.5 =
* Fix: E-Mail-Template-Rendering beschleunigt (falsche Inline-Style-Parameterreihenfolge korrigiert).
* Fix: Unnoetige, teure Verarbeitung im Vorschau-Pfad entfernt.
* Fix: E-Mail-Template-Editor greift jetzt deterministisch auf das Feld simple_options[content][email] zu.
* Fix: ACE-Editor/Hidden-Textarea-Synchronisierung fuer E-Mail-Template beim Laden, Bearbeiten und Speichern gehaertet.
* Fix: Globaler Speichern-Flow verbessert; Button zielt jetzt robust auf das korrekte Modul-Formular.
* Fix: Formularbindung fuer oberen "Aenderungen speichern"-Button via form-Attribut ergaenzt (JS-unabhaengiger Submit-Pfad).
* Fix: Frueher JS-Abbruch im Admin-Ready-Flow behoben, damit globale Save-Handler nicht mehr ausfallen.
* Fix: Sidebar-Modulnavigation verbessert; Tabs besitzen echte Fallback-Links und funktionieren auch ohne aktives JS.
* Fix: Asset-Enqueue auf Branding-Seiten gehaertet (Fallback-Hook fuer Admin-Assets ergaenzt).
* Fix: Hard-Dependency-Kette entschlackt, damit Kern-Adminlogik bei teilweisem Asset-Ausfall weiterlaeuft.
* Fix: Veraltete ClassicPress-Abhaengigkeit wp-pointer samt jquery-ui-core-Folgeabhaengigkeit aus dem Admin-Asset-Stack entfernt.
* Fix: Toolkit-TinyMCE ohne Legacy-wplink, Quicktags und automatische Medienbuttons konfiguriert; veraltete jQuery-UI-Autocomplete-Kette entfernt.

= 1.0.4 =
* Fix: Passwortfelder mit sinnvollen autocomplete-Attributen versehen.
* Verbesserung: Admin- und Shared-UI-Bundles neu gebaut, damit aktuelle Fixes sicher ausgeliefert werden.

= 1.0.3 =

* Fix: Auth-Konflikte bei Subseiten-Login in Multisite reduziert (konfliktarme Redirect-Behandlung)

= 1.0.2 =

* Fix: PHP Deprecated "Using null as an array offset" in class-pstoolkit-helper.php behoben
* Security: Zusätzliche Berechtigungsprüfungen für kritische Admin-AJAX-Endpunkte ergänzt
* Security: Feed-URL-Abruf gegen unsichere interne/private Ziele gehärtet (SSRF-Schutz)
* Security: SVG/ICO-MIME-Freigabe auf berechtigte Admin-Benutzer eingeschränkt

= 1.0.1 =

* Etliche Bugfixes
* PhP8 Anpassung

= 1.0.0 =

* Release

