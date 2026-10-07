# Upgrade from 3.x

[English](MIGRATION-4.0.md) · [Deutsch](MIGRATION-4.0-de.md)

Existing WordPress menus and the mstba_menu theme location remain available. Choose the source site/menu explicitly for independence from theme changes. The default grouped label follows the selected menu name. Review own 3.x customizations; removed obsolete destinations are not revived.

Requirements are WordPress 6.7/PHP 8.2. Shared Multisite menus remain protected for super administrators. Network activation is recommended for network-wide availability; site-only activation in the unpublished maintenance tree is also supported, with a network-scoped configuration managed by a super administrator from the active site. Back up before replacing a major release. User-profile frontend toolbar preferences remain respected.
