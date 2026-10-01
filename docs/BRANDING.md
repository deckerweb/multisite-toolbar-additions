# Launch Rail — Multisite Toolbar Additions

The original mark connects a toolbar rail to website tiles, while an orange shortcut arrow jumps beyond the rail. The form represents one convenient entry point for a network and its tools. The mark is custom SVG artwork, with no WordPress Dashicons, external fonts or stock icons.

## Voice

- Main slogan, German: **Viele Sites. Ein Handgriff.**
- Main slogan, English: **Many sites. One move.**
- Supporting line, German: **Weniger Wege. Mehr Überblick.**
- Supporting line, English: **Fewer clicks. A clearer view.**

Use the main slogan in banners, settings and the footer. Use the supporting line for descriptions and release announcements, rather than placing multiple slogans inside a small icon.

## Palette

| Color | Hex | Role |
| --- | --- | --- |
| Deep petrol | `#123640` | Identity, icon ground, primary text |
| Mint | `#b9eed9` | Connected websites, routes, active tool |
| Warm cream | `#f6f3e9` | Toolbar, quiet background |
| Shortcut orange | `#fa815f` | Jump arrow and visual accent |
| Slate petrol | `#41626a` | Supporting copy |

Orange is an illustration accent, not a default small-text color. Keep label/body text in petrol on cream or cream on petrol.

## Files

All editable sources and exports are in `assets/brand/`:

- `icon.svg`: full-color master, 256-unit square with rounded transparent corners.
- `icon-mono.svg`: simplified currentColor mark for future single-color UI placements.
- Icons as PNG: 32, 64, 128, 256 and 512 pixels.
- `banner-en.svg` and `banner-de.svg`: editable WordPress/GitHub banners.
- Banner PNG exports: 772 × 250 and 1544 × 500, both languages.
- `social-card.svg` / `social-card-1280x640.png`: repository/social preview.

The admin settings header uses the SVG at 72 pixels, or 48 pixels on narrow screens. Plugin details and update responses expose packaged icon/banner URLs; the shared updater itself remains unchanged. German user locales receive the German banner.

Root `assets/icon.svg`, `assets/icon-128x128.png`, `assets/icon-256x256.png` and standard banner PNG names mirror the new identity for familiar distribution workflows. Historical assets ending in `_old` remain only in the source repository; the installable package uses the new assets.

Copyright © 2012–2026 David Decker – DECKERWEB. Distributed with the plugin under GPL-2.0-or-later. No new remote requests, fonts or scripts are required by the identity.
