# Release conventions

[English](RELEASE-POLICY.md) · [Deutsch](RELEASE-POLICY-de.md)

Public GitHub direct distribution; default branch master and tags vMAJOR.MINOR.PATCH. The verified installable asset is multisite-toolbar-additions-VERSION.zip. Source archives are separate. The existing release workflow remains unchanged; ordinary maintenance work does not authorize its publication trigger.

A minor release adds backward-compatible features; a patch fixes compatible behavior or security; a major release documents incompatible changes, migrations and requirements. Current minimums remain WordPress 6.7/PHP 8.2 until an explicit requirement decision. No WordPress.org build is distributed with the external updater or installer. Release ZIPs require their own actual-package validation and publication instruction.
