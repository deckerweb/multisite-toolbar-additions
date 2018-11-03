## Multisite Toolbar Additions - Changelog Archive 


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