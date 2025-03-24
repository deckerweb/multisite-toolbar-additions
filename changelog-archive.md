## Multisite Toolbar Additions - Changelog Archive 


### ⚡ 1.9.4 - 2018-11-03
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.2.0) - which brings enhanced CSS styles, including for the "Dark Mode" plugin
* Tweak: Few internal code tweaks and improvements


### ⚡ 1.9.3 - 2018-10-01
* New: Created special [Facebook Group for user community support](https://www.facebook.com/groups/deckerweb.wordpress.plugins/) for all plugins from me (David Decker - DECKERWEB), this one here included! ;-) - [please join at facebook!](https://www.facebook.com/groups/deckerweb.wordpress.plugins/)
* Update: Small internal code improvements
* Update: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.1.0) - which brings smaller additions and enhancements, like CSS styles to the upload areas and plugin cards, plus plugin version number on plugin cards
* Update: `.pot` file plus all German translations (formal, informal) and language packs


### ⚡ 1.9.2 - 2018-09-08
* New: Added plugin update message also to Plugins page (overview table)
* Update: Fixed and improved various Plugins page links for Super Admins within the Admin area
* Update: Fixed CSS class name in the admin
* Update: Fixed wrong textdomain for one string
* Update: Improved plugin installer recommendations
* Update: `.pot` file for translators, plus German translations


### ⚡ 1.9.1 - 2018-08-22 
* New: Added first language packs via WordPress.org translations platform - for German (de_DE - informal) and German Formal (de_DE_formal) - thanks to Team WordPress DE! ;-)
* New: Added `composer.json` file to the plugin's root folder - this is great for developers using Composer
* New: Added `README.md` file for plugin's GitHub.com repository to make it more readable there
* Fix: Fatal error related to to Network Admin/ Multisite context.
* Removed: Plugin support for "Quick Cache" was removed as this plugin is no longer existing
* Update: Some smaller code tweaks and improvements
* Update: `.pot` file for translators, plus German translations
* Update: Readme.txt file
* *Trivia fact: this plugin is now 6 (six!) years old. Whoa, that's a lot. ;-)*


### 🎉 1.9.0 - 2018-04-01 
* *Maintenance release*
* Tweak: Improved security.
* Tweak: Updated all internal plugin links to current state, deleted the ones that were dead or no longer needed.
* Tweak: Added new plugin icon and banner on WordPress.org
* Update: `.pot` file for translators, plus German translations
* Update: Readme.txt file.


### 🎉 1.8.0 - 2014-10-20 
* **Unreleased - private beta version!**
* NEW: Added support for more (custom) post types in the "Manage Content" section.
* NEW: Added "Widget Customizer" admin deep link for WordPress 3.9+.
* UPDATE: Updated plugin installer & uploader admin links to be compatible with WordPress 4.0+.
* UPDATE: Updated theme installer & uploader admin links to be compatible with WordPress 3.9+.
* UPDATE: Updated labels for Super Admin/ Admin custom menus within the "Customizer".
* UPDATE: Updated German translations and also the .pot file for all translators!
* *Extended plugin support:*
 * NEW: Added support for "Smart Security Tools: Login Limit Add-On" (premium, by Smart Plugins/ Milan Petrovic).
 * NEW: Added support for "Smart Security Tools: Live Monitor Add-On" (premium, by Smart Plugins/ Milan Petrovic).
 * NEW: Added support for "Smart Robots.txt Tools" (premium, by Smart Plugins/ Milan Petrovic).
 * NEW: Added support for "iThemes Security" (free, by iThemes).
 * NEW: Added support for "iThemes Security Pro" (premium, by iThemes).
 * UPDATE: Updated and improved support for these plugins: "Snapshot", "Smart Security Tools", "Smart Options Optimizer", "Simple System Info", "Stream", "Quick Cache Pro".


### ⚡ 1.7.1 - 2014-04/05 
* *Unreleased - private beta version!*


### 🎉 1.7.0 - 2014-03-04 
* NEW: Highly improved "Nav Menu" support, all editable menus are now listed as sub level items for "Menus" entry. (Could be disabled via constant if needed.)
* NEW: As per user request I added an additional restricted Site Administrators toolbar menu. This is only effective in Multisite installs. Those menus can only be setup & edited via WP Nav Menus by Super Administrators - but then they are visible for administrator user roles (`edit_theme_options` capability).
* NEW: For Multisite, under "Plugins" added "Network Plugins" admin link for sub site admin areas - handy link to network wide plugins page.
* NEW: For Multisite, under "Themes" added "Network Theme Editor" admin link (respects all Editor disable stuff, hehe! :) for sub site admin areas - handy link to theme editor if needed.
* NEW: Added new logic to prevent other users than super admins from editing those custom (nav) menus that are used within the Toolbar.
* UPDATE: Removed all CSS that was added in v1.5.0 -- it was annoying and should not longer be there for WordPress 3.8 or higher. I guess this is finally for the better! :)
* UPDATE: Fixed double appearance of "Themes" and "Plugins" in Network Admin sublevel - now fixed for all instances :).
* CODE: Improved modular structure of the plugin for better maintenance and performance.
* CODE: Code and documentation tweaks and improvements.
* UPDATE: Extended and improved readme.txt file here.
* UPDATE: Updated German translations and also the .pot file for all translators!
* *Extended plugin support:*
 * NEW: Added support for "Stream" (free, by X-Team).
 * NEW: Added support for "Snitch" (free, by Sergej Müller).
 * NEW: Added support for "WPMS Admin Reports" (free, by Joe Motacek).
 * UPDATE: Updated and improved support for these plugins: "WP Migrate DB Pro".



### 1.6.1 - 2013-12-08 

* BUGFIX: Fix check for a special Multisite function.
* *Otherwise see below for changelog of v1.6.0*



### 1.6.0 - 2013-12-07 

* UPDATE: Tweaked the adding of Network "New Content" instance, to load more reliable.
* UPDATE: Tweaked "View Site" link for sub sites and fixed the display.
* UPDATE: Fixed double appearance of "Themes" and "Plugins" in Network Admin, that came in WordPress 3.7+ -- decided to unhook these defaults and keep our own items - already there from v1.0.0 :-).
* UPDATE: Introduced helper function for our helper constants to make them available early but also unhookable.
* *Extended plugin support:*
 * NEW: Added support for "Smart Security Tools" (premium, by Smart Plugins/ Milan Petrovic).
 * NEW: Added support for "Better WP Security" (free, by Chris Wiegman & iThemes).
 * UPDATE: Updated and improved support for these plugins: "Quick Cache"/ "Quick Cache Pro".
* UPDATE: Updated German translations and also the .pot file for all translators!



### 1.5.0 - 2013-11-21 

* UPDATE: Fixed "Menu Locations" link, updated for WordPress 3.6+.
* UPDATE: Fixed "Google Pagespeed" URL to their current used version.
* UPDATE: In Multisite context the plugin has "Network: true" defined in plugin header that means it is only network activated (the whole sense & purpose of the plugin, anyways :).
* UPDATE: Added additional checks for our defined constants to avoid PHP notices under some circumstances.
* UPDATE: Improved current "MP6" admin plugin support with various CSS tweaks.
* NEW: Under "Plugins" added "Add New" admin link for sub site admin areas - handy link to the plugin installer.
* *Extended plugin support:*
 * NEW: Added support for "Genesis Simple Sidebars" (free, by StudioPress/ Copyblogger Media LLC).
 * NEW: Added support for "Smart Tabber Widget" (premium, by Smart Plugins/ Milan Petrovic).
 * UPDATE: Updated and improved support for these plugins: "WP-Optimize", "Snapshot", "Smart Cleanup Tools", "Smart Admin Tweaks", "Ultimate Branding".
* UPDATE: Updated German translations and also the .pot file for all translators!



### 1.4.0 - 2013-05-07 

* NEW: Added filter for hook priority for the custom nav menu for super admins -- this allows you to change the position of your custom nav menu (try values between 1 and 100..., see FAQ for more info...).
* NEW: For Sub Sites or non-Multisite installs, added links for Widgets, Nav Menus, Theme Customizer, appropriate for backend/ frontend, based on default toolbar items.
* NEW: Added "+ New" (new content) section for the Network admin area, that contains only Network specific items for super admins, plus a few items from our supported plugins.
* NEW: Added "Plugins" items to non-Multisite installs to jump faster into plugins section.
* NEW: For Sub Sites or non-Multisite installs, replaced "View Site" item within "/wp-admin/" with our own iteration, allowing for smarter (own) translations, and better adding of sub level items.
* NEW: Added external links to "Pingdom" and "Google Page Speed" tests as sub level items for "View Site" (see before).
* NEW: Added minor CSS rule for group items if ["MP6" plugin(https://wordpress.org/plugins/mp6/) is active (note, will be the future of '/wp-admin/' styling!).
* *Extended plugin support:*
 * NEW: Added support for "Smart Options Optimizer" (premium, by Smart Plugins/ Milan Petrovic).
 * NEW: Added support for "Simple System Info" (premium, by Smart Plugins/ Milan Petrovic).
 * NEW: Added support for "Hide My WP" (premium, by Hassan Jahangiri).
 * NEW: Added support for "Widget Settings Importer/Exporter" (free, by Kevin Langley, Sean McCafferty, Mark Parolisi).
 * NEW: Added support for "Tabify Edit Screen" (free, by Marko Heijnen).
 * NEW: Added support for "Restrict Widgets" (free, by Digital Factory).
 * NEW: Added support for "P3 (Plugin Performance Profiler)" (free, by GoDaddy.com).
 * NEW: Added support for "Blog Copier" (free, by Modern Tribe, Inc.).
 * NEW: Added support for "NS Cloner - Site Copier" (free, by Never Settle).
 * NEW: Added support for "NS Cloner Pro" (premium, by Never Settle).
 * NEW: Added support for "Codestyling Localization" (free, by Heiko Rabe).
 * NEW: Added support for "WP Migrate DB" (free, by Brad Touesnard).
 * NEW: Added support for "WP Migrate DB Pro" (premium, by Delicious Brains (Brad Touesnard & Chris Aprea)).
 * NEW: Added support for "Multisite Robots.txt Manager" (free, by tribalNerd).
 * NEW: Added support for "WordPress MU Domain Mapping" (free, by Donncha O Caoimh, Ron Rennick, Automatic Inc.).
 * NEW: Added support for "Go Sidebar Wizard" (premium, by Granth).
 * UPDATE: Updated and improved support for these plugins: "Code Snippets", "Snapshot", "BackWPup", "WP-Piwik", "Smart Cleanup Tools", "Smart Admin Tweaks".
* UPDATED: A few minor tweaks to further improve loading/ performance.
* CODE: Some code/ documentation updates & improvements.
* UPDATE: Added new FAQ items here in the readme.txt file.
* UPDATE: Improved/ extended readme.txt file here.
* UPDATE: Updated German translations and also the .pot file for all translators!



### 1.3.0 - 2013-03-21 

* NEW: Added additional "Install Plugin" & "Install Theme" items to the regular "+ Add New" section. This makes it even faster and more elegant to jump to the install/ upload/ search sections!
* NEW: Little CSS tweak for Network Admin "My Sites Menu", to remove additional border line if Network Items from this plugin here are active.
* UPDATE: Enhanced Network wide "Plugins" & "Themes" items.
* *Extended plugin support:*
 * NEW: Added support for "Smart Cleanup Tools" (premium, by Smart Plugins/ Milan Petrovic).
 * NEW: Added support for "Smart Admin Tweaks" (premium, by Smart Plugins/ Milan Petrovic).
 * NEW: Added support for "Optimize Database after Deleting Revisions" (free, by Rolf van Gelder).
 * UPDATE: Updated "Snapshot" plugin support with link for new destination "GreenQloud Storage".
 * UPDATE: Updated support for "BackWPup" to support newest v3.x branch of the plugin.
* CODE: Minor code/ documentation updates & improvements.
* UPDATE: Updated German translations and also the .pot file for all translators!



### 1.2.0 - 2012-11-27 

* *Extended plugin support:*
 * NEW: Added support for "Snapshot" (premium, by Paul Menard (Incsub)/ WPMU DEV).
 * NEW: Added support for "Ultimate Branding" (premium, by Incsub Team/ WPMU DEV).
 * NEW: Added support for "Login Security Solution" (free, by Daniel Convissor).
* NEW: In Network Admin added 'Dashboard' link for main site to 'site-name' menu.
* CODE: Minor code/ documentation updates & improvements.
* UPDATE: Updated German translations and also the .pot file for all translators!



### 1.1.1 - 2012-10-05 

* BUGFIX: Corrected settings link for "Multisite Language Switcher" plugin - sorry!



### 1.1.0 - 2012-09-18 

* *Extended plugin support:*
 * NEW: Added support for "User Management Tools" (free, by scribu/AppThemes).
 * NEW: Added support for "Network Mass Email" (free, Kenny Zaron).
 * NEW: Added support for "Organizational Message Notifier" (free, Zaantar).
 * NEW: Added support for "Multisite Language Switcher" (free, Dennis Ploetner).
 * NEW: Added support for "Code Snippets" (free, by Shea Bunge).
 * NEW: Added support for "Code With WP Code Snippets" (free, by Thomas Griffin) (plugin currently in beta, [hosted at GitHub](https://github.com/thomasgriffin/CWWP-Custom-Snippets)).
 * NEW: Added support for "BackWPup" (free, by Daniel Hüsken).
 * NEW: Added support for "Toolbox Modules" (free, by Sergej Müller) - see also his [plugin instructions](http://playground.ebiene.de/toolbox-wordpress-plugin/).
 * NEW: Added support for "Relevanssi" (free) and "Relevanssi Premium" (premium) both by Mikko Saari, http://www.relevanssi.com.
* CODE: Performance optimizing to load code for a lot of plugins only if ever needed (when activated).
* NEW: Added CSS class suport for the Custom WP Nav Menu for Super Admins (via regular WP Menus!).
* UPDATE: Updated and improved readme.txt file here.
* UPDATE: Updated German translations and also the .pot file for all translators!
* UPDATE: Initiated new three digits versioning, starting with this version.
* UPDATE: Moved screenshots to 'assets' folder in WP.org SVN to reduce plugin package size.



### 1.0.0 - 2012-08-28

* *Initial release*
* Including support for 4 Multisite aware plugins
* Including support for 7 site specific plugins