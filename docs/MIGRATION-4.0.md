# Version 4.0 migration and feature decisions

## Preserved or improved

| 3.x feature | 4.0 decision |
| --- | --- |
| WordPress menu in toolbar | Retained; explicit source website/menu, context, placement, grouping and depth settings. |
| Menu location assignment | Retained as an upgrade fallback. Direct menu selection survives theme changes. |
| Main-site/global menu | Now actually resolves a network source website instead of each website's current theme location. |
| Menu visibility | Super-admin default; optional visibility for website administrators without granting editing or destination permissions. |
| Menu editing restriction | Moved from a GET-page check to permission checks and REST/Customizer validation. |
| Network/site links | Retained; destinations are capability checked and Core nodes remain intact. |
| My Sites extras | Retained, bounded and aware of each destination's theme. |
| Popular custom post type list | Replaced by discovering registered UI-enabled types and checking each type's editing capability. |
| Classic theme links | Retained when relevant; replaced with Site Editor for block themes. |
| Theme file editor | Retained as an explicit setting, off by default. Plugin file editor added under the same setting. |
| Plugin integrations | Retained as a compact detection registry; decorative support/affiliate submenu trees removed. Older plugin targets are compatibility links, not a claim that those external plugins are currently maintained. |
| ZIP upload helpers | Direct sidebar entries for plugin ZIP uploads and a dedicated theme ZIP page using Core’s signed upload form. Multisite website links target network administration. |
| Fullscreen toolbar | Retained as an optional desktop enhancement, using toolbar-height CSS variables. No logo removal or hardcoded admin color lookup. |
| Developer resources | Consolidated into handbooks, coding standards and contribution links. |
| Debug information | Retained and paired with direct Site Health access. |
| German localization | Updated for the new interface. |

## Removed

- **Restricted site-admin menu:** already removed in 3.0; its leftover code and outdated documentation are now gone. Website administrators can instead be granted visibility of the one centrally managed menu.
- **Jetpack/WooCommerce advertising suppression and Site Health percentage tweaks:** unrelated behavior that modifies other products; users should control those through the relevant plugins.
- **Affiliate/premium membership links and automatic newsletter URL personalization:** unnecessary for an administration helper and creates needless coupling to external sites/user profile data.
- **External speed-test shortcuts:** omitted from built-in shortcuts. These can be added to the custom menu with whichever diagnostic tools the owner actually uses; the plugin will not send a website URL to an external testing service automatically.
- **Translation-specific relabeling of the WordPress Dashboard:** normal translations provide consistent Core terminology.
- **Pre-6.7 compatibility branches and historical virtual uploader pages:** replaced with current Core APIs and a dedicated theme upload page.
- **The old global-function API and 28-argument menu filter:** replaced by small namespaced components, the integration registry filter, and retained extension actions. Major-version customization migration is intentional.

## Important upgrade behavior

1. A network now uses its main website as the default menu source. If a 3.x installation deliberately used different toolbar menus on different websites, select the intended shared source in network settings; per-website toolbar-menu overrides are not part of 4.0.
2. The old `mstba_menu` location is consulted on the selected source website when menu ID is zero. Select the menu explicitly and save to make its assignment independent of the theme.
3. Theme/plugin file editor shortcuts are off by default. Enable them explicitly if desired. Core permissions and `DISALLOW_FILE_EDIT`/`DISALLOW_FILE_MODS` still govern access.
4. Large-network extras are capped at 25 websites by default. Increase the limit if desired; other websites retain ordinary WordPress toolbar links.
5. Core Toolbar visibility preferences still apply. The plugin does not force the toolbar onto logged-out visitors or users who disabled it on the frontend.
6. Existing German translations installed in `wp-content/languages/plugins` can take precedence over bundled files; remove obsolete external translations if the new interface appears partly untranslated.
7. Single-site settings live in `mstba_settings`; network settings use the same key in the current network's options. Both are retained on removal, and no menus are deleted.
8. There is no build step and no production vendor directory. Upload the release ZIP directly. The source archive includes tests/docs; the installable ZIP excludes test fixtures and tooling.
