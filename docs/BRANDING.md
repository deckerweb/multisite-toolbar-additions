# Launch Rail artwork

[English](BRANDING.md) · [Deutsch](BRANDING-de.md)

For single WordPress sites and Multisite networks. Both have been supported since 2012.

The Launch Rail identity uses a continuous dark petrol gradient, cream and mint details, and an orange shortcut arrow. Its toolbar connects websites and tools. Slogan: Many sites. One move. / Viele Sites. Ein Handgriff.

## Masters and outputs

Each language has one 2:1 master in assets-source: banner-master-en-2560x1280.svg and banner-master-de-2560x1280.svg, with matching 2560 × 1280 PNGs. GitHub banners in assets-github use the complete master, scaled to 1280 × 640. WordPress banners in assets/brand use a centered vertical crop of the same master, then uniform scaling to 1544 × 500 or 772 × 250. No separate artwork is composed for those formats. The reproducible exporter is tools/artwork.cjs.

The text-free icon retains its original vector shapes and rounded corners. PNG sizes: 128, 256, 512 and 1024 px. The 1024 px version is rendered directly from SVG, without enlarging a small PNG. Large marketing files and master/source files are not needed in the installable plugin package.

## Font and SVG declaration

Typography: Manrope (regular, bold and extra-bold outlines), licensed under SIL Open Font License 1.1. Source font files and their license are kept in assets-source/fonts; the font license also accompanies runtime artwork in assets/brand/FONT-LICENSE.txt. Upstream: https://github.com/google/fonts/tree/main/ofl/manrope . Font software is not part of the installable plugin package.

Every current banner SVG contains native vector shapes and outlined Manrope glyphs. It contains no editable text, installed-font dependency, embedded raster image, external resource or filter. Native SVG gradients create the continuous background. Title/description metadata retains accessible language-specific descriptions. The icon has no text or font dependency and uses the matching petrol gradient. Artwork: David Decker, GPL-2.0-or-later; font software retains its separate OFL license.
