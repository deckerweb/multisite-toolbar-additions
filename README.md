# Multisite Toolbar Additions 

Adds a lot useful admin links to the WordPress Toolbar / Admin Bar in Multisite, Network and single site installs.

![Multisite Toolbar Additions plugin banner](https://repository-images.githubusercontent.com/127668325/2a7279cf-2bd5-4743-9d2d-42b1555aa7f9)


* Contributors: [David Decker](https://github.com/deckerweb), [contributors](https://github.com/deckerweb/multisite-toolbar-additions/graphs/contributors)
* Tags: admin bar, toolbar, multisite, single site, site builder, administrators
* Requires at least: 6.7
* Requires PHP: 7.4
* Stable tag: [master](https://github.com/deckerweb/multisite-toolbar-additions/releases/latest)
* Donate link: https://paypal.me/deckerweb
* License: GPL v2 or later

---

## Support the Project

If you find this project helpful, consider showing your support by buying me a coffee! Your contribution helps me keep developing and improving this plugin.

Enjoying the plugin? Feel free to treat me to a cup of coffee ☕🙂 through the following options:

- [![ko-fi](https://ko-fi.com/img/githubbutton_sm.svg)](https://ko-fi.com/W7W81BNTZE)
- [Buy me a coffee](https://buymeacoffee.com/daveshine)
- [PayPal donation](https://paypal.me/deckerweb)
- [Join my **newsletter** for DECKERWEB WordPress Plugins](https://eepurl.com/gbAUUn)

---

## Description 

> #### Quick Access to Super Admin Resources - Time Saver!
> This **small and lightweight** plugin just adds some missed and **very useful admin links** to your Toolbar / Admin Bar in Multisite installs, and even regular single site installs.
>
> Also included is support for a few third-party plugins out of the box. So you might just switch from the backend or frontend of your site to the 'Network Wide Plugins' or access the 'Nav Menu' Settings of a sub site/blog. To make you even more happy, the plugin also works just perfectly in single WordPress installs (non-Multisite context), just fewer menu items then... ---> **Use this time saver and get quicker access :-)**

*NOTE:* This plugin is **only intended towards Super Admins / Admins**.


### General Features & Benefits -- Global Usage 
* Add a **Custom Nav Menu** to the toolbar via WP Menu system - great for instructions for your staff members or other resources...
* Recommended in Multisite: to use the main site for this (but menu is available globally)
* Only visible and accessable for Super Admins (Multisite context) or for Site Admins (non-Multisite context)!
* Plugin is fully internationalized, English & German language files included by default :)
* Fully WPML compatible!


### Multisite Network Specific Features & Benefits 
* Network wide Plugins
* Network wide Themes (plus Theme Editor)
* Network Settings, Updates, plus Site Upgrade
* Special "+ New" (new content) section, like on site dashboards, but only for Network admin with Network specific items!
* Extra special *Custom Nav Menu* vieable for Site Admins but only editable for Super Admins, setup via WP Menu system.
* Multisite aware plugin support, to date for: *WP-Piwik, WPMS Site Maintenance Mode, Multisite Robots.txt Manager, WordPress MU Domain Mapping, WP Migrate DB Pro (premium), WPMS Admin Reports*


### (Sub) Site Specific Features & Benefits 
 * Widgets
 * Nav Menus, including list of editable Nav Menus!
 * *Manage Content:* Media Library / Edit Posts / Edit Pages
 * Theme Editor (also detects Multisite network-admin!), great for fast editions on the fly... -- also includes "Customizer", plus "Custom Background" and "Custom Header"!
 * (Site specific) Plugin support, to date for: *Relevanssi & Relevanssi Premium, Multisite Language Switcher, Tabify Edit Screen, WP Migrate DB, Stream*


### Included Plugin Support 
*Out of the box the plugin supports the following other plugins' admin menu links in the Toolbar if installed and activated:*

* ["WP-Piwik" (free, by Andr&eacute; Br&auml;kling)](https://wordpress.org/plugins/wp-piwik/) - also network wide
* ["WPMS Site Maintenance Mode" (free, 7 Media Web Solutions, LLC)](https://wordpress.org/plugins/wpms-site-maintenance-mode/) - also network wide
* ["Code Snippets" (free, by Shea Bunge)](https://wordpress.org/plugins/code-snippets/) - also network wide
* ["WP Migrate DB Pro" (premium, by Delicious Brains (Brad Touesnard & Chris Aprea))](https://ddwb.me/ai) - network wide
* ["Multisite Robots.txt Manager" (free, by tribalNerd)](https://wordpress.org/plugins/multisite-robotstxt-manager/) - network only!
* ["WordPress MU Domain Mapping" (free, by Donncha O Caoimh, Ron Rennick, Automatic Inc.)](https://wordpress.org/plugins/wordpress-mu-domain-mapping/) - network only!
* ["WPMS Admin Reports" (free, by Joe Motacek)](https://wordpress.org/plugins/wpms-admin-reports/) - network only! (MU Plugin!)
* ["Multisite Language Switcher" (free, Dennis Ploetner)](https://wordpress.org/plugins/multisite-language-switcher/)
* ["Relevanssi" (free)](https://wordpress.org/plugins/relevanssi/) and ["Relevanssi Premium" (premium)](https://www.relevanssi.com/) both by Mikko Saari
* ["WP Migrate DB" (free, by Brad Touesnard)](https://wordpress.org/plugins/wp-migrate-db/)
* ["Stream" (free, by X-Team)](https://wordpress.org/plugins/stream/)

---

## Installation 

**Quick Install**
1. **Download ZIP:** [**multisite-toolbar-additions.zip**](https://github.com/deckerweb/multisite-toolbar-additions/releases/latest/download/multisite-toolbar-additions.zip)
2. Upload via WordPress (Network) Plugins > Add New > Upload Plugin --> in _Multisite_ you can _activate network wide_!
3. Look at your toolbar / admin bar within the "My Sites" menu and enjoy using the new links there :)
4. If you want you could add a special custom Nav Menu via "Design > Menus" (best if using the main site of your Network for that) and assign it to the new "Multisite Toolbar Menu" menu location (only visible & accessable for Super Admins!).
5. Go and manage your Multisite Network or just your single site :)

**Note:** This plugin has NO settings page because I believe it's just not neccessarry. All customizing could be done via filters, constants and regular WordPress user roles & capabilities. As the plugin is only indended for a Super Admin (Network Admin) usage - that's the way to go. This way we can save the overhaul of an options panel/settings page, additional database requests, uninstall routines and such. End result: a lightweight system that just works and saves clicks & time :-).

**Multisite install:** Of course, it's fully compatible

**Single Site install:** The plugin WILL also working like a charm for regular non-Multisite installs - just without the network specific stuff. However, there's still A LOT (single) site specific stuff supported. So it's up to your use case :). -- I for myself use this plugin on each and every install because it SAVES ME A LOT OF CLICKS & TIME! ...and that was the very reason I've developed it, yeah :-)

---

## Frequently Asked Questions 

### Why another Multisite Toolbar plugin, there are already some others!? 
You're right! If you're happy with one of the others then that's absolutely great and you don't need to add or switch anything! :)

I just made this new plugin here for my own needs and some of my client admins. As I am an open source evangelist I like to release my stuff to the public to give back to the community!

Plugin developer David Decker: *What has proved its day to day usage and usefulness on more than 100 installs (Multisites and regular single site installs) before, could be used by many other (super) admins as well, right? :-)))*


### How do I use the custom Nav Menu for Super Admins for the toolbar? 
All menu items via a Custom Menu - and at all other places in the Toolbar (a.k.a. Admin Bar) - are only visible and accessable for Super Admins. That means in a Multisite environment all admins who can manage the network. In regular WordPress (single) installs these are users with the Administrator user role.

Added Menu Location by the plugin is: "Multisite Toolbar Menu" (again: only for Super Admins)

Steps for setting up a menu:

* Create a new menu, set a name like "Super Admin Toolbar" or such...
* Setup your links, might mostly be custom links, or any other...
* Save the new menu to the plugin's menu location. That's it :)
* *Please note:* Every parent item = one main toolbar entry! So best would be to only use one parent item and set all other items as children.


### How can I adjust the position of my custom Nav Menu? 
Since version 1.4.0 of the plugin there's a filter for that. See this example that needs to be added to your theme's/ child theme's `functions.php` file or a functionality plugin. Try values between `1` and `100`:
```
add_filter( 'mstba_filter_super_admin_nav_menu_priority', 'mstba_custom_position_super_admin_nav_menu' );
/**
 * Multisite Toolbar Additions:
 *    Adjust Super Admin Nav Menu Position
 */
function mstba_custom_position_super_admin_nav_menu() {
	return 20;
}
```


### How can I adjust the position of Network admin "+ New" section? 
This could be easily done with the following example code that needs to be added to your theme's/ child theme's `functions.php` file or a functionality plugin. Try values between `1` and `100`:
```
add_filter( 'mstba_filter_network_admin_new_content_priority', 'mstba_custom_position_network_admin_new_content' );
/**
 * Multisite Toolbar Additions:
 *    Adjust Network Admin "+ New" Position
 */
function mstba_custom_position_network_admin_new_content() {
	return 80;
}
```


### Can I remove the "+ New" (new content) section in Network admin? 
Yes, it's possible! This line of code needs to be added to your theme's/ child theme's `functions.php` file or a functionality plugin:
```
/**
 * Multisite Toolbar Additions:
 *    Remove Network Admin "+ New" section
 */
add_filter( 'mstba_filter_display_network_new_content', '__return_false' );
```

### Is this plugin Multisite compatible? 
Of course it is! :) Works really fine in Multisite invironment - for Super Admins.



### In Multisite, could I "network activate" this plugin? 
Yes, you could! Again, it's only displayed and useful for Super Admins. -- Activating on a per-site basis is also possible. Just decide what works best for you.



### Has this plugin any use for non-Multisite installs? 
Yes, of course! :) The plugin is *working like a charm* in single-site installs - just without the network specific stuff. However, there's still A LOT (single) site specific stuff supported. So it's up to your use case :).



### Could certain sections/ item groups be removed? 
Yes, this is possible! You can remove the following sections: "My Sites" menu area (all network items) / "My Sites" menu area (all sub site specific items) / "Super Admin Nav Menu" group (all items) / "Network Plugin Support" (all network plugin items) / "(Sub Site) Plugin Support" (all site plugin items) / "(Sub) Site Specific Items" - useful to disable for specific Super Admin users...

To achieve this add one, some or all of the following constants to your main theme's/child theme's `functions.php` file, functionality plugin or MU plugin:
```
/**
 * Multisite Toolbar Additions:
 *    Remove Network Admin Specific Items
 */
define( 'MSTBA_DISPLAY_NETWORK_ITEMS', FALSE );

/**
 * Multisite Toolbar Additions:
 *    Remove Sub Site Specific Items
 */
define( 'MSTBA_DISPLAY_SUBSITE_ITEMS', FALSE );

/**
 * Multisite Toolbar Additions:
 *    Disable Custom Nav Menu for Super Admins
 */
define( 'MSTBA_SUPER_ADMIN_NAV_MENU', FALSE );

/**
 * Multisite Toolbar Additions:
 *    Disable Plugin Support for Network Wide Plugins
 */
define( 'MSTBA_DISPLAY_NETWORK_EXTEND_GROUP', FALSE );

/**
 * Multisite Toolbar Additions:
 *    Disable Plugin Support for (Sub) Site Specific Plugins
 */
define( 'MSTBA_DISPLAY_SITE_EXTEND_GROUP', FALSE );

/**
 * Multisite Toolbar Additions:
 *    Disable Site Specific Items
 */
define( 'MSTBA_DISPLAY_SITE_GROUP', FALSE );

/**
 * Multisite Toolbar Additions:
 *    Disable Nav Menu List Edit Items
 */
define( 'MSTBA_DISPLAY_LIST_EDIT_MENUS', FALSE );
```



### Could the the whole toolbar entries be removed, especially for certain users? 
Yes, that's also possible! This could be useful if your site has special user roles/capabilities or other settings that are beyond the default WordPress stuff etc. For example: if you want to disable the display of any "Multisite Toolbar Additions" items for all user roles of "Editor" please use this code:

To hide only from the user with a user ID of "2":
```
/**
 * Multisite Toolbar Additions:
 *    Remove Network Admin specific Items for user ID 2
 */
if ( 2 === get_current_user_id() ) {
	define( 'MSTBA_DISPLAY_NETWORK_ITEMS', FALSE );
}
```

To hide items only in frontend use this code:
```
/**
 * Multisite Toolbar Additions:
 *    Remove Network Admin specific Items from frontend
 */
if ( ! is_admin() ) {
	define( 'MSTBA_DISPLAY_NETWORK_ITEMS', FALSE );
}
```


**Final note:** I DON'T recommend to add customization code snippets to your main theme's/ child theme's `functions.php` file! **Please use a functionality plugin or an MU-plugin instead!** This way you can also use this better for Multisite environments. In general you are then more independent from theme/child theme changes etc. If you don't know how to create such a plugin yourself just use one of my recommended 'Code Snippets' plugins. Read & bookmark these Sites:

* _Code Snippets_ (free, .org plugin repo) / also _Code Snippets Pro_ (premium)
* _FluentSnipperts_ (free, .org plugin repo)
* _Advanced Scripts_ (premium)
* _Scripts Organizer_ (premium)
* _WPCodeBox_ (premium)
* _WPCode_ (free, .org plugin repo)

All the custom & branding stuff code above can also be found as a Gist on Github: https://gist.github.com/deckerweb/3498510 (you can also add your questions/ feedback there :)

---

## Screenshots 

### 1. Multisite Toolbar Additions: New Network specific menu items located in "My Sites" toolbar parent item. ([Click here for larger version of screenshot](https://www.dropbox.com/s/m6w6h8icr44e568/screenshot-1.png)).
![Multisite Toolbar Additions: New Network specific menu items located in "My Sites" toolbar parent item. ([Click here for larger version of screenshot](https://www.dropbox.com/s/m6w6h8icr44e568/screenshot-1.png)).](https://ps.w.org/multisite-toolbar-additions/assets/screenshot-1.png)


### 2. Multisite Toolbar Additions: Included plugin support for Network aware plugins. ([Click here for larger version of screenshot](https://www.dropbox.com/s/ztu9haeh48eg6lr/screenshot-2.png)).
![Multisite Toolbar Additions: Included plugin support for Network aware plugins. ([Click here for larger version of screenshot](https://www.dropbox.com/s/ztu9haeh48eg6lr/screenshot-2.png)).](https://ps.w.org/multisite-toolbar-additions/assets/screenshot-2.png)


### 3. Multisite Toolbar Additions: New Sub Site/ Blog items located in the parent item for each site. ([Click here for larger version of screenshot](https://www.dropbox.com/s/a0qhymxlpkn1qox/screenshot-3.png)).
![Multisite Toolbar Additions: New Sub Site/ Blog items located in the parent item for each site. ([Click here for larger version of screenshot](https://www.dropbox.com/s/a0qhymxlpkn1qox/screenshot-3.png)).](https://ps.w.org/multisite-toolbar-additions/assets/screenshot-3.png)


### 4. Multisite Toolbar Additions: New (Sub) Site specific menu items - plus included plugin support for useful site specific plugins. ([Click here for larger version of screenshot](https://www.dropbox.com/s/w0aoaxwfqfw7iq2/screenshot-4.png)).
![Multisite Toolbar Additions: New (Sub) Site specific menu items - plus included plugin support for useful site specific plugins. ([Click here for larger version of screenshot](https://www.dropbox.com/s/w0aoaxwfqfw7iq2/screenshot-4.png)).](https://ps.w.org/multisite-toolbar-additions/assets/screenshot-4.png)


### 5. Multisite Toolbar Additions: How the optional Nav Menu for Super Admins works. ([Click here for larger version of screenshot](https://www.dropbox.com/s/7u83c0g5ehk4ozq/screenshot-5.png)).
![Multisite Toolbar Additions: How the optional Nav Menu for Super Admins works. ([Click here for larger version of screenshot](https://www.dropbox.com/s/7u83c0g5ehk4ozq/screenshot-5.png)).](https://ps.w.org/multisite-toolbar-additions/assets/screenshot-5.png)


### 6. Multisite Toolbar Additions: Plugin's help tab on Nav Menu admin page. ([Click here for larger version of screenshot](https://www.dropbox.com/s/dt6kkxqsh7yvbfn/screenshot-6.png)).
![Multisite Toolbar Additions: Plugin's help tab on Nav Menu admin page. ([Click here for larger version of screenshot](https://www.dropbox.com/s/dt6kkxqsh7yvbfn/screenshot-6.png)).](https://ps.w.org/multisite-toolbar-additions/assets/screenshot-6.png)

---

## Changelog 

### 🎉 3.1.0 - 2025-04-??
* New: Show Admin Bar also in Block Editor full screen mode
* New: Further cleanup of unneeded old(er) stuff
* New: Made this plugin itself installable and updateable via [Git Updater plugin](https://git-updater.com/) – improved compatibality
* New: Added support/integration for _Git Updater_ by Andy Fragen
* New: Added support/integration for _DevKit Pro_ by DPlugins
* Update: `.pot` file, plus packaged German translations, now including new `l10n.php` files!


### 🎉 3.0.0 - March 2025
* Improved: Brought back plugin into a lightweight and working state as it was originally intended!
* Cleanup: Restricted admin menu feature got completely removed as it was causing lots of issues (note: the global super admin menu remains)
* Cleanup: Lots of originally supported plugins got removed as these are no longer available or outdated.
* Removed: Some info links, help texts, plus the _DDWlib Plugin Installer Recommendations_ library got removed, it is no longer wanted/supported anyways
* **Note:** No longer in the .org plugin repo available – thanks to Matt... (I've taken it out myself as I have no longer interest in WordPress.org repo strategy) – just install yourself via ZIP file, see above under "Installation"


### ⚡ 2.0.1 - 2019-09-23
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.5.0) - better performance due to the use of transients
* Tweak: Minor code improvements


### 🎉 2.0.0 - 2019-05-04
* *New: Successfully tested with WordPress 5.2*
* New: Dedicated Theme and Plugin ZIP Uploader pages
* New: Enhanced Theme and Plugin Installer items in Toolbar (New Content Group)
* New: Integrated with WordPress 5.2+ new Site Health feature: Multisite Toolbar Additions now has an extra section on the Debug Info tab - this is especially helpful for support requests
* Tweak: Smaller internal improvements
* Tweak: Updated bundled library DDWlib Plugin Installer Recommendations to latest version (v1.4.0) - feature updates
* Tweak: Updated `.pot` file plus all German translations (formal, informal) and language packs
* New: [Join my newsletter for DECKERWEB WordPress Plugins](https://eepurl.com/gbAUUn) - insider info, plus tutorials and more useful stuff


**NOTE:** See [**Changelog Archive**](https://github.com/deckerweb/multisite-toolbar-additions/blob/master/changelog-archive.md) for all versions prior to 2.0.0

---

## Donate 
Enjoy using *Multisite Toolbar Additions*? **[Please consider making a donation](https://www.paypal.me/deckerweb)** - every donation helps to support the project's continued development, maintenance and support.
**Thank you very much in advance for your support!**


## Additional Info 
**Idea Behind / Philosophy:** Just a little lightweight plugin for all the Multisite Super Admins out there to make their daily network admin life a bit easier. I'll try to add more plugin support if it makes some sense. So stay tuned :).


---

Icon used in promo graphics: © Remix Icon

Readme & Plugin Copyright: © 2012–2025, David Decker – DECKERWEB.de